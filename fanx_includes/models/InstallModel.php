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
    Current file: fanx_includes/models/InstallModel.php
    First created: 8.9.2011

 *********************/

/**
 * Handles creating tables and executing complete statements
 */
class InstallModel extends AbstractDatabase {
    
    /**
     * An instance of this class
     * @var object
     */
    private static $instance;
    
    /**
     * Returns an instance of this class
     * @return object
     */
    public static function get_instance() {
        if (!self::$instance) { 
            self::$instance = new InstallModel(); 
        } 

        return self::$instance; 
    }
    
    /**
     *
     * @global array $FANX_CONFIG
     * @param string $schema
     * @return boolean 
     */
    public function create_tables($schema) {
        global $FANX_CONFIG;
        $sql = file_get_contents($schema);
        $sql = str_replace('$prefix', $FANX_CONFIG['mysql_prefix'], $sql);
        $sql = str_replace('$time', time(), $sql);
        $statements = explode(';', $sql);
        
        $success = array();
        
        foreach($statements as $statement) {
            $result = $this->execute_statement($statement);
            if($result == true) {
                $success[] = true;
            } else {
                $success[] = false;
            }
        }
        
        if(in_array(false, $success)) {
            return false;
        } else {
            return true;
        }
    }
}

?>
