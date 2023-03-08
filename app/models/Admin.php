<?php

require_once 'User.php';

class Admin extends User
{
    /***************************************************************************
     * Admin constructor
     *
     * @param $username
     * @param $password
     */
    public function __construct($username = '', $password = '')
    {
        parent::__construct($username, $password, 'admin');
    }


    /***************************************************************************
     * Execute find
     *
     * @param $stmt
     * @return Admin|false
     */
    private static function executeFind($stmt)
    {
        $stmt->execute();
        $result = $stmt->get_result();
        if($row = $result->fetch_assoc())
            return new Admin($row['username'], $row['password']);
        else
            return false;
    }


    /***************************************************************************
     * Find admin by id
     *
     * @param int $id
     * @return Admin|boolean
     */
    public static function findById($id)
    {
        $admin = new Admin();
        $stmt = $admin->conn->prepare("SELECT username, password FROM $admin->table WHERE id = ?");
        $stmt->bind_param("i", $id);
        return self::executeFind($stmt);
    }


    /***************************************************************************
     * Convert admin object to array
     *
     * @param $append
     * @return array
     */
    public function toArray($append = [])
    {
        return parent::toArray($append);
    }


    /***************************************************************************
     * Get all admins as array of objects
     *
     * @return Admin[]
     */
    public static function all()
    {
        $admin = new Admin();
        $sql = "SELECT username, password FROM $admin->table ORDER BY number";
        $stmt = $admin->conn->prepare($sql);
        $stmt->execute();

        $result = $stmt->get_result();
        $admins = [];
        while($row = $result->fetch_assoc()) {
            $admins[] = new Admin($row['username'], $row['password']);
        }
        return $admins;
    }


    /***************************************************************************
     * Get all admins as array of arrays
     *
     * @return array
     */
    public static function rows()
    {
        $admins = [];
        foreach(self::all() as $admin) {
            $admins[] = $admin->toArray();
        }
        return $admins;
    }


