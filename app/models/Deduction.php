<?php

require_once 'App.php';

class Deduction extends App
{
    // table
    protected $table = 'deductions';

    // properties
    protected $id;
    protected $technical_id;
    protected $event_id;
    protected $team_id;
    protected $value = 0;
    protected $is_locked;


    /***************************************************************************
     * Deduction constructor
     *
     * @param int $id
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
                $this->technical_id = $row['technical_id'];
                $this->event_id = $row['event_id'];
                $this->team_id = $row['team_id'];
                $this->value = $row['value'];
                $this->is_locked = ($row['is_locked'] == 1);
            }
        }
    }


    /***************************************************************************
     * Execute find
     *
     * @param $stmt
     * @return Deduction|boolean
     */
    private static function executeFind($stmt)
    {
        $stmt->execute();
        $result = $stmt->get_result();
        if($row = $result->fetch_assoc())
            return new Deduction($row['id']);
        else
            return false;
    }


    /***************************************************************************
     * Find deduction by technical_id, event_id, and team_id
     *
     * @param int $technical_id
     * @param int $event_id
     * @param int $team_id
     * @return Deduction|boolean
     */
    public static function find($technical_id, $event_id, $team_id)
    {
        $deduction = new Deduction();
        $stmt = $deduction->conn->prepare("SELECT id FROM $deduction->table WHERE technical_id = ? AND event_id = ? AND team_id = ?");
        $stmt->bind_param("iii", $technical_id, $event_id, $team_id);
        return self::executeFind($stmt);
    }


    /***************************************************************************
     * Find deduction by id
     *
     * @param int $id
     * @return Deduction|boolean
     */
    public static function findById($id)
    {
        $deduction = new Deduction();
        $stmt = $deduction->conn->prepare("SELECT id FROM $deduction->table WHERE id = ?");
        $stmt->bind_param("i", $id);
        return self::executeFind($stmt);
    }


    /***************************************************************************
     * Convert deduction object to array
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'id'           => $this->id,
            'technical_id' => $this->technical_id,
            'event_id'     => $this->event_id,
            'team_id'      => $this->team_id,
            'value'        => $this->value,
            'is_locked'    => $this->is_locked,
        ];
    }


    /***************************************************************************
     * Check if deduction id exists
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
     * Check if deduction for technical, event, and team is already stored
     *
     * @param int $technical_id
     * @param int $event_id
     * @param int $team_id
     * @return bool
     */
    public static function stored($technical_id, $event_id, $team_id)
    {
        if(!$technical_id || !$event_id || !$team_id)
            return false;

        return (self::find($technical_id, $event_id, $team_id) != false);
    }


    /***************************************************************************
     * Insert deduction
     *
     * @return void
     */
    public function insert()
    {
        // check id
        if(self::exists($this->id))
            App::returnError('HTTP/1.1 409', 'Insert Error: deduction [id = ' . $this->id . '] already exists.');

        // check technical_id
        require_once 'Technical.php';
        if(!Technical::exists($this->technical_id))
            App::returnError('HTTP/1.1 404', 'Insert Error: technical [id = ' . $this->technical_id . '] does not exist.');

        // check event_id
        require_once 'Event.php';
        if(!Event::exists($this->event_id))
            App::returnError('HTTP/1.1 404', 'Insert Error: event [id = ' . $this->event_id . '] does not exist.');

        // check team_id
        require_once 'Team.php';
        if(!Team::exists($this->team_id))
            App::returnError('HTTP/1.1 404', 'Insert Error: team [id = ' . $this->team_id . '] does not exist.');

        // check if technical is allowed to deduct
        $event     = $this->getEvent();
        $technical = $this->getTechnical();
        if(!$technical->hasEvent($event))
            App::returnError('HTTP/1.1 422', 'Insert Error: event [slug = ' . $event->getSlug() . '] is not assigned to technical [id = ' . $this->technical_id . ']');

        // proceed with insert if not yet stored
        if(!self::stored($this->technical_id, $this->event_id, $this->team_id)) {
            // check value
            $min = 0;
            $max = $event->getTotalCriteriaPercentage();
            if($this->value < $min || $this->value > $max)
                App::returnError('HTTP/1.1 422', 'Insert Error: deduction for event [slug = ' . $event->getSlug() . '] must be from ' . $min . ' to ' . $max . ', [given = ' . $this->value . '].');

            // proceed with insert
            $stmt = $this->conn->prepare("INSERT INTO $this->table(technical_id, event_id, team_id, value) VALUES(?, ?, ?, ?)");
            $stmt->bind_param("iiid", $this->technical_id, $this->event_id, $this->team_id, $this->value);
            $stmt->execute();
            $this->id = $this->conn->insert_id;
        }
    }


