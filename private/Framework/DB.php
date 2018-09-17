<?php

namespace Framework;

use PDO;

class DB {

    private $servername;
    private $db_name;
    private $username;
    private $password;
    private static $instance;

    public function __construct() {
        
    }

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function setDBConfig($db_config) {
        $this->servername = $db_config['servername'];
        $this->db_name = $db_config['db_name'];
        $this->username = $db_config['username'];
        $this->password = $db_config['password'];
    }

    private function DBConnect() {
        $pdo = new PDO("mysql:host=$this->servername;dbname=$this->db_name", $this->username, $this->password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }

    public function selectAllFromTable($sql_str) {
        $connection = $this->DBConnect();
        $statement = $connection->query($sql_str);
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public function executePreparedQuery($sql, $params) {
        $connection = $this->DBConnect();
        $statement = $connection->prepare($sql);
        return $statement->execute($params);
    }

    public function fetchData($sql, $params) {
        $connect = $this->DBConnect();
        $statement = $connect->prepare($sql);
        $statement->execute($params);
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function fetchAllData($sql, $params) {
        $connect = $this->DBConnect();
        $statement = $connect->prepare($sql);
        $statement->execute($params);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

}
