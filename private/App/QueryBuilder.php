<?php
namespace alina\project\App;

class QueryBuilder
{
    private $sql;
    
    public function getSql(){
        return $this->sql;
    }
 
    public function insert($tablename, $params){
    	$this->sql = "INSERT INTO " . $tablename;
    	$this->sql .= " (".implode(", ", array_keys($params)).")";
    	$this->sql .= " VALUES (:" . implode(", :", array_keys($params)).") ";
    	return $this;
    }

    public function update($tablename, $params){
        $this->sql = "UPDATE " . $tablename . " SET ";
    	$assigns = [];
    	foreach ($params as $key=>$value){
    		$assigns[] = "$key = :$key";
    	}
    	$this->sql .= implode(", ", $assigns);
    	return $this;
    }

    public function select($tablename, $columns = 0){
    	$this->sql = "SELECT ";
    	if (is_array($columns)){
                $this->sql .= implode(", ", $columns);
    	} else {
                $this->sql .= "* ";
    	}
    	$this->sql .= " FROM " . $tablename;
            $this->joins[$tablename] = $tablename;
    	return $this;
    }

    public function where(){
	   $this->sql .= " WHERE";
	   return $this; 
    }

    public function equals($column, $value = 0){
        if($value){
            $this->sql .= " $column = $value";
        } else {
            $this->sql .= " $column = :$column";
        }	
        return $this; 
    }
	
    public function addAnd() {
	   $this->sql .= " AND";
	   return $this;
    }

    public function limit($quantity) {
	   $this->sql .= " LIMIT $quantity";
	   return $this;
    }
            
    public function join(
        $tablename,
        $selfColumn = null,
        $refColumn = null
    ) {
        $this->sql .= " JOIN $tablename ON";
        $this->sql = $this->equals($selfColumn, $refColumn)->getSql();
        return $this;
    }
    
    public function left_join(
        $tablename,
        $selfColumn = null,
        $refColumn = null
    ) {
        $this->sql .= " LEFT JOIN $tablename ON";
        $this->sql = $this->equals($selfColumn, $refColumn)->getSql();
        return $this;
    }
    public function group_by($column) {
	   $this->sql .= " GROUP BY $column";
	   return $this;
    }
    
}


