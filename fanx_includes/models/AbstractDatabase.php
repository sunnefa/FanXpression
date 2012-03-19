<?php
/***********************
    FanXpression
    ********************
    Copyright 2011 Sunnefa Lind
    
    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    ********************
    FanXpression version: Version 1.0.3 Beta
    Current file: fanx_includes/models/AbstractDatabase.php
    First created: 11.7.2011

 *********************/

/**
 * An abstract database model. All models inherit from this class
 */
class AbstractDatabase {
    
    /**
     * A reference to the mysql connection
     * @var mysql resource 
     */
    private $connection;
    
    
    /**
     * Constructor connects to the database and saves the connection in a variable
     * @global array $FANX_CONFIG 
     */
    function __construct() {
        global $FANX_CONFIG;
        $this->connection = mysql_connect($FANX_CONFIG['mysql_host'], $FANX_CONFIG['mysql_user'], $FANX_CONFIG['mysql_pass']);

        if(!$this->connection) return ('Crap!' .  mysql_error());

        $select_db = mysql_select_db($FANX_CONFIG['mysql_data'], $this->connection);
        if(!$select_db) return ( $this->get_error());	
    }

    /**
     * Prepares a string to be used in a database query
     * @param string $string
     * @return string
     */
    protected function sanitize($string) {
        if(get_magic_quotes_gpc()) $string = stripslashes($string);
        return mysql_real_escape_string($string, $this->connection);	
    }
    
    /**
     * Returns the last error message thrown by mysql
     * @return string 
     */
    private function get_error() {
        return mysql_error($this->connection);	
    }

    /**
     * Gets data back from the database
     * @global array $FANX_CONFIG
     * @param string $table
     * @param array $fields
     * @param string $where
     * @param boolean $single
     * @param array $joins
     * @return array 
     */
    protected function get_data($table, $fields, $where = NULL, $order = NULL, $single = false, $joins = array()) {
        global $FANX_CONFIG;
        
        $table = $FANX_CONFIG['mysql_prefix'] . '_' . $table;
        
        if($this->table_exists($table)) {
            $sql = "SELECT ";
            $keys = array_keys($fields);
            $last = end($keys);
            
            foreach($fields as $key => $field) {
                $sql .= $field;
                if($key != $last) $sql .= ', ';
            }
            $sql .= " FROM $table";
            
            if(!empty($joins)) {
                foreach($joins as $join_table => $on) {
                    $sql .= " JOIN $join_table ON $on";
                }
            }
            
            if($where) $sql .= " WHERE $where";
            if($order) $sql .= " ORDER BY $order";
            $result = mysql_query($sql, $this->connection);
            if(!$result) return $this->get_error() . ' ' . $sql;
    
        //if(mysql_num_rows($result) == 0) return false;
            if(!$single) return $this->process_data($result);
            else return $this->flat($this->process_data($result));

        } else {
            return false;	
        }
    }
    
    /**
     * Updates data in the database
     * @global array $FANX_CONFIG
     * @param string $table
     * @param array $fields
     * @param array $values
     * @param string $where
     * @return boolean 
     */
    protected function update_data($table, $fields, $values, $where) {
        global $FANX_CONFIG;
        
        $table = $FANX_CONFIG['mysql_prefix'] . '_' . $table;
        
        if($this->table_exists($table)) {
            $sql = 'UPDATE ' . $table . ' SET ';
            $keys = array_keys($fields);
            $last = end($keys);
            foreach($fields as $key => $field) {
                $sql .= $field . " = '" . $this->sanitize($values[$key]) . "'";
                if($key != $last) $sql .= ', ';
            }
            $sql .= ' WHERE ' . $where;
            
            $result = mysql_query($sql, $this->connection);
            if(!$result) return $this->get_error() . ' ' .$sql;
            else return true;
        } else {
            return false;
        }
    }
    
    /**
     * Adds data to the database
     * @global array $FANX_CONFIG
     * @param string $table
     * @param array $fields
     * @param array $values
     * @return int 
     */
    protected function add_data($table, $fields, $values) {
        global $FANX_CONFIG;
        
        $table = $FANX_CONFIG['mysql_prefix'] . '_' . $table;
        
        if($this->table_exists($table)) {
            $sql = 'INSERT INTO ' . $table . ' (';
            $field_keys = array_keys($fields);
            $last_field = end($field_keys);
            foreach($fields as $key => $field) {
                $sql .= $field;
                if($key != $last_field) $sql .= ', ';
            }
            $sql .= ') VALUES (';
            $value_keys = array_keys($values);
            $last_value = end($value_keys);
            foreach($values as $val => $value) {
                $sql .= "'" . $this->sanitize($value) . "'";
                if($val != $last_value) $sql .= ', ';
            }
            $sql .= ')';
            
            $result = mysql_query($sql, $this->connection);
            if(!$result) return $this->get_error() . ' ' . $sql;
            else return mysql_insert_id();
        } else {
            return false;
        }
    }
    
    /**
     * Removes data from the database
     * @global array $FANX_CONFIG
     * @param string $table
     * @param string $where
     * @return boolean 
     */
    protected function remove_data($table, $where) {
        global $FANX_CONFIG;
        
        $table = $FANX_CONFIG['mysql_prefix'] . '_' . $table;
        
        if($this->table_exists($table)) {
            $sql = "DELETE FROM " . $table . " WHERE " . $where;
            $result = mysql_query($sql);
            if(!$result) return $this->get_error() . '  ' . $sql;
            else return true;
        } else {
            return false;
        }
    }

    /**
     * Takes a mysql result resource and puts it into a php readable array
     * @param mysql resource $result
     * @return type 
     */
    private function process_data($result) {
        $data = array();
        while($row = mysql_fetch_assoc($result)) {
            $keys = array_keys($row);
            foreach($keys as $key) {
                if($key == 'date') {
                    if(defined('DATE_FORMAT')) {
                        $row['date'] = date(DATE_FORMAT, $row['date']);
                    }
                }
            }
            $data[] = $row;	
        }

        return $data;
    }

    /**
     * Creates a one dimensional array from a multi-dimensional array
     * @param array $array
     * @param boolean $unique
     * @return array 
     */
    private function flat($array, $unique = false) {
        $single = array();
        $i = 0;
        foreach($array as $one) {
            foreach($one as $key => $value) {
                if($unique == true) {
                    $single[$key . '_' . $i++] = $value;
                } else {
                    $single[$key] = $value;	
                }
            }
        }
        return $single;
    }

    /**
     * Checks if a table exists in the database
     * @param string $table
     * @return boolean 
     */
    private function table_exists($table) {
        $sql = "SHOW TABLES FROM LIKE '$table'";
        
        $result = mysql_query($sql, $this->connection);

        if(!$result) return $this->get_error();
        if(mysql_num_rows($result) == 1) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Executes a complete sql statement, used for installation
     * @param string $statement
     * @return boolean 
     */
    protected function execute_statement($statement) {
        $result = mysql_query($statement, $this->connection);
        
        if(!$result) return $this->get_error();
        else return true;
    }
}
?>