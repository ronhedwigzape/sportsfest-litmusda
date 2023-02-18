<?php
//---------------Check-connection-for-mysql-database-----------------//
$server_name = "localhost";
$username = "root";
$password = "";
$db_name = "sportsfest-litmusda";

$conn = mysqli_connect($server_name, $username, $password, $db_name);

if (!$conn) {
    echo "Connection failed!";
}