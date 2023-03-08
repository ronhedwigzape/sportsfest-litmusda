<?php

require_once '../config/database.php';
require_once '../models/Technical.php';

// Insert Data
if(isset($_POST['insertdata'])) {

    $number = $_POST['number'];
    $name = $_POST['name'];
    $file_name = '';
    $username = $_POST['username'];
    $password = $_POST['password'];


    // Handle file upload
    if(isset($_FILES['avatar'])) {
        $file_name = $_FILES['avatar']['name'];
        $file_tmp = $_FILES['avatar']['tmp_name'];
        $arr_filename = explode('.', $file_name);
        $file_ext = strtolower(end($arr_filename));
        $extensions = array("jpeg", "jpg", "png");
        if(in_array($file_ext, $extensions) === false) {
            echo "File type not allowed, please choose a JPEG or PNG file.";
            exit();
        }
        $file_name = time() . '_' . $file_name; // add timestamp to prevent same file names
        move_uploaded_file($file_tmp, "uploads/" . $file_name);
    }

    $technical = new Technical();
    $technical->setNumber($number);
    $technical->setName($name);
    $technical->setAvatar($file_name);
    $technical->setUsername($username);
    $technical->setPassword($password);
    $technical->insert();
}

// Update Data
if (isset($_POST['updatedata'])) {

    $id = $_POST['update_id'];
    $number = $_POST['number'];
    $name = $_POST['name'];
    $file_name = '';
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Handle file upload
    if(isset($_FILES['avatar']) && $_FILES['avatar']['error'] !== UPLOAD_ERR_NO_FILE) {
        $file_name = $_FILES['avatar']['name'];
        $file_tmp = $_FILES['avatar']['tmp_name'];
        $arr_filename = explode('.', $file_name);
        $file_ext = strtolower(end($arr_filename));
        $extensions = array("jpeg", "jpg", "png");
        if(in_array($file_ext, $extensions) === false) {
            echo "File type not allowed, please choose a JPEG or PNG file.";
            exit();
        }
        $file_name = time() . '_' . $file_name; // add timestamp to prevent same file names
        move_uploaded_file($file_tmp, "uploads/" . $file_name);
    } else {
        $judge = Technical::findById($id);
        $file_name = $judge->getAvatar();
    }

    $technical = Technical::findById($id);
    $technical->setNumber($number);
    $technical->setName($name);
    $technical->setAvatar($file_name);
    $technical->setUsername($username);
    $technical->setPassword($password);
    $technical->update();
}


// Delete Data
if(isset($_POST['deletedata'])) {

    $id = $_POST['delete_id'];
    $technical = Technical::findById($id);
    $technical->delete();
}

$url = $_SERVER['HTTP_REFERER'];
header("location: $url");