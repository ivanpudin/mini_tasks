<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT");
header("Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token");

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
 $content = file_get_contents("php://input");
 $data = json_decode($content, true);
 $action = htmlspecialchars($data["action"]);
 if ($action == 'get_user') {
  $email = htmlspecialchars($data["email"]);
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
   http_response_code(400);
   header("Content-Type: application/json");
   echo json_encode(array("message" => "Invalid email format."));
  } else {
   $password = htmlspecialchars($data["password"]);
   $stmt = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ?");
   $stmt->bind_param("ss", $email, $password);
   if ($stmt->execute()) {
    $result = $stmt->get_result();
    if ($result->num_rows == 1) {
     $user = $result->fetch_assoc();
     http_response_code(200);
     header("Content-Type: application/json");
     echo json_encode($user);
    } else {
     http_response_code(401);
     header("Content-Type: application/json");
     echo json_encode(array("message" => "Invalid email or password."));
    }
   } else {
    http_response_code(500);
    header("Content-Type: application/json");
    $response["success"] = false;
    $response["message"] = "Error: " . $stmt->error;
   }
  }
 }
}
;

//get all users
if ($_SERVER["REQUEST_METHOD"] == "GET" && $_GET["action"] == "get_users") {
 $sql = "SELECT id, firstname, lastname FROM `users`;";
 $result = mysqli_query($conn, $sql);
 if ($result) {
  if (mysqli_num_rows($result) != 0) {
   $users = array();
   while ($row = mysqli_fetch_assoc($result)) {
    array_push($users, $row);
   }
   header("Content-Type: application/json");
   echo json_encode($users);
  } else {
   http_response_code(204);
   header("Content-Type: application/json");
  }
 } else {
  http_response_code(500);
  header("Content-Type: application/json");
  $response["success"] = false;
  $response["message"] = "Error: " . $stmt->error;
 }
}

/* TASKS SECTION */
//get all unfinished tasks
if ($_SERVER["REQUEST_METHOD"] == "GET" && $_GET["action"] == "get_tasks" && !isset($_GET["user"]) && !isset($_GET["deadline"])) {
 $sql = "
       SELECT tasks.id, title, description, created_at, deadline, firstname, lastname, status
       FROM `tasks`
       JOIN `users` ON users.id = tasks.performer
       WHERE `status` != 1
       ORDER BY `tasks`.`deadline` ASC;
       ";
 $result = mysqli_query($conn, $sql);
 if ($result) {
  if (mysqli_num_rows($result) != 0) {
   $tasks = array();
   while ($row = mysqli_fetch_assoc($result)) {
    array_push($tasks, $row);
   }
   header("Content-Type: application/json");
   echo json_encode($tasks);
  } else {
   http_response_code(204);
   header("Content-Type: application/json");
  }
 } else {
  http_response_code(500);
  header("Content-Type: application/json");
  $response["success"] = false;
  $response["message"] = "Error: " . $stmt->error;
 }
}

