<?php
require_once '_init.php';

// get requests
if(isset($_GET['getUser'])) {
    echo json_encode([
        'user' => getUser()
    ]);

    exit;
}

// user sign-in
else if(isset($_POST['username']) && isset($_POST['password'])) {
    require_once 'models/Admin.php';
    require_once 'models/Judge.php';
    require_once 'models/Technical.php';

    // todo: validate input
    $username = trim(strtolower($_POST['username']));
    $password = $_POST['password'];

    $user = (new Admin($username, $password))->signIn();
    if(!$user) {
        $user = (new Judge($username, $password))->signIn();
        if(!$user)
            $user = (new Technical($username, $password))->signIn();
    }

    if($user) {
        // successfully logged in
        echo json_encode([
            'user' => [...$user->toArray(), 'calling' => $user->isCalling()]
        ]);
    }
    else
        App::returnError('HTTP/1.1 401', 'Invalid Username or Password');

    exit;
}


// user sign out
else if(isset($_POST['signOut'])) {
    if($user_info = getUser()) {
        require_once 'models/User.php';
        $user = new User($user_info['username'], $_SESSION['pass'], $user_info['userType']);
        $user->signOut();
    }
    echo json_encode([
        'signedOut' => true
    ]);

    exit;
}



$routes = [
    [ "name" => "Main panel", "route" => "crud/competitions.php" ],
    [ "name" => "Tabulation", "route" => "http://localhost/sportsfest-litmusda" ],
    [ "name" => "Result"    , "route" => "results/overall" ],
    [ "name" => "Guidelines", "route" => "crud/guidelines/event_ranking.php" ],
    [ "name" => "Assignment", "route" => "crud/assignment" ],
    [ "name" => "No show"   , "route" => "crud/noshow" ],
    [ "name" => "Eliminations"   , "route" => "crud/eliminations" ]
];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="crud/dist/bootstrap-5.2.3/css/bootstrap.min.css" />
    <style type="text/css">
        body{ background: #111; color: white; }
        .card{ background: rgba(0,0,0,0.05); border: 1px solid rgba(225, 225, 225, 0.2); }
        h1{
            background: -webkit-linear-gradient(50deg,#50e9f0, #2e459f);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .card{ transition: 0.2s ease; }
        .card:hover{ transform: scale(1.02); }

        svg{
            animation: fire 1.5s infinite alternate-reverse;
        }

        @keyframes fire{
            from{ transform: scale(1.0) rotate(0deg) translateY(0px); filter: blur(0); }
            to{ transform: scale(1.1) rotate(4deg) translateY(-5px); filter: blur(2px); }
        }

    </style>
    <title>sportsfest-litmusda</title>
</head>
<body>

    <div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh;" >
        <div>
            <div class="text-center mb-5" >
                <svg xmlns="http://www.w3.org/2000/svg" width="52" height="52" class="bi bi-fire" viewBox="0 0 16 16">
                    <defs>
                        <linearGradient id="grad1" x1="0%" y1="0%" x2="100%" y2="0%">
                            <stop offset="0%" style="stop-color:#50e9f0;stop-opacity:1" />
                            <stop offset="100%" style="stop-color:#2e459f;stop-opacity:1" />
                        </linearGradient>
                    </defs>
                    <path fill="url(#grad1)" d="M8 16c3.314 0 6-2 6-5.5 0-1.5-.5-4-2.5-6 .25 1.5-1.25 2-1.25 2C11 4 9 .5 6 0c.357 2 .5 4-2 6-1.25 1-2 2.729-2 4.5C2 14 4.686 16 8 16Zm0-1c-1.657 0-3-1-3-2.75 0-.75.25-2 1.25-3C6.125 10 7 10.5 7 10.5c-.375-1.25.5-3.25 2-3.5-.179 1-.25 2 1 3 .625.5 1 1.364 1 2.25C11 14 9.657 15 8 15Z"/>
                </svg>
                <h1 class="fw-bold" >sportsfest-litmusda</h1>
                <p class="fst-italic" >Your SPORTSFEST & LITMUSDA Open Source Panel, because why not?</p>
            </div>

            <div class="row g-3 justify-content-center">

                <!-- Guidelines -->
                <?php foreach ($routes as $route){ ?>
                <div onclick="window.open('<?php echo $route['route'] ?>', '_blank');" class="col-md-4" >
                    <div class="card" >
                        <div class="card-body" role="button" >
                            <h4 class="font-bold mt-2 fw-bold" ><?php echo $route["name"]; ?></h4>
                            <code><?php echo $route["route"] ?></code>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>

            <div class="text-center text-secondary mt-5" >
                <small>Wanna contribute? <a target="_blank" href="https://github.com/ronhedwigzape/sportsfest-litmusda">https://github.com/ronhedwigzape/sportsfest-litmusda</a></small>
            </div>
        </div>
    </div>

</body>
</html>