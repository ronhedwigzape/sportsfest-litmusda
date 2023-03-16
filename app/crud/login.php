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
            header('Location: ' . ((isset($_GET['next'])) ? $_GET['next'] : 'competitions.php'));
        }else{
            $error = "Invalid username or password";
        }
    }
    else if(isset($_SESSION['admin_id']))
        header('Location: competitions.php');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="shortcut icon" href="logo.png">
        <link rel="stylesheet" href="style.css">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="dist/bootstrap-4.2.1/css/bootstrap.min.css">

        <!-- For Icon -->
        <link rel="stylesheet" href="dist/fontawesome-6.3.0/css/all.min.css">

        <title>CRUD | Sign In</title>
    </head>
    <body>
        <div class="main">
            <div class="container">
                <center>
                    <div class="middle">
                        <div id="login">
                            <div class="text-color text-info">
                                <h2><u>Sign In</u></h2>
                            </div>
                            <div id="login-warning">
                                <?php if(isset($error_msg)) { ?>
                                    <div class="alert"><?php echo $error_msg; ?></div>
                                <?php } ?>
                            </div>

                            <form action="" method="post" class="my-4">
                                <fieldset class="clearfix">
                                    <div class="form-element">
                                        <span class="fa fa-user"></span><input type="text" name="username" id="username" autocomplete="off" placeholder="Enter Username" required>
                                    </div>

                                    <div class="form-element">
                                        <span class="fa fa-lock"></span>
                                        <div class="password-wrapper">
                                            <input type="password" name="password" id="password" placeholder="Enter Password" required>
                                            <span class="toggle-password"><i class="fa fa-eye"></i></span>
                                        </div>
                                    </div>

                                    <button class="btn btn-info text-center" style="width:100%;" type="submit" name="login">Login</button>
                                </fieldset>
                            </form>
                            <div class="clearfix"></div>
                        </div> <!-- end login -->
                    </div>
                </center>
            </div>
        </div>

        <!-- Bootstrap Javascript -->
        <script src="dist/jquery-3.6.4/jquery-3.6.4.min.js"></script>
        <script src="dist/bootstrap-4.2.1/js/bootstrap.min.js"></script>

        <script>
            const togglePassword = document.querySelector('.toggle-password');
            const password = document.querySelector('#password');

            togglePassword.addEventListener('click', function (e) {
                // toggle the type attribute
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                // toggle the eye icon
                this.querySelector('i').classList.toggle('fa-eye');
                this.querySelector('i').classList.toggle('fa-eye-slash');
            });
        </script>

    </body>
</html>
