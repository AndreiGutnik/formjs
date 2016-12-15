<?php

require_once "config_class.php";

class DataBase{
    
    private $config;
    private $mysqli;

    public function __construct()
    {
        $this->config = new Config();
        $this->mysqli = new mysqli($this->config->host, $this->config->user, $this->config->password, $this->config->db);
        $this->mysqli->query("SET NAMES 'UTF-8'");
    }

    public function query($query)
    {
        return $this->mysqli->query($query);
    }

    public function select($table_name, $fields, $tab_inner="", $inner="", $where="", $order="", $up=true, $limit="")
    {
        for ($i = 0; $i < count($fields); $i++) {
            if ((strpos($fields[$i], "(") === false) && ($fields[$i] != "*")) $fields[$i] = "`" . $fields[$i] . "`";
        }
        $fields = implode(",", $fields);
        $table_name = $this->config->db_prefix . $table_name;
        if (!$order) {
            $order = "ORDER BY `id`";
        } else {
            if ($order != "RAID()") {
                $order = "ORDER BY $order";
                if (!$up) $order .= " DESC";
            } else {
                $order = "ORDER BY $order";
            }
        }
        if ($limit) $limit = "LIMIT $limit";
        if($inner) {
            $inner = "INNER JOIN $tab_inner ON $inner";
            $query = "SELECT $fields FROM $table_name $inner";
            if ($where) {
                $query .= " WHERE $where $order $limit";
            }
        }
        else {
            if ($where) {
                $query = "SELECT $fields FROM $table_name WHERE $where $order $limit";
            } else {
                $query = "SELECT $fields FROM $table_name $order $limit";
            }
        }
        //echo $query;
        $result_set=$this->query($query);
        if(!$result_set) return false;
        $i=0;
        while($row=$result_set->fetch_assoc()) {
            $data[$i]=$row;
            $i++;
        }
        $result_set->close();
        return $data;
    }


    public function insert($table_name, $new_values){
        $table_name=$this->config->db_prefix.$table_name;
        $query="INSERT INTO $table_name (";
        foreach($new_values as $field=>$value) $query.="`".$field."`,";
        $query=substr($query, 0, -1);
        $query.=") VALUES (";
        foreach($new_values as $value) $query.="'".addslashes($value)."',";
        $query=substr($query, 0, -1);
        $query.=")";
        //echo $query;
        return $this->query($query);
    }
}