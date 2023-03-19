<?php
    const LOGIN_PAGE_PATH = '../';
    require_once '../auth.php';

    require_once '../../config/database.php';
    require_once '../../models/Competition.php';
    require_once '../../models/Category.php';
    require_once '../../models/Event.php';
    require_once '../../models/Team.php';

    $competitions = Competition::all();
    $categories = Category::all();
    $teams = Team::all();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../../crud/dist/bootstrap-5.2.3/css/bootstrap.min.css">
    <script src="../../crud/dist/vue-3.2.47/vue.global.js"></script>
    <script src="../../crud/dist/jquery-3.6.4/jquery-3.6.4.min.js"></script>
    <title>Eliminations</title>
</head>
<body>
<div id="app" class="container mt-3" align="center">
    <h1>Eliminations</h1>
  <?php foreach ($competitions as $competition) { ?>
      <h2 class="text-center"><?= $competition->getTitle() ?></h2>
      <?php foreach ($categories as $category) {?>
        <hr>
          <h4><?= $category->getTitle()?></h4>
            <?php
                $events = Event::all($category->getId());
                foreach ($events as $event) {
                $event_name = $event->getTitle();
                $event_id = $event->getId();
            ?>
            <table class="table table-bordered w-50 text-center">
                <thead>
                    <tr>
                        <th><?php print_r($event_name) ?></th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                foreach ($teams as $team) {
                    $team_name = $team->getName();
                    $team_id = $team->getId();

                ?>
                    <tr>
                        <td class="<?php echo $event->hasTeamBeenEliminated($team) ? 'opacity-50' : '';?>">
                            <?= $team_name ?>
                        </td>
                        <td>
                            <button
                                class="btn btn-danger"
                                @click="toggleElimination(<?= $event_id ?>, <?= $team_id ?>)"
                            >
                            <?php echo $event->hasTeamBeenEliminated($team) ? 'Revive' : 'Eliminate' ?>
                            </button>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
                <tfoot>

                </tfoot>
            </table>
            <?php } ?>
      <?php } ?>
  <?php } ?>
</div>
</body>

<script>

    const { createApp } = Vue

    createApp({
        data() {
            return {

            }
        },
        methods: {
            toggleElimination(eventId, teamId) {
                $.ajax({
                    url: 'controller.php',
                    type: 'POST',
                    xhrFields: {
                        withCredentials: true
                    },
                    data: {
                        eventId,
                        teamId
                    },
                    success: (data, textStatus, jqXHR) => {
                        window.location.reload();
                        console.log(`${jqXHR.status}: ${jqXHR.statusText}`);
                    },
                    error: (error) => {
                        alert(`ERROR ${error.status}: ${error.statusText}`);
                    }
                })
            }
        }
    }).mount('#app')
</script>
</html>
