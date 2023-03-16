<?php
// apply authentication
const LOGIN_PAGE_PATH = '../crud/';
require_once '../crud/auth.php';

/*********************************************************
 * Task for @Luimhar:

Sa loob ng app folder, gawa ka ng folder na results

~/app/results

Then inside the results folder, gawa ka ng 4 files:
- index.php
- event.php
- category.php
- competition.php

File Descriptions:
1. index.php
- render mo yung overall results from
$admin->tabulate()

2. event.php
- render mo yung results ng isang event na ipinasa sa URL:
- examples:
-- the URL "localhost/fobi/event.php?oration" will render the results for oration
-- the URL "localhost/fobi/event.php?balagtasan" will render the results for balagtasan
- you can use $admin->tabulate($event)

2. category.php
- render mo yung results ng isang category na ipinasa sa URL:
- examples:
-- the URL "localhost/fobi/category.php?literary" will render the results for literary
-- the URL "localhost/fobi/category.php?music" will render the results for music
- you can use $admin->tabulate($category)


3. competition.php
- render mo yung results ng isang competition na ipinasa sa URL:
- examples:
-- the URL "localhost/fobi/competition.php?sports" will render the results for sports
-- the URL "localhost/fobi/competition.php?litmusda" will render the results for litmusda
- you can use $admin->tabulate($competition)

 */
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

</body>
</html>

