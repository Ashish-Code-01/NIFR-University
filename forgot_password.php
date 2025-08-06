<?php
include 'config.php';

session_start();
error_reporting(0);

if (isset($_POST['submit'])) {
    $email = $_POST['email'];

    // Check if email exists$sql = "SELECT * FROM department_master WHERE EMAIL='$email'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $token = md5(rand()); // Generate random token$exp_time = date("Y-m-d H:i:s", strtotime('+1 hour'));

        // Save token to database$update_query = "UPDATE department_master SET RESET_TOKEN='$token', RESET_EXP='$exp_time' WHERE EMAIL='$email'";
        mysqli_query($conn, $update_query);

        $reset_link = "http://yourdomain.com/reset_password.php?token=$token";
        $subject = "Password Reset Request";
        $message = "Click here to reset your password: $reset_link";
        $headers = "From: no-reply@yourdomain.com";

        mail($email, $subject, $message, $headers);
        echo "<script>alert('Password reset link has been sent to your email.');</script>";
    } else {
        echo "<script>alert('Email not found.');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="./assets/css/style.css">
    <link rel="icon" href="assets/img/mumbai-university-removebg-preview.png" type="image/png">
    <title>MU NIRF PORTAL</title>
</head>
<body>
<nav class="navbar">
<div class="items">
  <img src="assets\img\mumbai-university-removebg-preview.png" alt="image" height="100px" width="">
  <h1>University Of Mumbai</h1>
  <img src="assets\img\nirf-full-removebg-preview.png" alt="image" height="90px" width="">
</div>
</nav>

    <div class="main">
        <div class="container">
            <form method="POST" action="SendPasswordReset.php" class="login-email">
                <p class="login-text" style="font-size: 2rem; font-weight: 800;">Forgot Password</p>
                <div class="input-group">
                    <input type="email" name="email" placeholder="Enter your registered email" required>
                </div>
                <div class="input-group">
                    <button type="submit" name="submit" class="btn">Send Reset Link</button>
                </div>
                <div class="input-group">                     
                    <a href="index.php" class="nodal-officer" style="text-align: center; text-decoration: none;">Back to Login</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
 