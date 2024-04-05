<?php

const LOGIN_PAGE_PATH = '../';
require_once '../auth.php';

require_once '../../config/database.php';
require_once "../../models/Event.php";
require_once '../../models/Title.php';


// handle the AJAX request to set titles for each rank
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['event'])) {
    $eventData = json_decode($_POST['event'], true);

    foreach ($eventData as $eventId => $titles) {
        if (!is_numeric($eventId) || $eventId <= 0) {
            echo json_encode(['error' => 'Invalid event ID']);
            exit;
        }

        $event = new Event($eventId);

        // set titles for each rank
        foreach ($titles as $rank => $title) {
            if (!is_numeric($rank) || $rank <= 0) {
                echo json_encode(['error' => 'Invalid rank']);
                exit;
            }

            $event->setRankTitle($rank, $title);
        }
    }

    // titles set successfully
    echo json_encode(['success' => true]);
} else {
    // invalid request method or missing data
    echo json_encode(['error' => 'Invalid request']);
}
