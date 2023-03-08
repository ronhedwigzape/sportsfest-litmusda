<?php

require_once '../config/database.php';
require_once '../models/Criterion.php';

// Insert Data
if(isset($_POST['insertdata'])) {

    $event_id = $_POST['event_id'];
    $title = $_POST['title'];
    $percentage = $_POST['percentage'];

    $criterion = new Criterion();
    $criterion->setEventId($event_id);
    $criterion->setTitle($title);
    $criterion->setPercentage($percentage);
    $criterion->insert();
}

// Update Data
if (isset($_POST['updatedata'])) {

    $id = $_POST['update_id'];
    $event_id = $_POST['event_id'];
    $title = $_POST['title'];
    $percentage = $_POST['percentage'];

    $criterion = Criterion::findById($id);
    $criterion->setEventId($event_id);
    $criterion->setTitle($title);
    $criterion->setPercentage($percentage);
    $criterion->update();
}

// Delete Data
if(isset($_POST['deletedata'])) {

    $id = $_POST['delete_id'];
    $criterion = Criterion::findById($id);
    $criterion->delete();
}

$url = $_SERVER['HTTP_REFERER'];
header("location: $url");
