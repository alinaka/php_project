<?php
namespace alina\project\Models;
use alina\project\App\DB;
use alina\project\App\QueryBuilder;

class EntryModel
{
    private $db;
    private $tablename = "Entry";

    public function __construct(){
        $this->db = new DB();
        $this->builder = new QueryBuilder();
    }
    
    public function entry($task_data){
        $sql = $this->builder
                ->insert($this->tablename, $task_data)
                ->getSql();
        if ($this->db->executePreparedQuery($sql, $task_data)){
            return "Entry_new_success";
        } else {
            return "Entry_new_fail";
        }
    }
    
}