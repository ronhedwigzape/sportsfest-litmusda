<!-- goods na di -->
<?php

require_once '../config/database.php';
require_once '../models/Category.php';

if(isset($_POST['insertdata']))
{
    $competition_id = $_POST['competition_id'];
    $slug = $_POST['slug'];
    $title = $_POST['title'];

    $categories = new Category();
    $categories->setCompetitionId($competition_id);
    $categories->setSlug($slug);
    $categories->setTitle($title);
    $categories->insert();
}
header('location: categories.php');