# How to set everything up

**Create separate folder**

```
git clone https://github.com/ivanpudin/mini_tasks

git branch branch_name

git checkout branch_name

docker-compose up
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

# 3: ToDo app

## Endpoints

### GET requests
- get all users:
```
/api.php?{action}={get_users}
```
- get all unfinished tasks:
```
/api.php?{action}={get_tasks}
```
- get all unfinished tasks of user:
```
/api.php?{action}={get_tasks}&{user}={user_id}
```
- get specific task:
```
/api.php?{action}={get_task}?{task}={task_id}
```
- get all due tasks by a specific date:
```
/api.php?{action}={get_tasks}?{deadline}={date(YYYY-MM-DD)}
```
- get all due tasks of user by a specific date:
```
/api.php?{action}={get_tasks}?{deadline}={date(YYYY-MM-DD)&{user}={user_id}}
```
### POST requests
- check user's credentials:

url
```
/api.php
```
body
```
{
    "action": "get_user",
    "email": "xxx@xxx.xxx",
    "password": "md5 hash"
}
```
- create task:

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
    "performer": int
}
```
### PUT requests
- close task:

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
    "id": int
}
```
