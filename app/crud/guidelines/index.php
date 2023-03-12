<?php
    require_once '../../config/database.php';

    require_once '../../models/Competition.php';
    require_once '../../models/Category.php';
    require_once '../../models/Event.php';
    require_once '../../models/Point.php';
    $ranks = Point::ranks();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../../crud/dist/bootstrap-5.2.3/css/bootstrap.min.css">
    <style>
        th, td {
            vertical-align: middle
        }
    </style>
    <title>Guidelines</title>
<body>
    <div class="container-fluid mt-3">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-center p-4"><h2 class="m-0">POINTS SYSTEM</h2></th>
                    <?php foreach($ranks as $rank) { ?>
                        <th class="text-center">
                            <h3 class="m-0"><?= $rank ?></h3>
                        </th>
                    <?php } ?>
                </tr>
            </thead>

            <tbody>

                <!-- competitions -->
                <?php foreach(Competition::all() as $competition) { ?>
                    <!--divider -->
                    <tr><td colspan="<?= (1 + sizeof($ranks)) ?>"></td></tr>

                    <tr class="table-dark">
                        <td class="fw-bold p-3" colspan="<?= (1 + sizeof(Point::ranks())) ?>">
                            <h5 class="m-0 text-uppercase"><?= $competition->getTitle() ?></h5>
                        </td>
                    </tr>

                    <!-- categories -->
                    <?php foreach($competition->getAllCategories() as $category) { ?>
                        <tr class="table-secondary">
                            <td class="fw-bold p-3" colspan="<?= (1 + sizeof($ranks)) ?>">
                                <h6 class="m-0 text-uppercase"><?= $category->getTitle() ?></h6>
                            </td>
                        </tr>

                        <!-- events -->
                        <?php foreach($category->getAllEvents() as $event) { ?>
                            <tr>
                                <td class="px-4">
                                    <p class="m-0 px-4"><?= $event->getTitle() ?></p>
                                </td>
                                <?php foreach($ranks as $rank) { ?>
                                    <td class="px-4" align="right">
                                        <p class="m-0"><?= number_format($event->getRankPoint($rank)->getValue(), 0) ?></p>
                                    </td>
                                <?php } ?>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <script src="../../crud/dist/bootstrap-5.2.3/js/bootstrap.bundle.min.js"></script>
</body>
</html>