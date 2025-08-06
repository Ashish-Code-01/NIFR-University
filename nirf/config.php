<?php 

$server = "localhost";
// $user = "u257276344_uomnirf";
// $pass = "Uomnirf@2023";
$user="root";
$pass= "";
$database = "u257276344_Nirf";

$conn = mysqli_connect($server, $user, $pass, $database);

if (!$conn) {
    die("<script>alert('Connection Failed.')</script>");
}

?>