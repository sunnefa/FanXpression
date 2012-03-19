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
    Current file: fanx_sections/discography/DiscographyModel.php
    First created: 23.8.2011

 *********************/

/**
 * Handles all CRUD related to the discography section tables
 */
class DiscographyModel extends AbstractDatabase {
    
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
            self::$instance = new DiscographyModel(); 
        } 

        return self::$instance; 
    }
    
    /**
     * Fetches all categories
     * If the $recurse parameter is set to true, the function returns a multidimensional array that requires recursion to be displayed
     * @param int $parent
     * @param int $depth
     * @param boolean $recurse
     * @return array 
     */
    public function get_all_categories($parent, $depth = 0, $recurse = true) {
        $categories = $this->get_data('disco_categories', array('*'), "parent = $parent");
        if($recurse == true) {
            foreach($categories as $key => $category) {
                $categories[$key]['depth'] = $depth;
                $categories[$key]['children'] = $this->get_all_categories($category['id'], $depth+1);
            }
        }
        return $categories;
    }
    
    /**
     * Fetches a single category
     * @param string $field
     * @param string $value
     * @return array 
     */
    public function get_single_category($field, $value) {
        return $this->get_data('disco_categories', array('*'), "$field = '$value'", NULL, true);
    }
    
    /**
     * Adds a single category
     * @param string $name
     * @param string $description
     * @param int $parent
     * @return int 
     */
    public function add_category($name, $description, $parent) {
        return $this->add_data('disco_categories', array('name', 'description', 'parent'), array($name, $description, $parent));
    }
    
    /**
     * Updates a single category
     * @param int $id
     * @param string $name
     * @param stirng $description
     * @param int $parent
     * @return boolean 
     */
    public function update_category($id, $name, $description, $parent) {
        return $this->update_data('disco_categories', array('name', 'description', 'parent'), array($name, $description, $parent), "id = $id");
    }
    
    /**
     * Removes a single category
     * @param int $id
     * @return boolean
     */
    public function remove_category($id) {
        return $this->remove_data('disco_categories', "id = $id");
    }
    
    /**
     * Updates a single field on a single category's record
     * @param int $id
     * @param string $field
     * @param string $value
     * @return boolean 
     */
    public function update_single_category_field($id, $field, $value) {
        return $this->update_data('disco_categories', array($field), array($value), "id = $id");
    }
    
    /**
     * Fetches all albums
     * @global array $FANX_CONFIG
     * @param string $where
     * @return array 
     */
    public function get_all_albums($where = '') {
        global $FANX_CONFIG;
        return $this->get_data('disco_albums AS a', array(
            'a.id',
            'a.title',
            'a.release_date AS date',
            'a.feature_cover',
            '(SELECT c.name FROM ' . $FANX_CONFIG['mysql_prefix'] . '_disco_categories AS c WHERE c.id = a.category_id) AS category'
        ), $where);
    }
    
    /**
     * Fetches a single album
     * @global array $FANX_CONFIG
     * @param string $field
     * @param string $value
     * @return array 
     */
    public function get_single_album($field, $value) {
        global $FANX_CONFIG;
        return $this->get_data('disco_albums AS a', array(
            'a.id',
            'a.title',
            'a.release_date AS date',
            'a.feature_cover',
            '(SELECT c.id FROM ' . $FANX_CONFIG['mysql_prefix'] . '_disco_categories AS c WHERE c.id = a.category_id) AS category_id'
        ), "$field = '$value'", NULL, true);
    }
    
    /**
     * Updates a single album
     * @param int $id
     * @param string $title
     * @param int $release_date
     * @param string $feature_cover
     * @param int $category
     * @return boolean 
     */
    public function update_album($id, $title, $release_date, $feature_cover, $category) {
        return $this->update_data('disco_albums', array('title', 'release_date', 'feature_cover', 'category_id'), array($title, $release_date, $feature_cover, $category), "id = $id");
    }
    
    /**
     * Adds a single album
     * @param string $title
     * @param int $release_date
     * @param string $feature_cover
     * @param int $category
     * @return int 
     */
    public function add_album($title, $release_date, $feature_cover, $category) {
        return $this->add_data('disco_albums', array('title', 'release_date', 'feature_cover', 'category_id'), array($title, $release_date, $feature_cover, $category));
    }
    
    /**
     * Removes an album
     * @param string $field
     * @param string $value
     * @return boolean 
     */
    public function remove_album($field, $value) {
        return $this->remove_data('disco_albums', "$field = '$value'");
    }
    
    /**
     * Updates a single field on a single album's record
     * @param int $id
     * @param string $field
     * @param string $value
     * @return boolean 
     */
    public function update_single_album_field($id, $field, $value) {
        return $this->update_data('disco_albums', array($field), array($value), "id = '$id'");
    }
    
    /**
     * Fetches all songs
     * @global array $FANX_CONFIG
     * @param string $where
     * @return array 
     */
    public function get_all_songs($where = "") {
        global $FANX_CONFIG;
        return $this->get_data('disco_songs AS s', array(
            's.id',
            's.title',
            's.length',
            's.composer',
            's.lyrics',
            '(SELECT a.title FROM ' . $FANX_CONFIG['mysql_prefix'] . '_disco_albums AS a WHERE a.id = s.album_id) AS album'
        ), $where);
    }
    
    /**
     * Fetches a single song
     * @global array $FANX_CONFIG
     * @param string $field
     * @param string $value
     * @return array 
     */
    public function get_single_song($field, $value) {
        global $FANX_CONFIG;
        return $this->get_data('disco_songs AS s', array(
            's.id',
            's.title',
            's.length',
            's.composer',
            's.lyrics',
            '(SELECT a.title FROM ' . $FANX_CONFIG['mysql_prefix'] . '_disco_albums AS a WHERE a.id = s.album_id) AS album',
            's.album_id'
        ), "$field = '$value'", NULL, true);
    }
    
    /**
     * Updates a single song
     * @param int $id
     * @param stirng $title
     * @param string $length
     * @param string $composer
     * @param string $lyrics
     * @param int $album
     * @return boolean 
     */
    public function update_song($id, $title, $length, $composer, $lyrics, $album) {
        return $this->update_data('disco_songs', array('title', 'length', 'composer', 'lyrics', 'album_id'), array($title, $length, $composer, $lyrics, $album), "id = $id");
    }
    
    /**
     * Adds a single song
     * @param string $title
     * @param string $length
     * @param string $composer
     * @param string $lyrics
     * @param int $album
     * @return int 
     */
    public function add_song($title, $length, $composer, $lyrics, $album) {
        return $this->add_data('disco_songs', array('title', 'length', 'composer', 'lyrics', 'album_id'), array($title, $length, $composer, $lyrics, $album));
    }
    
    /**
     * Removes a single song
     * @param stirng $field
     * @param string $value
     * @return boolean 
     */
    public function remove_song($field, $value) {
        return $this->remove_data('disco_songs', "$field = '$value'");
    }
}
?>