<?php

require_once 'App.php';

class Rating extends App
{
    // table
    protected $table = 'ratings';

    // properties
    protected $id;
    protected $judge_id;
    protected $criterion_id;
    protected $team_id;
    protected $value = 0;
    protected $is_locked;


    /***************************************************************************
     * Rating constructor
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
                $this->id           = $row['id'];
                $this->judge_id     = $row['judge_id'];
                $this->criterion_id = $row['criteria_id'];
                $this->team_id      = $row['team_id'];
                $this->value        = $row['value'];
                $this->is_locked    = ($row['is_locked'] == 1);
            }
        }
    }


    /***************************************************************************
     * Execute find
     *
     * @param $stmt
     * @return Rating|boolean
     */
    private static function executeFind($stmt)
    {
        $stmt->execute();
        $result = $stmt->get_result();
        if($row = $result->fetch_assoc())
            return new Rating($row['id']);
        else
            return false;
    }


    /***************************************************************************
     * Find rating by judge_id, criterion_id, and team_id
     *
     * @param int $judge_id
     * @param int $criterion_id
     * @param int $team_id
     * @return Rating|boolean
     */
    public static function find($judge_id, $criterion_id, $team_id)
    {
        $rating = new Rating();
        $stmt = $rating->conn->prepare("SELECT id FROM $rating->table WHERE judge_id = ? AND criteria_id = ? AND team_id = ?");
        $stmt->bind_param("iii", $judge_id, $criterion_id, $team_id);
        return self::executeFind($stmt);
    }


    /***************************************************************************
     * Find rating by id
     *
     * @param int $id
     * @return Rating|boolean
     */
    public static function findById($id)
    {
        $rating = new Rating();
        $stmt = $rating->conn->prepare("SELECT id FROM $rating->table WHERE id = ?");
        $stmt->bind_param("i", $id);
        return self::executeFind($stmt);
    }


    /***************************************************************************
     * Convert rating object to array
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'id'           => $this->id,
            'judge_id'     => $this->judge_id,
            'criterion_id' => $this->criterion_id,
            'team_id'      => $this->team_id,
            'value'        => $this->value,
            'is_locked'    => $this->is_locked,
        ];
    }


    /***************************************************************************
     * Check if rating id exists
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
     * Check if rating for judge, criterion, and team is already stored
     *
     * @param int $judge_id
     * @param int $criterion_id
     * @param int $team_id
     * @return bool
     */
    public static function stored($judge_id, $criterion_id, $team_id)
    {
        if(!$judge_id || !$criterion_id || !$team_id)
            return false;

        return (self::find($judge_id, $criterion_id, $team_id) != false);
    }


    /***************************************************************************
     * Insert rating
     *
     * @return void
     */
    public function insert()
    {
        // check id
        if(self::exists($this->id))
            App::returnError('HTTP/1.1 409', 'Insert Error: rating [id = ' . $this->id . '] already exists.');

        // check judge_id
        require_once 'Judge.php';
        if(!Judge::exists($this->judge_id))
            App::returnError('HTTP/1.1 404', 'Insert Error: judge [id = ' . $this->judge_id . '] does not exist.');

        // check criterion_id
        require_once 'Criterion.php';
        if(!Criterion::exists($this->criterion_id))
            App::returnError('HTTP/1.1 404', 'Insert Error: criterion [id = ' . $this->criterion_id . '] does not exist.');

        // check team_id
        require_once 'Team.php';
        if(!Team::exists($this->team_id))
            App::returnError('HTTP/1.1 404', 'Insert Error: team [id = ' . $this->team_id . '] does not exist.');

        // check if judge is allowed to rate
        $criterion = $this->getCriterion();
        $event = $criterion->getEvent();
        $judge = $this->getJudge();
        if(!$judge->hasEvent($event))
            App::returnError('HTTP/1.1 422', 'Insert Error: event [slug = ' . $event->getSlug() . '] is not assigned to judge [id = ' . $this->judge_id . ']');

        // proceed with insert if not yet stored
        if(!self::stored($this->judge_id, $this->criterion_id, $this->team_id)) {
            // check value
            $min = 0;
            $max = $criterion->getPercentage();
            if($this->value < $min || $this->value > $max)
                App::returnError('HTTP/1.1 422', 'Insert Error: criterion [title = "' . $criterion->getTitle() . '"] must be from ' . $min . ' to ' . $max . ', [given = ' . $this->value . '].');

            // proceed with insert
            $stmt = $this->conn->prepare("INSERT INTO $this->table(judge_id, criteria_id, team_id, value) VALUES(?, ?, ?, ?)");
            $stmt->bind_param("iiid", $this->judge_id, $this->criterion_id, $this->team_id, $this->value);
            $stmt->execute();
            $this->id = $this->conn->insert_id;
        }
    }


