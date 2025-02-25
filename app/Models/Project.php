<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'status',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function timesheets()
    {
        return $this->hasMany(Timesheet::class);
    }

    public function attributes()
    {
        return $this->hasMany(AttributeValue::class, 'entity_id');
    }

    public function scopeThisUser($query)
    {
        return $query->whereHas('users', function ($q) {
            $q->where('user_id', auth()->id());
        });
    }

    public function scopeFilter($query, $filters)
    {
        if (! $filters) {
            return $query;
        }

        // build a where(key, = , value) unless there is an operator handle it separately
        // http://127.0.0.1:8000/api/projects?filters[name][operator]=LIKE&filters[name][value]=Project
        // http://127.0.0.1:8000/api/projects?filters[status]=done

        foreach ($filters as $key => $value) {

            if (is_array($value) && isset($value['operator']) && isset($value['value'])) {
                $operator = $value['operator'];
                $filterValue = $value['value'];
            } else {
                $operator = '=';
                $filterValue = $value;
            }

            if (in_array($key, ['name', 'status'])) {
                // Handle the LIKE because of %%
                $query->where($key, $operator === 'LIKE' ? 'LIKE' : $operator,
                    $operator === 'LIKE' ? "%{$filterValue}%" : $filterValue);
            } else {
                $query->whereHas('attributes', function ($subQuery) use ($key, $operator, $filterValue) {
                    $subQuery->whereHas('attribute', function ($attrQuery) use ($key) {
                        $attrQuery->where('name', $key);
                    })->where('value', $operator, $filterValue);
                });
            }
        }

        return $query;
    }
}
