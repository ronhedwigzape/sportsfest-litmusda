<?php
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
<body class="">
    <!-- The Modal for edit-->
    <div class="modal fade" id="editmodal">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title" id="event_name"></h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>

                            <!-- Modal body -->
                            <form action="action.php" method="POST">
                                <div class="modal-body">
                                    <input type="hidden" name="event_id" id="event_id">
                                    <input type="hidden" name="point_id" id="point_id">
                                    <!-- <input type="hidden" name="rank" id="rank"> -->
                                    <div class="form-group">
                                        <label>Rank</label>
                                        <input type="number" name="rank" id="rank" class="form-control" placeholder="" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>Points</label>
                                        <input type="number" name="points" id="points" class="form-control" placeholder="Enter your desired points">
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                    <button type="submit" name="edit_btn" id="edit_btn"class="btn btn-primary">Confirm</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>



    <div class="container py-5">
        <?php
            foreach($competitions as $competition){
        ?>
                <h1 class="text-center"><?php echo $competition->getTitle();?></h1>
                <hr>
                <?php
                    $Categories = Category::all($competition->getId());
                    foreach($Categories as $Category){
                        echo "<br><h4 class='text-primary'>", $Category->getTitle(),  "</h4> <br>";
                        $events = Event::all($Category->getId());
                        
                        $column_num = 3;
                        $counter = $column_num;
                        $num_items = sizeof($events)+ $column_num;
                        foreach($events as $event){
                            $x = $counter % $column_num;
                            if($x==0){
                                echo '<div class="row">';
                                $end = $counter+$column_num;
                            }
                            $eventID = $event->getId();
                            $counter++;
                            $event_name = $event->getTitle();
                            $event_id = $event->getId();
                            ?>
                                <div class="col-md-4">
                                    <div class="card mb-4 shadow-sm">
                                        <div class="card-body">
                                            <h5 class="card-title float-left"> <?php echo $event_name; ?></h5>
                                            <h5 class="card-title float-right" id="event_id"><?php echo $event_id; ?> </h5>
                                            <p class="card-text">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th scope="column" class="d-none">ID</th>
                                                            <th scope="column">Rank</th>
                                                            <th scope="column">Points</th>
                                                            <th scope="column"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 
                                                            foreach($ranks as $rank){
                                                                $Point = Point::find($event_id, $rank);
                                                        ?>
                                                        <tr>
                                                            <td class="d-none"><?php echo $Point->getId();?></td>
                                                            <td><?php echo $Point->getRank();?></td>
                                                            <td><?php echo $Point->getValue();?></td>
                                                            <th class=""><button class="ml-4 btn btn-warning edit" data-toggle="modal" data-target="#editmodal">Edit</button></th>
                                                        </tr>
                                                        <?php
                                                            }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </p>
                                            
                                        </div>
                                    </div>
                                </div>
                    <?php
                            if($counter == $end || $counter == $num_items){
                                echo "</div>";
                                $flag = false;
                            } 
                        }
                    ?>
                <?php
                    }
                ?>
        <?php
            }
        ?>

        




        
    </div>
    <script src="../dist/ajax/libs/jquery-3.3.1/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="../dist/bootstrap-4.2.1/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function () {

            $('.edit').on('click', function () {
                $tr = $(this).closest('tr');
                var point = $tr.children("td").map(function () {
                    return $(this).text();
                }).get();

                console.log(point);
                $('#point_id').val(point[0]);
                $('#rank').val(point[1]);
                $('#points').val(point[2]);

                $div = $(this).closest('div');
                var event = $div.children("h5").map(function () {
                    return $(this).text();
                }).get();

                console.log(event);
                $('#event_id').val(event[1]);
                $('#event_name').text(event[0]);
            });
        });
    </script>
</body>
</html>