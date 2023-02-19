<?php
header("Access-Control-Allow-Origin: http://localhost:5176");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

##################### INIT SESSION ##################################
session_start();

###################### CONNECTION ###############################
$server_name = "localhost";
$username = "root";
$password = "";
$db_name = "sportsfest-litmusda";

$conn = mysqli_connect($server_name, $username, $password, $db_name);

if (!$conn) {
    echo "Connection failed!";
}