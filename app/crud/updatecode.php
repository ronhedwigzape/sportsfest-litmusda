<?php

require_once '../config/database.php';
$db = mysqli_select_db($conn, 'sportsfest-litmusda');

    if(isset($_POST['updatedata']))
    {   
        $id = $_POST['update_id'];
        
        $slug = $_POST['slug'];
        $title = $_POST['title'];
        
        $query = "UPDATE competitions SET slug='$slug', title='$title' WHERE id='$id'  ";
        $query_run = mysqli_query($conn, $query);

        if($query_run)
        {
            echo '<script> alert("Data Updated"); </script>';
            header("Location:index.php");
        }
        else
        {
            echo '<script> alert("Data Not Updated"); </script>';
        }
    }
?>