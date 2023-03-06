<?php

require_once '../config/database.php';
require_once '../models/Competition.php';

// Insert Data
if(isset($_POST['insertdata'])) {

    $slug = $_POST['slug'];
    $title = $_POST['title'];

    $competition = new Competition();
    $competition->setSlug($slug);
    $competition->setTitle($title);
    $competition->insert();
}

// Update Data
if (isset($_POST['updatedata'])) {

    $id = $_POST['update_id'];
    $slug = $_POST['slug'];
    $title = $_POST['title'];

    $competition = Competition::findById($id);
    $competition->setSlug($slug);
    $competition->setTitle($title);
    $competition->update();
}

// Delete Data
if(isset($_POST['deletedata'])) {

    $id = $_POST['delete_id'];
    $competition = Competition::findById($id);
    $competition->delete();
}

$url = $_SERVER['HTTP_REFERER'];
header("location: $url");