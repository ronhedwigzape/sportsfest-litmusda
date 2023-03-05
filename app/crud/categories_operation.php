<?php

require_once '../config/database.php';
require_once '../models/Category.php';

// Insert Data
if(isset($_POST['insertdata'])) {

    $competition_id = $_POST['competition_id'];
    $slug = $_POST['slug'];
    $title = $_POST['title'];

    $category = new Category();
    $category->setCompetitionId($competition_id);
    $category->setSlug($slug);
    $category->setTitle($title);
    $category->insert();
}

// Update Data
if (isset($_POST['updatedata'])) {

    $id = $_POST['update_id'];

    $competition_id = $_POST['competition_id'];
    $slug = $_POST['slug'];
    $title = $_POST['title'];

    $category = Category::findById($id);
    $category->setCompetitionId($competition_id);
    $category->setSlug($slug);
    $category->setTitle($title);
    $category->update();
}

// Delete Data
if(isset($_POST['deletedata'])) {

    $id = $_POST['delete_id'];
    $category = Category::findById($id);
    $category->delete();
}

$url = $_SERVER['HTTP_REFERER'];
header("location: $url");
