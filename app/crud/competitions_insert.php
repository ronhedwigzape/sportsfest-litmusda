<!-- goods na di -->
<?php

require_once '../config/database.php';
require_once '../models/Competition.php';

if(isset($_POST['insertdata']))
{
    $slug = $_POST['slug'];
    $title = $_POST['title'];

    $competition = new Competition();
    $competition->setSlug($slug);
    $competition->setTitle($title);
    $competition->insert();
}
header('location: competitions.php');