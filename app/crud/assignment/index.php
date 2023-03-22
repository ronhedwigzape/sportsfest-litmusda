<?php

    const LOGIN_PAGE_PATH = '../';
    require_once '../auth.php';

    require_once '../../config/database.php';
    require_once '../../models/Judge.php';
    require_once '../../models/Event.php';
    require_once '../../models/Technical.php';

    $judge = Judge::all();
    $event = Event::all();
    $technical = Technical::all();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../dist/bootstrap-5.2.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="../dist/fontawesome-6.3.0/css/all.min.css">
    <title>CRUD</title>
    <style>
        .bigSpinner{
            margin-left: 48%;
            margin-top: 100px;
            display: none;
        }
    </style>
</head>
<body style="background-color: #B0C4DE" onload="load()">
    <div style="display: flex; width: 30%; margin-left: 20%; margin-top: 50px;">
        <div id="judgeDiv" onclick="judgeShow()"
             style="border: solid black 1px; width: 60%; height: 40px; cursor: pointer; text-align: center; background-color: #F0FFF0">
            <p id="judgeWord" style="font-size: 19px; color: #2F4F4F">Judge</p>
        </div>
        <div id="technicalDiv" onclick="technicalShow()"
             style="border: solid black 1px; width: 60%; height: 40px; cursor: pointer; text-align: center; background-color: #F0FFF0">
            <p id="technicalWord" style="font-size: 19px; color: #2F4F4F;">Technical</p>
        </div>
    </div>

    <div id="judgeData"
         style="width: 60%; margin-left: 20%; margin-top: 40px; background-color: #F0FFF0; padding-top: 30px; padding-bottom: 20px; margin-right: 20px;">
        <div style="display: flex;">
            <select class="form-select" aria-label="Default select example" id="select"
                    style="width: 20%; color: white; background-color: #2F4F4F; text-align: center;margin-left: 30px;">
                <option selected>Select Judge</option>
                <?php foreach($judge as $judges) { ?>
                    <option value="<?= $judges->getId() ?>"><?= $judges->getName() ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="spinner-border text-primary bigSpinner" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <div id="result" style="width: 70%; margin-left: 15%;"></div>
    </div>

    <div id="technicalData"
         style="width: 60%; margin-left: 20%; margin-top: 40px; background-color: #F0FFF0; padding-top: 30px; padding-bottom: 20px; margin-right: 20px;">
        <div style="display: flex;">
            <select class="form-select" aria-label="Default select example" id="selectTech"
                    style="width: 20%; color: white; background-color: #2F4F4F; text-align: center;margin-left: 30px;">
                <option selected>Select Technical</option>
                <?php foreach($technical as $technicals) { ?>
                    <option value="<?= $technicals->getId() ?>"><?= $technicals->getName() ?></option>
                <?php } ?>
            </select>

        </div>

        <div id="technicalResult" style="width: 70%; margin-left: 15%;"></div>
    </div>
    <?php $script_version = time();?>
    <script src="../dist/jquery-3.6.4/jquery-3.6.4.min.js"></script>
    <script src="../dist/bootstrap-5.2.3/js/bootstrap.bundle.min.js"></script>
    <script src="js/load_data.js<?= '?'.$script_version ?>"></script>
    <script src="js/action.js<?= '?'.$script_version ?>"></script>
    <script src="js/toggleButton.js<?= '?'.$script_version ?>"></script>
    <script src="js/show_hide.js<?= '?'.$script_version ?>"></script>
</body>
</html>
