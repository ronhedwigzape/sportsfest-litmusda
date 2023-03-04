<?php
require_once '_init.php';

// get authenticated user
$authUser = getUser();

if(!$authUser)
    denyAccess();

else if($authUser['userType'] !== 'admin')
    denyAccess();

else {
    require_once 'models/Admin.php';
    $admin = new Admin($authUser['username'], $_SESSION['pass']);

    if(!$admin->authenticated())
        denyAccess();

    else {
        // get events
        if(isset($_GET['getEvents'])) {
            require_once 'models/Event.php';

            echo json_encode([
                "events" => Event::rows()
            ]);
        }

        // tabulate an event
        else if(isset($_GET['tabulate'])) {
            require_once 'models/Event.php';

            $event_slug = trim($_GET['tabulate']);
            $event = Event::findBySlug($event_slug);

            echo json_encode([
                'event'   => $event->toArray(),
                'results' => $admin->tabulate($event)
            ]);
        }


        else
            denyAccess();
    }
}
