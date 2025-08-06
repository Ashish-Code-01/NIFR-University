<?php
include 'config.php';  
require 'header.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve user input from the form
    $email = $_SESSION['admin_username'];
    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    // You should validate and sanitize user input here

    // Check if the new password matches the confirm password
    if ($newPassword !== $confirmPassword) {
        echo "<script>alert('New password and confirm password do not match.')</script>";
    }

    // TODO: Perform database query to check the current password and update it
    $sql = "SELECT PASS_WORD FROM department_master WHERE EMAIL = '$email'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);

        if ($row) {
            $currentPasswordFromDatabase = $row['PASS_WORD'];

            // Verify the current password (plaintext comparison, not recommended)
            if ($currentPassword === $currentPasswordFromDatabase) {
                // Update the user's password in the database (plaintext, not recommended)
                $updateSql = "UPDATE department_master SET PASS_WORD = '$newPassword' WHERE EMAIL = '$email'";
                $updateResult = mysqli_query($conn, $updateSql);

                if ($updateResult) {
                    echo "<script>alert('Password changed successfully.')</script>";
                } else {
                    echo "Error updating password: " . mysqli_error($conn);
                }
            } else {
                echo "<script>alert('Current password is incorrect.')</script>";
            }
        } else {
            echo "<script>alert('User not found.')</script>";
        }
    } else {
        echo "Error retrieving user information: " . mysqli_error($conn);
    }
}
?>

    <div class="div">
    <div class="mb-3">
        <p class="text-center fs-4 "><B>Change Password </p>
    </div>
    <form action="" method="post" autocomplete="off">

        <div class="mb-3">
            <label class="form-label">
                Current Password
            </label>
            <input type="password" name="current_password" class="form-control" placeholder="Enter Current Password" required>
        </div>
        
        <div class="mb-3">
            <label class="form-label">
                New Password
            </label>
            <input type="password" name="new_password" class="form-control" placeholder="Enter New Password" required>
        </div>
       
        <div class="mb-3">
            <label class="form-label">
                Confirm New Password
            </label>
            <input type="password" name="confirm_password" class="form-control" placeholder="Confirm New Password" required>
        </div>

        <button type="submit" class="submit">Change Password</button>
    </form>
    </div>

<?php
require "footer.php";
?>