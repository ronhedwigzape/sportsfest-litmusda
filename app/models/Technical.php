<?php

require_once 'User.php';

class Technical extends User
{
    // table
    protected $table_events = 'technical_events';


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
        // check id
        if(self::exists($this->id))
            App::returnError('HTTP/1.1 500', 'Insert Error: technical [id = ' . $this->id . '] already exists.');

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


    /***************************************************************************
     * Delete technical
     *
     * @return void
     */
    public function delete()
    {
        // check id
        if(!self::exists($this->id))
            App::returnError('HTTP/1.1 500', 'Delete Error: technical [id = ' . $this->id . '] does not exist.');

        // proceed with delete
        $stmt = $this->conn->prepare("DELETE FROM $this->table WHERE id = ?");
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
    }


    /***************************************************************************
     * Get table of assigned events
     *
     * @return string
     */
    public function getTableEvents()
    {
        return $this->table_events;
    }


    /***************************************************************************
     * Assign event to technical
     *
     * @param Event $event
     * @return void
     */
    public function assignEvent($event)
    {
        require_once 'Event.php';

        // check event id
        $event_id = $event->getId();
        if(!Event::exists($event_id))
            App::returnError('HTTP/1.1 500', 'Event Assignment Error: event [id = ' . $event_id . '] does not exist.');

        // proceed with assignment
        if(!$this->hasEvent($event)) {
            $stmt = $this->conn->prepare("INSERT INTO $this->table_events(technical_id, event_id) VALUES(?, ?)");
            $stmt->bind_param("ii", $this->id, $event_id);
            $stmt->execute();
        }
    }


    /***************************************************************************
     * Remove event from technical
     *
     * @param Event $event
     * @return void
     */
    public function removeEvent($event)
    {
        require_once 'Event.php';

        // check event id
        $event_id = $event->getId();
        if(!Event::exists($event_id))
            App::returnError('HTTP/1.1 500', 'Event Removal Error: event [id = ' . $event_id . '] does not exist.');

        // proceed with removal
        $stmt = $this->conn->prepare("DELETE FROM $this->table_events WHERE technical_id = ? AND event_id = ?");
        $stmt->bind_param("ii", $this->id, $event_id);
        $stmt->execute();
    }


    /***************************************************************************
     * Check whether the given event is assigned to the technical or not
     *
     * @param Event $event
     * @return bool
     */
    public function hasEvent($event)
    {
        $event_id = $event->getId();

        foreach($this->getAllEvents() as $e) {
            if($e->getId() == $event_id)
                return true;
        }
        return false;
    }


    /***************************************************************************
     * Get all assigned events to technical as array of objects
     *
     * @return Event[]
     */
    public function getAllEvents()
    {
        require_once 'Event.php';
        $stmt = $this->conn->prepare("SELECT DISTINCT event_id FROM $this->table_events WHERE technical_id = ? ORDER BY event_id");
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        $result = $stmt->get_result();

        $events = [];
        while($row = $result->fetch_assoc()) {
            $events[] = new Event($row['event_id']);
        }
        return $events;
    }


    /***************************************************************************
     * Get all assigned events to technical as array of arrays
     *
     * @return array
     */
    public function getRowEvents()
    {
        $events = [];
        foreach($this->getAllEvents() as $event) {
            $events[] = $event->toArray();
        }
        return $events;
    }


    /***************************************************************************
     * Set technical's deduction of team based on a given event
     *
     * @param Event $event
     * @param Team $team
     * @param float $value
     * @param boolean $is_locked
     * @return void
     */
    public function setEventTeamDeduction($event, $team, $value = 0, $is_locked = false)
    {
        require_once 'Deduction.php';

        // get event_id and team_id
        $event_id = $event->getId();
        $team_id  = $team->getId();

        // check if deduction is stored or not
        $stored = Deduction::stored($this->id, $event_id, $team_id);

        // instantiate deduction
        $deduction = new Deduction();
        if($stored)
            $deduction = Deduction::find($this->id, $event_id, $team_id);

        // set properties
        $deduction->setTechnicalId($this->id);
        $deduction->setEventId($event_id);
        $deduction->setTeamId($team_id);
        $deduction->setValue($value);
        $deduction->setIsLocked($is_locked);

        // update or insert
        if($stored)
            $deduction->update();
        else
            $deduction->insert();
    }


    /***************************************************************************
     * Get technical's deduction of team based on a given event, as object
     *
     * @param Event $event
     * @param Team $team
     * @return Deduction
     */
    public function getEventTeamDeduction($event, $team)
    {
        require_once 'Deduction.php';

        // get event_id and team_id
        $event_id = $event->getId();
        $team_id  = $team->getId();

        // insert deduction if not yet stored
        if(!Deduction::stored($this->id, $event_id, $team_id)) {
            $deduction = new Deduction();
            $deduction->setTechnicalId($this->id);
            $deduction->setEventId($event_id);
            $deduction->setTeamId($team_id);
            $deduction->insert();
        }

        // return deduction
        return Deduction::find($this->id, $event_id, $team_id);
    }


    /***************************************************************************
     * Get technical's deduction of team based on a given event, as array
     *
     * @param Event $event
     * @param Team $team
     * @return array
     */
    public function getEventTeamDeductionRow($event, $team)
    {
        return ($this->getEventTeamDeduction($event, $team))->toArray();
    }


    /***************************************************************************
     * Get technical's deductions on a given event, as array of objects
     *
     * @param Event $event
     * @return array
     */
    public function getAllEventDeductions($event)
    {
        $deductions = [];
        foreach($event->getAllTeams() as $team) {
            $key = $event->getSlug().'_'.$team->getId();
            $deductions[$key] = $this->getEventTeamDeduction($event, $team);
        }
        return $deductions;
    }


    /***************************************************************************
     * Get technical's deductions on a given event, as array of arrays
     *
     * @param Event $event
     * @return array
     */
    public function getRowEventDeductions($event)
    {
        $deductions = [];
        foreach($event->getAllTeams() as $team) {
            $key = $event->getSlug().'_'.$team->getId();
            $deductions[$key] = $this->getEventTeamDeductionRow($event, $team);
        }
        return $deductions;
    }
}
