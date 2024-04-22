<?php
    date_default_timezone_set('Asia/Manila');
    const LOGIN_PAGE_PATH = '../../crud/';
    require_once '../../crud/auth.php';

    require_once '../../config/database.php';
    require_once '../../models/Admin.php';
    $results = (new Admin())->tabulate(null, true);
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
        th.bt, td.bt {
            border-top-width: 3px !important;
        }
        th.br, td.br {
            border-right-width: 3px !important;
        }
        th.bb, td.bb {
            border-bottom-width: 3px !important;
        }
        th.bl, td.bl {
            border-left-width: 3px !important;
        }

    </style>
    <title>Overall Results</title>
<body>
    <div class="container-fluid mt-3">
        <table class="table table-bordered">
            <!-- table header -->
            <thead>
                <tr>
                    <th class="text-center bl bt" rowspan="2">
                        <h1 class="mt-0">OFFICIAL RESULTS</h1>
                        <p class="m-0"><i>as of</i>&nbsp;&nbsp;<?= date('M. d, Y h:i A', time()) ?></p>
                    </th>
                    <?php foreach($results['teams'] as $team_key => $team) { ?>
                        <th colspan="2" style="color: <?= $team['color'] ?>" class="text-center bl bt br">
                            <h6 class="m-0 text-uppercase"><?= $team['color'] ?></h6>
                            <h4 class="m-0"><?= $team['name'] ?></h4>
                        </th>
                    <?php } ?>
                </tr>
                <tr>
                    <?php foreach($results['teams'] as $team_key => $team) { ?>
                        <th class="text-center bl">POINTS</th>
                        <th class="text-center br">RANK</th>
                    <?php } ?>
                </tr>
            </thead>

            <!-- table body -->
            <tbody>
                <!-- overall -->
                <tr>
                    <td class="fw-bold p-3 bl br">
                        <h5 class="m-0">TOTAL</h5>
                    </td>
                    <?php foreach($results['teams'] as $team_key => $team) { ?>
                        <td align="right" class="bl">
                            <h5 class="m-0 fw-normal"><?= number_format(($results['teams'][$team_key]['points'] + $results['teams'][$team_key]['team_deductions']), 2) ?></h5>
                        </td>
                        <td align="right" class="br">

                        </td>
                    <?php } ?>
                </tr>
                <tr>
                    <td class="fw-bold p-3 bl br">
                        <h5 class="m-0 text-danger">DEDUCTIONS</h5>
                    </td>
                    <?php foreach($results['teams'] as $team_key => $team) { ?>
                        <td align="right" class="bl">
                            <h5 class="m-0 fw-normal text-danger"><?= number_format($results['teams'][$team_key]['team_deductions'], 2) ?></h5>
                        </td>
                        <td align="right" class="br">

                        </td>
                    <?php } ?>
                </tr>
                <tr style="background: yellow">
                    <td class="fw-bold p-3 bl br bb">
                        <h5 class="m-0">OVERALL</h5>
                    </td>
                    <?php foreach($results['teams'] as $team_key => $team) { ?>
                        <td align="right" class="bb bl">
                            <h5 class="m-0"><?= number_format($results['teams'][$team_key]['points'], 2) ?></h5>
                        </td>
                        <td align="right" class="br bb">
                            <h4 class="m-0"><?= number_format($results['teams'][$team_key]['rank']['fractional'], 2) ?></h4>
                        </td>
                    <?php } ?>
                </tr>

                <!-- competitions -->
                <?php foreach($results['competitions'] as $competition_key => $competition) { ?>
                    <!--divider -->
                    <tr><td colspan="<?= (1 + sizeof($results['teams'])) ?>" style="border: 0;"></td></tr>

                    <tr class="table-dark">
                        <td class="fw-bold p-3 bl bt br">
                            <h5 class="m-0 text-uppercase"><?= $competition['title'] ?></h5>
                        </td>
                        <?php foreach($results['teams'] as $team_key => $team) { ?>
                            <td class="bl bt<?= ($competition['results']['teams'][$team_key]['points'] <= 0) ? ' text-danger' : '' ?>" align="right">
                                <h5 class="m-0 fw-normal"><?= number_format($competition['results']['teams'][$team_key]['points'], 2) ?></h5>
                            </td>
                            <td align="right" class="bt br">
                                <h5 class="m-0"><?= number_format($competition['results']['teams'][$team_key]['rank']['fractional'], 2) ?></h5>
                            </td>
                        <?php } ?>
                    </tr>

                    <!-- categories -->
                    <?php $category_ctr = 0; ?>
                    <?php foreach($competition['results']['categories'] as $category_key => $category) { ?>
                        <?php $category_ctr += 1; ?>
                        <tr class="table-secondary">
                            <td class="fw-bold p-3 bl br">
                                <h6 class="m-0 text-uppercase"><?= $category['title'] ?></h6>
                            </td>
                            <?php foreach($results['teams'] as $team_key => $team) { ?>
                                <td class="py-3 bl<?= ($category['results']['teams'][$team_key]['points'] <= 0) ? ' text-danger' : '' ?>" align="right">
                                    <h6 class="m-0 fw-normal"><?= number_format($category['results']['teams'][$team_key]['points'], 2) ?></h6>
                                </td>
                                <td class="py-3 br" align="right">
                                    <h6 class="m-0 fw-bold opacity-75"><?= number_format($category['results']['teams'][$team_key]['rank']['fractional'], 2) ?></h6>
                                </td>
                            <?php } ?>
                        </tr>

                        <!-- events -->
                        <?php $event_ctr = 0; ?>
                        <?php foreach($category['results']['events'] as $event_key => $event) { ?>
                            <?php
                                $event_ctr += 1;
                                $is_last_event = ($category_ctr >= sizeof($competition['results']['categories'])) && ($event_ctr >= sizeof($category['results']['events']))
                            ?>
                            <tr>
                                <td class="px-4 bl<?= $is_last_event ? ' bb' : '' ?>">
                                    <p class="m-0 px-4"><?= $event['title'] ?></p>
                                </td>
                                <?php foreach($results['teams'] as $team_key => $team) { ?>
                                    <td class="bl<?= $is_last_event ? ' bb' : '' ?><?= ($event['results']['teams'][$team_key]['points'] <= 0) ? ' text-danger' : '' ?>" align="right">
                                        <p class="m-0 fw-normal"><?= number_format($event['results']['teams'][$team_key]['points'], 2) ?></p>
                                    </td>
                                    <td align="right" class="br<?= $is_last_event ? ' bb' : '' ?>">
                                        <p class="m-0 fw-bold opacity-75"><?= number_format($event['results']['teams'][$team_key]['rank']['final']['fractional'], 2) ?></p>
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