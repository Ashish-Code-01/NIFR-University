<?php

include 'config.php';

session_start();
error_reporting(0); // Enable all error reporting

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["email"])) {
    $email = trim($_POST["email"]);

    // Generate a secure random token
    $token = bin2hex(random_bytes(16)); // 128-bit token
    //$otp = rand(100000, 999999); // 6-digit OTP  // Generate a secure random token
    $expiry = date("Y-m-d H:i:s", time() + (60 * 60)); // Token valid for 1 hour

    // Check if the email exists in the database
    $sql = "SELECT * FROM department_master WHERE EMAIL = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Email exists, update the database with the reset token and expiry
        $update_sql = "UPDATE department_master SET 
                       RESET_PASSWORD = ?, 
                       RESET_TOKEN_EXPIRE = ? 
                       WHERE EMAIL = ?";
        $update_stmt = $conn->prepare($update_sql);
        if (!$update_stmt) {
            die("Prepare failed: " . $conn->error);
        }
        $update_stmt->bind_param("sss", $token, $expiry, $email);

        if ($update_stmt->execute()) {
            // Send the password reset email
            
            $reset_link = "https://nirf.univofmumbai.in/dashboard.php/reset_password.php?token=$token"; // Update the URL with your actual domain
            $subject = "Password Reset Request";
            $message = "Hello,\n\nWe received a password reset request for your account.\n\n" .
                       "Click the link below to reset your password:\n\n$reset_link\n\n" .
                       "Note: This link will expire in 1 hour.\n\n" .
                       "If you didn't request this, please ignore this email.";
            $headers = "From: no-reply@yourdomain.com";

            if (mail($email, $subject, $message, $headers)) {
                echo "<script>alert('Password reset link has been sent to your email.');</script>";
                echo "<script>window.location.href = 'index.php';</script>";
            } else {
                echo "<script>alert('Failed to send email. Please try again later.');</script>";
            }
        } else {
            die("Database update failed: " . $update_stmt->error);
        }
    } else {
        // Email not found
        echo "<script>alert('Email address not registered.');</script>";
    }
} else {
    echo "<script>alert('Invalid access.');</script>";
}

?>


<!-- 
############################### -->
<!-- 
id = DEPT_ID 
Name = DEPT_NAME
name
email = EMAIL
password_hash = PASS_WORD
reset_token_hash = RESET_PASSWORD (RESET_PASSWORD_TOKEN)
reset_token_expires = RESET_TOKEN_EXPIRE (RESET_TOKEN_EXPIRE_TIME) -->






