<!-- goods na di -->
<?php

require_once '../config/database.php';
require_once '../models/Event.php';

if(isset($_POST['insertdata']))
{
    $category_id = $_POST['category_id'];
    $slug = $_POST['slug'];
    $title = $_POST['title'];

    $event = new Event();
    $event->setCategoryId($category_id);
    $event->setSlug($slug);
    $event->setTitle($title);
    $event->insert();
}
header('location: events.php');