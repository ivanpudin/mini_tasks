<?php declare (strict_types = 1) ?>
<?php

class createTaskAPI
{
 public function createTask($conn, $data)
 {
   $title = htmlspecialchars($data["title"]);
   $description = htmlspecialchars($data["description"]);
   $deadline = htmlspecialchars($data["deadline"]);
   $performer =$data["performer"];
   if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $deadline) || !intval($performer)) {
    http_response_code(400);
    header("Content-Type: application/json");
    echo json_encode(array("message" => "Invalid date or performer id format"));
   } else {
      if (!mb_strlen($title) || !mb_strlen($description)) {
          http_response_code(400);
          echo json_encode(array("message" => "title or description cannot ne empty."));
      } else {
        $stmt = $conn->prepare("SELECT * FROM `tasks` WHERE `title`=? AND `description`=? AND `deadline`=? AND `performer`=? AND `status`=0");
       $stmt->bind_param("ssss", $title, $description, $deadline, $performer);
       $stmt->execute();
        $result = $stmt->get_result();
        if ($result) {
          if ($result->num_rows != 0) {
            http_response_code(409);
            header("Content-Type: application/json");
            $response["message"] = "Task already exists.";
            echo json_encode($response);
          } else {
            $stmt = $conn->prepare("INSERT INTO `tasks` (`title`, `description`, `deadline`, `performer`) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $title, $description, $deadline, $performer);
            if ($stmt->execute()) {
             http_response_code(201);
             header("Content-Type: application/json");
             $response["success"] = true;
             $response["message"] = "Task has been created successfully.";
             echo json_encode($response);
            } else {
             http_response_code(500);
             header("Content-Type: application/json");
             $response["success"] = false;
             $response["message"] = "Error: " . $stmt->error;
             echo json_encode($response);
            }
            echo json_encode($response);
           }
        }
      }
  }
}
}