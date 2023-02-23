<?php
require_once '_init.php';

// get authenticated user
$authUser = getUser();

if(!$authUser)
    denyAccess();

else if($authUser['userType'] !== 'judge')
    denyAccess();

else {

   if (isset($_GET['getEvents'])) {
       require_once 'models/Judge.php';

       // todo: After Judge is logged in, fetch all of the events assigned to Judge... regardless of category

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
