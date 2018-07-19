<?php

namespace alina\project\Models;

use alina\project\App\DB;
use alina\project\App\QueryBuilder;
//use alina\project\App\Handler;
use alina\project\App\HttpException;
require_once('server_response.php');

class TaskModel {

    private $db;
    private $tablename = "Task";

    public function __construct() {
        $this->db = DB::getInstance();
        $this->builder = new QueryBuilder();
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
        $result = $this->db->fetchData($sql, $params);

        if ($result === false) {
            throw new HttpException("Задача не найдена");
        }

        return $result;
    }

    public function getCurrentTasks() {
//        $sql = "SELECT Task.task_id as task_id, title, date_end_plan, time_plan, SEC_TO_TIME(SUM(TIME_TO_SEC(time_entry))) as time_fact "
//                . "FROM Task LEFT JOIN Entry "
//                . "ON Task.task_id = Entry.task_id "
//                . "GROUP BY Task.task_id";
        $sql = $this->builder
                ->select("Task", ['Task.task_id as task_id', 'title', 'date_end_plan', 'time_plan', 'SEC_TO_TIME(SUM(TIME_TO_SEC(time_entry))) as time_fact'])
                ->left_join("Entry", "Task.task_id", "Entry.task_id")
                ->where()
                ->equals('status_id', 1)
                ->group_by("Task.task_id")
                ->getSql();
        return $this->db->selectAllFromTable($sql);
    }

    public function getEntriesById($id) {
        $sql = "SELECT * FROM Entry WHERE task_id=:task_id ORDER BY date_entry DESC";
        $params = [
            'task_id' => $id
        ];
        return $this->db->fetchAllData($sql, $params);
    }

    public function getFinishedTasks() {
//        $sql = "SELECT Task.task_id as task_id, title, date_end_plan, time_plan, SEC_TO_TIME(SUM(TIME_TO_SEC(time_entry))) as time_fact "
//                . "FROM Task LEFT JOIN Entry "
//                . "ON Task.task_id = Entry.task_id "
//                . "GROUP BY Task.task_id";
        $sql = $this->builder
                ->select("Task", ['Task.task_id as task_id', 'title', 'date_end_plan', 'time_plan', 'SEC_TO_TIME(SUM(TIME_TO_SEC(time_entry))) as time_fact'])
                ->left_join("Entry", "Task.task_id", "Entry.task_id")
                ->where()
                ->equals('status_id', 2)
                ->group_by("Task.task_id")
                ->getSql();
        return $this->db->selectAllFromTable($sql);
    }

    public function getCommentsById($task_id) {
//        $sql = "SELECT comment_text, name, surname, avatar, date_create "
//                . "FROM Comment JOIN Profile "
//                . "ON Comment.user_id = Profile.profile_id "
//                . "WHERE Comment.task_id = :task_id";
        $sql = $this->builder
                ->select("Comment", ['comment_text', 'name', 'surname', 'avatar', 'date_create', 'comment_id'])
                ->join("Profile", "Comment.user_id", "Profile.profile_id")
                ->where()
                ->equals("Comment.task_id", ":task_id")
                ->getSql();
        $params = [
            'task_id' => $task_id
        ];
        return $this->db->fetchAllData($sql, $params);
    }

    public function add($task_data) {
        $sql = $this->builder
                ->insert($this->tablename, $task_data)
                ->getSql();
        if ($this->db->executePreparedQuery($sql, $task_data)) {
            $response = [
                'msg' => TASK_NEW_SUCCESS,
                'modal'=>true,
                'path'=>'/task'
            ];
            return json_encode($response);
        } else {
            return DB_FAIL;
        }
    }

    public function entry($task_data) {
        $sql = $this->builder
                ->insert("Entry", $task_data)
                ->getSql();
        if ($this->db->executePreparedQuery($sql, $task_data)) {
            $response = [
                'msg' => ENTRY_NEW_SUCCESS,
                'modal'=>true,
                'path'=>'/task'
            ];
            return json_encode($response);
        } else {
            return DB_FAIL;
        }
    }

    public function save($task_data) {
        $sql = $this->builder
                ->update($this->tablename, $task_data)
                ->where()
                ->equals("$this->tablename.task_id", ":task_id")
                ->getSql();
        if ($this->db->executePreparedQuery($sql, $task_data)) {
            $response = [
                'msg' => EDIT_SUCCESS,
                'modal'=>true,
                'path'=>'/task'
            ];
            return json_encode($response);
        } else {
            return DB_FAIL;
        }
    }

    public function finish($id) {
        $sql = "UPDATE Task SET status_id = 2 WHERE task_id=:task_id";
        $params = [
            'task_id' => $id
        ];
        return $this->db->executePreparedQuery($sql, $params);
    }

}
