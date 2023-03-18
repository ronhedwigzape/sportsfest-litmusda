<?php
    date_default_timezone_set('Asia/Manila');
    const LOGIN_PAGE_PATH = '../../crud/';
    require_once '../../crud/auth.php';

    require_once '../../config/database.php';
    require_once '../../models/Admin.php';
    require_once '../../models/Event.php';
    require_once '../../models/Criterion.php';

    $criterion_preliminary  = Criterion::findById(21);
    $criterion_swimsuit     = Criterion::findById(22);
    $criterion_evening_gown = Criterion::findById(23);
    $criterion_qa           = Criterion::findById(24);

    $event_final_result = Event::findBySlug('final');
    $event_preliminary  = Event::findBySlug('preliminary');
    $event_swimsuit     = Event::findBySlug('swimsuit-2');
    $event_evening_gown = Event::findBySlug('evening-gown-2');
    $event_qa           = Event::findBySlug('qa');

    // tabulate events
    $admin = new Admin();
    $result_preliminary  = $admin->tabulate($event_preliminary);
    $result_swimsuit     = $admin->tabulate($event_swimsuit);
    $result_evening_gown = $admin->tabulate($event_evening_gown);
    $result_qa           = $admin->tabulate($event_qa);

    // tabulate $event_final_result
    $results = [];
    foreach($event_final_result->getAllTeams() as $team) {
        $team_key = 'team_'.$team->getId();

        $average_preliminary      = isset($result_preliminary['teams'][$team_key]) ? $result_preliminary['teams'][$team_key]['ratings']['average'] : 0;
        $percentage_preliminary   = $average_preliminary * 0.60;

        $average_swimsuit         = isset($result_swimsuit['teams'][$team_key]) ? $result_swimsuit['teams'][$team_key]['ratings']['average'] : 0;
        $percentage_swimsuit      = $average_swimsuit * 0.10;

        $average_evening_gown     = isset($result_evening_gown['teams'][$team_key]) ? $result_evening_gown['teams'][$team_key]['ratings']['average'] : 0;
        $percentage_evening_gown  = $average_evening_gown * 0.10;

        $average_qa               = isset($result_qa['teams'][$team_key]) ? $result_qa['teams'][$team_key]['ratings']['average'] : 0;
        $percentage_qa            = $average_qa * 0.20;

        // save ratings for the judge
        foreach($event_final_result->getAllJudges() as $judge) {
            $judge->setCriterionTeamRating($criterion_preliminary , $team, $percentage_preliminary);
            $judge->setCriterionTeamRating($criterion_swimsuit    , $team, $percentage_swimsuit);
            $judge->setCriterionTeamRating($criterion_evening_gown, $team, $percentage_evening_gown);
            $judge->setCriterionTeamRating($criterion_qa          , $team, $percentage_qa);
        }

        // append to results
        $results[$team_key] = [
            'preliminary' => [
                'average'    => $average_preliminary,
                'percentage' => $percentage_preliminary
            ],
            'swimsuit' => [
                'average'    => $average_swimsuit,
                'percentage' => $percentage_swimsuit
            ],
            'evening-gown' => [
                'average'    => $average_evening_gown,
                'percentage' => $percentage_evening_gown
            ],
            'qa' => [
                'average'    => $average_qa,
                'percentage' => $percentage_qa
            ]
        ];
    }
    $result_final_result = $admin->tabulate($event_final_result);
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
    <title>Overall Results</title>
