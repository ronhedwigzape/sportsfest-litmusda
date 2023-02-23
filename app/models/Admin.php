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


    /***************************************************************************
     * Execute find
     *
     * @param $stmt
     * @return Admin|false
     */
    private static function executeFind($stmt)
    {
        $stmt->execute();
        $result = $stmt->get_result();
        if($row = $result->fetch_assoc())
            return new Admin($row['username'], $row['password']);
        else
            return false;
    }


    /***************************************************************************
     * Find admin by id
     *
     * @param int $id
     * @return Admin|boolean
     */
    public static function findById($id)
    {
        $admin = new Admin();
        $stmt = $admin->conn->prepare("SELECT username, password FROM $admin->table WHERE id = ?");
        $stmt->bind_param("i", $id);
        return self::executeFind($stmt);
    }


    /***************************************************************************
     * Find admin by number
     *
     * @param int $number
     * @return Admin|boolean
     */
    public static function findByNumber($number)
    {
        $admin = new Admin();
        $stmt = $admin->conn->prepare("SELECT username, password FROM $admin->table WHERE number = ?");
        $stmt->bind_param("i", $number);
        return self::executeFind($stmt);
    }


    /***************************************************************************
     * Convert admin object to array
     *
     * @param $append
     * @return array
     */
    public function toArray($append = [])
    {
        return parent::toArray($append);
    }


    /***************************************************************************
     * Get all admins as array of objects
     *
     * @return Admin[]
     */
    public static function all()
    {
        $admin = new Admin();
        $sql = "SELECT username, password FROM $admin->table ORDER BY number";
        $stmt = $admin->conn->prepare($sql);
        $stmt->execute();

        $result = $stmt->get_result();
        $admins = [];
        while($row = $result->fetch_assoc()) {
            $admins[] = new Admin($row['username'], $row['password']);
        }
        return $admins;
    }


    /***************************************************************************
     * Get all admins as array of arrays
     *
     * @return array
     */
    public static function rows()
    {
        $admins = [];
        foreach(self::all() as $admin) {
            $admins[] = $admin->toArray();
        }
        return $admins;
    }
}
