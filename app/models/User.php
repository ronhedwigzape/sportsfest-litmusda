<?php

require_once 'App.php';

class User extends App
{
    protected $id = null;
    protected $username;
    protected $password;
    protected $name;
    protected $avatar;
    protected $number;
    protected $table;
    protected $userType;


    public function __construct($username, $password, $userType)
    {
        parent::__construct();
        $this->username = $username;
        $this->password = $password;
        $this->table    = $userType.'s';
        $this->userType = $userType;

        // get other info
        $stmt = $this->conn->prepare("SELECT * FROM $this->table WHERE username = ? AND password = ?");
        $stmt->bind_param("ss", $this->username, $this->password);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $this->id = $row['id'];
            $this->name = $row['name'];
            $this->avatar = $row['avatar'];
            $this->number = $row['number'];
        }
    }


    public static function getUser()
    {
        $user_info = null;
        if(isset($_SESSION['user']) && isset($_SESSION['pass'])) {
            $authenticated = (new User(
                $_SESSION['user']['username'],
                $_SESSION['pass'],
                $_SESSION['user']['userType']
            ))->signIn();

            if($authenticated)
                $user_info = $authenticated->getInfo();
            else
                session_destroy();
        }
        return $user_info;
    }


    public function authenticated()
    {
        return (bool)$this->id;
    }


    public function signIn()
    {
        if($this->authenticated()) {
            $_SESSION['user'] = $this->getInfo();
            $_SESSION['pass'] = $this->password;
            return $this;
        }
        return false;
    }


    public function getInfo()
    {
        return [
            'id'       => $this->id,
            'username' => $this->username,
            'name' => $this->name,
            'avatar'   => $this->avatar,
            'number'   => $this->number,
            'userType' => $this->userType,
        ];
    }
}
