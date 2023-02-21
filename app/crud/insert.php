<?php

require_once '../config/database.php';
require_once '../models/Competition.php';

// INSERT INTO Competition
// create a new Competition instance
$competition = new Competition();

// set the competition properties
$competition->setTitle("New Title");
$competition->setSlug("new-title");

// check if the slug value is not null before calling the insert function
if($competition->getSlug() !== null) {
    // insert the competition into the database
    if($competition->insert()) {
        echo "Competition inserted successfully!";
    } else {
        echo "Failed to insert competition.";
    }
} else {
    echo "Slug value cannot be null.";
}



