<?php
const LOGIN_PAGE_PATH = '../';
require_once '../auth.php';

require_once '../../config/database.php';
require_once '../../models/Competition.php';
require_once '../../models/Category.php';
require_once '../../models/Event.php';
require_once '../../models/Team.php';
require_once '../../models/Arrangement.php';

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
                                    <th>Team</th>
                                    <th>Order <i class="fa-solid fa-arrow-down-1-9"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $teams = Team::all($event->getId());
                                    foreach ($teams as $team) {
                                ?>
                                <tr class="border">
                                    <td>
                                        <div class="d-flex">
                                            <div class="d-flex align-items-center">
                                                <img class="ms-2 rounded-5" src="../uploads/<?= $team->getLogo() ?>" style="height: 3rem;" alt="Photo of <?= $team->getName() ?>">
                                            </div>
                                            <div class="ms-3 text-start">
                                                <p class="m-0 fw-bold" style="line-height: 1.1;"><?= $team->getName() ?></p>
                                                <small class="m-0" style="font-size: 12px"><?= $team->getColor() ?></small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <?php $arrangement = Arrangement::find($event->getId(), $team->getId()) ?>
                                        <div>
                                            <select 
                                                class="form-select"
                                                id="team-order"
                                                onchange="handleTeamOrder(<?= $team->getId() ?>, <?= $event->getId() ?>, this.value)"
                                            >
                                                <option id="<?= $team->getId() ?>-<?= $event->getId() ?>" selected><?= $arrangement ? $arrangement->getOrder() : 0 ?></option>
                                                <?php for($i = 1; $i <= Team::count(); $i++) { ?>
                                                        <option value="<?= $i ?>"><?= $i ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
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
