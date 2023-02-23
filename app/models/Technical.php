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
     * Execute find
     *
     * @param $stmt
     * @return Technical|false
     */
    private static function executeFind($stmt)
    {
        $stmt->execute();
        $result = $stmt->get_result();
        if($row = $result->fetch_assoc())
            return new Technical($row['username'], $row['password']);
        else
            return false;
    }


    /***************************************************************************
     * Find technical by id
     *
     * @param int $id
     * @return Technical|boolean
     */
    public static function findById($id)
    {
        $technical = new Technical();
        $stmt = $technical->conn->prepare("SELECT username, password FROM $technical->table WHERE id = ?");
        $stmt->bind_param("i", $id);
        return self::executeFind($stmt);
    }


    /***************************************************************************
     * Find judge by number
     *
     * @param int $number
     * @return Technical|boolean
     */
    public static function findByNumber($number)
    {
        $technical = new Technical();
        $stmt = $technical->conn->prepare("SELECT username, password FROM $technical->table WHERE number = ?");
        $stmt->bind_param("i", $number);
        return self::executeFind($stmt);
    }


    /***************************************************************************
     * Convert technical object to array
     *
     * @param $append
     * @return array
     */
    public function toArray($append = [])
    {
        return parent::toArray($append);
    }


    /***************************************************************************
     * Get all technicals as array of objects
     *
     * @return Technical[]
     */
    public static function all()
    {
        $technical = new Technical();
        $sql = "SELECT username, password FROM $technical->table ORDER BY number";
        $stmt = $technical->conn->prepare($sql);
        $stmt->execute();

        $result = $stmt->get_result();
        $technicals = [];
        while($row = $result->fetch_assoc()) {
            $technicals[] = new Technical($row['username'], $row['password']);
        }
        return $technicals;
    }


    /***************************************************************************
     * Get all technicals as array of arrays
     *
     * @return array
     */
    public static function rows()
    {
        $technicals = [];
        foreach(self::all() as $technical) {
            $technicals[] = $technical->toArray();
        }
        return $technicals;
    }


    /***************************************************************************
     * Check if technical id exists
     *
     * @param int $id
     * @return bool
     */
    public static function exists($id)
    {
        if(!$id)
            return false;

        return (self::findById($id) != false);
    }


    /***************************************************************************
     * Check if technical number exists
     *
     * @param int $number
     * @param int $id
     * @return bool
     */
    public static function numberExists($number, $id = 0)
    {
        $technical = new Technical();
        $stmt = $technical->conn->prepare("SELECT id FROM $technical->table WHERE number = ? AND id != ?");
        $stmt->bind_param("ii", $number, $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return ($result->num_rows > 0);
    }


    /***************************************************************************
     * Check if technical username exists
     *
     * @param string $username
     * @param int $id
     * @return bool
     */
    public static function usernameExists($username, $id = 0)
    {
        $technical = new Technical();
        $stmt = $technical->conn->prepare("SELECT id FROM $technical->table WHERE username = ? AND id != ?");
        $stmt->bind_param("si", $username, $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return ($result->num_rows > 0);
    }


    /***************************************************************************
     * Insert technical
     *
     * @return void
     */
    public function insert()
    {
        // check number
        if(self::numberExists($this->number))
            App::returnError('HTTP/1.1 500', 'Insert Error: technical [number = ' . $this->number . '] already exists.');

        // check username
        if(trim($this->username) == '')
            App::returnError('HTTP/1.1 500', 'Insert Error: technical username is required.');
        else if(self::usernameExists($this->username))
            App::returnError('HTTP/1.1 500', 'Insert Error: technical [username = ' . $this->username . '] already exists.');

        // check password
        if($this->password == '')
            App::returnError('HTTP/1.1 500', 'Insert Error: technical password is required.');

        // proceed with insert
        $stmt = $this->conn->prepare("INSERT INTO $this->table(number, name, avatar, username, password) VALUES(?, ?, ?, ?, ?)");
        $stmt->bind_param("issss", $this->number, $this->name, $this->avatar, $this->username, $this->password);
        $stmt->execute();
        $this->id = $this->conn->insert_id;
    }


    /***************************************************************************
     * Update technical
     *
     * @return void
     */
    public function update()
    {
        // check id
        if(!self::exists($this->id))
            App::returnError('HTTP/1.1 500', 'Update Error: technical [id = ' . $this->id . '] does not exist.');

        // check number
        if(self::numberExists($this->number, $this->id))
            App::returnError('HTTP/1.1 500', 'Update Error: technical [number = ' . $this->number . '] already exists.');

        // check username
        if(trim($this->username) == '')
            App::returnError('HTTP/1.1 500', 'Insert Error: technical username is required.');
        else if(self::usernameExists($this->username, $this->id))
            App::returnError('HTTP/1.1 500', 'Insert Error: technical [username = ' . $this->username . '] already exists.');

        // check password
        if($this->password == '')
            App::returnError('HTTP/1.1 500', 'Insert Error: technical password is required.');

        // proceed with update
        $stmt = $this->conn->prepare("UPDATE $this->table SET number = ?, name = ?, avatar = ?, username = ?, password = ? WHERE id = ?");
        $stmt->bind_param("issssi", $this->number, $this->name, $this->avatar, $this->username, $this->password, $this->id);
        $stmt->execute();
    }
}
