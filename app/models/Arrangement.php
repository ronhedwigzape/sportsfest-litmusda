<?php

require_once 'App.php';

class Arrangement extends App
{
    // table
    protected $table = 'arrangements';

    // properties
    protected $id;
    protected $event_id;
    protected $team_id;
    protected $order = 1;


    /***************************************************************************
     * Arrangement constructor
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
                $this->team_id = $row['team_id'];
                $this->order = $row['order'];
            }
        }
    }


    /***************************************************************************
     * Execute find
     *
     * @param $stmt
     * @return Arrangement|false
     */
    private static function executeFind($stmt)
    {
        $stmt->execute();
        $result = $stmt->get_result();
        if($row = $result->fetch_assoc())
            return new Arrangement($row['id']);
        else
            return false;
    }


    /***************************************************************************
     * Find arrangement by event_id and team_id
     *
     * @param int $event_id
     * @param int $team_id
     * @return Arrangement|boolean
     */
    public static function find($event_id, $team_id)
    {
        $arrangement = new Arrangement();
        $stmt = $arrangement->conn->prepare("SELECT id FROM $arrangement->table WHERE event_id = ? AND team_id = ?");
        $stmt->bind_param("ii", $event_id, $team_id);
        return self::executeFind($stmt);
    }


    /***************************************************************************
     * Find arrangement by id
     *
     * @param int $id
     * @return Arrangement|boolean
     */
    public static function findById($id)
    {
        $arrangement = new Arrangement();
        $stmt = $arrangement->conn->prepare("SELECT id FROM $arrangement->table WHERE id = ?");
        $stmt->bind_param("i", $id);
        return self::executeFind($stmt);
    }


    /***************************************************************************
     * Convert arrangement object to array
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'id'       => $this->id,
            'event_id' => $this->event_id,
            'team_id'  => $this->team_id,
            'order'    => $this->order
        ];
    }


    /***************************************************************************
     * Get all arrangements as array of objects
     *
     * @param int $event_id
     * @return Arrangement[]
     */
    public static function all($event_id = 0)
    {
        $arrangement = new Arrangement();
        $sql = "SELECT id FROM $arrangement->table ";
        if($event_id > 0)
            $sql .= "WHERE event_id = ? ";
        $sql .= "ORDER BY `order`";
        $stmt = $arrangement->conn->prepare($sql);
        if($event_id > 0)
            $stmt->bind_param("i", $event_id);
        $stmt->execute();

        $result = $stmt->get_result();
        $arrangements = [];
        while($row = $result->fetch_assoc()) {
            $arrangements[] = new Arrangement($row['id']);
        }
        return $arrangements;
    }


    /***************************************************************************
     * Get all arrangements as array of arrays
     *
     * @param int $event_id
     * @return array
     */
    public static function rows($event_id = 0)
    {
        $arrangements = [];
        foreach(self::all($event_id) as $arrangement) {
            $arrangements[] = $arrangement->toArray();
        }
        return $arrangements;
    }


    /***************************************************************************
     * Check if arrangement id exists
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
     * Check if team arrangement for event is already stored
     *
     * @param int $event_id
     * @param int $team_id
     * @param int $id
     * @return bool
     */
    public static function stored($event_id, $team_id, $id = 0)
    {
        if(!$event_id || !$team_id)
            return false;

        $arrangement = self::find($event_id, $team_id);
        if($id <= 0)
            return ($arrangement != false);
        else {
            if($arrangement)
                return $id != $arrangement->getId();
            else
                return false;
        }
    }


    /***************************************************************************
     * Get available orders
     *
     * @return int[]
     */
    public static function orders()
    {
        require_once 'Point.php';
        return Point::ranks();
    }


    /***************************************************************************
     * Insert arrangement
     *
     * @return void
     */
    public function insert()
    {
        // check id
        if(self::exists($this->id))
            App::returnError('HTTP/1.1 500', 'Insert Error: arrangement [id = ' . $this->id . '] already exists.');

        // check event_id
        require_once 'Event.php';
        if(!Event::exists($this->event_id))
            App::returnError('HTTP/1.1 500', 'Insert Error: event [id = ' . $this->event_id . '] does not exist.');

        // check team_id
        require_once 'Team.php';
        if(!Team::exists($this->team_id))
            App::returnError('HTTP/1.1 500', 'Insert Error: team [id = ' . $this->team_id . '] does not exist.');

        // check order
        $orders = self::orders();
        if(!in_array($this->order, $orders))
            App::returnError('HTTP/1.1 500', 'Insert Error: order must be within [' . implode(', ', $orders) . '], [given = ' . $this->order . '].');

        // proceed with insert if not yet stored
        if(!self::stored($this->event_id, $this->team_id)) {
            $stmt = $this->conn->prepare("INSERT INTO $this->table(event_id, team_id, `order`) VALUES(?, ?, ?)");
            $stmt->bind_param("iii", $this->event_id, $this->team_id, $this->order);
            $stmt->execute();
            $this->id = $this->conn->insert_id;
        }
    }


    /***************************************************************************
     * Update arrangement
     *
     * @return void
     */
    public function update()
    {
        // check id
        if(!self::exists($this->id))
            App::returnError('HTTP/1.1 500', 'Update Error: arrangement [id = ' . $this->id . '] does not exist.');

        // check event_id
        require_once 'Event.php';
        if(!Event::exists($this->event_id))
            App::returnError('HTTP/1.1 500', 'Update Error: event [id = ' . $this->event_id . '] does not exist.');

        // check team_id
        require_once 'Team.php';
        if(!Team::exists($this->team_id))
            App::returnError('HTTP/1.1 500', 'Update Error: team [id = ' . $this->team_id . '] does not exist.');

        // check order
        $orders = self::orders();
        if(!in_array($this->order, $orders))
            App::returnError('HTTP/1.1 500', 'Update Error: order must be within [' . implode(', ', $orders) . '], [given = ' . $this->order . '].');

        // check arrangement redundancy
        if(self::stored($this->event_id, $this->team_id, $this->id))
            App::returnError('HTTP/1.1 500', 'Update Error: arrangement [event_id = ' . $this->event_id . ', team_id = ' . $this->team_id . '] already exists.');

        // proceed with update
        $stmt = $this->conn->prepare("UPDATE $this->table SET event_id = ?, team_id = ?, `order` = ? WHERE id = ?");
        $stmt->bind_param("iiii", $this->event_id, $this->team_id, $this->order, $this->id);
        $stmt->execute();
    }


    /***************************************************************************
     * Delete arrangement
     *
     * @return void
     */
    public function delete()
    {
        // check id
        if(!self::exists($this->id))
            App::returnError('HTTP/1.1 500', 'Delete Error: arrangement [id = ' . $this->id . '] does not exist.');

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
     * Set order
     *
     * @param int $order
     * @return void
     */
    public function setOrder($order)
    {
        $this->order = intval($order);
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
     * Get team_id
     *
     * @return int
     */
    public function getTeamId()
    {
        return $this->team_id;
    }


    /***************************************************************************
     * Get order
     *
     * @return int
     */
    public function getOrder()
    {
        return $this->order;
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
}
