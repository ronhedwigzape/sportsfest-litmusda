<?php
	require_once "../auth.php";
	require_once '../../config/database.php';
	require_once "../../models/Event.php";
	require_once "../../models/Team.php";

	function returnJSON($data = ["status" => false]){
		header("Content-Type: application/json");
		echo json_encode($data); exit;
	}

	switch( $_SERVER['REQUEST_METHOD'] . ( isset($_GET["type"]) ? ":" . $_GET["type"] : "" ) ){
		case "POST":
			$event = Event::findById($_POST["event"]);
			$team = Team::findById($_POST["team"]);

			if( $event->hasTeamNotShownUp($team) ){
				$event->removeNoShowTeam($team);
				returnJSON([ "action" => 0 ]);
			}else{
				$event->addNoShowTeam($team);
				returnJSON([ "action" => 1 ]);
			}
			break;

		default:
			returnJSON();

	}

?>