    /***************************************************************************
     * Tabulate an event
     *
     * @param Event $event
     * @return array
     */
    private function tabulateEvent($event)
    {
        // initialize $result
        $result = [
            'technicals' => [],
            'judges'     => [],
            'teams'      => []
        ];

        // get all teams
        $teams = $event->getAllTeams();

        // get all technicals for this event
        $technicals = $event->getAllTechnicals();
        $technicals_total = sizeof($technicals);

        // get all judges for this event
        $judges = $event->getAllJudges();
        $judges_total = sizeof($judges);

        // get $judge_ranks for the event
        $judge_ranks = [];
        foreach($judges as $judge) {
            $key_judge = 'judge_' . $judge->getId();
            $judge_ranks[$key_judge] = $judge->getEventRanks($event);
        }

        // prepare $unique_total_fractional_ranks and $unique_final_adjustments
        $unique_total_fractional_ranks = [];
        $unique_final_adjustments = [];

        foreach($teams as $team) {
            $key_team = 'team_' . $team->getId();

            // initialize $team_row
            $team_row = $team->toArray();

            // =================================================================
            // get team deductions
            $team_row['deductions'] = [
                'inputs'  => [],
                'total'   => 0,
                'average' => 0
            ];

            foreach($technicals as $technical) {
                $key_technical = 'technical_' . $technical->getId();

                // append $technical to $result['technicals']
                $result['technicals'][$key_technical] = $technical->toArray();

                // get technical's total team deductions
                $technical_total = ($technical->getEventTeamDeduction($event, $team))->getValue();
                $team_row['deductions']['inputs'][$key_technical] = $technical_total;

                // increment deductions total
                $team_row['deductions']['total'] += $technical_total;
            }

            // compute for deductions average
            if($technicals_total > 0)
                $team_row['deductions']['average'] = $team_row['deductions']['total'] / $technicals_total;

            // =================================================================
            // get team ratings
            $team_row['ratings'] = [
                'inputs'  => [],
                'total'   => 0,
                'average' => 0
            ];

            $rank_total = [
                'dense'      => 0,
                'fractional' => 0
            ];
            foreach($judges as $judge) {
                $key_judge = 'judge_' . $judge->getId();

                // append $judge to $result['judges']
                $result['judges'][$key_judge] = $judge->toArray();

                // get judge's total team ratings and ranks
                $judge_total = $judge->getEventTeamRating($event, $team);
                $judge_rank = $judge_ranks[$key_judge][$key_team];
                $team_row['ratings']['inputs'][$key_judge] = [
                    'final' => $judge_total,
                    'rank'  => $judge_rank
                ];

                // increment ratings total
                $team_row['ratings']['total'] += $judge_total['deducted'];

                // increment $rank_total
                $rank_total['dense'] += $judge_rank['dense'];
                $rank_total['fractional'] += $judge_rank['fractional'];
            }

            // compute for ratings average
            if($judges_total > 0)
                $team_row['ratings']['average'] = $team_row['ratings']['total'] / $judges_total;


            // =================================================================
            // store team rank

            $team_row['rank'] = [
                'total'   => $rank_total,
                'initial' => [
                    'dense'      => 0,
                    'fractional' => 0
                ],
                'final'   => [
                    'adjustment' => 0,
                    'dense'      => 0,
                    'fractional' => 0
                ]
            ];
            $team_row['points'] = 0;

            // push $team_row to $result['teams']
            $result['teams'][$key_team] = $team_row;

            // push to $unique_total_fractional_ranks
            if(!in_array($rank_total['fractional'], $unique_total_fractional_ranks))
                $unique_total_fractional_ranks[] = $rank_total['fractional'];
        }

        // sort $unique_total_fractional_ranks
        sort($unique_total_fractional_ranks);

        // gather $rank_group (for getting fractional rank)
        $rank_group = [];
        foreach($result['teams'] as $key => $team) {
            // get dense rank
            $dense_rank = 1 + array_search($result['teams'][$key]['rank']['total']['fractional'], $unique_total_fractional_ranks);
            $result['teams'][$key]['rank']['initial']['dense'] = $dense_rank;

            // push $key to $rank_group
            $key_rank = 'rank_' . $dense_rank;
            if(!isset($rank_group[$key_rank]))
                $rank_group[$key_rank] = [];
            $rank_group[$key_rank][] = $key;
        }

        // get initial fractional rank
        $ctr = 0;
        for($i = 0; $i < sizeof($unique_total_fractional_ranks); $i++) {
            $key = 'rank_' . ($i + 1);
            $group = $rank_group[$key];
            $size = sizeof($group);
            $fractional_rank = $ctr + ((($size * ($size + 1)) / 2) / $size);

            // write $fractional_rank to $group members
            for($j = 0; $j < $size; $j++) {
                $result['teams'][$group[$j]]['rank']['initial']['fractional'] = $fractional_rank;

                // compute final average
                $final_adjustment = $fractional_rank - ($result['teams'][$group[$j]]['ratings']['average'] * 0.01);
                $result['teams'][$group[$j]]['rank']['final']['adjustment'] = $final_adjustment;

                // push to $unique_final_adjustments
                if(!in_array($final_adjustment, $unique_final_adjustments))
                    $unique_final_adjustments[] = $final_adjustment;
            }

            $ctr += $size;
        }

        // sort $unique_final_adjustments
        sort($unique_final_adjustments);
        // gather $rank_group (for getting fractional rank)
        $rank_group = [];
        foreach($result['teams'] as $key => $team) {
            // get dense rank
            $dense_rank = 1 + array_search($result['teams'][$key]['rank']['final']['adjustment'], $unique_final_adjustments);
            $result['teams'][$key]['rank']['final']['dense'] = $dense_rank;

            // push $key to $rank_group
            $key_rank = 'rank_' . $dense_rank;
            if(!isset($rank_group[$key_rank]))
                $rank_group[$key_rank] = [];
            $rank_group[$key_rank][] = $key;
        }

        // get final fractional rank and points
        $ctr = 0;
        for($i = 0; $i < sizeof($unique_final_adjustments); $i++) {
            $key = 'rank_' . ($i + 1);
            $group = $rank_group[$key];
            $size = sizeof($group);
            $fractional_rank = $ctr + ((($size * ($size + 1)) / 2) / $size);

            // write $fractional_rank to $group members and accumulate points
            $points = 0;
            for($j = 0; $j < $size; $j++) {
                $result['teams'][$group[$j]]['rank']['final']['fractional'] = $fractional_rank;

                if($point = $event->getRankPoint($ctr + $j + 1))
                    $points += $point->getValue();
            }

            // assign points to $group members
            $points = $points / $size;
            for($j = 0; $j < $size; $j++) {
                $result['teams'][$group[$j]]['points'] = $points;
            }

            $ctr += $size;
        }

        // return $result
        return $result;
    }


