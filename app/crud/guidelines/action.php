<?php
require_once '../../config/database.php';
require_once '../../models/Point.php';

// $Point = Point;
if (isset($_POST['edit_btn'])) {  
  $event_id = $_POST['event_id'];
  $point_id = $_POST['point_id'];
  $rank = $_POST['rank'];
  $points = $_POST['points'];

  $Point = Point::findById($point_id);
  $Point->setEventId($event_id);
  $Point->setRank($rank);
  $Point->setValue($points);
  $Point->update();
}
header('location: event_ranking.php');
?>