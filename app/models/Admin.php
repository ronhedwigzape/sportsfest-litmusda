<?php

require_once 'User.php';

class Admin extends User
{
    /***************************************************************************
     * Admin constructor
     *
     * @param $username
     * @param $password
     */
    public function __construct($username = '', $password = '')
    {
        parent::__construct($username, $password, 'admin');
    }
}
