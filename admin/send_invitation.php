<?php
error_reporting(0);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);

    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'test'); // Replace with actual credentials
    if ($conn->connect_error) {
        die('Database connection failed: ' . $conn->connect_error);
    }

    // Check if the email already exists in department_master
    $stmt = $conn->prepare("SELECT email FROM department_master WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "<script>alert('This email is already registered.'); window.location.href = 'Dashboard.php';</script>";
        exit();
    }
    $stmt->close();

    // Generate a unique token
    $token = bin2hex(random_bytes(32));

    // Set expiration time (1 hour from now)
    $expire_time = date('Y-m-d H:i:s', strtotime('+1 hour'));

    // Insert the token and expiration time into the database
    $stmt = $conn->prepare("INSERT INTO user_invitationss (email, token, RESET_TOKEN_EXPIRE) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $email, $token, $expire_time);
    
    if ($stmt->execute()) {
        // Prepare the account creation link
        $link = "https://localhost/univofmumbai.in/public_html/nirf/create_account.php?token=$token";

        // Send the email
        $subject = "NIRF Create Your Account";
        $message = "Click the link below to create your account:\n\n" . $link;
        $headers = "From: no-reply@yourdomain.com\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

        if (mail($email, $subject, $message, $headers)) {
            echo "<script>alert('Invitation email has been sent to $email.'); window.location.href = 'Dashboard.php';</script>";
        } else {
            echo "<script>alert('Failed to send the invitation email.'); window.location.href = 'Dashboard.php';</script>";
        }
    } else {
        echo "<script>alert('Failed to store the invitation token.'); window.location.href = 'Dashboard.php';</script>";
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>
