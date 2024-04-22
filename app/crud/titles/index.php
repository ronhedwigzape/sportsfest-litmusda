<?php

const LOGIN_PAGE_PATH = '../';
require_once '../auth.php';

require_once '../../config/database.php';
require_once '../../models/Competition.php';
require_once '../../models/Category.php';
require_once '../../models/Event.php';
require_once '../../models/Title.php';
require_once '../../models/Team.php';

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
    <link rel="stylesheet" href="styles/style.css">
    <script src="../../crud/dist/jquery-3.6.4/jquery-3.6.4.min.js"></script>
    <title>Titles</title>
</head>
<body>

<div id="app" class="container mt-3">
    <h1 class="text-center fw-bolder">Titles</h1>
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
                        <form class="event-form" id="form_event_<?= $event_id ?>">
                            <input type="hidden" name="eventId" value="<?= $event_id ?>">
                            <input type="hidden" name="eventSlug" value="<?= $event->getSlug() ?>">
                            <table class="table table-bordered text-center">
                                <thead>
                                <tr>
                                    <th><?php print_r($event_name); ?></th>
                                    <th>Title</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php foreach (Title::ranks() as $rank) { ?>
                                        <input type="hidden" name="rankId" value="<?= $rank ?>">
                                        <tr>
                                            <td>Rank <?= $rank ?></td>
                                            <td>
                                                <input id="<?=$event->getSlug()?>_rank-<?=$rank?>" type="text" name="titles[<?= $rank ?>]" value="" onchange="saveTitle(this)">
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </form>
                    </div>

                <?php } ?>
            </div>
        <?php } ?>
    <?php } ?>
</div>
<script>
    $(document).ready(function() {
        // function to load saved titles
        function loadSavedTitles(eventId, eventSlug) {
            $.ajax({
                url: 'get_titles.php',
                type: 'GET',
                data: { eventId: eventId },
                success: function(response) {
                    const data = JSON.parse(response);
                    console.log('Success response', data);
                    // loop through each key in the response data object
                    for (const key in data) {
                        if (data.hasOwnProperty(key)) {
                            const item = data[key];
                            const rank = item.rank;
                            $(`#${eventSlug}_rank-${rank}`).val(item.title);
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    console.error('AJAX Error:', error);
                    alert('Error occurred while fetching saved titles. Please check the console for details.');
                }
            });
        }

        $('.event-form').each(function() {
            var eventId = $(this).find('input[name="eventId"]').val();
            var eventSlug = $(this).find('input[name="eventSlug"]').val();
            loadSavedTitles(eventId, eventSlug);
        });

        // bind onchange event to input fields to save titles
        $('input[type="text"]').on('change', function() {
            saveTitle($(this));
        });

        // animation on input fields
        $('input[type="text"]').focus(function() {
            $(this).addClass('highlight-on-focus').removeClass('highlight-off-focus');
        }).blur(function() {
            $(this).removeClass('highlight-on-focus').addClass('highlight-off-focus');
            setTimeout(() => $(this).removeClass('highlight-off-focus'), 1000);
        });
    });

    function saveTitle(input) {
        var titleData = {};
        var form = $(input).closest('form');
        var eventId = form.find('input[name="eventId"]').val();
        var rank = input.name ? input.name.split("[")[1].split("]")[0] : null;
        var title = input.value;
        titleData[eventId] = {};
        titleData[eventId][rank] = title;

        // sending the AJAX request to controller.php
        $.ajax({
            url: 'controller.php',
            type: 'POST',
            data: {
                event: JSON.stringify(titleData),
            },
            success: function (response) {
                console.log('Success response', response);

            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
                console.error('AJAX Error:', error);
                alert('Error occurred while saving title. Please check the console for details.');
            }
        });
    }
</script>
</body>
</html>
