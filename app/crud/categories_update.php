<!-- goods na di -->
<?php

require_once '../config/database.php';
require_once '../models/Category.php';

if (isset($_POST['updatedata'])) {

    $id = $_POST['update_id'];

    $competition_id = $_POST['competition_id'];
    $slug = $_POST['slug'];
    $title = $_POST['title'];

    $category = Category::findById($id);
    $category->setCompetitionId($competition_id);
    $category->setSlug($slug);
    $category->setTitle($title);
    $result = $category->update();

}
header("location: categories.php");