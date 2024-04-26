<?php

require_once 'App.php';

class Team extends App
{
    // table
    protected $table = 'teams';

    // properties
    protected $id;
    protected $name;
    protected $color;
    protected $logo;
    protected $disabled = false;


    /***************************************************************************
     * Team constructor
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
                $this->name = $row['name'];
                $this->color = $row['color'];
                $this->logo = $row['logo'];
            }
        }
    }


    /***************************************************************************
     * Execute find
     *
     * @param $stmt
     * @return Team|false
     */
    private static function executeFind($stmt)
    {
        $stmt->execute();
        $result = $stmt->get_result();
        if($row = $result->fetch_assoc())
            return new Team($row['id']);
        else
            return false;
    }


    /***************************************************************************
     * Find team by id
     *
     * @param int $id
     * @return Team|boolean
     */
    public static function findById($id)
    {
        $team = new Team();
        $stmt = $team->conn->prepare("SELECT id FROM $team->table WHERE id = ?");
        $stmt->bind_param("i", $id);
        return self::executeFind($stmt);
    }


    /***************************************************************************
     * Convert team object to array
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'id'       => $this->id,
            'name'     => $this->name,
            'color'    => $this->color,
            'logo'     => $this->logo,
            'disabled' => $this->disabled
        ];
    }


    /***************************************************************************
     * Count all teams
     *
     * @return int
     */
    public static function count()
    {
        $team = new Team();
        $stmt = $team->conn->prepare("SELECT COUNT(id) as total_teams FROM $team->table");
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['total_teams'];
    }


    /***************************************************************************
     * Get all teams as array of objects
     *
     * @param int $event_id
     * @return Team[]
     */
    public static function all($event_id = 0)
    {
        // gather team ids of eliminated teams
        $event = null;
        $eliminated_team_ids = [];
        $noshow_team_ids     = [];
        if($event_id > 0) {
            require_once 'Event.php';
            $event = Event::findById($event_id);
            $eliminated_team_ids = $event->getRowEliminatedTeamIds();
            $noshow_team_ids     = $event->getRowNoShowTeamIds();
        }

        // gather teams
        $team = new Team();
        $sql  = "SELECT id FROM $team->table ";
        if(sizeof($eliminated_team_ids) > 0) {
            $sql .= "WHERE id NOT IN (" . implode(', ', $eliminated_team_ids) . ") ";
        }
        $sql .= "ORDER BY id";
        $stmt = $team->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();

        $teams = [];
        while($row = $result->fetch_assoc()) {
            $teams[] = new Team($row['id']);
        }

        // sort teams for an event
        if($event_id > 0) {
            require_once 'Arrangement.php';
            $sorted_teams   = [];
            $assigned_teams = [];
            $arrangements = Arrangement::all($event_id);

            for($i = 0; $i < sizeof($arrangements); $i++) {
                $arrangement = $arrangements[$i];

                $arranged_team = $arrangement->getTeam();
                $arranged_team_id = $arranged_team->getId();
                if(!in_array($arranged_team_id, $eliminated_team_ids)) {
                    $key = 'team_' . $arrangement->getOrder();
                    if(!isset($sorted_teams[$key]) && !in_array($arranged_team_id, $assigned_teams)) {
                        // push $arranged_team to $sorted_teams
                        $sorted_teams[$key] = $arranged_team;
                        $assigned_teams[] = $arranged_team_id;

                        // remove $arranged_team from $teams
                        for($j = 0; $j < sizeof($teams); $j++) {
                            if($teams[$j]->getId() == $arranged_team_id) {
                                unset($teams[$j]);
                                $teams = array_values($teams);
                                break;
                            }
                        }
                    }
                }
            }

            // merge $sorted_teams and remaining $teams
            $final_teams  = [];
            $total_orders = sizeof(Arrangement::orders());
            for($i = 1; $i <= $total_orders; $i++) {
                $key = 'team_' . $i;
                if(isset($sorted_teams[$key])) {
                    $sorted_teams[$key]->disabled = in_array($sorted_teams[$key]->getId(), $noshow_team_ids);
                    $final_teams[] = $sorted_teams[$key];
                }
                else if(isset($teams[0])) {
                    $teams[0]->disabled = in_array($teams[0]->getId(), $noshow_team_ids);
                    $final_teams[] = $teams[0];
                    unset($teams[0]);
                    $teams = array_values($teams);
                }
            }

            $teams = $final_teams;
        }

        return $teams;
    }


    /***************************************************************************
     * Get all teams as array of arrays
     *
     * @param int $event_id
     * @return array
     */
    public static function rows($event_id = 0)
    {
        $teams = [];
        foreach(self::all($event_id) as $team) {
            $teams[] = $team->toArray();
        }
        return $teams;
    }


    /***************************************************************************
     * Check if team id exists
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
     * Get the first Team record
     * @return Team|boolean
     */
    public static function first_record()
    {
        $first_team = false;
        $team = new Team();
        $stmt = $team->conn->prepare("SELECT `id` FROM $team->table ORDER BY `id` LIMIT 1");
        $stmt->execute();
        $result = $stmt->get_result();
        while($row = $result->fetch_assoc()) {
            $first_team = new Team($row['id']);
        }
        return $first_team;
    }


