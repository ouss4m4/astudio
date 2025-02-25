# Project Manager Sample API with Laravel

## Steps to run

Requirements:

-   php and composer installed
-   mysql

Clone the repo

```shell
git clone https://github.com/ouss4m4/astudio.git
```

copy the `.env.example` to `.env` file and edit the database credentials

Run migrations/seed

```shell
php artisan migrate:fresh --seed
```

Generate a Laravel Passport Personal Access Client

```shell
php artisan passport:client --personal
```

Start the server

```shell
composer run dev
```

## API Documentation

## API Test Requests

### POSTMAN (recomended)

import the `api-collection.json` in postman
and you should see requests like this

![postman request](./postman.png)

### Curl (optional)

### Register a new user

```bash
curl --silent --location 'http://127.0.0.1:8000/api/register' \
--header 'Content-Type: application/json' \
--data-raw '{
    "first_name": "John",
    "last_name": "Doe",
    "email": "john@gmail.com",
    "password": "johndoe"
}'
```

#### Login and store the token

```bash
export TOKEN=$(curl --silent --location 'http://127.0.0.1:8000/api/login' \
--header 'Content-Type: application/json' \
--data-raw '{
    "email": "john@gmail.com",
    "password": "johndoe"
}' | jq -r '.token')

echo "Token: $TOKEN"
```

#### Create a new project and store the project ID

```bash
export PROJECT_ID=$(curl --silent --location 'http://127.0.0.1:8000/api/projects' \
--header "Authorization: Bearer $TOKEN" \
--header 'Content-Type: application/json' \
--data '{
    "name": "Project X",
    "status": "todo",
    "attributes": [
        {
            "id": 1,
            "value": "Finance"
        },
        {
            "id":2,
            "value": "2025-02-25"
        }
    ]
}' | jq -r '.id')

echo "Project ID: $PROJECT_ID"
```

#### Assign users and update project status

```bash
curl --silent --location --request PATCH "http://127.0.0.1:8000/api/projects/$PROJECT_ID" \
--header "Authorization: Bearer $TOKEN" \
--header 'Content-Type: application/json' \
--data '{
"status": "progress",
"users": [1, 3]
}'
```

#### mark timesheet for a user

```bash
curl --location 'http://127.0.0.1:8000/api/timesheets' \
--header "Authorization: Bearer $TOKEN" \
--header 'Content-Type: application/json' \
--data '{
    "user_id": 1,
    "project_id": 1,
    "date": "2025-02-25",
    "hours": 4,
    "task_name": "Project setup"
}'
```

#### Fetch the updated project

```bash
curl --location 'http://127.0.0.1:8000/api/projects/'"$PROJECT_ID" \
--header "Authorization: Bearer $TOKEN"
```

#### Mark Project as DONE

```bash
curl --location --request PATCH 'http://127.0.0.1:8000/api/projects/'"$PROJECT_ID" \
--header "Authorization: Bearer $TOKEN" \
--header 'Content-Type: application/json' \
--data '{
    "status": "done"
}'
```

#### fetch projects with filter status=done

```bash
curl --location --globoff 'http://127.0.0.1:8000/api/projects?filters[status]=done' \
--header "Authorization: Bearer $TOKEN"
```

## Models

### User

-   first_name
-   last_name
-   email
-   password

### Project

-   name
-   status

### Timesheet

-   task_name
-   date
-   hours
-   project_id
-   user_id

### Project_user

-   project_id
-   user_id
