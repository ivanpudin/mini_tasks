# How to set everything up

**Create separate folder**

```
git clone https://github.com/ivanpudin/mini_tasks

cd frontend

npm i

cd -

docker-compose up

cd frontend

npm start

git branch branch_name

git checkout branch_name
```

# How to work

Run the docker and do your work

Everything can be found at **localhost:7001**

After you are done: git add, commit, push from a branch that you are working on

# git pull

When you start, be sure to work with up to date code

```
git config pull.rebase false
git pull
```
# 1: Convertor app
This is a PHP script that handles unit conversion requests. It includes conversion functions for mass, speed, and temperature, and accepts POST requests containing a JSON payload with unit1, unit2, and quantity parameters. It determines the appropriate conversion function based on the unit1 parameter, performs the conversion, and returns a JSON response with the converted value and corresponding units. The script has been tested using PHPUnit to ensure accurate conversion results.
## Endpoint
### POST request
#### convert units
url
```
/measurement-api.php
```
body
```
{
    "unit1": "kg",
    "unit2": "lb",
    "quantity": 100
}
```
response
```
{
    "message": "100 kilograms equals to 220.46 pounds"
}
```
# 2: Contact us form
The second part is a PHP script that handles a contact form submission. It includes a database connection script and accepts POST requests containing a JSON payload with name, email, subject, and message parameters. It first validates the email format and ensures that the name, subject, and message are not empty. If validation passes, it inserts the contact form data into a database table and returns a JSON response indicating success or failure.
## Endpoint
### POST request
#### send the message
url
```
/webform-api.php
```
body
```
{
    "name": "name",
    "email": "email@email.com",
    "message": "title",
    "subject": "subject"
}
```
response
```
{
    "message": "Contact form has been submitted successfully."
}
```
# 3: ToDo app
The third part is a PHP API for task data handles requests based on the method and action parameters in the requests. The API contains two sections - one for users and one for tasks.

In the users section, the API provides credential checking, user creation and retrieval of user information. The credentials check endpoint checks that the credentials provided by the user are valid, while the create user endpoint creates a new user with the details provided.

In the tasks section, the API allows for retrieval of all unfinished tasks, retrieval of all unfinished tasks of a user, retrieval of a specific task, retrieval of all tasks with a due date up to a specific date, retrieval of all the user's due tasks by a specific date, creation of a new task, and closing of a task.

Finally, the API includes a PHPUnit test that sets up a connection to a test database and tests the API endpoints using GuzzleHttp. The test also creates fixtures for all tests using PDO. 

## Endpoints

### GET requests

#### get all users:

request
```
/api.php?action=get_users
```
response

```
[
    {
        "id": 1,
        "firstname": "firstname",
        "lastname": "lastname"
    }
]
```

#### get all unfinished tasks:
request
```
/api.php?action=get_tasks
```
response
```
[
    {
        "id": 1,
        "title": "Task title",
        "description": "Task description",
        "created_at": "YYYY-MM-DD HH:MM:SS",
        "deadline": "YYYY-MM-DD",
        "firstname": "fistname",
        "lastname": "lastname",
        "status": 0
    }
]
```
#### get all unfinished tasks of user:
request
```
/api.php?action=get_tasks&user=user_id
```
response
```
[
    {
        "id": 1,
        "title": "Task title",
        "description": "Task description",
        "created_at": "YYYY-MM-DD HH:MM:SS",
        "deadline": "YYYY-MM-DD",
        "firstname": "fistname",
        "lastname": "lastname",
        "status": 0
    }
]
```
#### get specific task:
request

```
/api.php?action=get_task&task=task_id
```
response
```
{
        "id": 1,
        "title": "Task title",
        "description": "Task description",
        "created_at": "YYYY-MM-DD HH:MM:SS",
        "deadline": "YYYY-MM-DD",
        "firstname": "fistname",
        "lastname": "lastname",
        "status": 0
}
```

#### get all due tasks by a specific date:

request
```
/api.php?action=get_tasks&deadline=date
```
response
```
[
    {
        "id": 1,
        "title": "Task title",
        "description": "Task description",
        "created_at": "YYYY-MM-DD HH:MM:SS",
        "deadline": "YYYY-MM-DD",
        "firstname": "fistname",
        "lastname": "lastname",
        "status": 0
    }
]
```

#### get all due tasks of user by a specific date:
request
```
/api.php?action=get_tasks&deadline=date&user=user_id
```
response
```
[
    {
        "id": 1,
        "title": "Task title",
        "description": "Task description",
        "created_at": "YYYY-MM-DD HH:MM:SS",
        "deadline": "YYYY-MM-DD",
        "firstname": "fistname",
        "lastname": "lastname",
        "status": 0
    }
]
```
### POST requests

#### check user's credentials:

url

```
/api.php
```

body

```
{
    "action": "get_user",
    "email": "email@email.com",
    "password": "md5 hash"
}
```
response 
```
{
    "id": 1,
    "firstname": "fistname",
    "lastname": "lastname",
    "email": "email@email.com",
    "password": "md5 hash"
}
```
#### create user
url
```
/api.php
```
body
```
{
    "action": "create_user",
    "firstname": "fistname",
    "lastname": "lastname",
    "email": "email@email.com",
    "password": "md5 hash"
}
```
response
```
{
    "message": "User has been created successfully."
}
```

#### create task:

url

```
/api.php
```

body

```
{
    "action": "create_task",
    "title": "text",
    "description": "text",
    "deadline": "YYYY-MM-DD",
    "performer": 1
}
```
response
```
{
    "success": true,
    "message": "Task has been created successfully."
}
```

### PUT requests

#### close task:

url

```
/api.php
```

body

```
{
    "action": "close_task",
    "comment": "text",
    "status": 1,
    "closing_date": "YYYY-MM-DD",
    "id": 1
}
```
response
```
{
    "success": true,
    "message": "Task have been closed successfully."
}
```
