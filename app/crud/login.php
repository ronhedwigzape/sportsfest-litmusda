<?php
    session_start();

    require_once '../config/database.php';
    require_once '../models/Admin.php';

    if(isset($_POST['username']) && isset($_POST['password'])){
        $username = $_POST['username'];
        $password = $_POST['password'];

        $admin = ((new Admin($username, $password)))->signIn();
        if($admin){
            $_SESSION['admin_id'] = $admin->getId();
            header('Location: competitions.php');
        }else{
            $error = "Invalid username or password";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="logo.png">
    <title>CRUD | Sign In</title>
</head>
<body>
<div class="main">
    <div class="container">
        <center>
            <div class="middle">
                <div id="login">
                    <div class="text-color text-light">
                        <h2>Sign In</h2>
                    </div>
                    <br>

                    <form action="" method="post">

                        <fieldset class="clearfix">
                            <div class="form-element">
                                <span class="fa fa-user"></span><input type="text" name="username" id="username" autocomplete="off" placeholder="Enter Usename" required>
                            </div>

                            <div class="form-element">
                                <span class="fa fa-lock"></span><input type="password" name="password" id="password"  placeholder="Enter Password" required>
                            </div>

                            <button class="btn btn-secondary" style="text-align:center; width:100%;" type="submit" name="login">Login</button>
                        </fieldset>
                    </form>
                    <div class="clearfix"></div>
                </div> <!-- end login -->
                <div class="logo">
                    <img src="uploads/ACLClogo.png" alt="">
                    <div class="clearfix"></div>
                </div>
            </div>
    </div>
</div>
</center>
</div>
</div>

<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
</body>
</html>