    /***************************************************************************
     * Tabulate a category
     *
     * @param Category $category
     * @return array
     */
    private function tabulateCategory($category)
    {
        // initialize $result
        $result = [
            'events' => [],
            'teams'  => []
        ];

        // get all teams
        require_once 'Team.php';
        $teams = Team::all();
        foreach($teams as $team) {
            $key_team = 'team_' . $team->getId();
            $arr_team = $team->toArray();
            $arr_team['inputs'] = [];
            $arr_team['points'] = 0;
            $arr_team['rank'] = [
                'dense'      => 0,
                'fractional' => 0
            ];
            $result['teams'][$key_team] = $arr_team;
        }

        // tabulate each event in category
        foreach($category->getAllEvents() as $event) {
            // append event to $result['events']
            $key_event = $event->getSlug();
            if(!isset($result['events'][$key_event]))
                $result['events'][$key_event] = $event->toArray();

            // tabulate event
            $tabulated_event = $this->tabulateEvent($event);

            // accumulate team inputs and points
            foreach($teams as $team) {
                $key_team = 'team_' . $team->getId();
                $team_rank = $tabulated_event['teams'][$key_team]['rank'];
                $team_points = $tabulated_event['teams'][$key_team]['points'];
                $result['teams'][$key_team]['points'] += $team_points;

                // append $team rank and points to $result['teams'][$key_team]['inputs']
                $result['teams'][$key_team]['inputs'][$key_event] = [
                    'rank'   => [
                        'dense'      => $team_rank['final']['dense'],
                        'fractional' => $team_rank['final']['fractional'],
                    ],
                    'points' => $team_points
                ];
            }
        }

        // gather $unique_team_points
        $unique_team_points = [];
        foreach($result['teams'] as $result_team) {
            if(!in_array($result_team['points'], $unique_team_points))
                $unique_team_points[] = $result_team['points'];
        }

        // sort $unique_team_points
        rsort($unique_team_points);

        // gather $rank_group (for getting fractional rank)
        $rank_group = [];
        foreach($result['teams'] as $key => $team) {
            // get dense rank
            $dense_rank = 1 + array_search($result['teams'][$key]['points'], $unique_team_points);
            $result['teams'][$key]['rank']['dense'] = $dense_rank;

            // push $key to $rank_group
            $key_rank = 'rank_' . $dense_rank;
            if(!isset($rank_group[$key_rank]))
                $rank_group[$key_rank] = [];
            $rank_group[$key_rank][] = $key;
        }

        // get final fractional rank and points
        $ctr = 0;
        for($i = 0; $i < sizeof($unique_team_points); $i++) {
            $key = 'rank_' . ($i + 1);
            $group = $rank_group[$key];
            $size = sizeof($group);
            $fractional_rank = $ctr + ((($size * ($size + 1)) / 2) / $size);

            // write $fractional_rank to $group members
            for($j = 0; $j < $size; $j++) {
                $result['teams'][$group[$j]]['rank']['fractional'] = $fractional_rank;
            }

            $ctr += $size;
        }

        // return $result
        return $result;
    }


    /***************************************************************************
     * Tabulate a competition
     *
     * @param Competition $competition
     * @return array
     */
    private function tabulateCompetition($competition)
    {
        // initialize $result
        $result = [
            'categories' => [],
            'teams'      => []
        ];

        // get all teams
        require_once 'Team.php';
        $teams = Team::all();
        foreach($teams as $team) {
            $key_team = 'team_' . $team->getId();
            $arr_team = $team->toArray();
            $arr_team['inputs'] = [];
            $arr_team['points'] = 0;
            $arr_team['rank'] = [
                'dense'      => 0,
                'fractional' => 0
            ];
            $result['teams'][$key_team] = $arr_team;
        }

        // tabulate each category in competition
        foreach($competition->getAllCategories() as $category) {
            // append category to $result['categories']
            $key_category = $category->getSlug();
            if(!isset($result['categories'][$key_category]))
                $result['categories'][$key_category] = $category->toArray();

            // tabulate category
            $tabulated_category = $this->tabulateCategory($category);

            // accumulate team inputs and points
            foreach($teams as $team) {
                $key_team = 'team_' . $team->getId();
                $team_rank = $tabulated_category['teams'][$key_team]['rank'];
                $team_points = $tabulated_category['teams'][$key_team]['points'];
                $result['teams'][$key_team]['points'] += $team_points;

                // append $team rank and points to $result['teams'][$key_team]['inputs']
                $result['teams'][$key_team]['inputs'][$key_category] = [
                    'rank'   => $team_rank,
                    'points' => $team_points
                ];
            }
        }

        // gather $unique_team_points
        $unique_team_points = [];
        foreach($result['teams'] as $result_team) {
            if(!in_array($result_team['points'], $unique_team_points))
                $unique_team_points[] = $result_team['points'];
        }

        // sort $unique_team_points
        rsort($unique_team_points);

        // gather $rank_group (for getting fractional rank)
        $rank_group = [];
        foreach($result['teams'] as $key => $team) {
            // get dense rank
            $dense_rank = 1 + array_search($result['teams'][$key]['points'], $unique_team_points);
            $result['teams'][$key]['rank']['dense'] = $dense_rank;

            // push $key to $rank_group
            $key_rank = 'rank_' . $dense_rank;
            if(!isset($rank_group[$key_rank]))
                $rank_group[$key_rank] = [];
            $rank_group[$key_rank][] = $key;
        }

        // get final fractional rank and points
        $ctr = 0;
        for($i = 0; $i < sizeof($unique_team_points); $i++) {
            $key = 'rank_' . ($i + 1);
            $group = $rank_group[$key];
            $size = sizeof($group);
            $fractional_rank = $ctr + ((($size * ($size + 1)) / 2) / $size);

            // write $fractional_rank to $group members
            for($j = 0; $j < $size; $j++) {
                $result['teams'][$group[$j]]['rank']['fractional'] = $fractional_rank;
            }

            $ctr += $size;
        }

        // return $result
        return $result;
    }