    /***************************************************************************
     * Update rating
     *
     * @param bool $toggle_lock
     * @return void
     */
    public function update($toggle_lock = false)
    {
        // check id
        if(!self::exists($this->id))
            App::returnError('HTTP/1.1 404', 'Update Error: rating [id = ' . $this->id . '] does not exist.');

        // check is_locked
        if(!$toggle_lock) {
            $stored_rating = self::findById($this->id);
            if($stored_rating->is_locked)
                App::returnError('HTTP/1.1 409', 'Update Error: rating [id = ' . $this->id . '] is already locked.');
        }

        // check judge_id
        require_once 'Judge.php';
        if(!Judge::exists($this->judge_id))
            App::returnError('HTTP/1.1 404', 'Update Error: judge [id = ' . $this->judge_id . '] does not exist.');

        // check criterion_id
        require_once 'Criterion.php';
        if(!Criterion::exists($this->criterion_id))
            App::returnError('HTTP/1.1 404', 'Update Error: criterion [id = ' . $this->criterion_id . '] does not exist.');

        // check team_id
        require_once 'Team.php';
        if(!Team::exists($this->team_id))
            App::returnError('HTTP/1.1 404', 'Update Error: team [id = ' . $this->team_id . '] does not exist.');

        // check if judge is allowed to rate
        $criterion = $this->getCriterion();
        $event = $criterion->getEvent();
        $judge = $this->getJudge();
        if(!$judge->hasEvent($event))
            App::returnError('HTTP/1.1 422', 'Update Error: event [slug = ' . $event->getSlug() . '] is not assigned to judge [id = ' . $this->judge_id . ']');

        // check value
        $min = 0;
        $max = $criterion->getPercentage();
        if($this->value < $min || $this->value > $max)
            App::returnError('HTTP/1.1 422', 'Update Error: criterion [title = "' . $criterion->getTitle() . '"] must be from ' . $min . ' to ' . $max . ', [given = ' . $this->value . '].');

        // proceed with update
        $stmt = $this->conn->prepare("UPDATE $this->table SET judge_id = ?,  criteria_id = ?, team_id = ?, value = ?, is_locked = ? WHERE id = ?");
        $is_locked = $this->is_locked ? 1 : 0;
        $stmt->bind_param("iiidii", $this->judge_id, $this->criterion_id, $this->team_id, $this->value, $is_locked, $this->id);
        $stmt->execute();
    }


    /***************************************************************************
     * Delete rating
     *
     * @return void
     */
    public function delete()
    {
        // check id
        if(!self::exists($this->id))
            App::returnError('HTTP/1.1 404', 'Delete Error: rating [id = ' . $this->id . '] does not exist.');

        // proceed with delete
        $stmt = $this->conn->prepare("DELETE FROM $this->table WHERE id = ?");
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
    }


    /***************************************************************************
     * Lock or Unlock rating
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
     * Set judge_id
     *
     * @param int $judge_id
     * @return void
     */
    public function setJudgeId($judge_id)
    {
        $this->judge_id = $judge_id;
    }


    /***************************************************************************
     * Set criterion_id
     *
     * @param int $criterion_id
     * @return void
     */
    public function setCriterionId($criterion_id)
    {
        $this->criterion_id = $criterion_id;
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
     * Get judge_id
     *
     * @return int
     */
    public function getJudgeId()
    {
        return $this->judge_id;
    }


    /***************************************************************************
     * Get criterion_id
     *
     * @return int
     */
    public function getCriterionId()
    {
        return $this->criterion_id;
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
     * Get judge
     *
     * @return Judge|bool
     */
    public function getJudge()
    {
        require_once 'Judge.php';
        return Judge::findById($this->judge_id);
    }


    /***************************************************************************
     * Get criterion
     *
     * @return Criterion
     */
    public function getCriterion()
    {
        require_once 'Criterion.php';
        return new Criterion($this->criterion_id);
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