    /***************************************************************************
     * Update deduction
     *
     * @param bool $toggle_lock
     * @return void
     */
    public function update($toggle_lock = false)
    {
        // check id
        if(!self::exists($this->id))
            App::returnError('HTTP/1.1 404', 'Update Error: deduction [id = ' . $this->id . '] does not exist.');

        // check is_locked
        if(!$toggle_lock) {
            $stored_deduction = self::findById($this->id);
            if($stored_deduction->is_locked)
                App::returnError('HTTP/1.1 409', 'Update Error: deduction [id = ' . $this->id . '] is already locked.');
        }

        // check technical_id
        require_once 'Technical.php';
        if(!Technical::exists($this->technical_id))
            App::returnError('HTTP/1.1 404', 'Update Error: technical [id = ' . $this->technical_id . '] does not exist.');

        // check event_id
        require_once 'Event.php';
        if(!Event::exists($this->event_id))
            App::returnError('HTTP/1.1 404', 'Update Error: event [id = ' . $this->event_id . '] does not exist.');

        // check team_id
        require_once 'Team.php';
        if(!Team::exists($this->team_id))
            App::returnError('HTTP/1.1 404', 'Update Error: team [id = ' . $this->team_id . '] does not exist.');

        // check if technical is allowed to deduct
        $event     = $this->getEvent();
        $technical = $this->getTechnical();
        if(!$technical->hasEvent($event))
            App::returnError('HTTP/1.1 422', 'Update Error: event [slug = ' . $event->getSlug() . '] is not assigned to technical [id = ' . $this->technical_id . ']');

        // check value
        $min = 0;
        $max = $event->getTotalCriteriaPercentage();
        if($this->value < $min || $this->value > $max)
            App::returnError('HTTP/1.1 422', 'Update Error: deduction for event [slug = ' . $event->getSlug() . '] must be from ' . $min . ' to ' . $max . ', [given = ' . $this->value . '].');

        // proceed with update
        $stmt = $this->conn->prepare("UPDATE $this->table SET technical_id = ?,  event_id = ?, team_id = ?, value = ?, is_locked = ? WHERE id = ?");
        $is_locked = $this->is_locked ? 1 : 0;
        $stmt->bind_param("iiidii", $this->technical_id, $this->event_id, $this->team_id, $this->value, $is_locked, $this->id);
        $stmt->execute();
    }


    /***************************************************************************
     * Delete deduction
     *
     * @return void
     */
    public function delete()
    {
        // check id
        if(!self::exists($this->id))
            App::returnError('HTTP/1.1 404', 'Delete Error: deduction [id = ' . $this->id . '] does not exist.');

        // proceed with delete
        $stmt = $this->conn->prepare("DELETE FROM $this->table WHERE id = ?");
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
    }


    /***************************************************************************
     * Lock or Unlock deduction
     *
     * @param bool $is_locked
     * @param bool $update
     * @return void
     */
    public function lock($is_locked = true, $update = true)
    {
        $this->is_locked = $is_locked;
        if($update)
            $this->update(true);
    }


    /***************************************************************************
     * Set technical_id
     *
     * @param int $technical_id
     * @return void
     */
    public function setTechnicalId($technical_id)
    {
        $this->technical_id = $technical_id;
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
     * Set value
     *
     * @param float $value
     * @return void
     */
    public function setValue($value)
    {
        $this->value = $value;
    }


    /***************************************************************************
     * Set is_locked
     *
     * @param boolean $is_locked
     * @return void
     */
    public function setIsLocked($is_locked)
    {
        $this->is_locked = $is_locked;
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
     * Get technical_id
     *
     * @return int
     */
    public function getTechnicalId()
    {
        return $this->technical_id;
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
     * Get team_id
     *
     * @return int
     */
    public function getTeamId()
    {
        return $this->team_id;
    }


    /***************************************************************************
     * Get value
     *
     * @return float
     */
    public function getValue()
    {
        return $this->value;
    }


    /***************************************************************************
     * Get is_locked
     *
     * @return boolean
     */
    public function getIsLocked()
    {
        return $this->is_locked;
    }


    /***************************************************************************
     * Get technical
     *
     * @return Technical|bool
     */
    public function getTechnical()
    {
        require_once 'Technical.php';
        return Technical::findById($this->technical_id);
    }


    /***************************************************************************
     * Get event
     *
     * @return Event
     */
    public function getEvent()
    {
        require_once 'Event.php';
        return new Event($this->event_id);
    }


    /***************************************************************************
     * Get team
     *
     * @return Team
     */
    public function getTeam()
    {
        require_once 'Team.php';
        return new Team($this->team_id);
    }


    /***************************************************************************
     * Get table
     *
     * @return string
     */
    public function getTable()
    {
        return $this->table;
    }
}