<?php

// include 'config.php';


// function PERMISSION($rank) {


//     if(isset($_SESSION["PERMISSION"]) && !$_SESSION["PERMISSION"][$rank]) {
//         header("DeniedError.php");
//         die();
//     }

// }

// $_SESSION["PERMISSION"]["ADMIN"] = isset($_SESSION['my_permission']) && trim($_SESSION['my_permissin']) == "admin";
// $_SESSION["PERMISSION"]["USER"] = isset($_SESSION['my_permission']) && trim($_SESSION['my_permissin']) == "user";


?>




<?php
// session_start();
error_reporting(0);

// Function to check permissions
function checkPermission($requiredPermission) {
    if (!isset($_SESSION['my_permission']) || $_SESSION['my_permission'] !== $requiredPermission) {
        // If user doesn't have the required permission, redirect to an "Access Denied" page
        header("Location: DeniedError.php");
        exit();
    }
}

// For admin pages, call this function like so:
// checkPermission('admin');
?>


