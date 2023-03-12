<?php

// RESULT FOR SPECIFIC EVENT
// SAMPLE URL: localhost/sportsfest-litmusda/app/results/event.php?oration

// apply authentication
const LOGIN_PAGE_PATH = '../crud/';
require_once '../crud/auth.php';

// get $event_slug from the URL
$event_slug = '';
$arr_keys = array_keys($_GET);
if(sizeof($arr_keys) > 0)
    $event_slug = strtolower(trim($arr_keys[0]));

// require database.php and Category class
require_once '../config/database.php';
require_once '../models/Event.php';

// instantiate Category object
$event = Event::findBySlug($event_slug);

// define $result globally
$result = [];

if(!$event) {
    echo "Invalid Event [slug = '" . $event_slug . "']";
    exit();
}
else {
    // require Admin class
    require_once '../models/Admin.php';

    // instantiate an Admin object
    $admin = new Admin();

    // tabulate $event
    $result = $admin->tabulate($event);
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Results in <?= $event->getTitle() ?></title>
</head>
<body>
    <img class=img-"sportfest" src="img/foundation-logo.png" alt="sportfest">
    <br>
    <h1><?= $event->getTitle() ?></h1>
    <br>

<table border="1" cellspacing="0">
    <thead>
    <tr>
        <th rowspan="2">TEAMS</th>
        <?php foreach($result['events'] as $event_slug => $event_data) { ?>
            <th colspan="2"><?= $event_data['title'] ?></th>
        <?php } ?>
        <th rowspan="2">TOTAL</th>
        <th rowspan="2">RANK</th>
    </tr>
    <tr>
        <?php foreach($result['events'] as $event_slug => $event_data) { ?>
            <th>Rank</th>
            <th>Points</th>
        <?php } ?>
    </tr>
    </thead>
    <tbody>
    <?php foreach($result['teams'] as $team_key => $team_data) { ?>
        <tr>
            <!-- team name -->
            <td><?= $team_data['name'] ?></td>

            <!-- events -->
            <?php foreach($result['events'] as $event_slug => $event_data) { ?>
                <td><?= number_format($team_data['inputs'][$event_slug]['rank']['fractional'], 2) ?></td>
                <td><?= number_format($team_data['inputs'][$event_slug]['points'], 2) ?></td>
            <?php } ?>

            <!-- total points -->
            <td><b><?= number_format($team_data['points'], 2) ?></b></td>

            <!-- rank -->
            <td><?= number_format($team_data['rank']['fractional'], 2) ?></td>
        </tr>
    <?php } ?>
    </tbody>
</table>

    <!-- Footer Section Start -->
    <footer>
        <div class="text">
            <span>© ACLC IRIGA | 2023</span>
        </div>
    </footer>

</body>
</html>
