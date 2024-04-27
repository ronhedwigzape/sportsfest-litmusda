<?php

require_once 'App.php';

class Event extends App
{
    // table
    protected $table = 'events';
    protected $table_noshows = 'noshows';
    protected $table_eliminations = 'eliminations';

    // properties
    protected $id;
    protected $category_id;
    protected $slug;
    protected $title;


    /***************************************************************************
     * Event constructor
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
                $this->category_id = $row['category_id'];
                $this->slug = $row['slug'];
                $this->title = $row['title'];
            }
        }
    }


    /***************************************************************************
     * Execute find
     *
     * @param $stmt
     * @return Event|false
     */
    private static function executeFind($stmt)
    {
        $stmt->execute();
        $result = $stmt->get_result();
        if($row = $result->fetch_assoc())
            return new Event($row['id']);
        else
            return false;
    }


    /***************************************************************************
     * Find event by id
     *
     * @param int $id
     * @return Event|boolean
     */
    public static function findById($id)
    {
        $event = new Event();
        $stmt = $event->conn->prepare("SELECT id FROM $event->table WHERE id = ?");
        $stmt->bind_param("i", $id);
        return self::executeFind($stmt);
    }


    /***************************************************************************
     * Find event by slug
     *
     * @param string $slug
     * @return Event|boolean
     */
    public static function findBySlug($slug)
    {
        $event = new Event();
        $stmt = $event->conn->prepare("SELECT id FROM $event->table WHERE slug = ?");
        $stmt->bind_param("s", $slug);
        return self::executeFind($stmt);
    }


    /***************************************************************************
     * Convert event object to array
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'id'          => $this->id,
            'category_id' => $this->category_id,
            'slug'        => $this->slug,
            'title'       => $this->title
        ];
    }


    /***************************************************************************
     * Get all events as array of objects
     *
     * @param int $category_id
     * @return Event[]
     */
    public static function all($category_id = 0)
    {
        $event = new Event();
        $sql = "SELECT id FROM $event->table ";
        if($category_id > 0)
            $sql .= "WHERE category_id = ? ";
        $sql .= "ORDER BY id";
        $stmt = $event->conn->prepare($sql);
        if($category_id > 0)
            $stmt->bind_param("i", $category_id);
        $stmt->execute();

        $result = $stmt->get_result();
        $events = [];
        while($row = $result->fetch_assoc()) {
            $events[] = new Event($row['id']);
        }
        return $events;
    }


    /***************************************************************************
     * Get all events as array of arrays
     *
     * @param int $category_id
     * @return array
     */
    public static function rows($category_id = 0)
    {
        $events = [];
        foreach(self::all($category_id) as $event) {
            $events[] = $event->toArray();
        }
        return $events;
    }


