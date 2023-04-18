<?php declare (strict_types = 1) ?>
<?php

class createTaskAPI
{
 public function createTask($conn)
 {
  $content = file_get_contents("php://input");
  $data = json_decode($content, true);
  $action = htmlspecialchars($data["action"]);
  if ($action == 'create_task') {
   $title = htmlspecialchars($data["title"]);
   $description = htmlspecialchars($data["description"]);
   $deadline = htmlspecialchars($data["deadline"]);
   $performer =$data["performer"];
   if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $deadline) || !intval($performer)) {
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
}
