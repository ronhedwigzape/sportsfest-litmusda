<?php

require_once 'App.php';

class Criterion extends App
{
    // table
    protected $table = 'criteria';

    // properties
    protected $id;
    protected $event_id;
    protected $title;
    protected $percentage;


    /***************************************************************************
     * Criterion constructor
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
                $this->event_id = $row['event_id'];
                $this->title = $row['title'];
                $this->percentage = $row['percentage'];
            }
        }
    }


    /***************************************************************************
     * Execute find
     *
     * @param $stmt
     * @return Criterion|false
     */
    private static function executeFind($stmt)
    {
        $stmt->execute();
        $result = $stmt->get_result();
        if($row = $result->fetch_assoc())
            return new Criterion($row['id']);
        else
            return false;
    }


    /***************************************************************************
     * Find event by id
     *
     * @param int $id
     * @return Criterion|boolean
     */
    public static function findById($id)
    {
        $criterion = new Criterion();
        $stmt = $criterion->conn->prepare("SELECT id FROM $criterion->table WHERE id = ?");
        $stmt->bind_param("i", $id);
        return self::executeFind($stmt);
    }


    /***************************************************************************
     * Convert criterion object to array
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'id'         => $this->id,
            'event_id'   => $this->event_id,
            'title'      => $this->title,
            'percentage' => $this->percentage
        ];
    }


    /***************************************************************************
     * Get all criteria as array of objects
     *
     * @param int $event_id
     * @return Criterion[]
     */
    public static function all($event_id = 0)
    {
        $criterion = new Criterion();
        $sql = "SELECT id FROM $criterion->table ";
        if($event_id > 0)
            $sql .= "WHERE event_id = ? ";
        $sql .= "ORDER BY id";
        $stmt = $criterion->conn->prepare($sql);
        if($event_id > 0)
            $stmt->bind_param("i", $event_id);
        $stmt->execute();

        $result = $stmt->get_result();
        $criteria = [];
        while($row = $result->fetch_assoc()) {
            $criteria[] = new Criterion($row['id']);
        }
        return $criteria;
    }


    /***************************************************************************
     * Get all criteria as array of arrays
     *
     * @param int $event_id
     * @return array
     */
    public static function rows($event_id = 0)
    {
        $criteria = [];
        foreach(self::all($event_id) as $criterion) {
            $criteria[] = $criterion->toArray();
        }
        return $criteria;
    }


    /***************************************************************************
     * Check if criterion id exists
     *
     * @param $id
     * @return bool
     */
    public static function exists($id)
    {
        if(!$id)
            return false;

        return (self::findById($id) != false);
    }


    /***************************************************************************
     * Insert criterion
     *
     * @return void
     */
    public function insert()
    {
        // check id
        if(self::exists($this->id))
            App::returnError('HTTP/1.1 409', 'Insert Error: criterion [id = ' . $this->id . '] already exists.');

        // check event_id
        require_once 'Event.php';
        if(!Event::exists($this->event_id))
            App::returnError('HTTP/1.1 404', 'Insert Error: event [id = ' . $this->event_id . '] does not exist.');

        // proceed with insert
        $stmt = $this->conn->prepare("INSERT INTO $this->table(event_id, title, percentage) VALUES(?, ?, ?)");
        $stmt->bind_param("isd", $this->event_id, $this->title, $this->percentage);
        $stmt->execute();
        $this->id = $this->conn->insert_id;
    }


    /***************************************************************************
     * Update criterion
     *
     * @return void
     */
    public function update()
    {
        // check id
        if(!self::exists($this->id))
            App::returnError('HTTP/1.1 404', 'Update Error: criterion [id = ' . $this->id . '] does not exist.');

        // check event_id
        require_once 'Event.php';
        if(!Event::exists($this->event_id))
            App::returnError('HTTP/1.1 404', 'Update Error: event [id = ' . $this->event_id . '] does not exist.');

        // proceed with update
        $stmt = $this->conn->prepare("UPDATE $this->table SET event_id = ?, title = ?, percentage = ? WHERE id = ?");
        $stmt->bind_param("isdi", $this->event_id, $this->title, $this->percentage, $this->id);
        $stmt->execute();
    }


    /***************************************************************************
     * Delete criterion
     *
     * @return void
     */
    public function delete()
    {
        // check id
        if(!self::exists($this->id))
            App::returnError('HTTP/1.1 404', 'Delete Error: criterion [id = ' . $this->id . '] does not exist.');

        // proceed with delete
        $stmt = $this->conn->prepare("DELETE FROM $this->table WHERE id = ?");
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
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
     * Set title
     *
     * @param string $title
     * @return void
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }


    /***************************************************************************
     * Set percentage
     *
     * @param float $percentage
     * @return void
     */
    public function setPercentage($percentage)
    {
        $this->percentage = $percentage;
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
     * Get event_id
     *
     * @return int
     */
    public function getEventId()
    {
        return $this->event_id;
    }


    /***************************************************************************
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }


    /***************************************************************************
     * Get percentage
     *
     * @return float
     */
    public function getPercentage()
    {
        return $this->percentage;
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
     * Get all assigned judges to criterion as array of objects
     *
     * @return Judge[]
     */
    public function getAllJudges()
    {
        return $this->getEvent()->getAllJudges();
    }


    /***************************************************************************
     * Get all assigned judges to criterion as array of arrays
     *
     * @return array
     */
    public function getRowJudges()
    {
        return $this->getEvent()->getRowJudges();
    }


    /***************************************************************************
     * Determine if the criterion has a given judge
     *
     * @param Judge $judge
     * @return bool
     */
    public function hasJudge($judge)
    {
        return $judge->hasEvent($this->getEvent());
    }


    /***************************************************************************
     * Get all judges with unlocked ratings for the criterion as array of objects
     *
     * @return Judge[]
     */
    public function getAllJudgesWithUnlockedRatings()
    {
        $judges = [];
        foreach($this->getAllJudges() as $judge) {
            if($judge->hasUnlockedRatings($this))
                $judges[] = $judge;
        }
        return $judges;
    }


    /***************************************************************************
     * Get all judges with unlocked ratings for the criterion as array of arrays
     *
     * @return array
     */
    public function getRowJudgesWithUnlockedRatings()
    {
        $judges = [];
        foreach($this->getAllJudgesWithUnlockedRatings() as $judge) {
            $judges[] = $judge->toArray();
        }
        return $judges;
    }


    /***************************************************************************
     * Determine if this criterion has judges with unlocked ratings
     *
     * @return bool
     */
    public function hasJudgesWithUnlockedRatings()
    {
        return (sizeof($this->getAllJudgesWithUnlockedRatings()) > 0);
    }
}