<!-- goods na di -->
<?php

require_once '../config/database.php';
require_once '../models/Event.php';

if(isset($_POST['insertdata']))
{
    $category_id = $_POST['category_id'];
    $slug = $_POST['slug'];
    $title = $_POST['title'];

    $events = new Event();
    $events->setCategoryId($category_id);
    $events->setSlug($slug);
    $events->setTitle($title);
    $events->insert();
}
header('location: events.php');