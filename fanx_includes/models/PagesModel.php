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
    Current file: fanx_includes/models/PagesModel.php
    First created: 22.7.2011

 *********************/

/**
 * Handles all CRUD related to the pages table
 */
class PagesModel extends AbstractDatabase {
    
    /**
     * An instance of this class
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
            self::$instance = new PagesModel(); 
        } 

        return self::$instance; 
    }
    
    /**
     * Fetches all pages from the database but can be limited with the parameter
     * @global array $FANX_CONFIG
     * @param string $where
     * @return array
     */
    public function get_all_pages($where = '') {
        global $FANX_CONFIG;
        return $this->get_data('pages AS p', array(
            'p.id',
            'p.title',
            'p.content',
            "p.date",
            'p.user_id',
            'p.status',
            's.id AS category_id',
            's.name AS category'
        ), $where, 'p.date DESC', false, array($FANX_CONFIG['mysql_prefix'] . '_categories AS s' => 's.id = p.cat_id'));
    }
    
    /**
     * Fetches a single page
     * @global array $FANX_CONFIG
     * @param string $field
     * @param string $value
     * @return array 
     */
    public function get_single_page($field, $value) {
        global $FANX_CONFIG;
        return $this->get_data('pages AS p', array(
            'p.id',
            'p.title',
            'p.content',
            "p.date",
            'p.user_id',
            '(SELECT u.username FROM ' . $FANX_CONFIG['mysql_prefix'] . '_users AS u WHERE u.id = p.user_id) AS user',
            'p.status',
            's.id AS category_id',
            's.name AS category'   
        ), "$field = '$value'", NULL, true, array($FANX_CONFIG['mysql_prefix'] . '_categories AS s' => 's.id = p.cat_id'));
    }
    
    /**
     * Adds a single page to the database
     * @param string $title
     * @param string $content
     * @param int $category
     * @param int $date
     * @param int $user
     * @param string $status
     * @return boolean 
     */
    public function add_page($title, $content, $category, $date, $user, $status) {
        return $this->add_data('pages', array('title', 'content', 'cat_id', 'date', 'user_id', 'status'), array($title, $content, $category, $date, $user, $status));
    }
    
    /**
     * Updates a single page in the database
     * @param int $id
     * @param string $title
     * @param string $content
     * @param int $category
     * @param string $status
     * @return boolean 
     */
    public function update_page($id, $title, $content, $category, $status) {
        return $this->update_data('pages', array('title', 'content', 'cat_id', 'status'), array($title, $content, $category, $status), "id = $id");
    }
    
    /**
     * Updates a single field on a single page
     * @param string $field
     * @param string $value
     * @param int $id
     * @return boolean 
     */
    public function update_single_field($field, $value, $id) {
        return $this->update_data('pages', array($field), array($value), 'id = ' . $id);
    }
    
    /**
     * Deletes a single page from the database
     * @param int $id
     * @return boolean
     */
    public function delete_page($id) {
        return $this->remove_data('pages', "id = $id");
    }
    
}
?>