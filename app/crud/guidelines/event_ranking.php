<?php
require_once '../../config/database.php';
require_once '../../models/Event.php';
require_once '../../models/Point.php';

$events = Event::all();
// $Point = Point;
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Ranking</title>
    <link rel="stylesheet" href="../dist/bootstrap-4.2.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body class="container py-5">

    <?php
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
        ?>
            <div class="col-md-4">
                <div class="card mb-4 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $event->getTitle(); ?></h5>
                        <p class="card-text">
                            <?php 
                            
                            $ranks = Point::ranks();
                            // print_r($Points);
                            foreach($ranks as $rank){
                            ?>
                            <p>Rank <?php echo $rank;?>: </p>

                                <?php
                                    echo Point::stored($eventID, $rank);
                                ?>

                                <?php
                            }

                            
                            ?>


                        
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
</body>
</html>