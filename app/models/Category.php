<?php

require_once 'App.php';

class Category extends App
{
    // table
    protected $table = 'categories';

    // properties
    protected $id;
    protected $competition_id;
    protected $slug;
    protected $title;


    /***************************************************************************
     * Category constructor
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
                $this->competition_id = $row['competition_id'];
                $this->slug = $row['slug'];
                $this->title = $row['title'];
            }
        }
    }


    /***************************************************************************
     * Execute find
     *
     * @param $stmt
     * @return Category|false
     */
    private static function executeFind($stmt)
    {
        $stmt->execute();
        $result = $stmt->get_result();
        if($row = $result->fetch_assoc())
            return new Category($row['id']);
        else
            return false;
    }


    /***************************************************************************
     * Find category by id
     *
     * @param int $id
     * @return Category|boolean
     */
    public static function findById($id)
    {
        $category = new Category();
        $stmt = $category->conn->prepare("SELECT id FROM $category->table WHERE id = ?");
        $stmt->bind_param("i", $id);
        return self::executeFind($stmt);
    }


    /***************************************************************************
     * Find category by slug
     *
     * @param string $slug
     * @return Category|boolean
     */
    public static function findBySlug($slug)
    {
        $category = new Category();
        $stmt = $category->conn->prepare("SELECT id FROM $category->table WHERE slug = ?");
        $stmt->bind_param("s", $slug);
        return self::executeFind($stmt);
    }


    /***************************************************************************
     * Convert category object to array
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'id'             => $this->id,
            'competition_id' => $this->competition_id,
            'slug'           => $this->slug,
            'title'          => $this->title
        ];
    }


    /***************************************************************************
     * Get all categories as array of objects
     *
     * @param int $competition_id
     * @return Category[]
     */
    public static function all($competition_id = 0)
    {
        $category = new Category();
        $sql = "SELECT id FROM $category->table ";
        if($competition_id > 0)
            $sql .= "WHERE competition_id = ? ";
        $sql .= "ORDER BY id";
        $stmt = $category->conn->prepare($sql);
        if($competition_id > 0)
            $stmt->bind_param("i", $competition_id);
        $stmt->execute();

        $result = $stmt->get_result();
        $categories = [];
        while($row = $result->fetch_assoc()) {
            $categories[] = new Category($row['id']);
        }
        return $categories;
    }


    /***************************************************************************
     * Get all categories as array of arrays
     *
     * @param int $competition_id
     * @return array
     */
    public static function rows($competition_id = 0)
    {
        $categories = [];
        foreach(self::all($competition_id) as $category) {
            $categories[] = $category->toArray();
        }
        return $categories;
    }


    /***************************************************************************
     * Check if category id exists
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
     * Check if category slug exists
     *
     * @param string $slug
     * @param int $id
     * @return bool
     */
    public static function slugExists($slug, $id = 0)
    {
        $category = new Category();
        $stmt = $category->conn->prepare("SELECT id FROM $category->table WHERE slug = ? AND id != ?");
        $stmt->bind_param("si", $slug, $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return ($result->num_rows > 0);
    }


    /***************************************************************************
     * Insert category
     *
     * @return void
     */
    public function insert()
    {
        // check competition_id
        require_once 'Competition.php';
        if(!Competition::exists($this->competition_id))
            App::returnError('HTTP/1.1 500', 'Insert Error: competition [id = ' . $this->competition_id . '] does not exist.');

        // check slug
        if(self::slugExists($this->slug))
            App::returnError('HTTP/1.1 500', 'Insert Error: category [slug = ' . $this->slug . '] already exists.');

        // proceed with insert
        $stmt = $this->conn->prepare("INSERT INTO $this->table(competition_id, slug, title) VALUES(?, ?, ?)");
        $stmt->bind_param("iss", $this->competition_id, $this->slug, $this->title);
        $stmt->execute();
        $this->id = $this->conn->insert_id;
    }


    /***************************************************************************
     * Update category
     *
     * @return void
     */
    public function update()
    {
        // check id
        if(!self::exists($this->id))
            App::returnError('HTTP/1.1 500', 'Update Error: category [id = ' . $this->id . '] does not exist.');

        // check competition_id
        require_once 'Competition.php';
        if(!Competition::exists($this->competition_id))
            App::returnError('HTTP/1.1 500', 'Insert Error: competition [id = ' . $this->competition_id . '] does not exist.');

        // check slug
        if(self::slugExists($this->slug, $this->id))
            App::returnError('HTTP/1.1 500', 'Update Error: category [slug = ' . $this->slug . '] already exists.');

        // proceed with update
        $stmt = $this->conn->prepare("UPDATE $this->table SET competition_id = ?, slug = ?, title = ? WHERE id = ?");
        $stmt->bind_param("issi", $this->competition_id, $this->slug, $this->title, $this->id);
        $stmt->execute();
    }


    /***************************************************************************
     * Delete category
     *
     * @return void
     */
    public function delete()
    {
        // check id
        if(!self::exists($this->id))
            App::returnError('HTTP/1.1 500', 'Delete Error: category [id = ' . $this->id . '] does not exist.');

        // proceed with delete
        $stmt = $this->conn->prepare("DELETE FROM $this->table WHERE id = ?");
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
    }


    /***************************************************************************
     * Set competition_id
     *
     * @param int $competition_id
     * @return void
     */
    public function setCompetitionId($competition_id)
    {
        $this->competition_id = $competition_id;
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
     * Get competition_id
     *
     * @return int
     */
    public function getCompetitionId()
    {
        return $this->competition_id;
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
     * Get all events as array of objects
     *
     * @return Event[]
     */
    public function getAllEvents()
    {
        require_once 'Event.php';
        return Event::all($this->id);
    }


    /***************************************************************************
     * Get all events as array of arrays
     *
     * @return Event[]
     */
    public function getRowEvents()
    {
        require_once 'Event.php';
        return Event::rows($this->id);
    }


    /***************************************************************************
     * Get parent competition
     *
     * @return Competition
     */
    public function getCompetition()
    {
        require_once 'Competition.php';
        return new Competition($this->competition_id);
    }
}
