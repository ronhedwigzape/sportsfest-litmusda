<?php
    if(!isset($_SESSION)){
        session_start();
    }

    // Check if the user is not logged in and is not trying to log in
    if(!isset($_SESSION['admin_id']) && !isset($_POST['username']) && !isset($_POST['password'])){
        $path = defined('LOGIN_PAGE_PATH') ? LOGIN_PAGE_PATH : '';
        header('Location: ' . $path . 'login.php?next=' . $_SERVER['REQUEST_URI']);
        exit;
    }

?>