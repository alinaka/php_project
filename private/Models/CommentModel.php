<?php

namespace alina\project\Models;

use alina\project\App\DB;
use alina\project\App\QueryBuilder;

class CommentModel {

    private $db;
    private $tablename = "Comment";
    private $builder;

    public function __construct() {
        $this->db = new DB();
        $this->builder = new QueryBuilder();
    }

    public function addComment($comment_data) {
        /* $sql = "INSERT INTO $this->tablename (comment_text, user_id, task_id) "
          . "VALUES (:comment_text, :user_id, :task_id)"; */
        $sql = $this->builder
                ->insert($this->tablename, $comment_data)
                ->getSql();
        if ($this->db->executePreparedQuery($sql, $comment_data)) {
            return "Comment_success";
        } else {
            return "Comment_new_fail";
        }
    }

    public function getNewComments($last_update) {
        /* $sql = "SELECT comment_text, name, surname, avatar, date_create "
          . "FROM Comment JOIN Profile "
          . "ON Comment.user_id = Profile.profile_id "
          . "WHERE Comment.task_id = 2 "
          . "AND date_create >= :date_create"; */
        $sql = $this->builder
                ->select($this->tablename, ['comment_text', 'name', 'surname', 'avatar', 'date_create'])
                ->join("Profile", "$this->tablename.user_id", "Profile.profile_id ")
                ->where()
                ->equals("$this->tablename.task_id", 2)
                ->addAnd()
                ->equals('date_create')
                ->getSql();
        $params = [
            'date_create' => $last_update
        ];
        return $this->db->fetchAllData($sql, $params);
    }

    public function delete($id) {
        $sql = "DELETE FROM Comment WHERE comment_id=:comment_id";
        $params = [
            'comment_id' => $id
        ];
        return $this->db->executePreparedQuery($sql, $params);
    }

}
