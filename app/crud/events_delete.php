<!-- goods na di -->
<?php

require_once '../config/database.php';
require_once '../models/Event.php';

if(isset($_POST['deletedata']))
{
    $id = $_POST['delete_id'];
    $event = Event::findById($id);
    $event->delete();
}

header('location: events.php');