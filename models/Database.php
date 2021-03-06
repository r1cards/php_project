<?php
// This class deals with the connection to the database
class Database
{
// Database variable
    protected static $_dbInstance = null;

// PDO variable
    protected $_dbHandle;
// This is the constructor for the database class
    private function __construct($username, $password, $host, $database)
    {
        try {
            $this->_dbHandle = new PDO("mysql:host=$host;dbname=$database", $username, $password); // creates the database handle with connection info
            //$this->_dbHandle = new PDO('mysql:host=' . $host . ';dbname=' . $database,  $username, $password); // creates the database handle with connection info

        } catch (PDOException $e) { // catch any failure to connect to the database
            echo $e->getMessage();
        }
    }
// This function returns an instance of the database connection
    public static function getInstance()
    {
        $username = 'sye432';
        $host = 'poseidon.salford.ac.uk';
        $password = 'qMfpq6HpEqCC91v';
        $dbName = 'sye432';

        if (self::$_dbInstance === null) { //checks if the PDO exists
            // creates new instance if not, sending in connection info
            self::$_dbInstance = new self($username, $password, $host, $dbName);
        }

        return self::$_dbInstance;
    }
// Returning the PDO
    public function getdbConnection()
    {
        return $this->_dbHandle; // returns the PDO handle to be used elsewhere
    }

    public function __destruct()
    {
        $this->_dbHandle = null; // destroys the PDO handle when no longer needed
    }
}