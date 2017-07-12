<?php

class DB
{
    private static $_instance = null;
    private $_pdo,
            $_query,
            $_error = false,
            $_results,
            $_count = 0;

    private function __construct()
    {
        try{
            $this->_pdo = new PDO('mysql:host=' . Config::get('mysql/host') . ';dbname=' .Config::get('mysql/db'), Config::get('mysql/username'), Config::get('mysql/password'));

        }catch (PDOException $e){
            die($e->getMessage());
        }
    }

    public static function getInstance(){
        if (!isset(self::$_instance)){
            self::$_instance = new DB();
        }

        return self::$_instance;
    }


    public function query($sql, $parms = array()){
        $this->_error = false;
        if($this->_query = $this->_pdo->prepare($sql)){
            $x = 1;

            if (count($parms)){
                foreach ($parms as $parm){
                    $this->_query->bindValue($x, $parm);
                    $x++;
                }
            }

            if ($this->_query->execute()){
                $this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
                $this->_count = $this->_query->rowCount();
            }else {
                $this->_error = true;
            }

        }
        return $this;
    }

    public function action($action, $table, $where = array())
    {
        if (count($where) === 3) {
            $opetators = array('=', '>', '<', '>=', '<=');

            $field     = $where[0];
            $operator  = $where[1];
            $value     = $where[2];

            if (in_array($operator, $opetators)) {
                $sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";

                if (!$this->query($sql, array($value))->error()) {
                    return $this;
                }
            }
        }

        return false;
    }

    public function getAll($table)
    {
        $sql = "SELECT * FROM {$table}";
        if (!$this->query($sql)->error()) {
            return $this;
        }

        return false;
    }

    public function getAllWithPagination($table, $page = null, $perPage = null, $where = null)
    {
        $page = $page ? $page : 1;
        $perPage = $perPage && $perPage <= 50 ? $perPage : 20;
        $start = ($page > 1) ? ($page * $perPage) - $perPage : 0;
        $where = $where ? "WHERE {$where}" : '';
        $sql = "SELECT * FROM (SELECT * FROM {$table} LIMIT {$start}, {$perPage}) {$table} $where";
        if (!$this->query($sql)->error()) {
            return $this;
        }

        return $sql;
    }

    public function getPages($table, $count = null, $where = null)
    {
        $count = $count ? "COUNT({$count})" : '*';
        $where = $where ? 'WHERE '.$where : '';
        $sql = "SELECT $count as total FROM {$table} {$where}";
        if (!$this->query($sql)->error()) {
            return $this->firstResult()->total;
        }
        return false;
    }

    public function getAllWithSql($sql)
    {
        if (!$this->query($sql)->error()) {
            return $this;
        }

        return false;
    }

    public function getJoin_2_TableData($tableToJoin, $tableWithJoin, $where, $joinValue1 = null, $joinValue2 = null, $order = null)
    {
        $tableToJoin_s = $tableToJoin.'s';
        $tableWithJoin_s = $tableWithJoin.'s';
        $joinValue1 = $joinValue1 ? $tableToJoin_s.'.'.$joinValue1 : $tableToJoin_s.'.'.$tableWithJoin.'_id';
        $joinValue2 = $joinValue2 ? $tableWithJoin_s.'.'.$joinValue2 : $tableWithJoin_s.'.'.'id';
        $order = $order ? $order : '';

        $sql = "SELECT * FROM {$tableToJoin_s} JOIN {$tableWithJoin_s} ON {$joinValue1} = {$joinValue2} WHERE $where $order";
        if (!$this->query($sql)->error()) {
            return $this;
        }

        return $sql;
    }


    public function get($table, $where)
    {
        return $this->action('SELECT *', $table, $where);
    }

    public function delete($table, $where)
    {
        return $this->action('DELETE', $table, $where);
    }

    public function insert($table, $fields = array())
    {

        $keys = array_keys($fields);
        $values = null;
        $x = 1;

        foreach ($fields as $field) {
            $values .= '?';
            if ($x < count($fields)) {
                $values .= ', ';
            }
            $x++;
        }

        $sql = "INSERT INTO {$table} (`" . implode('`, `', $keys) . "`) VALUES ({$values})";
        
        if (!$this->query($sql, $fields)->error()) {
            return true;
        }
        return false;
    }

    public function update($table, $id, $fields)
    {
        $set = '';
        $x = 1;

        foreach($fields as $name => $value){
            $set .= "{$name} = ?";
            if($x < count($fields)){
                $set .= ', ';
            }
            $x++;
        }
        
        $sql = "UPDATE {$table} SET $set WHERE id = $id";
        
        if(!$this->query($sql, $fields)->error()){
            return true;
        }
        return $sql;
    }

    public function results()
    {
        return $this->_results;
    }

    public function firstResult()
    {
        return $this->_results[0];
    }

    public function error()
    {
        return $this->_error;
    }

    public function count()
    {
        return $this->_count;
    }

}