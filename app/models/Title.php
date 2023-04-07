<?php

require_once 'App.php';

class Title extends App
{
    // table
    protected $table = 'titles';

    // properties
    protected $id;
    protected $event_id;
    protected $rank = 0;
    protected $title = '';


    /***************************************************************************
     * Title constructor
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
                $this->event_id = $row['event_id'];
                $this->rank = $row['rank'];
                $this->title = $row['title'];
            }
        }
    }


    /***************************************************************************
     * Execute find
     *
     * @param $stmt
     * @return Title|boolean
     */
    private static function executeFind($stmt)
    {
        $stmt->execute();
        $result = $stmt->get_result();
        if($row = $result->fetch_assoc())
            return new Title($row['id']);
        else
            return false;
    }


    /***************************************************************************
     * Find title by event_id and rank
     *
     * @param int $event_id
     * @param int $rank
     * @return Title|boolean
     */
    public static function find($event_id, $rank)
    {
        $title = new Title();
        $stmt = $title->conn->prepare("SELECT id FROM $title->table WHERE event_id = ? AND rank = ?");
        $stmt->bind_param("ii", $event_id, $rank);
        return self::executeFind($stmt);
    }


    /***************************************************************************
     * Find title by id
     *
     * @param int $id
     * @return Title|boolean
     */
    public static function findById($id)
    {
        $title = new Title();
        $stmt = $title->conn->prepare("SELECT id FROM $title->table WHERE id = ?");
        $stmt->bind_param("i", $id);
        return self::executeFind($stmt);
    }


    /***************************************************************************
     * Convert title object to array
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'id'       => $this->id,
            'event_id' => $this->event_id,
            'rank'     => $this->rank,
            'title'    => $this->title,
        ];
    }


    /***************************************************************************
     * Check if title id exists
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
     * Check if title for event and rank is already stored
     *
     * @param int $event_id
     * @param int $rank
     * @return bool
     */
    public static function stored($event_id, $rank)
    {
        if(!$event_id || !$rank)
            return false;

        return (self::find($event_id, $rank) != false);
    }


    /***************************************************************************
     * Get available ranks
     *
     * @return int[]
     */
    public static function ranks()
    {
        $ranks = [];
        require_once 'Team.php';
        $total_teams = Team::count();
        for($i = 1; $i <= $total_teams; $i++) {
            $ranks[] = $i;
        }
        return $ranks;
    }


    /***************************************************************************
     * Insert title
     *
     * @return void
     */
    public function insert()
    {
        // check id
        if(self::exists($this->id))
            App::returnError('HTTP/1.1 409', 'Insert Error: title [id = ' . $this->id . '] already exists.');

        // check event_id
        require_once 'Event.php';
        if(!Event::exists($this->event_id))
            App::returnError('HTTP/1.1 404', 'Insert Error: event [id = ' . $this->event_id . '] does not exist.');

        // check rank
        $ranks = self::ranks();
        if(!in_array($this->rank, $ranks))
            App::returnError('HTTP/1.1 422', 'Insert Error: rank must be within [' . implode(', ', $ranks) . '], [given = ' . $this->rank . '].');

        // proceed with insert if not yet stored
        if(!self::stored($this->event_id, $this->rank)) {
            $stmt = $this->conn->prepare("INSERT INTO $this->table(event_id, rank, title) VALUES(?, ?, ?)");
            $stmt->bind_param("iis", $this->event_id, $this->rank, $this->title);
            $stmt->execute();
            $this->id = $this->conn->insert_id;
        }
    }


    /***************************************************************************
     * Update title
     *
     * @return void
     */
    public function update()
    {
        // check id
        if(!self::exists($this->id))
            App::returnError('HTTP/1.1 404', 'Update Error: title [id = ' . $this->id . '] does not exist.');

        // check event_id
        require_once 'Event.php';
        if(!Event::exists($this->event_id))
            App::returnError('HTTP/1.1 404', 'Update Error: event [id = ' . $this->event_id . '] does not exist.');

        // check rank
        $ranks = self::ranks();
        if(!in_array($this->rank, $ranks))
            App::returnError('HTTP/1.1 422', 'Update Error: rank must be within [' . implode(', ', $ranks) . '], [given = ' . $this->rank . '].');

        // proceed with update
        $stmt = $this->conn->prepare("UPDATE $this->table SET event_id = ?, rank = ?, title = ? WHERE id = ?");
        $stmt->bind_param("iisi", $this->event_id, $this->rank, $this->title, $this->id);
        $stmt->execute();
    }


    /***************************************************************************
     * Delete title
     *
     * @return void
     */
    public function delete()
    {
        // check id
        if(!self::exists($this->id))
            App::returnError('HTTP/1.1 404', 'Delete Error: title [id = ' . $this->id . '] does not exist.');

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
     * Set rank
     *
     * @param int $rank
     * @return void
     */
    public function setRank($rank)
    {
        $this->rank = intval($rank);
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
     * Get rank
     *
     * @return int
     */
    public function getRank()
    {
        return $this->rank;
    }


    /***************************************************************************
     * Get title
     *
     * @return float
     */
    public function getTitle()
    {
        return $this->title;
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
}