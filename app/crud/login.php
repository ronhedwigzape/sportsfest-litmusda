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

        <!-- For Icon -->
        <link rel="stylesheet" href="dist/fontawesome-6.3.0/css/all.min.css">

        <title>CRUD | Sign In</title>
    </head>
    <body>
        <div class="login-box">
            <h2>Sign In</h2>
            <form action="" method="post" class="my-4">
                <div class="user-box">
                    <input type="text" name="username" id="username" autocomplete="off" required>
                    <label>Username</label>
                </div>

                <div class="user-box">
                    <input type="password" name="password" id="password" required>
                    <label>Password</label>
                    <span class="toggle-password"><i class="fa fa-eye-slash"></i></span>
                </div>

                <button class="btn-secondary" type="submit" name="login">
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    Login
                </button>
            </form>
        </div>
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
