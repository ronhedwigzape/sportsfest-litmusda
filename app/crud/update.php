<?php

require_once '../config/database.php';
require_once '../models/Competition.php';

//UPDATE
// create a new Competition instance with the ID of the competition to update
$competition = new Competition(1);

// update the competition title
$competition->setTitle("Sports");

// update the competition in the database
if($competition->update()) {
    echo "Competition updated successfully!";
} else {
    echo "Failed to update competition.";
}
