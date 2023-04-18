<?php declare (strict_types = 1) ?>
<?php

class closeTaskAPI
{
 public function closeTask($conn)
 {
  $content = file_get_contents("php://input");
  $data = json_decode($content, true);
  $action = htmlspecialchars($data["action"]);
  if ($action == 'close_task') {
   $comment = htmlspecialchars($data["comment"]);
   $status = ($data["status"]);
   $closing_date = htmlspecialchars($data["closing_date"]);
   $id = $data["id"];
   if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $closing_date) || (!is_numeric($id)) || (!is_numeric($status))) {
    http_response_code(400);
    header("Content-Type: application/json");
    echo json_encode(array("message" => "Invalid date or id format"));
   } else {
    $stmt = $conn->prepare("UPDATE `tasks` SET `status` = ?, `comment` = ?, `closing_date` = ? WHERE `tasks`.`id` = ?");
    $stmt->bind_param("issi", $status, $comment, $closing_date, $id);
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
}
