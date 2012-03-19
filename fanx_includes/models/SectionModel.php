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
    Current file: fanx_includes/models/SectionModel.php
    First created: 23.8.2011

 *********************/

/**
 * Handles all CRUD related to the sections table but not related to each individual section
 */
class SectionModel extends AbstractDatabase {
    
    /**
     * This class instance
     * @var object
     */
    private static $instance;
    
    /**
     * Returns an instance of this class
     * @return object
     */
    public static function get_instance() 
    { 
        if (!self::$instance) { 
            self::$instance = new SectionModel(); 
        } 

        return self::$instance; 
    }
    
    /**
     * Fetches all sections
     * @global array $FANX_CONFIG
     * @param string $where
     * @return array 
     */
    public function get_all_sections($where = "") {
        global $FANX_CONFIG;
        return $this->get_data('sections AS s', array(
            's.id',
            's.title',
            's.name',
            's.active',
            's.cat_id',
            '(SELECT c.name FROM ' . $FANX_CONFIG['mysql_prefix'] . '_categories AS c WHERE s.cat_id = c.id) AS category'
        ), $where);
    }
    
    /**
     * Fetches a single section
     * @global array $FANX_CONFIG
     * @param string $field
     * @param string $value
     * @return array 
     */
    public function get_single_section($field, $value) {
        global $FANX_CONFIG;
        return $this->get_data('sections AS s', array(
            's.id',
            's.title',
            's.name',
            's.active',
            's.cat_id',
            '(SELECT c.name FROM ' . $FANX_CONFIG['mysql_prefix'] . '_categories AS c WHERE s.cat_id = c.id) AS category'
        ), "$field = '$value'", NULL, true);
    }
    
    /**
     * Gets a list of inactive sections, both that have never been active and once that have been deactivated
     * @return array
     */
    public function get_inactive_sections() {
        $folders = scandir(EXTENSIONS);
        $invisible = array('..', '.', '.DS_Store', 'Thumbs.db');
        $section = array();
        foreach($folders as $key => $folder) {
            if(!in_array($folder, $invisible)) {
                $exists = $this->get_single_section('name', $folder);
                if(empty($exists)) {
                    $section[$key]['name'] = $folder;
                    $section[$key]['id'] = null;
                    $section[$key]['title'] = null;
                    $section[$key]['cat_id'] = null;
                    $section[$key]['category'] = null;
                    $section[$key]['active'] = 0;
                } else if($exists['active'] == 0) {
                    $section[] = $exists;
                }
            }
        }
        return $section;
    }
    
    /**
     * Updates a section
     * @param int $id
     * @param string $title
     * @param int $cat
     * @return boolean 
     */
    public function update_section($id, $title, $cat) {
        return $this->update_data('sections', array('title', 'cat_id'), array($title, $cat), "id = '$id'");
    }
    
    /**
     * Adds a section
     * @param string $title
     * @param string $name
     * @param int $active
     * @param int $cat
     * @return int
     */
    public function add_section($title, $name, $active, $cat) {
        return $this->add_data('sections', array('title', 'name', 'active', 'cat_id'), array($title, $name, $active, $cat));
    }
    
    /**
     * Removes a single section... incomplete
     * @param string $field
     * @param string $value
     * @return boolean 
     */
    public function remove_section($field, $value) {
        
    }
    
    /**
     * Updates a single field on a single section
     * @param int $id
     * @param string $field
     * @param string $value
     * @return boolean
     */
    public function update_single_section_field($id, $field, $value) {
        return $this->update_data('sections', array($field), array($value), "id = '$id'");
    }
}
?>