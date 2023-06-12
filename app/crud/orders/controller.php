<?php 
const LOGIN_PAGE_PATH = '../';
require_once "../auth.php";

require_once '../../config/database.php';
require_once "../../models/Event.php";
require_once "../../models/Team.php";

if (isset($_POST['order'])){

    $eventId = $_POST['eventId'];
    $teamId = $_POST['teamId'];
    $order = $_POST['order'];

    $event = Event::findById($eventId);
    $team = Team::findById($teamId);

    // set current team order
    $event->setTeamOrder($team, $order);
}

