<?php
require_once '_init.php';

// get authenticated user
$authUser = getUser();

if(!$authUser)
    denyAccess();

else if($authUser['userType'] !== 'judge')
    denyAccess();

else {

   if (isset($_GET['getEvents']) || isset($_GET['getScoreSheet'])) {
       require_once 'models/Judge.php';

       $judge = new Judge($authUser['username'], $_SESSION['pass']);

       if(!$judge->authenticated())
           denyAccess();

       else {
           echo json_encode([
               "events" => $judge->getRowEvents()
           ]);
       }
   }
}
