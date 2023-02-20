<?php

class App
{
    protected $conn;


    /***************************************************************************
     *  App constructor
     */
    public function __construct()
    {
        if(isset($GLOBALS['conn']))
            $this->conn = $GLOBALS['conn'];
        else
            $this::returnError('HTTP/1.1 500', 'Missing database connection configuration.');
    }


    /***************************************************************************
     * Return an http error
     *
     * @param $header
     * @param $error
     * @return void
     */
    public static function returnError($header, $error)
    {
        header($header);
        die(json_encode([
            'error' => $error
        ]));
    }


    /***************************************************************************
     * Generate slug
     *
     * @param $title
     * @return string
     */
    public static function generateSlug($title)
    {
        // convert the title to lowercase
        $slug = strtolower($title);

        // replace any non-alphanumeric characters with hyphens
        $slug = preg_replace('/[^a-zA-Z0-9]+/', '-', $slug);

        // remove any leading or trailing hyphens
        return trim($slug, '-');
    }
}