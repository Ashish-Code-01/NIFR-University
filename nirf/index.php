<?php 

include 'config.php';

session_start();

error_reporting(0);

if (isset($_SESSION['admin_username'])) {
    header("Location: dashboard.php");
}

if (isset($_POST['submit'])) {
	$email = $_POST['email'];
	$password = ($_POST['password']);

	$sql = "SELECT * FROM department_master WHERE BINARY `EMAIL`='$email' AND `PASS_WORD`='$password'";
	$result = mysqli_query($conn, $sql);
	$num_rows = mysqli_num_rows($result);
	if ($num_rows > 0) {
		$row = mysqli_fetch_assoc($result);
		$_SESSION['admin_username'] = $row['EMAIL'];
		$_SESSION['dept_id'] = $row['DEPT_ID'];
		header("Location: dashboard.php");
	} else {
		echo "<script>alert('Woops! Email or Password is Wrong.')</script>";
	}
}

if (isset($_POST['login'])) {
	$email = $_POST['email'];
	$password = ($_POST['password']);

	$sql = "SELECT * FROM department_master WHERE BINARY `EMAIL`='UDIT@gmail.com' AND `PASS_WORD`='$password'";
	$result = mysqli_query($conn, $sql);
	$num_rows = mysqli_num_rows($result);
	if ($num_rows > 0) {
		$row = mysqli_fetch_assoc($result);
		$_SESSION['admin_username'] = $row['EMAIL'];
		$_SESSION['dept_id'] = $row['DEPT_ID'];
		header("Location: admin/admin.php");
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
  <img src="assets\img\mumbai-university-removebg-preview.png" alt="image" height="100px" width="">
  <h1>University Of Mumbai</h1>
  <img src="assets\img\nirf-full-removebg-preview.png" alt="image" height="90px" width="">
</div>
</nav>
	<div class="main">

		<div class="container news">
			<p id="news">Instructions</p>
			<p id="newsDesc">1. India Ranking NIRF 2023-24 data capturing system of University of Mumbai is now open. <br>
            2. The last date of submission is 18/12/2023 <br>
            3. For operational guidance, please refer to this link 
			
		<?php
        if (isset($_GET['file_path']) && isset($_GET['file_name'])) {
            $file_path = $_GET['file_path'];
            $file_name = $_GET['file_name'];
    
            $full_path = $file_path . $file_name;

            if (file_exists($full_path)) {
                // Set headers for force download
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="' . basename($full_path) . '"');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($full_path));

                // Clear output buffer
                ob_clean();
                flush();

                // Read the file and output its contents
                if ($file = fopen($full_path, 'rb')) {
                    while (!feof($file) && (connection_status() === 0)) {
                        echo fread($file, 8192);
                        flush();
                    }
                    fclose($file);
                }

                exit;
            } else {
                // File not found
                echo 'File not found.';
            }
        }
        ?>
            <a href="?file_path=assets/files/&file_name=Nirf_Sample_Data.pdf">Click here</a>

            </p>
		</div>
		
		<div class="container">
			<form action="" method="POST" class="login-email" onsubmit="return validateForm()">
				<p class="login-text" style="font-size: 2rem; font-weight: 800;">Login</p>
				<div class="input-group">
					<input type="email" placeholder="Email" name="email" value="<?php echo $email; ?>" required>
				</div>
				<div class="input-group">
					<input type="password" placeholder="Password" name="password" value="<?php echo $_POST['password']; ?>" required>
				</div>
				
				<div class="input-group">
					<button name="submit" class="btn">Login</button>
				</div>

				
					<button name="login" class="nodal-officer">Login as a nodal Officer</button>
			</form>
		</div>
		
		<div class="container helpdesk">
			<p id="help">Helpdesk</p>
			<p id="description">For technical query, Contact us at
				<a href="mailto:techhelpnirf@gmail.com?">techhelpnirf@gmail.com</a>
			</p>
		</div>
	</div>
</body>
</html>