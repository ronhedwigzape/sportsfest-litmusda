<?php
const LOGIN_PAGE_PATH = '../';
require_once '../auth.php';

require_once '../../config/database.php';
require_once '../../models/Event.php';
require_once '../../models/Judge.php';

if(isset($_POST['option'])) {
    $option = $_POST['option'];
    if($option != "Select Judge") {
        $judge_data = Judge::findById($option);
        $judgeEvent = $judge_data->getAllEvents();
        $judgeID = $option;

        $all_event = Event::all();
        $j = 0;
        $display = [];
        $displayTitle = [];

        foreach($all_event as $all) {
            foreach($judgeEvent as $evt) {
                if($all->getId() == $evt->getId()) {
                    $j++;
                }

            }
            if($j == 0) {
                $display[] = $all->getId();
            }
            else {
                $j = 0;
            }
        }
        for($i = 0; $i < count($display); $i++) {
            $displayTitle[] = Event::findById($display[$i]);
        }

    }
    else {
        $judgeEvent = [];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="logo.png">
    <link rel="stylesheet" href="../dist/bootstrap-5.2.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="../dist/fontawesome-6.3.0/css/all.min.css">
    <title>CRUD</title>
</head>
<body>
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addData<?= $option ?>"
        style="margin-left: 77%; width: 23%; margin-top: 30px;">
    Assign Event
</button>

<!-- ADD Modal -->
<div class="modal fade" id="addData<?= $option ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
     aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Event title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <select class="form-select" aria-label="Default select example"
                        style="width: 50%; color: white; background-color: #2F4F4F; text-align: center; margin-left: 25%;"
                        id="selected_Event<?= $option ?>">
                    <option selected><b>Select Event</b></option>
                    <?php foreach($displayTitle as $disTitle) { ?>
                        <option value="<?= $disTitle->getId() ?>"><?= $disTitle->getTitle() ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="closeAdd<?= $option ?>">
                    Close
                </button>
                <button type="button" class="btn btn-primary" onclick="submitAdd(<?= $option ?>)">Submit</button>
            </div>
        </div>
    </div>
</div>
<table class="table table-bordered" style="margin-top: 10px;">
    <thead>
    <tr>
        <th colspan="2" style="text-align: center; font-size: 20px;">
            Event Title
        </th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($judgeEvent as $eventData) { ?>
        <tr>
            <td style="padding-left: 30px;">
                <?= $eventData->getTitle() ?>
            </td>
            <td style="width: 10%;">
                <span
                    class="fa fa-fw fa-remove text-danger"
                    type="button"
                    style="cursor: pointer;
                    margin-left: 10px;"
                    data-bs-toggle="modal"
                    data-bs-target="#deleteModal<?= $eventData->getId() ?>">
                </span>
            </td>
        </tr>

        <!-- DELETE Modal -->
        <div class="modal fade" id="deleteModal<?= $eventData->getId() ?>" data-bs-backdrop="static"
             data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel"></h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Do you want to <b>Delete <?= $eventData->getTitle() ?></b>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                                id="button<?= $eventData->getId() ?>">Close
                        </button>
                        <button class="btn btn-primary" onclick="remove(<?= $judgeID ?>,<?= $eventData->getId() ?>)">
                            Proceed
                        </button>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    </tbody>
</table>
</body>
</html>
