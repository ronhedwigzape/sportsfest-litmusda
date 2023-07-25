<?php
const LOGIN_PAGE_PATH = '../';
require_once '../auth.php';

require_once '../../config/database.php';
require_once '../../models/Competition.php';
require_once '../../models/Category.php';
require_once '../../models/Event.php';
require_once '../../models/Team.php';
require_once '../../models/Arrangement.php';

const GROUP = 'Team';

function findArrangementId($eventId, $order) {
    global $conn;
    $stmt = $conn->prepare("SELECT id FROM `arrangements` WHERE event_id = ? AND `order` = ?");
    if (!$stmt) {
        die('Error in prepared statement: ' . $conn->error);
    }
    $stmt->bind_param("ii", $eventId, $order);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        return $row['id'];
    } else {
        return false;
    }
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../../crud/dist/bootstrap-5.2.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../crud/dist/fontawesome-6.3.0/css/all.min.css">
    <script src="../../crud/dist/jquery-3.6.4/jquery-3.6.4.min.js"></script>
    <title>Orders</title>
</head>
<body>
<div id="app" class="container mt-3">
    <h1 class="text-center fw-bolder ">Orders</h1>
    <?php
    $competitions = Competition::all();
    foreach ($competitions as $competition) { ?>
        <h2 class="text-center fw-bold text-uppercase"><?= $competition->getTitle(); ?></h2>
        <?php $categories = Category::all($competition->getId());
                foreach ($categories as $category) { ?>
            <hr>
            <div class="row d-flex justify-content-center">
                <h3 class="text-center text-uppercase"><u><?= $category->getTitle(); ?></u></h3>
                <?php
                    $events = Event::all($category->getId());
                    foreach ($events as $event) {
                ?>
                    <div class="col-lg-4 col-md-6 text-center mt-3">
                        <table class="table table-bordered text-center">
                            <thead>
                                <tr>
                                    <td colspan="2" class="font-weight-bold">
                                        <h2><?php print_r($event->getTitle()); ?></h2>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Order <i class="fa-solid fa-arrow-down-1-9"></i></th>
                                    <th><?= GROUP ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php for ($order = 1; $order <= Team::count(); $order++) { ?>
                                <tr class="border">
                                    <td class="fw-bold"><?= $order ?></td>
                                    <td>
                                        <?php
                                            $arrangement = Arrangement::findById(findArrangementId($event->getId(), $order));
                                            $arrangements = $arrangement !== false ? Arrangement::find($event->getId(), $arrangement->getTeamId()) : false;
                                        ?>
                                        <select
                                            class="form-select" onchange="handleTeamOrder(this.value, <?= $event->getId() ?>, <?= $order ?>)"
                                        >
                                            <?php
                                                $team_ctr = 0;
                                                foreach (Team::all() as $team) {
                                                    $team_ctr += 1;
                                            ?>
                                                <option
                                                    value="<?= $team->getId() ?>"
                                                    <?php
                                                        if($arrangements) {
                                                            if($arrangements->getTeamId() == $team->getId())
                                                                echo " selected";
                                                        }
                                                        else {
                                                            if($team_ctr == $order)
                                                                echo " selected";
                                                        }
                                                    ?>
                                                >
                                                    <?= $team->getId() ?> - <?= $team->getName() ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
    <?php } ?>
</div>
<script>
function handleTeamOrder(teamId, eventId, order) {
    $(document).ready(function() {
        $.ajax({
            url: 'controller.php',
            type: 'POST',
            xhrFields: {
                withCredentials: true
            },
            data: {
                teamId,
                eventId,
                order
            },
            success: (data, textStatus, jqXHR) => {
                console.log(`${jqXHR.status}: ${jqXHR.statusText}`);
            },
            error: (error) => {
                alert(`ERROR ${error.status}: ${error.statusText}`);
            }
        });
    });
}
</script>
</body>
</html>
