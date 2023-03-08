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

        // get scoreSheet of the passed event
        else if (isset($_GET['getScoreSheet'])) {
            require_once 'models/Event.php';

            $event_slug = trim($_GET['getScoreSheet']);
            $event    = Event::findBySlug($event_slug);

            echo json_encode([
                'event'    => $event->toArray(),
                'criteria' => $event->getRowCriteria(),
                'teams'    => $event->getRowTeams(),
                'ratings'  => $judge->getRowEventRatings($event)
            ]);
        }

        // auto save criterion rating for teams
        else if (isset($_POST['rating'])) {
            require_once 'models/Criterion.php';
            require_once 'models/Team.php';

            $rating = $_POST['rating'];

            $judge->setCriterionTeamRating(
                Criterion::findById($rating['criterion_id']),
                Team::findById($rating['team_id']),
                floatval($rating['value'])
            );
        }

        else if (isset($_POST['ratings'])) {
            require_once 'models/Criterion.php';
            require_once 'models/Team.php';

            foreach ($_POST['ratings'] as $rating) {
                $judge->setCriterionTeamRating(
                    Criterion::findById($rating['criterion_id']),
                    Team::findById($rating['team_id']),
                    floatval($rating['value']),
                    filter_var($rating['is_locked'], FILTER_VALIDATE_BOOLEAN)
                );
            }
        }

        else
           denyAccess();
    }
}
