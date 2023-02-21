<?php

require_once '../config/database.php';
require_once '../models/Competition.php';

// create a new Competition instance with the ID of the competition to delete
$competition = new Competition(4);

// delete the competition from the database
if ($competition->delete()) {
    echo "Competition deleted successfully!";
} else {
    echo "Failed to delete competition.";
}