//get all unfinished tasks of user
if ($_SERVER["REQUEST_METHOD"] == "GET" && $_GET["action"] == "get_tasks" && isset($_GET["user"]) && !isset($_GET["deadline"])) {
 $id = htmlspecialchars($_GET["user"]);
 if ((!is_numeric($id))) {
  http_response_code(400);
  header("Content-Type: application/json");
  echo json_encode(array("message" => "Invalid user id format"));
 } else {
  $stmt = $conn->prepare("
          SELECT tasks.id, title, description, created_at, deadline, firstname, lastname, status
          FROM `tasks`
          JOIN `users` ON users.id = tasks.performer
          WHERE performer = ? and status != 1
          ORDER BY `tasks`.`deadline` ASC;
     ");
  $stmt->bind_param("i", $id);
  if ($stmt->execute()) {
   $result = $stmt->get_result();
   if (mysqli_num_rows($result) != 0) {
    $tasks = array();
    while ($row = mysqli_fetch_assoc($result)) {
     array_push($tasks, $row);
    }
    header("Content-Type: application/json");
    echo json_encode($tasks);
   } else {
    http_response_code(204);
    header("Content-Type: application/json");
   }
  } else {
   http_response_code(500);
   header("Content-Type: application/json");
   $response["success"] = false;
   $response["message"] = "Error: " . $stmt->error;
  }
 }
}

//get specific task
if ($_SERVER["REQUEST_METHOD"] == "GET" && $_GET["action"] == "get_task" && isset($_GET["task"])) {
 $id = htmlspecialchars($_GET["task"]);
 if ((!is_numeric($id))) {
  http_response_code(400);
  header("Content-Type: application/json");
  echo json_encode(array("message" => "Invalid user id format"));
 } else {
  $stmt = $conn->prepare("
      SELECT tasks.id, title, description, created_at, deadline, firstname, lastname, status
      FROM `tasks`
      JOIN `users` ON users.id = tasks.performer
      WHERE tasks.id = ?;
      ");
  $stmt->bind_param("i", $id);
  if ($stmt->execute()) {
   $result = $stmt->get_result();
   if (mysqli_num_rows($result) != 0) {
    $tasks = mysqli_fetch_assoc($result);
    header("Content-Type: application/json");
    echo json_encode($tasks);
   } else {
    http_response_code(204);
    header("Content-Type: application/json");
   }
  } else {
   http_response_code(500);
   header("Content-Type: application/json");
   $response["success"] = false;
   $response["message"] = "Error: " . $stmt->error;
  }
 }
}

//get all the tasks with a due date up to a specific date
if ($_SERVER["REQUEST_METHOD"] == "GET" && $_GET["action"] == "get_tasks" && isset($_GET["deadline"]) && !isset($_GET["user"])) {
 $date = htmlspecialchars($_GET["deadline"]);
 if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
  http_response_code(400);
  header("Content-Type: application/json");
  echo json_encode(array("message" => "Invalid date format"));
 } else {
  list($year, $month, $day) = explode('-', $date);
  $stmt = $conn->prepare("
          SELECT tasks.id, title, description, created_at, deadline, firstname, lastname, status
          FROM `tasks`
          JOIN `users` ON users.id = tasks.performer
          WHERE deadline <= ? and status != 1
          ORDER BY `tasks`.`deadline` ASC;");
  $date = $year . '-' . $month . '-' . $day;
  $stmt->bind_param("s", $date);
  if ($stmt->execute()) {
   $result = $stmt->get_result();
   if (mysqli_num_rows($result) != 0) {
    $tasks = array();
    while ($row = mysqli_fetch_assoc($result)) {
     array_push($tasks, $row);
    }
    header("Content-Type: application/json");
    echo json_encode($tasks);
   } else {
    http_response_code(204);
    header("Content-Type: application/json");
   }
  } else {
   http_response_code(500);
   header("Content-Type: application/json");
   $response["success"] = false;
   $response["message"] = "Error: " . $stmt->error;
  }
 }
}

//get all the user's due tasks by a specific date
if ($_SERVER["REQUEST_METHOD"] == "GET" && $_GET["action"] == "get_tasks" && isset($_GET["deadline"]) && isset($_GET["user"])) {
 $date = htmlspecialchars($_GET["deadline"]);
 $user = htmlspecialchars($_GET["user"]);
 if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date) || (!is_numeric($user))) {
  http_response_code(400);
  header("Content-Type: application/json");
  echo json_encode(array("message" => "Invalid date or user id format"));
 } else {
  list($year, $month, $day) = explode('-', $date);
  $stmt = $conn->prepare("
          SELECT tasks.id, title, description, created_at, deadline, firstname, lastname, status
          FROM `tasks`
          JOIN `users` ON users.id = tasks.performer
          WHERE deadline <= ? and status != 1 and users.id = ?
          ORDER BY `tasks`.`deadline` ASC;");
  $date = $year . '-' . $month . '-' . $day;
  $stmt->bind_param("si", $date, $user);
  if ($stmt->execute()) {
   $result = $stmt->get_result();
   if (mysqli_num_rows($result) != 0) {
    $tasks = array();
    while ($row = mysqli_fetch_assoc($result)) {
     array_push($tasks, $row);
    }
    header("Content-Type: application/json");
    echo json_encode($tasks);
   } else {
    http_response_code(204);
    header("Content-Type: application/json");
   }
  } else {
   http_response_code(500);
   header("Content-Type: application/json");
   $response["success"] = false;
   $response["message"] = "Error: " . $stmt->error;
  }
 }
}

//create task
if ($_SERVER["REQUEST_METHOD"] == "POST" && $_SERVER["CONTENT_TYPE"] == 'application/json') {
 $content = file_get_contents("php://input");
 $data = json_decode($content, true);
 $action = htmlspecialchars($data["action"]);
 if ($action == 'create_task') {
  $title = htmlspecialchars($data["title"]);
  $description = htmlspecialchars($data["description"]);
  $deadline = htmlspecialchars($data["deadline"]);
  $performer = htmlspecialchars($data["performer"]);
  if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $deadline) || (!preg_match('/^\d+$/', $performer))) {
   http_response_code(400);
   header("Content-Type: application/json");
   echo json_encode(array("message" => "Invalid date or performer id format"));
  } else {
   $stmt = $conn->prepare("INSERT INTO `tasks` (`title`, `description`, `deadline`, `performer`) VALUES (?, ?, ?, ?)");
   $stmt->bind_param("ssss", $title, $description, $deadline, $performer);
   if ($stmt->execute()) {
    http_response_code(201);
    header("Content-Type: application/json");
    $response["success"] = true;
    $response["message"] = "Task has been created successfully.";
   } else {
    http_response_code(500);
    header("Content-Type: application/json");
    $response["success"] = false;
    $response["message"] = "Error: " . $stmt->error;
   }
   echo json_encode($response);
  }
 }
}

//close task
if ($_SERVER["REQUEST_METHOD"] == "PUT" && $_SERVER["CONTENT_TYPE"] == 'application/json') {
 $content = file_get_contents("php://input");
 $data = json_decode($content, true);
 $action = htmlspecialchars($data["action"]);
 if ($action == 'close_task') {
  $comment = htmlspecialchars($data["comment"]);
  $status = htmlspecialchars($data["status"]);
  $closing_date = htmlspecialchars($data["closing_date"]);
  $id = $data["id"];
  if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $closing_date) || (!is_numeric($id))) {
   http_response_code(400);
   header("Content-Type: application/json");
   echo json_encode(array("message" => "Invalid date or id format"));
  } else {
   $stmt = $conn->prepare("UPDATE `tasks` SET `status` = ?, `comment` = ?, `closing_date` = ? WHERE `tasks`.`id` = ?");
   $stmt->bind_param("sssi", $status, $comment, $closing_date, $id);
   if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
     http_response_code(200);
     header("Content-Type: application/json");
     $response["success"] = true;
     $response["message"] = "Task have been closed successfully.";
    } else {
     http_response_code(400);
     header("Content-Type: application/json");
     $response["success"] = false;
     $response["message"] = "No tasks have been closed.";
    }
   } else {
    http_response_code(500);
    header("Content-Type: application/json");
    $response["success"] = false;
    $response["message"] = "Error: " . $stmt->error;
   }
   echo json_encode($response);
  }
 }
}
