<!-- goods na di -->
<?php

require_once '../config/database.php';
require_once '../models/Competition.php';

if(isset($_POST['deletedata']))
{
    $id = $_POST['delete_id'];
    $competition = Competition::findById($id);
    $competition->delete();
}

header('location: competitions.php');