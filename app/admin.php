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
            require_once 'models/Category.php';
            require_once 'models/Event.php';

            echo json_encode([
                'categories' => Category::rows(),
                'events'     => Event::rows()
            ]);
        }

        // tabulate an event
        else if(isset($_GET['tabulate'])) {
            require_once 'models/Event.php';

            $event_slug = trim($_GET['tabulate']);
            $event = Event::findBySlug($event_slug);
            // $admin->setActivePortion($event_slug);

            echo json_encode([
                'event'   => $event->toArray(),
                'results' => $admin->tabulate($event)
            ]);
        }

        // unlock ratings of judge for an event
        else if (isset($_POST['unlock_judge_id']) && isset($_POST['unlock_event_id'])) {
            // instantiate judge object
            require_once 'models/Judge.php';
            $judge = Judge::findById($_POST['unlock_judge_id']);

            // instantiate event object
            require_once 'models/Event.php';
            $event = Event::findById($_POST['unlock_event_id']);

            // unlock ratings of judge
            $judge->unlockRatings($event);
        }

        // unlock deductions of technical for an event
        else if (isset($_POST['unlock_technical_id']) && isset($_POST['unlock_event_id'])) {
            // instantiate technical object
            require_once 'models/Technical.php';
            $technical = Technical::findById($_POST['unlock_technical_id']);

            // instantiate event object
            require_once 'models/Event.php';
            $event = Event::findById($_POST['unlock_event_id']);

            // unlock deductions of technical
            $technical->unlockDeductions($event);
        }

        else
            denyAccess();
    }
}
