<?php

const LOGIN_PAGE_PATH = '../';
require_once '../auth.php';

require_once '../../config/database.php';
require_once "../../models/Event.php";
require_once '../../models/Title.php';


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['event'])) {
    $titlesData = json_decode($_POST['event'], true);

    foreach ($titlesData as $eventId => $titles) {
        foreach ($titles as $rank => $title) {
            $titleObject = Title::find($eventId, $rank);
            if ($titleObject) {
                $titleObject->setTitle($title);
                $titleObject->update();
            } else {
                $titleObject = new Title();
                $titleObject->setEventId($eventId);
                $titleObject->setRank($rank);
                $titleObject->setTitle($title);
                $titleObject->insert();
            }
        }
    }

    // Send a response to indicate success
    echo 'Titles saved successfully.';
} else {
    // Send an error response if the data is not provided
    http_response_code(400);
    echo 'Bad request. Event and titles data are required.';
}
