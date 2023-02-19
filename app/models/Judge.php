<?php

require_once 'User.php';

class Judge extends User
{
    public function __construct($username = '', $password = '')
    {
        parent::__construct($username, $password, 'judge');
    }


    public static function all()
    {
        $judge = new Judge();
        $sql = "SELECT id, number, name, avatar, is_chairman FROM $judge->table ORDER BY number";
        $result = $judge->conn->query($sql);

        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
