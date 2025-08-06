<?php 
$server = "localhost";
//$user = "u257276344_uomnirf";
//$pass = "Uomnirf@2023";
$database = "u257276344_Nirf";

####### added by me for testing ############
$user="root";
$pass= "";
// $database = "test";
####### added by me for testing ############

#### Connect to the database #######
$conn = mysqli_connect($server, $user, $pass, $database);

if (!$conn) {
    //die("<script>alert('Connection Failed.')</script>");
    die("<script>alert('Connection Failed: " . mysqli_connect_error() . "')</script>");

}
?>