<?php

require_once '../config/database.php';
require_once '../models/Event.php';

// Insert Data
if(isset($_POST['insertdata'])) {

    $category_id = $_POST['category_id'];
    $slug = $_POST['slug'];
    $title = $_POST['title'];

    $event = new Event();
    $event->setCategoryId($category_id);
    $event->setSlug($slug);
    $event->setTitle($title);
    $event->insert();
}

// Update Data
if (isset($_POST['updatedata'])) {

    $id = $_POST['update_id'];
    $category_id = $_POST['category_id'];
    $slug = $_POST['slug'];
    $title = $_POST['title'];

    $event = Event::findById($id);
    $event->setCategoryId($category_id);
    $event->setSlug($slug);
    $event->setTitle($title);
    $event->update();
}

// Delete Data
if(isset($_POST['deletedata'])) {

    $id = $_POST['delete_id'];
    $event = Event::findById($id);
    $event->delete();
}

$url = $_SERVER['HTTP_REFERER'];
header("location: $url");

