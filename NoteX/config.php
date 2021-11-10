<?php

$server = "localhost";
$user = "root";
$password = "";
$database = "simple_note";

$conn = mysqli_connect($server, $user, $password, $database);

if (!$conn) {
    die("<script>alert('Connection Failed')</script>");
}

?>