    /***************************************************************************
     * Tabulate all
     *
     * @return array
     */
    private function tabulateAll()
    {
        // initialize $result
        $result = [
            'competitions' => [],
            'teams'        => []
        ];

        // get all teams
        require_once 'Team.php';
        $teams = Team::all();
        foreach($teams as $team) {
            $key_team = 'team_' . $team->getId();
            $arr_team = $team->toArray();
            $arr_team['inputs'] = [];
            $arr_team['points'] = 0;
            $arr_team['rank'] = [
                'dense'      => 0,
                'fractional' => 0
            ];
            $result['teams'][$key_team] = $arr_team;
        }

        // tabulate each competition
        require_once 'Competition.php';
        foreach(Competition::all() as $competition) {
            // append competition to $result['competitions']
            $key_competition = $competition->getSlug();
            if(!isset($result['competitions'][$key_competition]))
                $result['competitions'][$key_competition] = $competition->toArray();

            // tabulate competition
            $tabulated_competition = $this->tabulateCompetition($competition);

            // accumulate team inputs and points
            foreach($teams as $team) {
                $key_team = 'team_' . $team->getId();
                $team_rank   = $tabulated_competition['teams'][$key_team]['rank'];
                $team_points = $tabulated_competition['teams'][$key_team]['points'];
                $result['teams'][$key_team]['points'] += $team_points;

                // append $team rank and points to $result['teams'][$key_team]['inputs']
                $result['teams'][$key_team]['inputs'][$key_competition] = [
                    'rank'   => $team_rank,
                    'points' => $team_points
                ];
            }
        }

        // gather $unique_team_points
        $unique_team_points = [];
        foreach($result['teams'] as $result_team) {
            if(!in_array($result_team['points'], $unique_team_points))
                $unique_team_points[] = $result_team['points'];
        }

        // sort $unique_team_points
        rsort($unique_team_points);

        // gather $rank_group (for getting fractional rank)
        $rank_group = [];
        foreach($result['teams'] as $key => $team) {
            // get dense rank
            $dense_rank = 1 + array_search($result['teams'][$key]['points'], $unique_team_points);
            $result['teams'][$key]['rank']['dense'] = $dense_rank;

            // push $key to $rank_group
            $key_rank = 'rank_' . $dense_rank;
            if(!isset($rank_group[$key_rank]))
                $rank_group[$key_rank] = [];
            $rank_group[$key_rank][] = $key;
        }

        // get final fractional rank and points
        $ctr = 0;
        for($i = 0; $i < sizeof($unique_team_points); $i++) {
            $key = 'rank_' . ($i + 1);
            $group = $rank_group[$key];
            $size = sizeof($group);
            $fractional_rank = $ctr + ((($size * ($size + 1)) / 2) / $size);

            // write $fractional_rank to $group members
            for($j = 0; $j < $size; $j++) {
                $result['teams'][$group[$j]]['rank']['fractional'] = $fractional_rank;
            }

            $ctr += $size;
        }

        // return $result
        return $result;
    }


    /***************************************************************************
     * Tabulate
     *
     * @param Competition|Category|Event $entity
     * @return array
     */
    public function tabulate($entity = null)
    {
        // tabulate event
        require_once 'Event.php';
        if($entity instanceof Event) {
            if(Event::exists($entity->getId()))
                return $this->tabulateEvent($entity);
        }

        // tabulate category
        require_once 'Category.php';
        if($entity instanceof Category) {
            if(Category::exists($entity->getId()))
                return $this->tabulateCategory($entity);
        }

        // tabulate competition
        require_once 'Competition.php';
        if($entity instanceof Competition) {
            if(Competition::exists($entity->getId()))
                return $this->tabulateCompetition($entity);
        }

        // tabulate all
        if($entity == null)
            return $this->tabulateAll();

        // default
        return [];
    }
}
