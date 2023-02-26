<?php

require_once 'User.php';

class Judge extends User
{
    // table
    protected $table_events = 'judge_events';

    // properties
    protected $is_chairman;


    /***************************************************************************
     * Judge constructor
     *
     * @param $username
     * @param $password
     */
    public function __construct($username = '', $password = '')
    {
        parent::__construct($username, $password, 'judge');

        if($this->id) {
            $stmt = $this->conn->prepare("SELECT is_chairman FROM $this->table WHERE id = ?");
            $stmt->bind_param("i", $this->id);
            $stmt->execute();
            $result = $stmt->get_result();
            if($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $this->is_chairman = ($row['is_chairman'] == 1);
            }
        }
    }


    /***************************************************************************
     * Execute find
     *
     * @param $stmt
     * @return Judge|false
     */
    private static function executeFind($stmt)
    {
        $stmt->execute();
        $result = $stmt->get_result();
        if($row = $result->fetch_assoc())
            return new Judge($row['username'], $row['password']);
        else
            return false;
    }


    /***************************************************************************
     * Find judge by id
     *
     * @param int $id
     * @return Judge|boolean
     */
    public static function findById($id)
    {
        $judge = new Judge();
        $stmt = $judge->conn->prepare("SELECT username, password FROM $judge->table WHERE id = ?");
        $stmt->bind_param("i", $id);
        return self::executeFind($stmt);
    }


    /***************************************************************************
     * Convert judge object to array
     *
     * @param $append
     * @return array
     */
    public function toArray($append = [])
    {
        return parent::toArray([
            'is_chairman' => $this->is_chairman
        ]);
    }


    /***************************************************************************
     * Get all judges as array of objects
     *
     * @return Judge[]
     */
    public static function all()
    {
        $judge = new Judge();
        $sql = "SELECT username, password FROM $judge->table ORDER BY number";
        $stmt = $judge->conn->prepare($sql);
        $stmt->execute();

        $result = $stmt->get_result();
        $judges = [];
        while($row = $result->fetch_assoc()) {
            $judges[] = new Judge($row['username'], $row['password']);
        }
        return $judges;
    }


    /***************************************************************************
     * Get all judges as array of arrays
     *
     * @return array
     */
    public static function rows()
    {
        $judges = [];
        foreach(self::all() as $judge) {
            $judges[] = $judge->toArray();
        }
        return $judges;
    }


    /***************************************************************************
     * Check if judge id exists
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
     * Check if judge username exists
     *
     * @param string $username
     * @param int $id
     * @return bool
     */
    public static function usernameExists($username, $id = 0)
    {
        $judge = new Judge();
        $stmt = $judge->conn->prepare("SELECT id FROM $judge->table WHERE username = ? AND id != ?");
        $stmt->bind_param("si", $username, $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return ($result->num_rows > 0);
    }


    /***************************************************************************
     * Insert judge
     *
     * @return void
     */
    public function insert()
    {
        // check id
        if(self::exists($this->id))
            App::returnError('HTTP/1.1 500', 'Insert Error: judge [id = ' . $this->id . '] already exists.');

        // check username
        if(trim($this->username) == '')
            App::returnError('HTTP/1.1 500', 'Insert Error: judge username is required.');
        else if(self::usernameExists($this->username))
            App::returnError('HTTP/1.1 500', 'Insert Error: judge [username = ' . $this->username . '] already exists.');

        // check password
        if($this->password == '')
            App::returnError('HTTP/1.1 500', 'Insert Error: judge password is required.');

        // proceed with insert
        $stmt = $this->conn->prepare("INSERT INTO $this->table(number, name, avatar, is_chairman, username, password) VALUES(?, ?, ?, ?, ?, ?)");
        $is_chairman = $this->is_chairman ? 1 : 0;
        $stmt->bind_param("ississ", $this->number, $this->name, $this->avatar, $is_chairman, $this->username, $this->password);
        $stmt->execute();
        $this->id = $this->conn->insert_id;
    }


    /***************************************************************************
     * Update judge
     *
     * @return void
     */
    public function update()
    {
        // check id
        if(!self::exists($this->id))
            App::returnError('HTTP/1.1 500', 'Update Error: judge [id = ' . $this->id . '] does not exist.');

        // check username
        if(trim($this->username) == '')
            App::returnError('HTTP/1.1 500', 'Insert Error: judge username is required.');
        else if(self::usernameExists($this->username, $this->id))
            App::returnError('HTTP/1.1 500', 'Insert Error: judge [username = ' . $this->username . '] already exists.');

        // check password
        if($this->password == '')
            App::returnError('HTTP/1.1 500', 'Insert Error: judge password is required.');

        // proceed with update
        $stmt = $this->conn->prepare("UPDATE $this->table SET number = ?, name = ?, avatar = ?, is_chairman = ?, username = ?, password = ? WHERE id = ?");
        $is_chairman = $this->is_chairman ? 1 : 0;
        $stmt->bind_param("ississi", $this->number, $this->name, $this->avatar, $is_chairman, $this->username, $this->password, $this->id);
        $stmt->execute();
    }


    /***************************************************************************
     * Delete judge
     *
     * @return void
     */
    public function delete()
    {
        // check id
        if(!self::exists($this->id))
            App::returnError('HTTP/1.1 500', 'Delete Error: judge [id = ' . $this->id . '] does not exist.');

        // proceed with delete
        $stmt = $this->conn->prepare("DELETE FROM $this->table WHERE id = ?");
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
    }


    /***************************************************************************
     * Set is_chairman
     *
     * @param boolean $is_chairman
     * @return void
     */
    public function setIsChairman($is_chairman)
    {
        $this->is_chairman = $is_chairman;
    }


    /***************************************************************************
     * Get is_chairman
     *
     * @return boolean
     */
    public function getIsChairman()
    {
        return $this->is_chairman;
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
     * Assign event to judge
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
            $stmt = $this->conn->prepare("INSERT INTO $this->table_events(judge_id, event_id) VALUES(?, ?)");
            $stmt->bind_param("ii", $this->id, $event_id);
            $stmt->execute();
        }
    }


