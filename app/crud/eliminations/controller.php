<?php
const LOGIN_PAGE_PATH = '../';
require_once "../auth.php";

require_once '../../config/database.php';
require_once "../../models/Event.php";
require_once "../../models/Team.php";

if (isset($_POST['teamId']) && isset($_POST['eventId'])) {

    $event = Event::findById($_POST['eventId']);
    $team = Team::findById($_POST['teamId']);

    if ($event->hasTeamBeenEliminated($team)) {
        $event->reviveTeam($team);
    }
    else {
        $event->eliminateTeam($team);
    }

    echo json_encode([
        "teamEliminated" => $event->hasTeamBeenEliminated($team),
        "teams"      => $team->toArray()
    ]);
}


