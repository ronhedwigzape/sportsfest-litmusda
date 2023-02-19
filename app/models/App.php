<?php

class App
{
    protected $conn;

    public function __construct()
    {
        if(isset($GLOBALS['conn']))
            $this->conn = $GLOBALS['conn'];
        else
            $this::returnError('HTTP/1.1 500', 'Missing database connection configuration.');
    }


    public static function returnError($header, $error)
    {
        header($header);
        die(json_encode([
            'error' => $error
        ]));
    }
}