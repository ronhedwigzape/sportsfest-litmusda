<?php

require_once 'User.php';

class Technical extends User
{
    /***************************************************************************
     * Technical constructor
     *
     * @param $username
     * @param $password
     */
    public function __construct($username = '', $password = '')
    {
        parent::__construct($username, $password, 'technical');
    }


    /***************************************************************************
     * Get all technicals
     *
     * @return mixed
     */
    public static function all()
    {
        $technical = new Technical();
        $sql = "SELECT id, number, name, avatar FROM $technical->table ORDER BY number";
        $result = $technical->conn->query($sql);

        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
