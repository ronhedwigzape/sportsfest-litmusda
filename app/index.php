<?php
require_once '_init.php';

// get requests
if(isset($_GET['getUser'])) {
    echo json_encode([
        'user' => getUser()
    ]);
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
            'user' => $user->getInfo()
        ]);
    }
    else
        App::returnError('HTTP/1.1 401', 'Invalid Username or Password');
}


// user sign out
else if(isset($_POST['signOut'])) {
    session_destroy();
    echo json_encode([
        'signedOut' => true
    ]);
}


else
    denyAccess();
