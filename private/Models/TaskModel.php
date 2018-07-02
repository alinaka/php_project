<?php
namespace alina\project\Models;
use alina\project\App\DB;
use alina\project\App\QueryBuilder;

class TaskModel
{
    private $db;
    private $tablename = "Task";

    public function __construct(){
        $this->db = new DB();
        $this->builder = new QueryBuilder();
    }

    public function getAllTasks(){
        $sql = $this->builder
                ->select($this->tablename)
                ->where()
                ->equals('author_id', 1)
                ->getSql();
        return $this->db->selectAllFromTable($sql);
    }

    public function getTaskById($id) {
        $sql = $this->builder
                ->select($this->tablename)
                ->where()
                ->equals('task_id')
                ->getSql();
        $params = [
            'task_id' => $id
        ];
        return $this->db->fetchData($sql, $params);
    }

    public function add($task_data){
        $sql = $this->builder
                ->insert($this->tablename, $task_data)
                ->getSql();
        if ($this->db->executePreparedQuery($sql, $task_data)){
            return "Task_new_success";
        } else {
            return "Task_new_fail";
        }
    }
    
    public function save($task_data){
        $sql = $this->builder
                ->update($this->tablename, $task_data)
                ->where()
                ->equals('task_id')
                ->getSql();
        if($this->db->executePreparedQuery($sql, $task_data)){
            return "Task_edit_success";
        } else {
            return "Task_edit_fail";
        }
    }
}