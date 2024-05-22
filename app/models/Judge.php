<?php

require_once 'User.php';

class Judge extends User
{
    // table
    protected $table_events = 'judge_event';

    // properties
    protected $is_chairman = false;


    /***************************************************************************
     * Judge constructor
     *
     * @param $username
     * @param $password
     */
    public function __construct($username = '', $password = '')
    {
        parent::__construct($username, $password, 'judge');
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
            App::returnError('HTTP/1.1 409', 'Insert Error: judge [id = ' . $this->id . '] already exists.');

        // check username
        if(trim($this->username) == '')
            App::returnError('HTTP/1.1 422', 'Insert Error: judge username is required.');
        else if(self::usernameExists($this->username))
            App::returnError('HTTP/1.1 409', 'Insert Error: judge [username = ' . $this->username . '] already exists.');

        // check password
        if($this->password == '')
            App::returnError('HTTP/1.1 422', 'Insert Error: judge password is required.');

        // proceed with insert
        $stmt = $this->conn->prepare("INSERT INTO $this->table(number, name, avatar, username, password) VALUES(?, ?, ?, ?, ?)");
        $stmt->bind_param("issss", $this->number, $this->name, $this->avatar, $this->username, $this->password);
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
            App::returnError('HTTP/1.1 404', 'Update Error: judge [id = ' . $this->id . '] does not exist.');

        // check username
        if(trim($this->username) == '')
            App::returnError('HTTP/1.1 422', 'Insert Error: judge username is required.');
        else if(self::usernameExists($this->username, $this->id))
            App::returnError('HTTP/1.1 409', 'Insert Error: judge [username = ' . $this->username . '] already exists.');

        // check password
        if($this->password == '')
            App::returnError('HTTP/1.1 422', 'Insert Error: judge password is required.');

        // proceed with update
        $stmt = $this->conn->prepare("UPDATE $this->table SET number = ?, name = ?, avatar = ?, username = ?, password = ? WHERE id = ?");
        $stmt->bind_param("issssi", $this->number, $this->name, $this->avatar, $this->username, $this->password, $this->id);
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
            App::returnError('HTTP/1.1 404', 'Delete Error: judge [id = ' . $this->id . '] does not exist.');

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
     * @return bool
     */
    public function getIsChairman()
    {
        return $this->is_chairman;
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
     * @param bool $is_chairman
     * @return void
     */
    public function assignEvent($event, $is_chairman = false)
    {
        require_once 'Event.php';
        require_once 'Team.php';

        // check event id
        $event_id = $event->getId();
        if(!Event::exists($event_id))
            App::returnError('HTTP/1.1 404', 'Event Assignment Error: event [id = ' . $event_id . '] does not exist.');

        // check first team
        $first_team = Team::first_record();
        if(!$first_team)
            App::returnError('HTTP/1.1 403', 'Event Assignment Error: There must be at least one team record.');

        // proceed with assignment
        if(!$this->hasEvent($event)) {
            $stmt = $this->conn->prepare("INSERT INTO $this->table_events(judge_id, event_id, is_chairman, active_team_id) VALUES(?, ?, ?, ?)");
            $is_chairman    = $is_chairman ? 1 : 0;
            $active_team_id = $first_team->getId();
            $stmt->bind_param("iiii", $this->id, $event_id, $is_chairman, $active_team_id);
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
            App::returnError('HTTP/1.1 404', 'Event Removal Error: event [id = ' . $event_id . '] does not exist.');

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
     * Toggle judge is_chairman for a given event
     *
     * @param Event $event
     * @param bool $is_chairman
     * @return void
     */
    private function toggleChairmanOfEvent($event, $is_chairman = true) {
        require_once 'Event.php';

        // initialize values
        $action = 'Assign';
        $value  = 1;
        if(!$is_chairman) {
            $action = 'Remove';
            $value  = 0;
        }

        // check event id
        $event_id = $event->getId();
        if(!Event::exists($event_id))
            App::returnError('HTTP/1.1 404', $action . ' Chairman Error: event [id = ' . $event_id . '] does not exist.');

        // check if judge has the event
        if(!$this->hasEvent($event))
            App::returnError('HTTP/1.1 422', $action . ' Chairman Error: judge [id = ' . $this->id . '] is not assigned to event [id = ' . $event_id . '].');

        // proceed
        $stmt = $this->conn->prepare("UPDATE $this->table_events SET is_chairman = ? WHERE judge_id = ? AND event_id = ?");
        $stmt->bind_param("iii", $value, $this->id, $event_id);
        $stmt->execute();
    }


    /***************************************************************************
     * Assign judge as chairman of a given event
     *
     * @param $event
     * @return void
     */
    public function assignChairmanOfEvent($event) {
        $this->toggleChairmanOfEvent($event);
    }


    /***************************************************************************
     * Remove judge as chairman of a given event
     *
     * @param $event
     * @return void
     */
    public function removeChairmanOfEvent($event) {
        $this->toggleChairmanOfEvent($event, false);
    }


    /***************************************************************************
     * Determine if judge is chairman of a given event
     *
     * @param Event $event
     * @return bool
     */
    public function isChairmanOfEvent($event) {
        $stmt = $this->conn->prepare("SELECT id FROM $this->table_events WHERE judge_id = ? AND event_id = ? AND is_chairman = 1");
        $event_id = $event->getId();
        $stmt->bind_param("ii", $this->id, $event_id);
        $stmt->execute();
        $result = $stmt->get_result();

        return ($result->num_rows > 0);
    }


    /***************************************************************************
     * Set the judge's active team in an event
     *
     * @param Event $event
     * @param Team  $team
     */
    public function setActiveTeamInEvent($event, $team) {
        $stmt = $this->conn->prepare("UPDATE $this->table_events SET active_team_id = ?, has_active_team = 1 WHERE judge_id = ? AND event_id = ?");
        $event_id = $event->getId();
        $team_id  = $team->getId();
        $stmt->bind_param("iii", $team_id, $this->id, $event_id);
        $stmt->execute();
    }


    /***************************************************************************
     * Get the judge's active team in an event
     *
     * @param Event $event
     * @return Team|boolean
     */
    public function getActiveTeamInEvent($event) {
        $active_team = false;
        $stmt = $this->conn->prepare("SELECT active_team_id, has_active_team FROM $this->table_events WHERE judge_id = ? AND event_id = ?");
        $event_id = $event->getId();
        $stmt->bind_param("ii", $this->id, $event_id);
        $stmt->execute();
        $result = $stmt->get_result();
        while($row = $result->fetch_assoc()) {
            if(intval($row['has_active_team']) == 1) {
                require_once 'Team.php';
                $active_team = new Team($row['active_team_id']);
            }
        }
        return $active_team;
    }


    /***************************************************************************
     * Remove the judge's active team in an event
     *
     * @param Event $event
     */
    public function removeActiveTeamInEvent($event) {
        $stmt = $this->conn->prepare("UPDATE $this->table_events SET has_active_team = 0 WHERE judge_id = ? AND event_id = ?");
        $event_id = $event->getId();
        $stmt->bind_param("ii", $this->id, $event_id);
        $stmt->execute();
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
            $rating->update(true);
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
            $key = $this->id . '_' . $criterion->getId() . '_' . $team->getId();
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
            $key = $this->id . '_' . $criterion->getId() . '_' . $team->getId();
            $ratings[$key] = $this->getCriterionTeamRatingRow($criterion, $team);
        }
        return $ratings;
    }


    /***************************************************************************
     * Get judge's total rating of team based on a given event
     *
     * @param Event $event
     * @param Team $team
     * @return array
     */
    public function getEventTeamRating($event, $team)
    {
        $total = [
            'is_locked' => false,
            'original'  => 0
        ];

        foreach($event->getAllCriteria() as $criterion) {
            $rating = $this->getCriterionTeamRating($criterion, $team);
            $total['original'] += $rating->getValue();

            if(!$total['is_locked'] && $rating->getIsLocked())
                $total['is_locked'] = true;
        }

        // apply technicals' average deduction when judge is chairman
        $total['deducted'] = $total['original'];
        if($this->isChairmanOfEvent($event)) {
            $technicals = $event->getAllTechnicals();
            $deduction_total = 0;
            foreach($technicals as $technical) {
                $deduction_total += ($technical->getEventTeamDeduction($event, $team))->getValue();
            }
            $deduction_average = (sizeof($technicals) > 0) ? ($deduction_total / sizeof($technicals)) : 0;
            $total['deducted'] -= $deduction_average;
        }

        // clear $total['deducted'] if the team never showed up for the event
        if($team->hasNotShownUpForEvent($event))
            $total['deducted'] = 0;

        return $total;
    }


    /***************************************************************************
     * Get judge's ratings on a given event, as array of objects
     *
     * @param Event $event
     * @return array
     */
    public function getAllEventRatings($event)
    {
        $ratings = [];
        foreach($event->getAllTeams() as $team) {
            $key = $event->getSlug() . '_' . $team->getId();
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
        $ratings = [];
        foreach($event->getAllTeams() as $team) {
            $key = $event->getSlug() . '_' . $team->getId();
            $ratings[$key] = $this->getRowEventTeamRatings($event, $team);
        }
        return $ratings;
    }


    /***************************************************************************
     * Get judge's final rank of teams based on a given event
     *
     * @param Event $event
     * @return array
     */
    public function getEventRanks($event)
    {
        require_once 'Team.php';
        $team_rows = $event->getRowTeams();

        // prepare $ranks
        $ranks = [];

        // gather unique ratings
        $unique_ratings = [];
        for($i = 0; $i < sizeof($team_rows); $i++) {
            $event_rating = $this->getEventTeamRating($event, new Team($team_rows[$i]['id']));
            $t_rating = $event_rating['deducted'];
            $team_rows[$i]['rating'] = $t_rating;
            $team_rows[$i]['rank'] = [
                'rating'     => $event_rating,
                'dense'      => 0,
                'fractional' => 0
            ];

            if(!in_array($t_rating, $unique_ratings))
                $unique_ratings[] = $t_rating;
        }

        // sort $unique_ratings in descending order
        rsort($unique_ratings);

        // gather $rank_group (for getting fractional rank)
        $rank_group = [];
        for($i = 0; $i < sizeof($team_rows); $i++) {
            // get dense rank
            $dense_rank = 1 + array_search($team_rows[$i]['rating'], $unique_ratings);
            $team_rows[$i]['rank']['dense'] = $dense_rank;

            // push $i to $rank_group
            $key_rank = 'rank_' . $dense_rank;
            if(!isset($rank_group[$key_rank]))
                $rank_group[$key_rank] = [];
            $rank_group[$key_rank][] = $i;
        }

        // get fractional rank
        $ctr = 0;
        for($i = 0; $i < sizeof($unique_ratings); $i++) {
            $key = 'rank_' . ($i + 1);
            $group = $rank_group[$key];
            $size = sizeof($group);
            $fractional_rank = $ctr + ((($size * ($size + 1)) / 2) / $size);

            // write $fractional_rank to $group members
            for($j = 0; $j < $size; $j++) {
                $team_row = $team_rows[$group[$j]];
                $team_row['rank']['fractional'] = $fractional_rank;

                // append to $ranks
                $ranks['team_' . $team_row['id']] = $team_row['rank'];
            }
            $ctr += $size;
        }

        // return $ranks
        return $ranks;
    }


    /***************************************************************************
     * Unlock judge's ratings on a given event
     *
     * @param Event $event
     * @return void
     */
    public function unlockRatings($event)
    {
        foreach($this->getAllEventRatings($event) as $key => $ratings) {
            foreach($ratings as $rating) {
                $rating->lock(false);
            }
        }
    }


    /***************************************************************************
     * Determine whether the judge has any unlocked ratings for a given event or criterion
     *
     * @param Event|Criterion $entity
     * @return bool
     */
    public function hasUnlockedRatings($entity)
    {
        require_once 'Event.php';
        require_once 'Criterion.php';
        require_once 'Rating.php';

        $bool     = false;
        $criteria = [];
        if($entity instanceof Event) {
            if($this->hasEvent($entity))
                $criteria = $entity->getAllCriteria();
        }
        else if($entity instanceof Criterion) {
            if($this->hasEvent($entity->getEvent()))
                $criteria = [$entity];
        }
        $rating = new Rating();
        $table_ratings = $rating->getTable();
        foreach($criteria as $criterion) {
            $criterion_id = $criterion->getId();
            $stmt = $this->conn->prepare("SELECT criteria_id FROM $table_ratings WHERE judge_id = ? AND criteria_id = ? AND is_locked = 0 LIMIT 1");
            $stmt->bind_param("ii", $this->id, $criterion_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $bool   = $result->num_rows > 0;
            if($bool)
                break;
        }
        return $bool;
    }
}
