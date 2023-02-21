<!-- goods na di -->
<?php

require_once '../config/database.php';
require_once '../models/Category.php';

if(isset($_POST['deletedata']))
{
    $id = $_POST['delete_id'];
    $categories = Category::findById($id);
    $categories->delete();
}

header('location: categories.php');