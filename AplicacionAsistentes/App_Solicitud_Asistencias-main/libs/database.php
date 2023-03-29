<?php

class Database{

    private $host;
    private $db;
    private $user;
    private $password;
    private $charset;

    public function __construct(){
        $this->host = getenv('DDBB_HOST');
        $this->db = getenv('DDBB');
        $this->user = getenv('DDBB_USER');
        $this->password = getenv('DDBB_PASSWORD');
    }

    public function connection(){
        $connection = new mysqli($this->host, $this->user, $this->password, $this->db);

        if (!$connection) {
            die('Error de conexión: ' . $mysqli->connect_error);
            exit();
        }

        return $connection;
    }

    public function closeConnection(){
        mysqli_close($connection);
    }

}

?>