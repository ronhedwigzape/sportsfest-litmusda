<?php

require_once '../config/database.php';
$db = mysqli_select_db($conn, 'sportsfest-litmusda');

if(isset($_POST['deletedata']))
{
    $id = $_POST['delete_id'];

    $query = "DELETE FROM competitions WHERE id='$id'";
    $query_run = mysqli_query($conn, $query);

    if($query_run)
    {
        echo '<script> alert("Data Deleted"); </script>';
        header("Location:index.php");
    }
    else
    {
        echo '<script> alert("Data Not Deleted"); </script>';
    }
}

?>