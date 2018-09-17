<?php

namespace alina\project\Models;

use Framework\DB;
use Framework\QueryBuilder;

class ReportModel {

    private $db;

    public function __construct() {
        $this->db = DB::getInstance();
        $this->builder = new QueryBuilder();
    }

    public function getEntriesById($id) {
        //$sql = "SELECT Task.task_id as task_id, title, date_entry, time_entry FROM Task JOIN Entry ON Task.task_id = Entry.task_id WHERE Task.task_id=:task_id";
        $sql = $this->builder
                ->select("Task", ['Task.task_id as task_id', 'title', 'date_entry', 'time_entry'])
                ->join("Entry", "Task.task_id", "Entry.task_id")
                ->where()
                ->equals('Task.task_id', ':task_id')
                ->getSql();
        $params = [
            'task_id' => $id
        ];
        return $this->db->fetchAllData($sql, $params);
    }

    public function getEntries() {
        //$sql = "SELECT Task.task_id as task_id, SEC_TO_TIME(SUM(TIME_TO_SEC(time_entry))) as time_sum FROM Task JOIN Entry on Task.task_id = Entry.task_id";
        $sql = $this->builder
                ->select("Task", ['Task.task_id as task_id', 'SEC_TO_TIME(SUM(TIME_TO_SEC(time_entry))) as time_sum'])
                ->join("Entry", "Task.task_id", "Entry.task_id")
                ->getSql();
        return $this->db->selectAllFromTable($sql);
    }

    public function getTasksLists() {
        //$sql = "SELECT task_id, title FROM Task";
        $sql = $this->builder
                ->select("Task", ['task_id', 'title'])
                ->getSql();
        return $this->db->selectAllFromTable($sql);
    }

    public function getAllTime($from, $to) {
        //все задачи
//        $sql = "SELECT Task.task_id, title, SEC_TO_TIME(SUM(TIME_TO_SEC(time_entry))) as time_sum FROM Task JOIN Entry ON Task.task_id=Entry.task_id AND date_entry>=:from 
//                    AND date_entry<=:to GROUP BY Task.task_id";
        $sql = "SELECT Task.task_id, title, time_entry, SEC_TO_TIME(SUM(TIME_TO_SEC(time_entry))) as time_sum "
                . "FROM Task JOIN Entry "
                . "ON Task.task_id=Entry.task_id "
                . "AND date_entry>=:from "
                . "AND date_entry<=:to "
                . "GROUP BY Task.task_id";
        $params = [
            'from' => $from,
            'to' => $to
        ];
        return $this->db->fetchAllData($sql, $params);
    }

    public function getTimeOnTask($id, $from, $to) {
        $sql = "SELECT Task.task_id, title, SEC_TO_TIME(SUM(TIME_TO_SEC(time_entry))) as time_sum, date_entry "
                . "FROM Task JOIN Entry "
                . "ON Task.task_id=Entry.task_id "
                . "AND Task.task_id=:task_id 
                    AND date_entry>=:from 
                    AND date_entry<=:to "
                . "GROUP BY date_entry";
        $params = [
            'task_id' => $id,
            'from' => $from,
            'to' => $to
        ];
        return $this->db->fetchAllData($sql, $params);
    }

}