    /***************************************************************************
     * Insert team
     *
     * @return void
     */
    public function insert()
    {
        // check id
        if(self::exists($this->id))
            App::returnError('HTTP/1.1 409', 'Insert Error: team [id = ' . $this->id . '] already exists.');

        // proceed with insert
        $stmt = $this->conn->prepare("INSERT INTO $this->table(name, color, logo) VALUES(?, ?, ?)");
        $stmt->bind_param("sss", $this->name, $this->color, $this->logo);
        $stmt->execute();
        $this->id = $this->conn->insert_id;
    }


    /***************************************************************************
     * Update team
     *
     * @return void
     */
    public function update()
    {
        // check id
        if(!self::exists($this->id))
            App::returnError('HTTP/1.1 404', 'Update Error: team [id = ' . $this->id . '] does not exist.');

        // proceed with update
        $stmt = $this->conn->prepare("UPDATE $this->table SET name = ?, color = ?, logo = ? WHERE id = ?");
        $stmt->bind_param("sssi", $this->name, $this->color, $this->logo, $this->id);
        $stmt->execute();
    }


    /***************************************************************************
     * Delete team
     *
     * @return void
     */
    public function delete()
    {
        // check id
        if(!self::exists($this->id))
            App::returnError('HTTP/1.1 404', 'Delete Error: team [id = ' . $this->id . '] does not exist.');

        // proceed with delete
        $stmt = $this->conn->prepare("DELETE FROM $this->table WHERE id = ?");
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
    }


    /***************************************************************************
     * Set name
     *
     * @param string $name
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
    }


    /***************************************************************************
     * Set color
     *
     * @param string $color
     * @return void
     */
    public function setColor($color)
    {
        $this->color = $color;
    }


    /***************************************************************************
     * Set logo
     *
     * @param string $logo
     * @return void
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;
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
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }


    /***************************************************************************
     * Get color
     *
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }


    /***************************************************************************
     * Get logo
     *
     * @return string
     */
    public function getLogo()
    {
        return $this->logo;
    }


    /***************************************************************************
     * Add team participant for an event
     *
     * @param Event $event
     * @param int $number
     * @param string $first_name
     * @param string $middle_name
     * @param string $last_name
     * @param string $gender
     * @param string $avatar
     * @return void
     */
    public function addParticipant($event, $number, $first_name, $middle_name, $last_name, $gender = 'male', $avatar = 'no-avatar.jpg')
    {
        require_once 'Participant.php';
        $participant = new Participant();
        $participant->setTeamId($this->id);
        $participant->setEventId($event->getId());
        $participant->setNumber($number);
        $participant->setFirstName($first_name);
        $participant->setMiddleName($middle_name);
        $participant->setLastName($last_name);
        $participant->setGender($gender);
        $participant->setAvatar($avatar);
        $participant->insert();
    }


    /***************************************************************************
     * Get all team participants for an event as array of objects
     *
     * @param Event $event
     * @return Participant[]
     */
    public function getAllParticipants($event)
    {
        require_once 'Participant.php';
        $participants = [];
        foreach(Participant::all($this->id, $event->getId()) as $participant) {
            $participants[] = $participant;
        }
        return $participants;
    }


    /***************************************************************************
     * Get all team participants for an event as array of arrays
     *
     * @param Event $event
     * @return Participant[]
     */
    public function getRowParticipants($event)
    {
        $participants = [];
        foreach(self::getAllParticipants($event) as $participant) {
            $participants[] = $participant->toArray();
        }
        return $participants;
    }


    /***************************************************************************
     * Get events for which the team never showed up, as array of objects
     *
     * @return Event[]
     */
    public function getAllNotShownEvents()
    {
        require_once 'Event.php';

        $table_noshows = (new Event())->getTableNoShows();
        $stmt = $this->conn->prepare("SELECT DISTINCT event_id FROM $table_noshows WHERE team_id = ? ORDER BY event_id");
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
     * Get events for which the team never showed up, as array of arrays
     *
     * @return array
     */
    public function getRowNotShownEvents()
    {
        $events = [];
        foreach($this->getAllNotShownEvents() as $event) {
            $events[] = $event->toArray();
        }

        return $events;
    }


    /***************************************************************************
     * Determine if the team never showed up for a given event
     *
     * @param Event $event
     * @return bool
     */
    public function hasNotShownUpForEvent($event)
    {
        return $event->hasTeamNotShownUp($this);
    }


    /***************************************************************************
     * Get events for which the team was eliminated, as array of objects
     *
     * @return Event[]
     */
    public function getAllEliminatedEvents()
    {
        require_once 'Event.php';

        $table_eliminations = (new Event())->getTableEliminations();
        $stmt = $this->conn->prepare("SELECT DISTINCT event_id FROM $table_eliminations WHERE team_id = ? ORDER BY event_id");
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
     * Get events for which the team was eliminated, as array of arrays
     *
     * @return array
     */
    public function getRowEliminatedEvents()
    {
        $events = [];
        foreach($this->getAllEliminatedEvents() as $event) {
            $events[] = $event->toArray();
        }

        return $events;
    }


    /***************************************************************************
     * Determine if the team is eliminated from a given event
     *
     * @param Event $event
     * @return bool
     */
    public function hasBeenEliminatedFromEvent($event)
    {
        return $event->hasTeamBeenEliminated($this);
    }
}
