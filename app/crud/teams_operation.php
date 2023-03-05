<?php

require_once '../config/database.php';
require_once '../models/Team.php';

// Insert Data
if(isset($_POST['insertdata'])) {

    $name = $_POST['name'];
    $color = $_POST['color'];
    $file_name = '';

    // Handle file upload
    if(isset($_FILES['logo'])) {
        $file_name = $_FILES['logo']['name'];
        $file_tmp = $_FILES['logo']['tmp_name'];
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

    $team = new Team();
    $team->setName($name);
    $team->setColor($color);
    $team->setLogo($file_name);
    $team->insert();
}


// Update Data
if (isset($_POST['updatedata'])) {

    $id = $_POST['update_id'];
    $name = $_POST['name'];
    $color = $_POST['color'];
    $file_name = '';

    // Handle file upload
    if(isset($_FILES['logo']) && $_FILES['logo']['error'] !== UPLOAD_ERR_NO_FILE) {
        $file_name = $_FILES['logo']['name'];
        $file_tmp = $_FILES['logo']['tmp_name'];
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
        $team = Team::findById($id);
        $file_name = $team->getLogo();
    }

    $team = Team::findById($id);
    $team->setName($name);
    $team->setColor($color);
    $team->setLogo($file_name);
    $team->update();
}


// Delete Data
if(isset($_POST['deletedata'])) {

    $id = $_POST['delete_id'];
    $team = Team::findById($id);
    $team->delete();
}

$url = $_SERVER['HTTP_REFERER'];
header("location: $url");