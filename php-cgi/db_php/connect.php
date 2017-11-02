<?php 
//check if session variables are set, if not redirect to login screen
$servername = "dbserver.engr.scu.edu";
$username = "skarstei";
$password = "00001015034";
$dbname = "sdb_skarstei";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error){
  die("Connection failed: " .$conn->connect_error);
}


function clean_string($data) {
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