<body>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th colspan="2" rowspan="2" class="text-center">
                    <h1 class="m-0">FINAL RESULTS</h1>
                </th>
                <th colspan="2" class="text-center">
                    PRELIM
                </th>
                <th colspan="2" class="text-center">
                    SWIMSUIT
                </th>
                <th colspan="2" class="text-center">
                    EVENING<br>GOWN
                </th>
                <th colspan="2" class="text-center">
                    Q & A
                </th>
                <th rowspan="2" class="text-center">
                    TOTAL<br>AVERAGE
                </th>
                <th rowspan="2" class="text-center">
                    INITIAL<br>RANK
                </th>
                <th rowspan="2" class="text-center">
                    <h5 class="m-0 fw-bold">
                        FINAL<br>RANK
                    </h5>
                </th>
            </tr>
            <tr>
                <th></th>
                <th class="text-center">60%</th>
                <th></th>
                <th class="text-center">10%</th>
                <th></th>
                <th class="text-center">10%</th>
                <th></th>
                <th class="text-center">20%</th>
            </tr>
        </thead>

        <tbody>
            <?php
            $i = 0;
            foreach($event_final_result->getAllTeams() as $team) {
                $i += 1;
                $team_key = 'team_'.$team->getId();
            ?>
                <tr>
                    <td class="pe-2 fw-bold" align="right">
                        <h5 class="m-0">
                            <?= $i ?>
                        </h5>
                    </td>
                    <td>
                        <div class="d-flex">
                            <div style="position: relative; width: 48px; height: 48px; overflow: hidden; border-radius: 50%;">
                                <img
                                    src="../../crud/uploads/<?= $team->getAvatar() ?>"
                                    alt="<?= $team->getCountry() ?>"
                                    style="position: absolute; width: 100%; left: 0; right: 0;"
                                >
                            </div>
                            <div class="ps-3">
                                <h5 class="text-uppercase m-0"><?= $team->getCountry() ?></h5>
                                <p class="m-0"><?= $team->getName() ?></p>
                            </div>
                        </div>
                    </td>

                    <!-- prelim -->
                    <td class="pe-2" align="right">
                        <?= number_format($results[$team_key]['preliminary']['average'], 2) ?>
                    </td>
                    <td class="pe-2 fw-bold text-secondary" align="right">
                        <?= number_format($results[$team_key]['preliminary']['percentage'], 2) ?>
                    </td>

                    <!-- swimsuit -->
                    <td class="pe-2" align="right">
                        <?= number_format($results[$team_key]['swimsuit']['average'], 2) ?>
                    </td>
                    <td class="pe-2 fw-bold text-secondary" align="right">
                        <?= number_format($results[$team_key]['swimsuit']['percentage'], 2) ?>
                    </td>

                    <!-- evening-gown -->
                    <td class="pe-2" align="right">
                        <?= number_format($results[$team_key]['evening-gown']['average'], 2) ?>
                    </td>
                    <td class="pe-2 fw-bold text-secondary" align="right">
                        <?= number_format($results[$team_key]['evening-gown']['percentage'], 2) ?>
                    </td>

                    <!-- qa -->
                    <td class="pe-2" align="right">
                        <?= number_format($results[$team_key]['qa']['average'], 2) ?>
                    </td>
                    <td class="pe-2 fw-bold text-secondary" align="right">
                        <?= number_format($results[$team_key]['qa']['percentage'], 2) ?>
                    </td>

                    <!-- average -->
                    <td class="pe-2 fw-bold text-secondary" align="right">
                        <h5 class="m-0">
                            <?= number_format($result_final_result['teams'][$team_key]['ratings']['average'], 2) ?>
                        </h5>
                    </td>

                    <!-- initial rank -->
                    <td class="pe-2 fw-bold text-secondary" align="right">
                        <h5 class="m-0">
                            <?= number_format($result_final_result['teams'][$team_key]['rank']['initial']['fractional'], 2) ?>
                        </h5>
                    </td>

                    <!-- final rank -->
                    <td class="pe-2 fw-bolder" align="right">
                        <h4 class="m-0">
                            <?= number_format($result_final_result['teams'][$team_key]['rank']['final']['fractional'], 2) ?>
                        </h4>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <script src="../../crud/dist/bootstrap-5.2.3/js/bootstrap.bundle.min.js"></script>
</body>
</html>