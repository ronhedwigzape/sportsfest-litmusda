<!-- goods na di -->
<?php

require_once '../config/database.php';
require_once '../models/Event.php';

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
header("location: events.php");