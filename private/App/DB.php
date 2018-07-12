<?php
namespace alina\project\App;
use PDO;

class DB
{
	private $server_name;
	private $db_name;
	private $username;
	private $pwd;

	public function __construct(){
		$this->server_name = 'localhost';
		$this->db_name = 'tt_project';
		$this->username = 'root';
		$this->pwd = '';
	}

	private function DBConnect(){
                $pdo = new PDO("mysql:host=$this->server_name;dbname=$this->db_name",
							$this->username, $this->pwd);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return $pdo;
	}

	public function selectAllFromTable($sql_str){
		$connection = $this->DBConnect();
		$statement = $connection->query($sql_str);
		$data = $statement->fetchAll(PDO::FETCH_ASSOC);
		return $data;
	}

	public function executePreparedQuery($sql, $params){
		$connection = $this->DBConnect();
		$statement = $connection->prepare($sql);
		return $statement->execute($params);
	}

        public function fetchData($sql, $params){
            $connect = $this->DBConnect(); 
            $statement = $connect->prepare($sql);
            $statement->execute($params);
            return $statement->fetch(PDO::FETCH_ASSOC);
        }
        
        public function fetchAllData($sql, $params){
            $connect = $this->DBConnect(); 
            $statement = $connect->prepare($sql);
            $statement->execute($params);
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }
}