<?php declare (strict_types = 1) ?>
<?php

class unfinishedTasksAPI
{
 public function getAllUnfinishedTasks($conn)
 {
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
     $row['id'] = (int) $row['id']; 
     $row['status'] = (int) $row['status']; 
     array_push($tasks, $row);
    }
    http_response_code(200);
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

 public function getAllUnfinishedTasksOfUser($conn)
 {
  $user = htmlspecialchars($_GET["user"]);
  if ((!is_numeric($user))) {
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
   $stmt->bind_param("i", $user);
   if ($stmt->execute()) {
    $result = $stmt->get_result();
    if (mysqli_num_rows($result) != 0) {
     $tasks = array();
     while ($row = mysqli_fetch_assoc($result)) {
      array_push($tasks, $row);
     }
     http_response_code(200);
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

 public function getSpecificTask($conn)
 {
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
   $stmt->bind_param("s", $id);
   if ($stmt->execute()) {
    $result = $stmt->get_result();
    if (mysqli_num_rows($result) != 0) {
     $tasks = mysqli_fetch_assoc($result);
     http_response_code(200);
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

 public function getAllTasksDueToSpecificDate($conn)
 {
  $deadline = htmlspecialchars($_GET["deadline"]);
  if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $deadline)) {
   http_response_code(400);
   header("Content-Type: application/json");
   echo json_encode(array("message" => "Invalid date format"));
  } else {
   list($year, $month, $day) = explode('-', $deadline);
   $stmt = $conn->prepare("
          SELECT tasks.id, title, description, created_at, deadline, firstname, lastname, status
          FROM `tasks`
          JOIN `users` ON users.id = tasks.performer
          WHERE deadline <= ? and status != 1
          ORDER BY `tasks`.`deadline` ASC;");
   $deadline = $year . '-' . $month . '-' . $day;
   $stmt->bind_param("s", $deadline);
   if ($stmt->execute()) {
    $result = $stmt->get_result();
    if (mysqli_num_rows($result) != 0) {
     $tasks = array();
     while ($row = mysqli_fetch_assoc($result)) {
      array_push($tasks, $row);
     }
     http_response_code(200);
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
 public function getAllTasksDueToSpecificDateOfUser($conn)
 {
  $deadline = htmlspecialchars($_GET["deadline"]);
  $user = htmlspecialchars($_GET["user"]);
  if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $deadline) || (!is_numeric($user))) {
   http_response_code(400);
   header("Content-Type: application/json");
   echo json_encode(array("message" => "Invalid date or user id format"));
  } else {
   list($year, $month, $day) = explode('-', $deadline);
   $stmt = $conn->prepare("
            SELECT tasks.id, title, description, created_at, deadline, firstname, lastname, status
            FROM `tasks`
            JOIN `users` ON users.id = tasks.performer
            WHERE deadline <= ? and status != 1 and users.id = ?
            ORDER BY `tasks`.`deadline` ASC;");
   $deadline = $year . '-' . $month . '-' . $day;
   $stmt->bind_param("si", $deadline, $user);
   if ($stmt->execute()) {
    $result = $stmt->get_result();
    if (mysqli_num_rows($result) != 0) {
     $tasks = array();
     while ($row = mysqli_fetch_assoc($result)) {
      array_push($tasks, $row);
     }
     http_response_code(200);
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
}
