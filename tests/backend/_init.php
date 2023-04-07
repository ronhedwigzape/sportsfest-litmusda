<?php

// initialize database connection for testing
require_once 'tests/backend/config/test-database.php';
$GLOBALS['conn'] = $conn ?? null;


// load models
require_once 'app/models/App.php';
require_once 'app/models/User.php';
require_once 'app/models/Admin.php';
require_once 'app/models/Judge.php';
require_once 'app/models/Technical.php';
require_once 'app/models/Competition.php';
require_once 'app/models/Category.php';
require_once 'app/models/Event.php';
require_once 'app/models/Criterion.php';
require_once 'app/models/Point.php';
require_once 'app/models/Title.php';
require_once 'app/models/Team.php';
require_once 'app/models/Participant.php';
require_once 'app/models/Arrangement.php';
require_once 'app/models/Deduction.php';
require_once 'app/models/Rating.php';


// reset database
function resetDatabase(): void
{
    $tables = [
        'ratings',
        'deductions',
        'arrangements',
        'participants',
        'teams',
        'titles',
        'points',
        'eliminations',
        'noshows',
        'judge_event',
        'technical_event',
        'criteria',
        'events',
        'categories',
        'competitions',
        'technicals',
        'judges',
        'admins'
    ];

    foreach($tables as $table) {
        // delete all records from the table
        $sql = "DELETE FROM $table";
        if(!$GLOBALS['conn']->query($sql))
            die("Error deleting records from $table: " . $GLOBALS['conn']->error);

        // reset the auto-increment value for the table
        $sql = "ALTER TABLE $table AUTO_INCREMENT = 1";
        if (!$GLOBALS['conn']->query($sql))
            die("Error resetting auto-increment for $table: " . $GLOBALS['conn']->error);
    }
}
resetDatabase();
