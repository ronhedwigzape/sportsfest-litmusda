<?php

require_once '../../../config/database.php';
require_once '../../../models/Judge.php';
require_once '../../../models/Event.php';
require_once '../../../models/Technical.php';

$judge = Judge::all();
$event = Event::all();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>CRUD</title>

</head>
<body style="background-color: #B0C4DE">

    <div style="width: 60%; margin-left: 20%; margin-top: 80px; background-color: #F0FFF0; padding-top: 30px; padding-bottom: 20px; margin-right: 20px;">
        <div style="display: flex;">
            <select class="form-select" aria-label="Default select example" id="select" style="width: 20%; color: white; background-color: #2F4F4F; text-align: center;margin-left: 30px;">
                <option selected>Select Judge</option>
                <?php foreach($judge as $judges){ ?>
                    <option value="<?=$judges->getId()?>"><?=$judges->getName()?></option>
                <?php } ?>
            </select>

        </div>


        <div id="result" style="width: 70%; margin-left: 15%;"></div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

<script src="../dist/bootstrap-5.3.0-alpha1-dist/js/bootstrap.js"></script>
    <script src="js/jqueryCdn.js"></script>
    <script src="js/load_data.js"></script>
    <script src="action.js"></script>

<!--    <script>-->
<!--        function remove(id){-->
<!--            alert(id);-->
<!--        }-->
<!--    </script>-->
</body>
</html>
