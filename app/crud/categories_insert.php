<!-- goods na di -->
<?php

require_once '../config/database.php';
require_once '../models/Category.php';

if(isset($_POST['insertdata']))
{
    $competition_id = $_POST['competition_id'];
    $slug = $_POST['slug'];
    $title = $_POST['title'];

    $category = new Category();
    $category->setCompetitionId($competition_id);
    $category->setSlug($slug);
    $category->setTitle($title);
    $category->insert();
}
header('location: categories.php');