<?php
require_once '_init.php';

// get authenticated user
$authUser = getUser();

if (!$authUser)
    denyAccess();

else if ($authUser['userType'] !== 'judge')
    denyAccess();

else {
    require_once 'models/Judge.php';
    $judge = new Judge($authUser['username'], $_SESSION['pass']);

    if (!$judge->authenticated())
        denyAccess();

    else {

        // get events assigned to judge
        if (isset($_GET['getEvents'])) {
            echo json_encode([
                "events" => $judge->getRowEvents()
            ]);
        }

        // get scoresheet of the passed event
        else if (isset($_GET['getScoreSheet'])) {
            require_once 'models/Event.php';
            require_once 'models/Team.php';

            $event_slug = trim($_GET['getScoreSheet']);
            $event    = Event::findBySlug($event_slug);

            echo json_encode([
                'event'    => $event->toArray(),
                'criteria' => $event->getRowCriteria(),
                'teams'    => Team::rows(),
                'ratings'  => $judge->getRowEventRatings($event)
            ]);
        }

        else
           denyAccess();
    }
}
