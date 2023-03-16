<?php

require_once 'auth.php';
require_once '../config/database.php';
require_once '../models/Team.php';

// Insert Data
if(isset($_POST['insertdata'])) {

    $name = $_POST['name'];
    $country = $_POST['country'];
    $file_name = '';

    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
        $file_name    = $_FILES['avatar']['name'];
        $file_tmp     = $_FILES['avatar']['tmp_name'];
        $arr_filename = explode('.', $file_name);
        $file_ext     = strtolower(end($arr_filename));
        $extensions   = array("jpeg", "jpg", "png");
        if (in_array($file_ext, $extensions) === false) {
            echo "File type not allowed, please choose a JPEG or PNG file.";
            exit();
        }
        $file_name = time() . '_' . $file_name;
        move_uploaded_file($file_tmp, "uploads/" . $file_name);
    } else {
        $file_name = 'no-avatar.jpg';
    }

    $team   = new Team();
    $team->setName($name);
    $team->setCountry($country);
    $team->setAvatar($file_name);
    $team->insert();
}


// Update Data
if (isset($_POST['updatedata'])) {

    $id = $_POST['update_id'];
    $name = $_POST['name'];
    $country = $_POST['country'];
    $file_name = '';

    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
        $file_name    = $_FILES['avatar']['name'];
        $file_tmp     = $_FILES['avatar']['tmp_name'];
        $arr_filename = explode('.', $file_name);
        $file_ext     = strtolower(end($arr_filename));
        $extensions   = array("jpeg", "jpg", "png");
        if (in_array($file_ext, $extensions) === false) {
            echo "File type not allowed, please choose a JPEG or PNG file.";
            exit();
        }
        $file_name = time() . '_' . $file_name;
        move_uploaded_file($file_tmp, "uploads/" . $file_name);
    } else {
        $team = Team::findById($id);
        $file_name = $team->getAvatar();
    }

    $team = Team::findById($id);
    $team->setName($name);
    $team->setCountry($country);
    $team->setAvatar($file_name);
    $team->update();
}


// Delete Data
if(isset($_POST['deletedata'])) {

    $id   = $_POST['delete_id'];
    $team = Team::findById($id);
    $team->delete();
}

$url = $_SERVER['HTTP_REFERER'];
header("location: $url");