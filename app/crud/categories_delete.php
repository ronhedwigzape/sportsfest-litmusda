<!-- goods na di -->
<?php

require_once '../config/database.php';
require_once '../models/Category.php';

if(isset($_POST['deletedata']))
{
    $id = $_POST['delete_id'];
    $category = Category::findById($id);
    $category->delete();
}

header('location: categories.php');