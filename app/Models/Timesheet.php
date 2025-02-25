<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timesheet extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_name',
        'date',
        'hours',
        'project_id',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function scopeFilter($query, $filters)
    {
        if (! $filters) {
            return $query;
        }

        // http://127.0.0.1:8000/api/timesheets?filters[project_id]=1
        // http://127.0.0.1:8000/api/timesheets?filters[user_id]=1

        foreach ($filters as $key => $value) {
            if (in_array($key, ['user_id', 'project_id'])) {
                $query->where($key, $value);
            }
        }

        return $query;
    }
}
