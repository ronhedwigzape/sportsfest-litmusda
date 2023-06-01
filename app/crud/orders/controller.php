<?php 
const LOGIN_PAGE_PATH = '../';
require_once "../auth.php";

require_once '../../config/database.php';
require_once "../../models/Event.php";
require_once "../../models/Team.php";
require_once "../../models/Arrangement.php";

if (isset($_POST['order']) && isset($_POST['teamId']) && isset($_POST['eventId'])){

    $eventId = $_POST['eventId'];
    $teamId = $_POST['teamId'];
    $order = $_POST['order'];

    $event = Event::findById($eventId);
    $team = Team::findById($teamId);
    $arrangement = Arrangement::find($eventId, $teamId);
    $arrangement_stored = Arrangement::stored($eventId, $teamId, $order);

    $event->setTeamOrder($team, $order);
}