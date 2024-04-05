<?php

const LOGIN_PAGE_PATH = '../';
require_once '../auth.php';

require_once '../../config/database.php';
require_once "../../models/Event.php";
require_once '../../models/Title.php';


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['eventId']) && is_numeric($_GET['eventId'])) {
        $eventId = $_GET['eventId'];

        $event = new Event($eventId);

        $titles = $event->getRowTitles();

        echo json_encode($titles);
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Event ID not provided']);
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Invalid request method']);
}
