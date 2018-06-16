<?php
namespace alina\project\Models;
use alina\project\App\DB;

class TaskModel
{
    private $db;
    private $tablename = "Task";

    public function __construct(){
        $this->db = new DB();
    }

    public function getAllTasks(){
        $sql_str = "SELECT * FROM $this->tablename WHERE author_id = 1";
        return $this->db->selectAllFromTable($sql_str);
    }

    public function getTaskById($id) {
        if (empty($id)) {
            return false;
        }
        $sql_str = "SELECT * FROM $this->tablename
                    WHERE task_id = :id";
        $params = [
            'id' => $id
        ];
        return $this->db->fetchData($sql_str, $params);
    }

    public function addTask($task_data){
        $sql = "INSERT INTO $this->tablename (title, description, date_start_plan, date_end_plan, time_plan, author_id)
        VALUES (:title, :description, :date_start_plan, :date_end_plan, :time_plan, :author_id)";
        return $this->db->executePreparedQuery($sql, $task_data);
    }
}
?>