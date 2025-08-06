<?php 

include 'config.php';

session_start();

error_reporting(0);

// Redirect to dashboard if already logged in
if (isset($_SESSION['admin_username'])) {
    header("Location: dashboard.php");
    exit();
}

// Function to sanitize input
function sanitizeInput($data) {
    $data = trim($data); // Remove extra spaces
    $data = stripslashes($data); // Remove slashes
    $data = htmlspecialchars($data); // Convert special characters to HTML entities
    return $data;
}

// Login for department_master
if (isset($_POST['submit'])) {
    // Sanitize and validate email and password
    $email = sanitizeInput($_POST['email']);
    $password = sanitizeInput($_POST['password']);
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format.')</script>";
        exit();
    }

    if (empty($password)) {
        echo "<script>alert('Password cannot be empty.')</script>";
        exit();
    }

    // Use prepared statements
    $stmt = $conn->prepare("SELECT * FROM department_master WHERE BINARY `EMAIL` = ? AND `PASS_WORD` = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    $num_rows = $result->num_rows;

    if ($num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['admin_username'] = $row['EMAIL'];
        $_SESSION['dept_id'] = $row['DEPT_ID'];
        $_SESSION['my_permission'] = $row['PERMISSION'];

        // Redirect to dashboard to prevent resubmission
        header("Location: dashboard.php");
        exit();
    } else {
        echo "<script>alert('Woops! Email or Password is Wrong.')</script>";
    }
}

// Login for boss
if (isset($_POST['login'])) {
    // Sanitize and validate email and password
    $email = sanitizeInput($_POST['email']);
    $password = sanitizeInput($_POST['password']);
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format.')</script>";
        exit();
    }

    if (empty($password)) {
        echo "<script>alert('Password cannot be empty.')</script>";
        exit();
    }

    // Use prepared statements
    $stmt = $conn->prepare("SELECT * FROM boss WHERE BINARY `EMAIL` = ? AND `PASS_WORD` = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    $num_rows = $result->num_rows;

    if ($num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['admin_username'] = $row['EMAIL'];
        $_SESSION['dept_id'] = $row['DEPT_ID'];
        $_SESSION['my_permission'] = $row['PERMISSION'];

        // Redirect to admin page to prevent resubmission
        // header("Location: admin/admin.php");
        header('Location: admin/Dashboard.php');
        exit();
    } else {
        echo "<script>alert('Woops! Email or Password is Wrong.')</script>";
    }
}
?>



<!DOCTYPE html>
<html>
<head>
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
            <img src="assets/img/mumbai-university-removebg-preview.png" alt="image" height="100px">
            <h1>University Of Mumbai</h1>
            <img src="assets/img/nirf-full-removebg-preview.png" alt="image" height="90px">
        </div>
    </nav>
    <div class="main">
        <div class="container news">
            <p id="news">Instructions</p>
            <p id="newsDesc">
                <br>1. India Ranking NIRF 2025 data capturing system of University of Mumbai is now open. <br>
                <br>2. The last date of submission is 28/12/2024 <br>
				<br>3. For operational guidance, please refer to this link 
				<?php
        			$file_path = "assets/files/Nirf_Sample_Data.pdf";
					if (file_exists($file_path)) {
            // File exists, display the link
			echo '<a href="' . $file_path . '" download>Click here</a>';
        } else {
            // File not found, display an error message
            echo '<span style="color: red;">File not found.</span>';
        }
        ?>
            </p>
        </div>

        <div class="container">
            <form action="" method="POST" class="login-email">
                <p class="login-text" style="font-size: 2rem; font-weight: 800;">Login</p>
                <div class="input-group">
                    <input type="email" placeholder="Email" name="email" required>
                </div>
                <div class="input-group">
                    <input type="password" placeholder="Password" name="password" required>
                </div>
                
                <div class="input-group">
                    <button name="submit" class="btn">Login</button>
                </div>

                <div>
                    <button name="login" class="nodal-officer">Login as a nodal Officer</button>
                </div>
                <div>
                    <p>Forgot Password? <a href="forgot_password.php">Click Here</a></p>
                </div>
            </form>
        </div>

        <div class="container helpdesk">
            <p id="help">Helpdesk</p>
            <p id="description">For technical query, Contact us at
                <a href="mailto:techhelpnirf@gmail.com">techhelpnirf@gmail.com</a>
            </p>
        </div>
    </div>
</body>
</html>