    /***************************************************************************
     * Check if event id exists
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
     * Check if event slug exists
     *
     * @param string $slug
     * @param int $id
     * @return bool
     */
    public static function slugExists($slug, $id = 0)
    {
        $event = new Event();
        $stmt = $event->conn->prepare("SELECT id FROM $event->table WHERE slug = ? AND id != ?");
        $stmt->bind_param("si", $slug, $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return ($result->num_rows > 0);
    }


    /***************************************************************************
     * Insert event
     *
     * @return void
     */
    public function insert()
    {
        // check id
        if(self::exists($this->id))
            App::returnError('HTTP/1.1 409', 'Insert Error: event [id = ' . $this->id . '] already exists.');

        // check category_id
        require_once 'Category.php';
        if(!Category::exists($this->category_id))
            App::returnError('HTTP/1.1 404', 'Insert Error: category [id = ' . $this->category_id . '] does not exist.');

        // check slug
        if(self::slugExists($this->slug))
            App::returnError('HTTP/1.1 409', 'Insert Error: event [slug = ' . $this->slug . '] already exists.');

        // proceed with insert
        $stmt = $this->conn->prepare("INSERT INTO $this->table(category_id, slug, title) VALUES(?, ?, ?)");
        $stmt->bind_param("iss", $this->category_id, $this->slug, $this->title);
        $stmt->execute();
        $this->id = $this->conn->insert_id;
    }


    /***************************************************************************
     * Update event
     *
     * @return void
     */
    public function update()
    {
        // check id
        if(!self::exists($this->id))
            App::returnError('HTTP/1.1 404', 'Update Error: event [id = ' . $this->id . '] does not exist.');

        // check category_id
        require_once 'Category.php';
        if(!Category::exists($this->category_id))
            App::returnError('HTTP/1.1 404', 'Update Error: category [id = ' . $this->category_id . '] does not exist.');

        // check slug
        if(self::slugExists($this->slug, $this->id))
            App::returnError('HTTP/1.1 409', 'Update Error: event [slug = ' . $this->slug . '] already exists.');

        // proceed with update
        $stmt = $this->conn->prepare("UPDATE $this->table SET category_id = ?, slug = ?, title = ? WHERE id = ?");
        $stmt->bind_param("issi", $this->category_id, $this->slug, $this->title, $this->id);
        $stmt->execute();
    }


    /***************************************************************************
     * Delete event
     *
     * @return void
     */
    public function delete()
    {
        // check id
        if(!self::exists($this->id))
            App::returnError('HTTP/1.1 404', 'Delete Error: event [id = ' . $this->id . '] does not exist.');

        // proceed with delete
        $stmt = $this->conn->prepare("DELETE FROM $this->table WHERE id = ?");
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
    }


    /***************************************************************************
     * Set category_id
     *
     * @param int $category_id
     * @return void
     */
    public function setCategoryId($category_id)
    {
        $this->category_id = $category_id;
    }


    /***************************************************************************
     * Set slug
     *
     * @param string $slug
     * @return void
     */
    public function setSlug($slug)
    {
        $this->slug = parent::generateSlug($slug);
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
     * Get category_id
     *
     * @return int
     */
    public function getCategoryId()
    {
        return $this->category_id;
    }


    /***************************************************************************
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
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
     * Get table of no-show teams
     *
     * @return string
     */
    public function getTableNoShows()
    {
        return $this->table_noshows;
    }


    /***************************************************************************
     * Get table of eliminated teams
     *
     * @return string
     */
    public function getTableEliminations()
    {
        return $this->table_eliminations;
    }


    /***************************************************************************
     * Get all criteria as array of objects
     *
     * @return Criterion[]
     */
    public function getAllCriteria()
    {
        require_once 'Criterion.php';
        return Criterion::all($this->id);
    }


    /***************************************************************************
     * Get all criteria as array of arrays
     *
     * @return array
     */
    public function getRowCriteria()
    {
        require_once 'Criterion.php';
        return Criterion::rows($this->id);
    }


    /***************************************************************************
     * Get parent category
     *
     * @return Category
     */
    public function getCategory()
    {
        require_once 'Category.php';
        return new Category($this->category_id);
    }


    /***************************************************************************
     * Get all assigned judges to event as array of objects
     *
     * @return Judge[]
     */
    public function getAllJudges()
    {
        require_once 'Judge.php';
        $judge = new Judge();
        $table_judges = $judge->getTable();
        $table_events = $judge->getTableEvents();

        $stmt = $this->conn->prepare("SELECT DISTINCT $table_events.judge_id FROM $table_judges, $table_events WHERE $table_events.event_id = ? AND $table_judges.id = $table_events.judge_id ORDER BY $table_judges.number");
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        $result = $stmt->get_result();

        $judges = [];
        while($row = $result->fetch_assoc()) {
            $judge = Judge::findById($row['judge_id']);
            $judge->setIsChairman($judge->isChairmanOfEvent($this));
            $judges[] = $judge;
        }
        return $judges;
    }


    /***************************************************************************
     * Get all assigned judges to event as array of arrays
     *
     * @return array
     */
    public function getRowJudges()
    {
        $judges = [];
        foreach($this->getAllJudges() as $judge) {
            $judges[] = $judge->toArray();
        }
        return $judges;
    }


    /***************************************************************************
     * Determine if the event has a given judge
     *
     * @param Judge $judge
     * @return bool
     */
    public function hasJudge($judge)
    {
        return $judge->hasEvent($this);
    }


    /***************************************************************************
     * Get all judges with unlocked ratings for the event as array of objects
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
     * Get all judges with unlocked ratings for the event as array of arrays
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
     * Determine if this event has judges with unlocked ratings
     *
     * @return bool
     */
    public function hasJudgesWithUnlockedRatings()
    {
        return (sizeof($this->getAllJudgesWithUnlockedRatings()) > 0);
    }


    /***************************************************************************
     * Get all assigned technicals to event as array of objects
     *
     * @return Technical[]
     */
    public function getAllTechnicals()
    {
        require_once 'Technical.php';
        $table_events = (new Technical())->getTableEvents();

        $stmt = $this->conn->prepare("SELECT DISTINCT technical_id FROM $table_events WHERE event_id = ? ORDER BY technical_id");
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        $result = $stmt->get_result();

        $technicals = [];
        while($row = $result->fetch_assoc()) {
            $technicals[] = Technical::findById($row['technical_id']);
        }
        return $technicals;
    }


    /***************************************************************************
     * Get all assigned technicals to event as array of arrays
     *
     * @return array
     */
    public function getRowTechnicals()
    {
        $technicals = [];
        foreach($this->getAllTechnicals() as $technical) {
            $technicals[] = $technical->toArray();
        }
        return $technicals;
    }


    /***************************************************************************
     * Determine if the event has a given technical
     *
     * @param Technical $technical
     * @return bool
     */
    public function hasTechnical($technical)
    {
        return $technical->hasEvent($this);
    }


    /***************************************************************************
     * Get all technicals with unlocked deductions for the event as array of objects
     *
     * @return Technical[]
     */
    public function getAllTechnicalsWithUnlockedDeductions()
    {
        $technicals = [];
        foreach($this->getAllTechnicals() as $technical) {
            if($technical->hasUnlockedDeductions($this))
                $technicals[] = $technical;
        }
        return $technicals;
    }


    /***************************************************************************
     * Get all technicals with unlocked deductions for the event as array of arrays
     *
     * @return array
     */
    public function getRowTechnicalsWithUnlockedDeductions()
    {
        $technicals = [];
        foreach($this->getAllTechnicalsWithUnlockedDeductions() as $technical) {
            $technicals[] = $technical->toArray();
        }
        return $technicals;
    }


    /***************************************************************************
     * Determine if this event has technicals with unlocked deductions
     *
     * @return bool
     */
    public function hasTechnicalsWithUnlockedDeductions()
    {
        return (sizeof($this->getAllTechnicalsWithUnlockedDeductions()) > 0);
    }


    /***************************************************************************
     * Get total criteria percentage
     *
     * @return float
     */
    public function getTotalCriteriaPercentage()
    {
        $total = 0;
        foreach($this->getAllCriteria() as $criterion) {
            $total += $criterion->getPercentage();
        }
        return $total;
    }


    /***************************************************************************
     * Set event point on a given rank
     *
     * @param int $rank
     * @param float $value
     * @return void
     */
    public function setRankPoint($rank, $value)
    {
        require_once 'Point.php';

        // check if point is stored or not
        $stored = Point::stored($this->id, $rank);

        // instantiate point
        $point = new Point();
        if($stored)
            $point = Point::find($this->id, $rank);

        // set properties
        $point->setEventId($this->id);
        $point->setRank($rank);
        $point->setValue($value);

        // update or insert
        if($stored)
            $point->update();
        else
            $point->insert();
    }


    /***************************************************************************
     * Get event point of given rank, as object
     *
     * @param int $rank
     * @return bool|Point
     */
    public function getRankPoint($rank)
    {
        require_once 'Point.php';

        // insert point if not yet stored
        if(!Point::stored($this->id, $rank)) {
            $point = new Point();
            $point->setEventId($this->id);
            $point->setRank($rank);
            $point->insert();
        }

        // return point
        return Point::find($this->id, $rank);
    }


    /***************************************************************************
     * Get event point of given rank, as array
     *
     * @param $rank
     * @return array
     */
    public function getRankPointRow($rank)
    {
        return ($this->getRankPoint($rank))->toArray();
    }


    /***************************************************************************
     * Get all event points as array of objects
     *
     * @return Point[]
     */
    public function getAllPoints()
    {
        require_once 'Point.php';
        $ranks = Point::ranks();

        $points = [];
        foreach($ranks as $rank) {
            $key = $this->slug.'_rank-'.$rank;
            $points[$key] = $this->getRankPoint($rank);
        }
        return $points;
    }


    /***************************************************************************
     * Get all event points as array of arrays
     *
     * @return array
     */
    public function getRowPoints()
    {
        $points = [];
        foreach($this->getAllPoints() as $point) {
            $key = $this->slug.'_rank-'.$point->getRank();
            $points[$key] = $this->getRankPointRow($point->getRank());
        }
        return $points;
    }


    /***************************************************************************
     * Set event title on a given rank
     *
     * @param int $rank
     * @param string $title
     * @return void
     */
    public function setRankTitle($rank, $title)
    {
        require_once 'Title.php';

        // check if title is stored or not
        $stored = Title::stored($this->id, $rank);

        // instantiate title
        $title_obj = new Title();
        if($stored)
            $title_obj = Title::find($this->id, $rank);

        // set properties
        $title_obj->setEventId($this->id);
        $title_obj->setRank($rank);
        $title_obj->setTitle($title);

        // update or insert
        if($stored)
            $title_obj->update();
        else
            $title_obj->insert();
    }


    /***************************************************************************
     * Get event title of given rank, as object
     *
     * @param int $rank
     * @return bool|Title
     */
    public function getRankTitle($rank)
    {
        require_once 'Title.php';

        // insert title if not yet stored
        if(!Title::stored($this->id, $rank)) {
            $title = new Title();
            $title->setEventId($this->id);
            $title->setRank($rank);
            $title->insert();
        }

        // return title
        return Title::find($this->id, $rank);
    }


    /***************************************************************************
     * Get event title of given rank, as array
     *
     * @param $rank
     * @return array
     */
    public function getRankTitleRow($rank)
    {
        return ($this->getRankTitle($rank))->toArray();
    }


    /***************************************************************************
     * Get all event titles as array of objects
     *
     * @return Title[]
     */
    public function getAllTitles()
    {
        require_once 'Title.php';
        $ranks = Title::ranks();

        $titles = [];
        foreach($ranks as $rank) {
            $key = $this->slug.'_rank-'.$rank;
            $titles[$key] = $this->getRankTitle($rank);
        }
        return $titles;
    }


    /***************************************************************************
     * Get all event titles as array of arrays
     *
     * @return array
     */
    public function getRowTitles()
    {
        $titles = [];
        foreach($this->getAllTitles() as $title) {
            $key = $this->slug.'_rank-'.$title->getRank();
            $titles[$key] = $this->getRankTitleRow($title->getRank());
        }
        return $titles;
    }


    /***************************************************************************
     * Set team arrangement order
     *
     * @param Team $team
     * @param int $order
     * @return void
     */
    public function setTeamOrder($team, $order)
    {
        // get team_id
        $team_id = $team->getId();

        // check if arrangement is stored or not
        require_once 'Arrangement.php';
        $stored = Arrangement::stored($this->id, $team_id);

        // instantiate arrangement
        $arrangement = new Arrangement();
        if($stored)
            $arrangement = Arrangement::find($this->id, $team_id);

        // set properties
        $arrangement->setEventId($this->id);
        $arrangement->setTeamId($team_id);
        $arrangement->setOrder($order);

        // update or insert
        if($stored)
            $arrangement->update();
        else
            $arrangement->insert();
    }


    /***************************************************************************
     * Get sorted teams for event, as array of objects
     *
     * @return Team[]
     */
    public function getAllTeams()
    {
        require_once 'Team.php';
        return Team::all($this->getId());
    }


    /***************************************************************************
     * Get sorted teams for event, as array of arrays
     *
     * @return array
     */
    public function getRowTeams()
    {
        require_once 'Team.php';
        return Team::rows($this->getId());
    }


    /***************************************************************************
     * Get teams which never showed up for the event, as a result set
     *
     * @return array
     */
    private function getResultNoShowTeams()
    {
        $stmt = $this->conn->prepare("SELECT DISTINCT team_id FROM $this->table_noshows WHERE event_id = ? ORDER BY team_id");
        $stmt->bind_param("i", $this->id);
        $stmt->execute();

        return $stmt->get_result();
    }


    /***************************************************************************
     * Get teams which never showed up for the event, as array of objects
     *
     * @return Team[]
     */
    public function getAllNoShowTeams()
    {
        require_once 'Team.php';

        $result = $this->getResultNoShowTeams();
        $teams = [];
        while($row = $result->fetch_assoc()) {
            $teams[] = new Team($row['team_id']);
        }

        return $teams;
    }


    /***************************************************************************
     * Get id's of teams which never showed up for the event
     *
     * @return array
     */
    public function getRowNoShowTeamIds()
    {
        $result = $this->getResultNoShowTeams();

        $team_ids = [];
        while($row = $result->fetch_assoc()) {
            $team_ids[] = $row['team_id'];
        }

        return $team_ids;
    }


    /***************************************************************************
     * Get teams which never showed up for the event, as array of arrays
     *
     * @return array
     */
    public function getRowNoShowTeams()
    {
        $teams = [];
        foreach($this->getAllNoShowTeams() as $team) {
            $teams[] = $team->toArray();
        }

        return $teams;
    }


    /***************************************************************************
     * Determine if a given team never showed up for the event
     *
     * @param Team $team
     * @return bool
     */
    public function hasTeamNotShownUp($team)
    {
        $team_id = $team->getId();

        foreach($this->getAllNoShowTeams() as $t) {
            if($t->getId() == $team_id)
                return true;
        }
        return false;
    }


    /***************************************************************************
     * Add team which never showed up for the event
     *
     * @param Team $team
     * @return void
     */
    public function addNoShowTeam($team)
    {
        require_once 'Team.php';

        // check team id
        $team_id = $team->getId();
        if(!Team::exists($team_id))
            App::returnError('HTTP/1.1 404', 'NowShow Team Addition Error: team [id = ' . $team_id . '] does not exist.');

        // proceed with addition
        if(!$this->hasTeamNotShownUp($team)) {
            $stmt = $this->conn->prepare("INSERT INTO $this->table_noshows(event_id, team_id) VALUES(?, ?)");
            $stmt->bind_param("ii", $this->id, $team_id);
            $stmt->execute();
        }
    }


    /***************************************************************************
     * Remove team from event noshows
     *
     * @param Team $team
     * @return void
     */
    public function removeNoShowTeam($team)
    {
        require_once 'Team.php';

        // check team id
        $team_id = $team->getId();
        if(!Team::exists($team_id))
            App::returnError('HTTP/1.1 404', 'NowShow Team Removal Error: team [id = ' . $team_id . '] does not exist.');

        // proceed with removal
        $stmt = $this->conn->prepare("DELETE FROM $this->table_noshows WHERE event_id = ? AND team_id = ?");
        $stmt->bind_param("ii", $this->id, $team_id);
        $stmt->execute();
    }


    /***************************************************************************
     * Get teams which are eliminated from the event, as a result set
     *
     * @return array
     */
    private function getResultEliminatedTeams()
    {
        $stmt = $this->conn->prepare("SELECT DISTINCT team_id FROM $this->table_eliminations WHERE event_id = ? ORDER BY team_id");
        $stmt->bind_param("i", $this->id);
        $stmt->execute();

        return $stmt->get_result();
    }


    /***************************************************************************
     * Get teams which are eliminated from the event, as array of objects
     *
     * @return Team[]
     */
    public function getAllEliminatedTeams()
    {
        require_once 'Team.php';
        $result = $this->getResultEliminatedTeams();

        $teams = [];
        while($row = $result->fetch_assoc()) {
            $teams[] = new Team($row['team_id']);
        }

        return $teams;
    }


    /***************************************************************************
     * Get id's of teams which are eliminated from the event
     *
     * @return array
     */
    public function getRowEliminatedTeamIds()
    {
        $result = $this->getResultEliminatedTeams();

        $team_ids = [];
        while($row = $result->fetch_assoc()) {
            $team_ids[] = $row['team_id'];
        }

        return $team_ids;
    }


    /***************************************************************************
     * Get teams which are eliminated from the event, as array of arrays
     *
     * @return array
     */
    public function getRowEliminatedTeams()
    {
        $teams = [];
        foreach($this->getAllEliminatedTeams() as $team) {
            $teams[] = $team->toArray();
        }

        return $teams;
    }


    /***************************************************************************
     * Determine if a given team is eliminated from the event
     *
     * @param Team $team
     * @return bool
     */
    public function hasTeamBeenEliminated($team)
    {
        $team_id = $team->getId();

        foreach($this->getAllEliminatedTeams() as $t) {
            if($t->getId() == $team_id)
                return true;
        }
        return false;
    }


    /***************************************************************************
     * Eliminate a given team from the event
     *
     * @param Team $team
     * @return void
     */
    public function eliminateTeam($team)
    {
        require_once 'Team.php';

        // check team id
        $team_id = $team->getId();
        if(!Team::exists($team_id))
            App::returnError('HTTP/1.1 404', 'Team Elimination Error: team [id = ' . $team_id . '] does not exist.');

        // proceed with elimination
        if(!$this->hasTeamBeenEliminated($team)) {
            $stmt = $this->conn->prepare("INSERT INTO $this->table_eliminations(event_id, team_id) VALUES(?, ?)");
            $stmt->bind_param("ii", $this->id, $team_id);
            $stmt->execute();
        }
    }


    /***************************************************************************
     * Revive an eliminated from the event
     *
     * @param Team $team
     * @return void
     */
    public function reviveTeam($team)
    {
        require_once 'Team.php';

        // check team id
        $team_id = $team->getId();
        if(!Team::exists($team_id))
            App::returnError('HTTP/1.1 404', 'Team Revival Error: team [id = ' . $team_id . '] does not exist.');

        // proceed with removal
        $stmt = $this->conn->prepare("DELETE FROM $this->table_eliminations WHERE event_id = ? AND team_id = ?");
        $stmt->bind_param("ii", $this->id, $team_id);
        $stmt->execute();
    }
}