    /***************************************************************************
     * Remove event from judge
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
        $stmt = $this->conn->prepare("DELETE FROM $this->table_events WHERE judge_id = ? AND event_id = ?");
        $stmt->bind_param("ii", $this->id, $event_id);
        $stmt->execute();
    }


    /***************************************************************************
     * Check whether the given event is assigned to the judge or not
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
     * Get all assigned events to judge as array of objects
     *
     * @return Event[]
     */
    public function getAllEvents()
    {
        require_once 'Event.php';
        $stmt = $this->conn->prepare("SELECT DISTINCT event_id FROM $this->table_events WHERE judge_id = ? ORDER BY event_id");
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
     * Get all assigned events to judge as array of arrays
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
     * Set judge's rating of team based on a given criterion
     *
     * @param Criterion $criterion
     * @param Team $team
     * @param float $value
     * @param boolean $is_locked
     * @return void
     */
    public function setCriterionTeamRating($criterion, $team, $value = 0, $is_locked = false)
    {
        require_once 'Rating.php';

        // get criterion_id and team_id
        $criterion_id = $criterion->getId();
        $team_id = $team->getId();

        // check if rating is stored or not
        $stored = Rating::stored($this->id, $criterion_id, $team_id);

        // instantiate rating
        $rating = new Rating();
        if($stored)
            $rating = Rating::find($this->id, $criterion_id, $team_id);

        // set properties
        $rating->setJudgeId($this->id);
        $rating->setCriterionId($criterion_id);
        $rating->setTeamId($team_id);
        $rating->setValue($value);
        $rating->setIsLocked($is_locked);

        // update or insert
        if($stored)
            $rating->update();
        else
            $rating->insert();
    }


    /***************************************************************************
     * Get judge's rating of team based on a given criterion, as object
     *
     * @param Criterion $criterion
     * @param Team $team
     * @return Rating
     */
    public function getCriterionTeamRating($criterion, $team)
    {
        require_once 'Rating.php';

        // get criterion_id and team_id
        $criterion_id = $criterion->getId();
        $team_id = $team->getId();

        // insert rating if not yet stored
        if(!Rating::stored($this->id, $criterion_id, $team_id)) {
            $rating = new Rating();
            $rating->setJudgeId($this->id);
            $rating->setCriterionId($criterion_id);
            $rating->setTeamId($team_id);
            $rating->insert();
        }

        // return rating
        return Rating::find($this->id, $criterion_id, $team_id);
    }


    /***************************************************************************
     * Get judge's rating of team based on a given criterion, as array
     *
     * @param Criterion $criterion
     * @param Team $team
     * @return array
     */
    public function getCriterionTeamRatingRow($criterion, $team)
    {
        return ($this->getCriterionTeamRating($criterion, $team))->toArray();
    }


    /***************************************************************************
     * Get judge's rating of team based on a given event, as array of objects
     *
     * @param Event $event
     * @param Team $team
     * @return array
     */
    public function getAllEventTeamRatings($event, $team)
    {
        $ratings = [];
        foreach($event->getAllCriteria() as $criterion) {
            $key = $this->id.'_'.$criterion->getId().'_'.$team->getId();
            $ratings[$key] = $this->getCriterionTeamRating($criterion, $team);
        }
        return $ratings;
    }


    /***************************************************************************
     * Get judge's rating of team based on a given event, as array of arrays
     *
     * @param Event $event
     * @param Team $team
     * @return array
     */
    public function getRowEventTeamRatings($event, $team)
    {
        $ratings = [];
        foreach($event->getAllCriteria() as $criterion) {
            $key = $this->id.'_'.$criterion->getId().'_'.$team->getId();
            $ratings[$key] = $this->getCriterionTeamRatingRow($criterion, $team);
        }
        return $ratings;
    }


    /***************************************************************************
     * Get judge's ratings on a given event, as array of objects
     * 
     * @param Event $event
     * @return array
     */
    public function getAllEventRatings($event)
    {
        require_once 'Team.php';

        $ratings = [];
        foreach(Team::all() as $team) {
            $key = $event->getSlug().'_'.$team->getId();
            $ratings[$key] = $this->getAllEventTeamRatings($event, $team);
        }
        return $ratings;
    }


    /***************************************************************************
     * Get judge's ratings on a given event, as array of arrays
     *
     * @param Event $event
     * @return array
     */
    public function getRowEventRatings($event)
    {
        require_once 'Team.php';

        $ratings = [];
        foreach(Team::all() as $team) {
            $key = $event->getSlug().'_'.$team->getId();
            $ratings[$key] = $this->getRowEventTeamRatings($event, $team);
        }
        return $ratings;
    }
}
