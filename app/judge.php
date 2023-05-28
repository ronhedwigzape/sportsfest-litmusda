<?php
require_once '_init.php';

// get authenticated user
$authUser = getUser();

if(!$authUser)
    denyAccess();

else if($authUser['userType'] !== 'judge')
    denyAccess();

else {
    require_once 'models/Judge.php';
    $judge = new Judge($authUser['username'], $_SESSION['pass']);

    if(!$judge->authenticated())
        denyAccess();

    else {
        // ping judge
        if(isset($_POST['ping'])) {
            $judge->ping();
            if(isset($_POST['eventSlug']))
                $judge->setActivePortion($_POST['eventSlug']);

            echo json_encode([
                'pinged'  => true,
                'calling' => $judge->isCalling()
            ]);
        }

        // call help for judge
        else if(isset($_POST['call'])) {
            $judge->call(filter_var($_POST['call'], FILTER_VALIDATE_BOOLEAN));

            echo json_encode([
                'called' => true,
            ]);
        }

        // get events assigned to judge
        else if(isset($_GET['getEvents'])) {
            require_once 'models/Category.php';

            echo json_encode([
                'categories' => Category::rows(),
                'events'     => $judge->getRowEvents()
            ]);
        }

        // get scoreSheet of the passed event
        else if(isset($_GET['getScoreSheet'])) {
            require_once 'models/Event.php';

            $event_slug = trim($_GET['getScoreSheet']);
            $event = Event::findBySlug($event_slug);
            $judge->setActivePortion($event_slug);

            echo json_encode([
                'event'    => $event->toArray(),
                'criteria' => $event->getRowCriteria(),
                'teams'    => $event->getRowTeams(),
                'ratings'  => $judge->getRowEventRatings($event)
            ]);
        }

        // auto save criterion rating for teams
        else if(isset($_POST['rating'])) {
            require_once 'models/Criterion.php';
            require_once 'models/Team.php';

            $rating = $_POST['rating'];

            $judge->setCriterionTeamRating(
                Criterion::findById($rating['criterion_id']),
                Team::findById($rating['team_id']),
                floatval($rating['value'])
            );
        }

        // submit ratings
        else if(isset($_POST['ratings'])) {
            require_once 'models/Criterion.php';
            require_once 'models/Team.php';

            // determine if locking ratings or not
            $locking = false;
            if(isset($_POST['locking']))
                $locking = filter_var($_POST['locking'], FILTER_VALIDATE_BOOLEAN);

            foreach($_POST['ratings'] as $rating) {
                $judge->setCriterionTeamRating(
                    Criterion::findById($rating['criterion_id']),
                    Team::findById($rating['team_id']),
                    floatval($rating['value']),
                    filter_var($rating['is_locked'], FILTER_VALIDATE_BOOLEAN) || $locking
                );
            }
        }

        else
            denyAccess();
    }
}
