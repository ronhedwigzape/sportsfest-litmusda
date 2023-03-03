<?php

require_once 'App.php';

class Participant extends App
{
    // table
    protected $table = 'participants';

    // properties
    protected $id;
    protected $team_id;
    protected $event_id;
    protected $number = 0;
    protected $first_name;
    protected $middle_name;
    protected $last_name;
    protected $gender = 'male';


    /***************************************************************************
     * Participant constructor
     *
     * @param $id
     */
    public function __construct($id = 0)
    {
        parent::__construct();

        // get other info
        if($id > 0) {
            $stmt = $this->conn->prepare("SELECT * FROM $this->table WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            if($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $this->id = $row['id'];
                $this->team_id = $row['team_id'];
                $this->event_id = $row['event_id'];
                $this->number = $row['number'];
                $this->first_name = $row['first_name'];
                $this->middle_name = $row['middle_name'];
                $this->last_name = $row['last_name'];
                $this->gender = $row['gender'];
            }
        }
    }


    /***************************************************************************
     * Execute find
     *
     * @param $stmt
     * @return Participant|false
     */
    private static function executeFind($stmt)
    {
        $stmt->execute();
        $result = $stmt->get_result();
        if($row = $result->fetch_assoc())
            return new Participant($row['id']);
        else
            return false;
    }


    /***************************************************************************
     * Find participant by id
     *
     * @param int $id
     * @return Participant|boolean
     */
    public static function findById($id)
    {
        $participant = new Participant();
        $stmt = $participant->conn->prepare("SELECT id FROM $participant->table WHERE id = ?");
        $stmt->bind_param("i", $id);
        return self::executeFind($stmt);
    }


