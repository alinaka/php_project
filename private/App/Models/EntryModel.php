<?php

namespace alina\project\Models;

use Framework\DB;
use Framework\QueryBuilder;

require_once('server_response.php');

class EntryModel {

    private $db;
    private $tablename = "Entry";

    public function __construct() {
        $this->db = DB::getInstance();
        $this->builder = new QueryBuilder();
    }

    public function entry($task_data) {
        $sql = $this->builder
                ->insert($this->tablename, $task_data)
                ->getSql();
        if ($this->db->executePreparedQuery($sql, $task_data)) {
            $response = json_encode([
                'msg' => ENTRY_NEW_SUCCESS,
                'modal' => true,
                'path' => '/task'
            ]);
        } else {
            $response = DB_FAIL;
        }
        return $response;
    }

    public function delete($id,$task_id) {
        $sql = "DELETE FROM Entry WHERE entry_id=:entry_id";
        $params = [
            'entry_id' => $id
        ];
        if ($this->db->executePreparedQuery($sql, $params)) {
            $response = json_encode([
                'msg' => ENTRY_DELETE_SUCCESS,
                'modal' => true,
                'path' => "/task/show/$task_id"
            ]);
        } else {
            $response = DB_FAIL;
        }
        return $response;
    }

    public function save($entry_data) {
        $sql = $this->builder
                ->update($this->tablename, $entry_data)
                ->where()
                ->equals("entry_id", ":entry_id")
                ->getSql();
        $task_id = $entry_data['task_id'];
        if ($this->db->executePreparedQuery($sql, $entry_data)) {
            $response = json_encode([
                'msg' => EDIT_SUCCESS,
                'modal' => true,
                'path' => "/task/show/$task_id"
            ]);
        } else {
            $response = DB_FAIL;
        }
        return $response;
    }

    public function getEntryById($id) {
        $sql = "SELECT * FROM Entry WHERE entry_id=:entry_id";
        $params = [
            'entry_id' => $id
        ];
        return $this->db->fetchData($sql, $params);
    }

}
