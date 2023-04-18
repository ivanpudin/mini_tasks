<?php declare (strict_types = 1) ?>
<?php

class getAllUsersAPI
{
 public function getAllUsers($conn)
 {
  $sql = "SELECT id, firstname, lastname FROM `users`;";
  $result = mysqli_query($conn, $sql);
  if ($result) {
   if (mysqli_num_rows($result) != 0) {
    $users = array();
    while ($row = mysqli_fetch_assoc($result)) {
     $row['id'] = (int) $row['id']; 
     array_push($users, $row);
    }
    http_response_code(200);
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
}
