<?php

require_once 'App.php';

class Competition extends App
{
    // table
    protected $table = 'competitions';

    // properties
    protected $id;
    protected $slug;
    protected $title;


    /***************************************************************************
     * Competition constructor
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
                $this->setSlug($row['slug']);
                $this->setTitle($row['title']);
            }
        }
    }


    /***************************************************************************
     * Execute find
     *
     * @param $stmt
     * @return Competition|false
     */
    private static function executeFind($stmt)
    {
        $stmt->execute();
        $result = $stmt->get_result();
        if($row = $result->fetch_assoc())
            return new Competition($row['id']);
        else
            return false;
    }


    /***************************************************************************
     * Find competition by id
     *
     * @param int $id
     * @return Competition|boolean
     */
    public static function findById($id)
    {
        $competition = new Competition();
        $stmt = $competition->conn->prepare("SELECT id FROM $competition->table WHERE id = ?");
        $stmt->bind_param("i", $id);
        return self::executeFind($stmt);
    }


    /***************************************************************************
     * Find competition by slug
     *
     * @param string $slug
     * @return Competition|boolean
     */
    public static function findBySlug($slug)
    {
        $competition = new Competition();
        $stmt = $competition->conn->prepare("SELECT id FROM $competition->table WHERE slug = ?");
        $stmt->bind_param("s", $slug);
        return self::executeFind($stmt);
    }


    /***************************************************************************
     * Convert competition object to array
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'id'    => $this->id,
            'slug'  => $this->slug,
            'title' => $this->title
        ];
    }


    /***************************************************************************
     * Get all competitions as array of objects
     *
     * @return Competition[]
     */
    public static function all()
    {
        $competition = new Competition();
        $sql = "SELECT id FROM $competition->table ORDER BY id";
        $stmt = $competition->conn->prepare($sql);
        $stmt->execute();

        $result = $stmt->get_result();
        $competitions = [];
        while($row = $result->fetch_assoc()) {
            $competitions[] = new Competition($row['id']);
        }
        return $competitions;
    }


    /***************************************************************************
     * Get all competitions as array of arrays
     *
     * @return array
     */
    public static function rows()
    {
        $competitions = [];
        foreach(self::all() as $competition) {
            $competitions[] = $competition->toArray();
        }
        return $competitions;
    }


    /***************************************************************************
     * Check if competition id exists
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
     * Check if competition slug exists
     *
     * @param string $slug
     * @param int $id
     * @return bool
     */
    public static function slugExists($slug, $id = 0)
    {
        $competition = new Competition();
        $stmt = $competition->conn->prepare("SELECT id FROM $competition->table WHERE slug = ? AND id != ?");
        $stmt->bind_param("si", $slug, $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return ($result->num_rows > 0);
    }


    /***************************************************************************
     * Insert competition
     *
     * @return void
     */
    public function insert()
    {
        // check id
        if(self::exists($this->id))
            App::returnError('HTTP/1.1 409', 'Insert Error: competition [id = ' . $this->id . '] already exists.');

        // check slug
        if(self::slugExists($this->slug))
            App::returnError('HTTP/1.1 409', 'Insert Error: competition [slug = ' . $this->slug . '] already exists.');

        // proceed with insert
        $stmt = $this->conn->prepare("INSERT INTO $this->table(slug, title) VALUES(?, ?)");
        $stmt->bind_param("ss", $this->slug, $this->title);
        $stmt->execute();
        $this->id = $this->conn->insert_id;
    }


    /***************************************************************************
     * Update competition
     *
     * @return void
     */
    public function update()
    {
        // check id
        if(!self::exists($this->id))
            App::returnError('HTTP/1.1 404', 'Update Error: competition [id = ' . $this->id . '] does not exist.');

        // check slug
        if(self::slugExists($this->slug, $this->id))
            App::returnError('HTTP/1.1 409', 'Update Error: competition [slug = ' . $this->slug . '] already exists.');

        // proceed with update
        $stmt = $this->conn->prepare("UPDATE $this->table SET slug = ?, title = ? WHERE id = ?");
        $stmt->bind_param("ssi", $this->slug, $this->title, $this->id);
        $stmt->execute();
    }


    /***************************************************************************
     * Delete competition
     *
     * @return void
     */
    public function delete()
    {
        // check id
        if(!self::exists($this->id))
            App::returnError('HTTP/1.1 404', 'Delete Error: competition [id = ' . $this->id . '] does not exist.');

        // proceed with delete
        $stmt = $this->conn->prepare("DELETE FROM $this->table WHERE id = ?");
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
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
     * Get all categories as array of objects
     *
     * @return Category[]
     */
    public function getAllCategories()
    {
        require_once 'Category.php';
        return Category::all($this->id);
    }


    /***************************************************************************
     * Get all categories as array of arrays
     *
     * @return array
     */
    public function getRowCategories()
    {
        require_once 'Category.php';
        return Category::rows($this->id);
    }
}
