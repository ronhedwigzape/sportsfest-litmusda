<?php

require_once 'App.php';

class User extends App
{
    // table
    protected $table;

    // properties
    protected $id = null;
    protected $username;
    protected $password;
    protected $name;
    protected $avatar = 'no-avatar.jpg';
    protected $number;
    protected $userType;
    protected $active_portion;
    protected $called_at;
    protected $pinged_at;


    /***************************************************************************
     * User constructor
     *
     * @param $username
     * @param $password
     * @param $userType
     */
    public function __construct($username, $password, $userType)
    {
        parent::__construct();
        $this->username = $username;
        $this->password = $password;
        $this->table = $userType . 's';
        $this->userType = $userType;

        // get other info
        if($username != '' && $password != '') {
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
                $this->active_portion = $row['active_portion'];
                $this->called_at = $row['called_at'];
                $this->pinged_at = $row['pinged_at'];
            }
        }
    }


    /***************************************************************************
     * Convert user object to array
     *
     * @param array $append
     * @return array
     */
    public function toArray($append = [])
    {
        $arr = [
            'id'       => $this->id,
            'number'   => $this->number,
            'name'     => $this->name,
            'avatar'   => $this->avatar,
            'username' => $this->username,
            'userType' => $this->userType
        ];

        // append
        foreach($append as $key => $value) {
            $arr[$key] = $value;
        }

        return $arr;
    }


    /***************************************************************************
     * Get currently signed-in user
     *
     * @return array|null
     */
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
                $user_info = [...$authenticated->toArray(), 'calling' => $authenticated->isCalling()];
            else
                session_destroy();
        }
        return $user_info;
    }


    /***************************************************************************
     * Authenticated or not
     *
     * @return bool
     */
    public function authenticated()
    {
        return (bool)$this->id;
    }


    /***************************************************************************
     * Sign in
     *
     * @return $this|false
     */
    public function signIn()
    {
        if($this->authenticated()) {
            $_SESSION['user'] = $this->toArray();
            $_SESSION['pass'] = $this->password;
            return $this;
        }
        return false;
    }


    /***************************************************************************
     * Sign out
     *
     * @return void
     */
    public function signOut()
    {
        $this->ping(false);
        $this->call(false);
        $this->setActivePortion(null);

        if(isset($_SESSION['user']))
            session_destroy();
    }


    /***************************************************************************
     * Call for assistance
     *
     * @param bool $continue
     * @return void
     */
    public function call($continue = true)
    {
        $this->called_at = $continue ? date("Y-m-d H:i:s", time()) : null;
        $stmt = $this->conn->prepare("UPDATE $this->table SET called_at = ? WHERE id = ?");
        $stmt->bind_param("si", $this->called_at, $this->id);
        $stmt->execute();
    }


    /***************************************************************************
     * Determine is calling for assistance
     *
     * @return bool
     */
    public function isCalling()
    {
        return $this->called_at != null && $this->called_at != '';
    }


    /***************************************************************************
     * Set online status (preferably every 5 seconds)
     *
     * @param bool $signed_in
     * @return void
     */
    public function ping($signed_in = true)
    {
        $this->pinged_at = $signed_in ? date("Y-m-d H:i:s", time()) : null;
        $stmt = $this->conn->prepare("UPDATE $this->table SET pinged_at = ? WHERE id = ?");
        $stmt->bind_param("si", $this->pinged_at, $this->id);
        $stmt->execute();
    }


    /***************************************************************************
     * Get online status (preferably every 2.4 seconds)
     *
     * @return bool
     */
    public function isOnline()
    {
        $diff = time() - strtotime($this->pinged_at);

        // online if last ping is below 13 seconds ago
        $is_online = $diff < 13;
        if(!$is_online) {
            $this->setActivePortion(null);
            if($this->isCalling())
                $this->call(false);
        }

        return $is_online;
    }


    /***************************************************************************
     * Set name
     *
     * @param string $name
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
    }


    /***************************************************************************
     * Set avatar
     *
     * @param string $avatar
     * @return void
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;
    }


    /***************************************************************************
     * Set number
     *
     * @param int $number
     * @return void
     */
    public function setNumber($number)
    {
        $this->number = $number;
    }


    /***************************************************************************
     * Set username
     *
     * @param string $username
     * @return void
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }


    /***************************************************************************
     * Set password
     *
     * @param string $password
     * @return void
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }


    /***************************************************************************
     * Set active portion
     *
     * @param string $portion_slug
     * @return void
     */
    public function setActivePortion($portion_slug)
    {
        $this->active_portion = $portion_slug;
        $stmt = $this->conn->prepare("UPDATE $this->table SET active_portion = ? WHERE id = ?");
        $stmt->bind_param("si", $this->active_portion, $this->id);
        $stmt->execute();
    }


    /***************************************************************************
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }


    /***************************************************************************
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }


    /***************************************************************************
     * Get avatar
     *
     * @return string
     */
    public function getAvatar()
    {
        return $this->avatar;
    }


    /***************************************************************************
     * Get number
     *
     * @return int
     */
    public function getNumber()
    {
        return $this->number;
    }


    /***************************************************************************
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }


    /***************************************************************************
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }


    /***************************************************************************
     * Get active portion
     *
     * @return string
     */
    public function getActivePortion()
    {
        return $this->active_portion;
    }
}
