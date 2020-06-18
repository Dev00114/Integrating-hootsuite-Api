<?php
/*
* Mysql database class - only one connection alowed
*/
namespace HootSuite;

use mysqli;

class TableManager {
    protected $_connection;
    private static $_instance; //The single instance

    protected $_host;
    protected $_username;
    protected $_password;
    protected $_database;
    protected $_port;
    protected $_table;

    protected $_debugMode;
    /*
    Get an instance of the Database
    @return Instance
    */
    public static function getInstance() {

        if(!self::$_instance) { // If no instance then make one
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    // Constructor
    public function __construct($debugMode = false) {

        global $hootsuite_config;
        $this->_host = $hootsuite_config['database']['host'];
        $this->_username = $hootsuite_config['database']['username'];
        $this->_password = $hootsuite_config['database']['password'];
        $this->_port = $hootsuite_config['database']['port'];
        $this->_database = $hootsuite_config['database']['db_name'];
        $this->_table = $hootsuite_config['database']['hootsuite_tbl'];

        $this->_debugMode = $debugMode;

        $this->_connection = new mysqli($this->_host, $this->_username, 
            $this->_password, $this->_database, $this->_port);
    
        // Error handling
        if(mysqli_connect_error()) {
            trigger_error("Failed to conencto to MySQL: " . mysql_connect_error(),
                 E_USER_ERROR);
        }

        $create_sql = "CREATE TABLE {$this->_table} (
            id INT AUTO_INCREMENT PRIMARY KEY, 
            socialid INT unsigned NOT NULL, 
            title VARCHAR(200) NOT NULL, 
            description blob NOT NULL, 
            media_path VARCHAR(500) NOT NULL, 
            mime_type VARCHAR(10),
            posted_id VARCHAR(100) NOT NULL, 
            tags VARCHAR(500) NOT NULL, 
            scheduled_time DATETIME NOT NULL, 
            state VARCHAR(20) NOT NULL, 
            created_at DATETIME NOT NULL, 
            deleted_at DATETIME NOT NULL)";
        $this->_connection->query($create_sql);
    }

    // Get mysqli connection
    public function getConnection() {
        return $this->_connection;
    }

    public function getMedias($conditions)
    {
        $cond = "";
        foreach ($conditions as $key => $value)
            $cond .= "{$key}='{$value}' AND ";
        $cond .= "deleted_at=''";

        $query = $this->_connection->query("SELECT * FROM  {$this->_table} WHERE {$cond}");
        $result = [];

        while($row = $query->fetch_assoc())
            array_push($result, $row);
        return $result;
    }


    /**
    valid mimeType video/mp4, image/gif, image/jpeg, image/jpg, image/png.
    **/
    public function addMedia($scheduledSendTime, $socialid, $title, $description, $media_path, $mime_type='video/mp4')
    {
        $sql = "INSERT INTO {$this->_table}(scheduled_time, socialid, title, description, media_path, mime_type, created_at) VALUES(
            '{$scheduledSendTime}', '{$socialid}', '{$title}', '{$description}', '{$media_path}', '{$mime_type}', NOW()
        )";
        $insert_state = $this->_connection->query($sql);

        $this->debug('Add Media:: insert Sql ==>   '.$sql);

        if($insert_state)
        {
            $row = $this->_connection->query("SELECT MAX(id) as inserted_id FROM {$this->_table}")->fetch_assoc();
            return $row['inserted_id'];
        } else {
            return $this->_connection->error;
        }
    }

    public function postedMessage($draft_id, $posted_id)
    {
        $state = $this->_connection->query("UPDATE {$this->_table} SET posted_id='{$posted_id}' WHERE id='{$draft_id}'");
        if($state)
            return $posted_id;
        else
            return $this->_connection->error;
    }

    public function deleteMedia($draft_id)
    {
        $state = $this->_connection->query("UPDATE {$this->_table} SET deleted_at=NOW() WHERE id='{$draft_id}'");
        if($state === TRUE) {
            return $draft_id;
        } else {
            return $_connection->error;
        }
    }

    public function setState($posted_id, $state)
    {
        $state  = $this->_connection->query("UPDATE {$this->_table} SET state='{$state}' WHERE posted_id='{$posted_id}'");
        return !!$state;
    }

    public function debug($message)
    {
        if(!! $this->_debugMode) echo $message;
    }
}
