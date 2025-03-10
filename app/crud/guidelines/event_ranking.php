<?php
const LOGIN_PAGE_PATH = '../';
require_once '../auth.php';

require_once '../../config/database.php';
require_once '../../models/Event.php';
require_once '../../models/Point.php';
require_once '../../models/Competition.php';
require_once '../../models/Category.php';

$ranks = Point::ranks();
$competitions = Competition::all();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Ranking</title>
    <link rel="stylesheet" href="../dist/bootstrap-4.2.1/css/bootstrap.min.css">
</head>
<body>
<div aria-live="polite" aria-atomic="true" style="position: fixed; top: 20px; right: 20px; min-width: 250px; z-index: 9999;">
    <div id="liveToast" class="toast" data-delay="3000">
        <div class="toast-header">
            <strong class="mr-auto" id="toastTitle"></strong>
            <small>Just now</small>
            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast">&times;</button>
        </div>
        <div class="toast-body" id="toastBody"></div>
    </div>
</div>
<div class="modal fade" id="editmodal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="event_name"></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="event_id">
                <input type="hidden" id="point_id">
                <div class="form-group">
                    <label>Rank</label>
                    <input type="number" id="rank" class="form-control" readonly>
                </div>
                <div class="form-group">
                    <label>Points</label>
                    <input type="number" id="points" class="form-control" placeholder="Enter your desired points">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="button" id="confirm_btn" class="btn btn-primary">Confirm</button>
            </div>
        </div>
    </div>
</div>

<div class="container py-5">
    <?php foreach($competitions as $competition){ ?>
        <h1 class="text-center"><?php echo $competition->getTitle(); ?></h1>
        <hr>
        <?php
        $Categories = Category::all($competition->getId());
        foreach($Categories as $Category){
            echo "<br><h4 class='text-primary'>" . $Category->getTitle() . "</h4><br>";
            $events = Event::all($Category->getId());
            $column_num = 3;
            $counter = $column_num;
            $num_items = sizeof($events) + $column_num;
            foreach($events as $event){
                $x = $counter % $column_num;
                if($x == 0){
                    echo '<div class="row">';
                    $end = $counter + $column_num;
                }
                $event_name = $event->getTitle();
                $event_id = $event->getId();
                ?>
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title float-left"><?php echo $event_name; ?></h5>
                            <h5 class="card-title float-right event-info"><?php echo $event_id; ?></h5>
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th class="d-none">ID</th>
                                    <th>Rank</th>
                                    <th>Points</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach($ranks as $rank){
                                    $Point = $event->getRankPoint($rank);
                                    ?>
                                    <tr>
                                        <td class="d-none"><?php echo $Point->getId(); ?></td>
                                        <td><?php echo $Point->getRank(); ?></td>
                                        <td><?php echo $Point->getValue(); ?></td>
                                        <td>
                                            <button class="ml-4 btn btn-warning edit" data-toggle="modal" data-target="#editmodal">Edit</button>
                                        </td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <?php
                $counter++;
                if($counter == $end || $counter == $num_items){
                    echo "</div>";
                }
            }
        }
        ?>
    <?php } ?>
</div>

<script src="../dist/jquery-3.6.4/jquery-3.6.4.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="../dist/bootstrap-4.2.1/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function () {
        var currentRow = null;

        $('.edit').on('click', function () {
            currentRow = $(this).closest('tr');
            var pointData = currentRow.children("td").map(function () {
                return $(this).text();
            }).get();

            $('#point_id').val(pointData[0]);
            $('#rank').val(pointData[1]);
            $('#points').val(pointData[2]);

            var $card = $(this).closest('.card-body');
            var eventData = $card.find('.event-info').map(function () {
                return $(this).text();
            }).get();

            $('#event_id').val(eventData[0]);
            $('#event_name').text($card.find('.card-title.float-left').text());
        });

        $('#confirm_btn').on('click', function () {
            var dataToSend = {
                event_id: $('#event_id').val(),
                point_id: $('#point_id').val(),
                rank: $('#rank').val(),
                points: $('#points').val(),
                edit_btn: true
            };

            $.ajax({
                type: "POST",
                url: "action.php",
                data: dataToSend,
                dataType: "json",
                success: function (response) {
                    if (response.status === 'success') {
                        if (currentRow) {
                            currentRow.find('td:eq(2)').text(response.new_points);
                        }
                        showToast('Success', response.message, 'success');
                        $('#editmodal').modal('hide');
                    } else {
                        showToast('Error', response.message, 'danger');
                    }
                },
                error: function () {
                    showToast('Error', 'An error occurred while processing your request.', 'danger');
                }
            });
        });

        function showToast(title, message, type) {
            var toast = $('#liveToast');
            $('#toastTitle').text(title);
            $('#toastBody').text(message);

            var header = toast.find('.toast-header');
            header.removeClass('bg-success bg-danger text-white');
            if (type === 'success') {
                header.addClass('bg-success text-white');
            } else if (type === 'danger') {
                header.addClass('bg-danger text-white');
            }
            toast.toast('show');
        }
    });
</script>
</body>
</html>