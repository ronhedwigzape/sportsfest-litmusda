<!-- goods na di -->
<?php

require_once '../config/database.php';
require_once '../models/Competition.php';

if (isset($_POST['updatedata'])) {

    $id = $_POST['update_id'];

    $slug = $_POST['slug'];
    $title = $_POST['title'];

    $competition = Competition::findById($id);
    $competition->setSlug($slug);
    $competition->setTitle($title);
    $competition->update();

}
header("location: competitions.php");