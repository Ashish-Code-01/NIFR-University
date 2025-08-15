<?php 

// $server = "localhost";
// // $user = "u257276344_uomnirf";
// // $pass = "Uomnirf@2023";
// $user="root";
// $pass= "";
// $database = "u257276344_Nirf";

$server = "database-ranking-mu.ctqcaks44o4u.ap-south-1.rds.amazonaws.com";
$user = "admin";
$pass = "sO77NWrPV0f0Yi8AuhG5";
$database = "u257276344_Nirf_Test";

$conn = mysqli_connect($server, $user, $pass, $database);

if (!$conn) {
    die("<script>alert('Connection Failed.')</script>");
}

?>