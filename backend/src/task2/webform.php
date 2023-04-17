<?php
include 'connect.php';

if(isset($_POST['submit'])){


    $name= $_POST['name'];
    $email= $_POST['email'];
    $subject= $_POST['subject'];
    $message= $_POST['message'];
    $q= "INSERT INTO `contact`(`name`, `email`,`subject`, `message`) VALUES ('$name', '$email', '$subject', '$message')";

    $query = mysqli_query($conn, $q);


     if($query){
        echo "<script>alert('Thank you for contacting us');</script>";
     }
 

}
?>


<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="webform.css" media="all">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>    
    <script src="main.js"></script>
</head>

<body>
    <div class="container">
        <h1>Contact Us</h1>
        <form action="webform.php" method="POST" class="form">
            <div class="form-group">
                <label for="name" class="form-label">Your Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Please enter your name" tabindex="1" required>
            </div>
            <div class="form-group">
                <label for="email" class="form-label">Your Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Please enter your email" tabindex="2" required>
            </div>
            <div class="form-group">
                <label for="subject" class="form-label">Subject</label>
                <input type="text" class="form-control" id="subject" name="subject" placeholder="Subject" tabindex="3" required>
            </div>
            <div class="form-group">
                <label for="message" class="form-label">Message</label>
                <textarea class="form-control" rows="5" cols="50" id="message" name="message" placeholder="Enter Message..." tabindex="4"></textarea>
            </div>
            <div>
                <button type="submit" name="submit" class="btn">Send Message!</button>
            </div>
        </form>
    </div>
</body>

</html>

<style><?php include 'webform.css'?></style>