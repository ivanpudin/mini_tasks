<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT");
header("Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token");
header("Content-Type: application/json");
?>

<?php
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && $_SERVER["CONTENT_TYPE"] == 'application/json') {
    $content = file_get_contents("php://input");
    $data = json_decode($content, true);
    $name = htmlspecialchars($data["name"]); //add a validation: should not be null
    $email = htmlspecialchars($data["email"]); //add a validation: see line 13 of the credentailsCheckAPI.php file and should not be null
    $subject = htmlspecialchars($data["subject"]); //add a validation: should not be null
    $message = htmlspecialchars($data["message"]); //add a validation: should not be null
    $stmt = $conn->prepare("INSERT INTO `contact` (`name`, `email`, `subject`, `message`) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $subject, $message);
    if ($stmt->execute()) {
     http_response_code(201);
     $response["success"] = true;
     $response["message"] = "Contact form has been submitted successfully.";
     echo json_encode($response);
    } else {
     http_response_code(500);
     $response["success"] = false;
     $response["message"] = "Error: " . $stmt->error;
     echo json_encode($response);
    }
}
?>