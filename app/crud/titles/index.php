<?php

const LOGIN_PAGE_PATH = '../';
require_once '../auth.php';

require_once '../../config/database.php';
require_once '../../models/Competition.php';
require_once '../../models/Category.php';
require_once '../../models/Event.php';
require_once '../../models/Title.php';

$competitions = Competition::all();

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../../crud/dist/bootstrap-5.2.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../crud/dist/fontawesome-6.3.0/css/all.min.css">
    <script src="../../crud/dist/vue-3.2.47/vue.global.js"></script>
    <script src="../../crud/dist/jquery-3.6.4/jquery-3.6.4.min.js"></script>
    <title>Titles</title>
    <style>
        .text-decor-none {
            text-decoration: none !important;
        }
    </style>
</head>
<body>
<div id="app" class="container mt-3">
    <h1 class="text-center fw-bolder ">Titles</h1>
    <?php
    foreach ($competitions as $competition) { ?>
        <h2 class="text-center fw-bold text-uppercase"><?= $competition->getTitle(); ?></h2>
        <?php
        $categories = Category::all($competition->getId());
        foreach ($categories as $category) { ?>
            <hr>
            <div class="row d-flex justify-content-center">
                <h3 class="text-center text-uppercase"><u><?= $category->getTitle(); ?></u></h3>
                <?php
                $events = Event::all($category->getId());
                foreach ($events as $event) {
                    $event_name = $event->getTitle();
                    $event_id = $event->getId();
                    ?>

                    <div class="col-lg-4 col-md-6 text-center mt-3">
                        <table class="table table-bordered text-center">
                            <thead>
                            <tr>
                                <th><?php print_r($event_name); ?></th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <!-- Form to set titles for each rank using AJAX -->
                            <form id="form_event_<?= $event_id ?>" @submit.prevent="saveTitles($event_id)">
                                <input type="hidden" name="event" value="<?= $event_id ?>">
                                <?php foreach (Title::ranks() as $rank) : ?>
                                    <tr>
                                        <td>Rank <?= $rank ?></td>
                                        <td>
                                            <input type="text" name="titles[<?= $rank ?>]" required>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                <tr>
                                    <td colspan="2">
                                        <button type="submit" class="btn btn-primary">Save Titles</button>
                                    </td>
                                </tr>
                            </form>
                            </tbody>
                        </table>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
    <?php } ?>
</div>
<script>
    $(document).ready(function () {
        $('#saveTitlesBtn').click(function () {
            var titlesData = {};
            $('.table').each(function () {
                var eventId = $(this).find('th').text(); // Get the event ID
                var titles = {};
                $(this).find('tbody tr').each(function () {
                    var rank = $(this).find('td:first-child').text(); // Get the rank
                    var title = $(this).find('input').val(); // Get the title input value
                    titles[rank] = title; // Add rank and title to titles object
                });
                titlesData[eventId] = titles; // Add titles to titlesData object
            });

            // Sending the AJAX request to controller.php
            $.ajax({
                url: 'controller.php',
                type: 'POST',
                data: {
                    event: JSON.stringify(titlesData), // Send titles data as JSON string
                },
                success: function (response) {
                    alert('Titles saved successfully.');
                },
                error: function () {
                    alert('Error occurred while saving titles.');
                }
            });
        });
    });
</script>
</body>
</html>
