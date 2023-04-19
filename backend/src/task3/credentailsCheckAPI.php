<?php declare (strict_types = 1) ?>
<?php

class credentailsAPI
{
 public function checkCredentails($conn, $data)
 {
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
     echo json_encode($response);
    }
   }
  }
 }
