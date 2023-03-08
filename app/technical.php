<?php
require_once '_init.php';

// get authenticated user
$authUser = getUser();

if (!$authUser)
    denyAccess();

else if ($authUser['userType'] !== 'technical')
    denyAccess();

else {
    require_once 'models/Technical.php';
    $technical = new Technical($authUser['username'], $_SESSION['pass']);

    if (!$technical->authenticated())
        denyAccess();

    else {

        // get events assigned to technical
        if (isset($_GET['getEvents'])) {
            echo json_encode([
                "events" => $technical->getRowEvents()
            ]);
        }

        // get deduction sheet of the passed event
        else if (isset($_GET['getDeductionSheet'])) {
            require_once 'models/Event.php';

            $event_slug = trim($_GET['getDeductionSheet']);
            $event    = Event::findBySlug($event_slug);

            echo json_encode([
                'event'    => $event->toArray(),
                'teams'    => $event->getRowTeams(),
                'deductions'  => $technical->getRowEventDeductions($event)
            ]);
        }

        // auto save deductions for teams
        else if (isset($_POST['deductions'])) {
            require_once 'models/Deduction.php';
            require_once 'models/Event.php';
            require_once 'models/Team.php';

            $deduction = $_POST['deductions'];

            $technical->setEventTeamDeduction(
                Event::findById($deduction['event_id']),
                Team::findById($deduction['team_id']),
                floatval($deduction['value'])
            );
        }

        else
            denyAccess();
    }
}
