<?php

require_once '../config/database.php';
require_once '../models/Judge.php';

// Insert Data
if(isset($_POST['insertdata'])) {

    $number = $_POST['number'];
    $name = $_POST['name'];
    $file_name = '';
    $is_chairman = $_POST['is_chairman'];
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

    $judge = new Judge();
    $judge->setNumber($number);
    $judge->setName($name);
    $judge->setAvatar($file_name);
    $judge->setIsChairman($is_chairman);
    $judge->setUsername($username);
    $judge->setPassword($password);
    $judge->insert();
}

// Update Data
if (isset($_POST['updatedata'])) {

    $id = $_POST['update_id'];
    $number = $_POST['number'];
    $name = $_POST['name'];
    $file_name = '';
    $is_chairman = $_POST['is_chairman'];
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
        $judge = Judge::findById($id);
        $file_name = $judge->getAvatar();
    }

    $judge = Judge::findById($id);
    $judge->setNumber($number);
    $judge->setName($name);
    $judge->setAvatar($file_name);
    $judge->setIsChairman($is_chairman);
    $judge->setUsername($username);
    $judge->setPassword($password);
    $judge->update();
}


// Delete Data
if(isset($_POST['deletedata'])) {

    $id = $_POST['delete_id'];
    $judge = Judge::findById($id);
    $judge->delete();
}

$url = $_SERVER['HTTP_REFERER'];
header("location: $url");