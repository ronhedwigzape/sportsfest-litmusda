<?php

require_once '../config/database.php';
$db = mysqli_select_db($conn, 'sportsfest-litmusda');

if(isset($_POST['insertdata']))
{
    $slug = $_POST['slug'];
    $title = $_POST['title'];

    $query = "INSERT INTO competitions (`slug`,`title`) VALUES ('$slug','$title')";
    $query_run = mysqli_query($conn, $query);

    if($query_run)
    {
        echo '<script> alert("Data Saved"); </script>';
        header('Location: index.php');
    }
    else
    {
        echo '<script> alert("Data Not Saved"); </script>';
    }
}

?>