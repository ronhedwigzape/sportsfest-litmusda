<?php
    if(!isset($_SESSION)){
        session_start();
    }

    require_once '../config/database.php';
    require_once '../models/Admin.php';

    // Check if the user is not logged in and is not trying to log in
    if(!isset($_SESSION['admin_id']) && !isset($_POST['username']) && !isset($_POST['password'])){
        header('Location: login.php');
        exit;
    }

?>