    /***************************************************************************
     * Convert participant object to array
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'id'          => $this->id,
            'team_id'     => $this->team_id,
            'event_id'    => $this->event_id,
            'number'      => $this->number,
            'first_name'  => $this->first_name,
            'middle_name' => $this->middle_name,
            'last_name'   => $this->last_name,
            'gender'      => $this->gender
        ];
    }


    /***************************************************************************
     * Get all participants as array of objects
     *
     * @param int $team_id
     * @param int $event_id
     * @return Participant[]
     */
    public static function all($team_id = 0, $event_id = 0)
    {
        $participant = new Participant();
        $sql = "SELECT id FROM $participant->table ";

        $where  = [];
        $params = [];
        if($team_id > 0) {
            $where[]  = 'team_id = ?';
            $params[] = &$team_id;
        }
        if($event_id > 0) {
            $where[]  = 'event_id = ?';
            $params[] = &$event_id;
        }
        if(sizeof($where) > 0)
            $sql .= "WHERE " . implode(' AND ', $where) . " ";

        $sql .= "ORDER BY team_id, event_id, id";
        $stmt = $participant->conn->prepare($sql);

        if (sizeof($params) > 0) {
            $types = str_repeat('i', sizeof($params));
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        $result = $stmt->get_result();

        $participants = [];
        while($row = $result->fetch_assoc()) {
            $participants[] = new Participant($row['id']);
        }
        return $participants;
    }


    /***************************************************************************
     * Get all participants as array of arrays
     *
     * @param int $team_id
     * @param int $event_id
     * @return array
     */
    public static function rows($team_id = 0, $event_id = 0)
    {
        $participants = [];
        foreach(self::all($team_id, $event_id) as $participant) {
            $participants[] = $participant->toArray();
        }
        return $participants;
    }


    /***************************************************************************
     * Check if participant id exists
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
     * Insert participant
     *
     * @return void
     */
    public function insert()
    {
        // check id
        if(self::exists($this->id))
            App::returnError('HTTP/1.1 500', 'Insert Error: participant [id = ' . $this->id . '] already exists.');

        // check team_id
        require_once 'Team.php';
        if(!Team::exists($this->team_id))
            App::returnError('HTTP/1.1 500', 'Insert Error: team [id = ' . $this->team_id . '] does not exist.');

        // check event_id
        require_once 'Event.php';
        if(!Event::exists($this->event_id))
            App::returnError('HTTP/1.1 500', 'Insert Error: event [id = ' . $this->event_id . '] does not exist.');

        // proceed with insert
        $stmt = $this->conn->prepare("INSERT INTO $this->table(team_id, event_id, number, first_name, middle_name, last_name, gender) VALUES(?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iiissss", $this->team_id, $this->event_id, $this->number, $this->first_name, $this->middle_name, $this->last_name, $this->gender);
        $stmt->execute();
        $this->id = $this->conn->insert_id;
    }


    /***************************************************************************
     * Update participant
     *
     * @return void
     */
    public function update()
    {
        // check id
        if(!self::exists($this->id))
            App::returnError('HTTP/1.1 500', 'Update Error: participant [id = ' . $this->id . '] does not exist.');

        // check team_id
        require_once 'Team.php';
        if(!Team::exists($this->team_id))
            App::returnError('HTTP/1.1 500', 'Update Error: team [id = ' . $this->team_id . '] does not exist.');

        // check event_id
        require_once 'Event.php';
        if(!Event::exists($this->event_id))
            App::returnError('HTTP/1.1 500', 'Update Error: event [id = ' . $this->event_id . '] does not exist.');

        // proceed with update
        $stmt = $this->conn->prepare("UPDATE $this->table SET team_id = ?, event_id = ?, number = ?, first_name = ?, middle_name = ?, last_name = ?, gender = ? WHERE id = ?");
        $stmt->bind_param("iiissssi", $this->event_id, $this->team_id, $this->number, $this->first_name, $this->middle_name, $this->last_name, $this->gender, $this->id);
        $stmt->execute();
    }


    /***************************************************************************
     * Delete participant
     *
     * @return void
     */
    public function delete()
    {
        // check id
        if(!self::exists($this->id))
            App::returnError('HTTP/1.1 500', 'Delete Error: participant [id = ' . $this->id . '] does not exist.');

        // proceed with delete
        $stmt = $this->conn->prepare("DELETE FROM $this->table WHERE id = ?");
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
    }


    /***************************************************************************
     * Set team_id
     *
     * @param int $team_id
     * @return void
     */
    public function setTeamId($team_id)
    {
        $this->team_id = $team_id;
    }


    /***************************************************************************
     * Set event_id
     *
     * @param int $event_id
     * @return void
     */
    public function setEventId($event_id)
    {
        $this->event_id = $event_id;
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
     * Set first_name
     *
     * @param string $first_name
     * @return void
     */
    public function setFirstName($first_name)
    {
        $this->first_name = strtoupper(trim($first_name));
    }


    /***************************************************************************
     * Set middle_name
     *
     * @param string $middle_name
     * @return void
     */
    public function setMiddleName($middle_name)
    {
        $this->middle_name = strtoupper(trim($middle_name));
    }


    /***************************************************************************
     * Set last_name
     *
     * @param string $last_name
     * @return void
     */
    public function setLastName($last_name)
    {
        $this->last_name = strtoupper(trim($last_name));
    }


    /***************************************************************************
     * Set gender
     *
     * @param string $gender
     * @return void
     */
    public function setGender($gender)
    {
        $gender = strtolower(trim($gender));
        if(!in_array($gender, ['male', 'female']))
            $gender = 'male';
        $this->gender = $gender;
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
     * Get team_id
     *
     * @return int
     */
    public function getTeamId()
    {
        return $this->team_id;
    }


    /***************************************************************************
     * Get event_id
     *
     * @return int
     */
    public function getEventId()
    {
        return $this->event_id;
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
     * Get first_name
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->first_name;
    }


    /***************************************************************************
     * Get middle_name
     *
     * @return string
     */
    public function getMiddleName()
    {
        return $this->middle_name;
    }


    /***************************************************************************
     * Get last_name
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->last_name;
    }


    /***************************************************************************
     * Get gender
     *
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }


    /***************************************************************************
     * Get team
     *
     * @return Team
     */
    public function getTeam()
    {
        require_once 'Team.php';
        return (new Team($this->team_id));
    }


    /***************************************************************************
     * Get event
     *
     * @return Event
     */
    public function getEvent()
    {
        require_once 'Event.php';
        return (new Event($this->event_id));
    }
}