<!-- goods na di -->
<?php

require_once '../config/database.php';
require_once '../models/Category.php';

if (isset($_POST['updatedata'])) {

    $id = $_POST['update_id'];

    $competition_id = $_POST['competition_id'];
    $slug = $_POST['slug'];
    $title = $_POST['title'];

    $categories = Category::findById($id);
    $categories->setCompetitionId($competition_id);
    $categories->setSlug($slug);
    $categories->setTitle($title);
    $result = $categories->update();

}
header("location: categories.php");