<?php

/*
|-----------------------------------------------------------------------
| Database Configuration
|-----------------------------------------------------------------------
| Enter the configuration for your MySQL Database
|
|    host    ->  your config host
|    user    ->  your config username
|    pass    ->  your config password
|    dbname  ->  your config name
|
*/

$config = [
    'host'   => 'localhost',
    'user'   => 'root',
    'pass'   => isset($DB_PASSWORD) ? $DB_PASSWORD : '',
    'dbname' => 'sportsfest-litmusda'
];

$conn = new mysqli($config['host'], $config['user'], $config['pass'], $config['dbname']);

if($conn->connect_error) {
    die(json_encode([
        'error' => $conn->connect_error
    ]));
}
