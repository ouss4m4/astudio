# Steps To Run

Requirements:
php and composer installed
mysql db

Clone the repo  
`git clone https://github.com/ouss4m4/astudio.git`

copy the .env.example to .env file and edit the database credentials

# Models

## User

-   first_name
-   last_name
-   email
-   password

## Project

-   name
-   status

## Timesheet

-   task_name
-   date
-   hours
-   project_id
-   user_id

## Project_user

-   project_id
-   user_id
