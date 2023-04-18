<?php 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT");
header("Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token");
?>
<?php include_once 'credentailsCheckAPI.php';?>
<?php include_once 'getAllUsersAPI.php';?>
<?php include_once 'getAllUnfinishedTasksAPI.php';?>
<?php include_once 'createTaskAPI.php';?>
<?php include_once 'closeTaskAPI.php';?>
<?php


$host = 'db';
$port = 7008;
$user = 'root';
$pass = 'lionPass';
$dbname = 'ApiDB';

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
 die("<div style='margin-top: 15px;'>Connection failed: {$conn->connect_error}</div>");
}

/* USERS SECTION */
// credentials check
if ($_SERVER["REQUEST_METHOD"] == "POST" && $_SERVER["CONTENT_TYPE"] == 'application/json') {
 (new credentailsAPI())->checkCredentails($conn);
}
;

//get all users
if ($_SERVER["REQUEST_METHOD"] == "GET" && $_GET["action"] == "get_users") {
 (new getAllUsersAPI())->getAllUsers($conn);
}

/* TASKS SECTION */
//get all unfinished tasks
if ($_SERVER["REQUEST_METHOD"] == "GET" && $_GET["action"] == "get_tasks" && !isset($_GET["user"]) && !isset($_GET["deadline"])) {
 (new unfinishedTasksAPI())->getAllUnfinishedTasks($conn);
}

//get all unfinished tasks of user
if ($_SERVER["REQUEST_METHOD"] == "GET" && $_GET["action"] == "get_tasks" && isset($_GET["user"]) && !isset($_GET["deadline"])) {
 
 (new unfinishedTasksAPI())->getAllUnfinishedTasksOfUser($conn);
}

//get specific task
if ($_SERVER["REQUEST_METHOD"] == "GET" && $_GET["action"] == "get_task" && isset($_GET["task"])) {
 (new unfinishedTasksAPI())->getSpecificTask($conn);
}

//get all the tasks with a due date up to a specific date
if ($_SERVER["REQUEST_METHOD"] == "GET" && $_GET["action"] == "get_tasks" && isset($_GET["deadline"]) && !isset($_GET["user"])) {
 (new unfinishedTasksAPI())->getAllTasksDueToSpecificDate($conn);
}

//get all the user's due tasks by a specific date
if ($_SERVER["REQUEST_METHOD"] == "GET" && $_GET["action"] == "get_tasks" && isset($_GET["deadline"]) && isset($_GET["user"])) {
 (new unfinishedTasksAPI())->getAllTasksDueToSpecificDateOfUser($conn);
}

//create task
if ($_SERVER["REQUEST_METHOD"] == "POST" && $_SERVER["CONTENT_TYPE"] == 'application/json') {
 (new createTaskAPI())->createTask($conn);
}

//close task
if ($_SERVER["REQUEST_METHOD"] == "PUT" && $_SERVER["CONTENT_TYPE"] == 'application/json') {
 (new closeTaskAPI())->closeTask($conn);
}
