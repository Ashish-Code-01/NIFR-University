
<?php
include "config.php";
require "header.php";

include"PERMISSION.php";
checkPermission('user');

error_reporting(0);

// Ensure session_start() is called only once, so no need to call it here again
if (isset($_SESSION['admin_username'])) {
    // Sanitize and display session data
    $admin_username = htmlspecialchars($_SESSION['admin_username'], ENT_QUOTES, 'UTF-8');
    echo "<div><b><h4>Hello, {$admin_username}</h4></b></div>";
} else {
    echo "<div>Please log in to access this page.</div>";
}

require "footer.php";
?>

