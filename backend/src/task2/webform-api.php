<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT");
header("Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token");
header("Content-Type: application/json");
?>

<?php
include 'connect.php';

if (isset($_POST['submit'])) {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    $q = "INSERT INTO `contact`(`name`, `email`,`subject`, `message`) VALUES ('$name', '$email', '$subject', '$message')";

    $query = mysqli_query($conn, $q);

    if ($query) {
        echo "<script>alert('Thank you for contacting us');</script>";
    }

}

if ($_SERVER["REQUEST_METHOD"] == "POST" && $_SERVER["CONTENT_TYPE"] == 'application/json') {
    $content = file_get_contents("php://input");
    $data = json_decode($content, true);
    $name = htmlspecialchars($data["name"]);
    $email = htmlspecialchars($data["email"]);
    $subject = htmlspecialchars($subject["subject"]);
    $message = htmlspecialchars($data["message"]);
    $q = "INSERT INTO `contact`(`name`, `email`,`subject`, `message`) VALUES ('$name', '$email', '$subject', '$message')";

    $query = mysqli_query($conn, $q);
}
if ($query) {
    http_response_code(201);
    header("Content-Type: application/json");
    $response["success"] = true;
    $response["message"] = "Contact form has been created successfully.";
} else {
    http_response_code(500);
    header("Content-Type: application/json");
    $response["success"] = false;
    $response["message"] = "Error";
}
?>