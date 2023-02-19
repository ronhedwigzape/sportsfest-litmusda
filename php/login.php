<?php
require_once 'config.php';

if(isset($_POST)) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $result = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username' ");

    while($row = mysqli_fetch_array($result)){
        if($row['password'] == $password && $row['type'] == 'admin'){
            $_SESSION['id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['fullname'] = $row['fullname'];
            echo json_encode([
                'id' => $row['id'],
                'username' => $row['username'],
                'fullname' => $row['fullname']
            ]);
        }
        else if($row['user_password'] == $password && $row['type'] == 'judge'){
            $_SESSION['id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            echo json_encode([
                'id' => $row['id'],
                'username' => $row['username'],
                'fullname' => $row['fullname']
            ]);
        }
    }
}

