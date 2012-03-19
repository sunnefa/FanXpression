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
    Current file: fanx_includes/models/CategoriesModel.php
    First created: 19.7.2011

 *********************/

/**
 * Handles all CRUD related to the categories table
 */
class CategoriesModel extends AbstractDatabase {
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
            self::$instance = new CategoriesModel(); 
        } 

        return self::$instance; 
    } 
    
    /**
     * Fetches all categories, can be limited by the parameters
     * If $recurse is set to true, this function will return a multidimensional array which will need a recursive function
     * @param int $parent
     * @param int $depth
     * @param boolean $recurse
     * @return array
     */
    public function get_all_categories($parent, $depth = 0, $recurse = true) {
        $categories = $this->get_data('categories', array(
            'id',
            'name',
            'description',
            'parent',
            'name AS title'
        ), "parent = $parent");
        if($recurse === true) {
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
        return $this->get_data('categories', array('*'), "$field = '$value'", NULL, true);
    }
    
    /**
     * Updates a single category
     * @param string $name
     * @param string $description
     * @param int $parent
     * @param int $id
     * @return boolean
     */
    public function update_category($name, $description, $parent, $id) {
        return $this->update_data('categories', array('name', 'description', 'parent'), array($name, $description, $parent), "id = $id");
    }
    
    /**
     * Adds a single category
     * @param string $name
     * @param string $description
     * @param int $parent
     * @return int 
     */
    public function add_category($name, $description, $parent) {
        return $this->add_data('categories', array('name', 'description', 'parent'), array($name, $description, $parent)); 
    }
    
    /**
     * Updates a single field on a single category
     * @param string $field
     * @param string $value
     * @param int $id
     * @return boolean
     */
    public function update_single_field($field, $value, $id) {
        return $this->update_data('categories', array($field), array($value), "id = $id");    
    }
    
    /**
     * Removes a single category
     * @param int $id
     * @return boolean 
     */
    public function remove_category($id) {
        return $this->remove_data('categories', "id = $id");
    }
}
?>