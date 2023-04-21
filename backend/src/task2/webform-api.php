<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT");
header("Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token");
header("Content-Type: application/json");
$token = '6112498499:AAHeg-V30cy7u_K5hCXO32K-jqnVgWpmwqU';
$chat_id = '196187013';
$url = 'https://api.telegram.org/bot' . $token . '/sendMessage?chat_id=' . $chat_id;
?>


<?php
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && $_SERVER["CONTENT_TYPE"] == 'application/json') {
    $content = file_get_contents("php://input");
    $data = json_decode($content, true);
    $name = htmlspecialchars($data["name"]);
    $subject = htmlspecialchars($data["subject"]);
    $message = htmlspecialchars($data["message"]);
    $email = htmlspecialchars($data["email"]);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo json_encode(array("message" => "Invalid email format."));
    } else {
        if (!mb_strlen($name) || !mb_strlen($subject) || !mb_strlen($message)) {
            http_response_code(400);
            echo json_encode(array("message" => "Name, subject or message cannot be empty."));
        } else {
          $stmt = $conn->prepare("INSERT INTO `contact` (`name`, `email`, `subject`, `message`) VALUES (?, ?, ?, ?)");
          $stmt->bind_param("ssss", $name, $email, $subject, $message);
          if ($stmt->execute()) {
           http_response_code(201);
           $response["message"] = "Contact form has been submitted successfully.";
           echo json_encode($response);
           file_get_contents($url . '&text=' . urlencode("Name: $name, email: $email, subject: $subject, message: $message."));
          } else {
           http_response_code(500);
           $response["message"] = "Error: " . $stmt->error;
           echo json_encode($response);
        }
    }
}
}
?>