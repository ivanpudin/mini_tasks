<?php declare (strict_types = 1);

class createUserAPI
{
  public function createUser($conn, $data)
  {
    $firstname = htmlspecialchars($data["firstname"]);
    $lastname = htmlspecialchars($data["lastname"]);
    $password = htmlspecialchars($data["password"]);
    $email = htmlspecialchars($data["email"]);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      http_response_code(400);
      header("Content-Type: application/json");
      echo json_encode(array("message" => "Invalid email format."));
    } else {
      $stmt = $conn->prepare("SELECT * FROM `users` WHERE `firstname`=? AND `lastname`=? AND `email`=? AND `password`=?");
      $stmt->bind_param("ssss", $firstname, $lastname, $email, $password);
      $stmt->execute();
      $result = $stmt->get_result();
      if ($result) {
        if ($result->num_rows != 0) {
          http_response_code(409);
          header("Content-Type: application/json");
          $response["message"] = "User already exists.";
        } else {
          $stmt = $conn->prepare("INSERT INTO `users` (`firstname`, `lastname`, `email`, `password`) VALUES (?, ?, ?, ?)");
          $stmt->bind_param("ssss", $firstname, $lastname, $email, $password);
          if ($stmt->execute()) {
            http_response_code(201);
            header("Content-Type: application/json");
            $response["message"] = "User has been created successfully.";
          } else {
            http_response_code(500);
            header("Content-Type: application/json");
            $response["message"] = "Error: " . $stmt->error;
          }
        }
      } else {
        http_response_code(500);
        header("Content-Type: application/json");
        $response["message"] = "Error: " . $stmt->error;
      }
      echo json_encode($response);
    }
  }
}
