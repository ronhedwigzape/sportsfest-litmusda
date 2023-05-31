<?php
require_once '_init.php';

// get authenticated user
$authUser = getUser();

if(!$authUser)
    denyAccess();

else if($authUser['userType'] !== 'technical')
    denyAccess();

else {
    require_once 'models/Technical.php';
    $technical = new Technical($authUser['username'], $_SESSION['pass']);

    if(!$technical->authenticated())
        denyAccess();

    else {
        // ping technical
        if(isset($_POST['ping'])) {
            $technical->ping();
            if(isset($_POST['eventSlug']))
                $technical->setActivePortion($_POST['eventSlug']);

            echo json_encode([
                'pinged'  => true,
                'calling' => $technical->isCalling()
            ]);
        }

        // call help for technical
        else if(isset($_POST['call'])) {
            $technical->call(filter_var($_POST['call'], FILTER_VALIDATE_BOOLEAN));

            echo json_encode([
                'called' => true,
            ]);
        }

        // get events assigned to technical
        else if(isset($_GET['getEvents'])) {
            require_once 'models/Category.php';

            echo json_encode([
                'categories' => Category::rows(),
                'events'     => $technical->getRowEvents()
            ]);
        }

        // get deduction sheet of the passed event
        else if(isset($_GET['getDeductionSheet'])) {
            require_once 'models/Event.php';

            $event_slug = trim($_GET['getDeductionSheet']);
            $event = Event::findBySlug($event_slug);
            $technical->setActivePortion($event_slug);

            echo json_encode([
                'event'      => $event->toArray(),
                'teams'      => $event->getRowTeams(),
                'deductions' => $technical->getRowEventDeductions($event)
            ]);
        }

        // auto save deductions for teams
        else if(isset($_POST['deduction'])) {
            require_once 'models/Deduction.php';
            require_once 'models/Event.php';
            require_once 'models/Team.php';

            $deduction = $_POST['deduction'];

            $technical->setEventTeamDeduction(
                Event::findById($deduction['event_id']),
                Team::findById($deduction['team_id']),
                floatval($deduction['value'])
            );
        }

        // submit deductions
        else if(isset($_POST['deductions'])) {
            require_once 'models/Deduction.php';
            require_once 'models/Event.php';
            require_once 'models/Team.php';

            // determine if locking ratings or not
            $locking = false;
            if(isset($_POST['locking']))
                $locking = filter_var($_POST['locking'], FILTER_VALIDATE_BOOLEAN);

            foreach($_POST['deductions'] as $deduction) {
                $technical->setEventTeamDeduction(
                    Event::findById($deduction['event_id']),
                    Team::findById($deduction['team_id']),
                    floatval($deduction['value']),
                    filter_var($deduction['is_locked'], FILTER_VALIDATE_BOOLEAN) || $locking
                );
            }
        }

        else
            denyAccess();
    }
}
