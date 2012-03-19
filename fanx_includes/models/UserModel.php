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
    Current file: fanx_includes/models/UserModel.php
    First created: 11.7.2011

 *********************/

/**
 * Handles all CRUD related to the users table
 */
class UserModel extends AbstractDatabase {
    
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
            self::$instance = new UserModel(); 
        } 

        return self::$instance; 
    } 
    
    /**
     * Gets all user data from the database
     * @return array 
     */
    public function get_all_users() {
        return $this->get_data('users', array("
        id, username, email, 
        password, bio, avatar, 
        date_registered AS date, status
        "));
        
    }
    
    /**
     * Returns a single user
     * @param string $field
     * @param string $value
     * @return array 
     */
    public function get_single_user($field, $value) {
        return $this->get_data('users', array("
        id, role, username, email, 
        password, bio, avatar, 
        date_registered AS date, status
        "), "$field = '$value'", NULL, true);
    }
    
    /**
     * Inserts a single user into the database
     * @param string $user_name
     * @param string $user_email
     * @param string $user_password
     * @param string $user_bio
     * @param string $user_role
     * @param int $date
     * @param string $status
     * @return int 
     */
    public function add_user($user_name, $user_email, $user_password, $user_bio, $user_role, $date, $status) {
        return $this->add_data('users', array('username', 'email', 'password', 'bio', 
            'role', 'date_registered', 'status'), array($user_name, $user_email, $user_password, $user_bio, $user_role, $date, $status));
    }
    
    /**
     * Updates a single user in the database
     * @param int $user_id
     * @param string $user_name
     * @param string $user_email
     * @param string $user_password
     * @param string $user_avatar
     * @param string $user_bio
     * @param string $user_role
     * @return boolean
     */
    public function update_user($user_id, $user_name, $user_email, $user_password, $user_avatar, $user_bio, $user_role) {
        return $this->update_data('users', array('username', 'email', 'password', 'avatar', 'bio', 'role'), array($user_name, $user_email, $user_password, $user_avatar, $user_bio, $user_role), 'id = ' . $user_id);

    }
    
    /**
     * Updates a single field in a single user's records
     * @param string $field
     * @param string $value
     * @param int $id
     * @return boolean
     */
    public function update_single_field($field, $value, $id) {
        return $this->update_data('users', array($field), array($value), 'id = ' . $id);
    }
    
    /**
     * Puts the userinfo through validation
     * @param array $user_info
     * @return string 
     */
    public function validate_user_info($user_info) {
        $errors = array();
        if(isset($user_info['username'])) {
            if(!is_username($user_info['username'])) {
                $errors[] = 'Username must only contain alphanumeric characters, hyphens and underscores';
            } elseif($this->get_single_user('username', $user_info['username'])) {
                $errors[] = 'That username is taken';
            }
        }
        
        if(isset($user_info['password'])) {
            if(!strong_password($user_info['password'])) {
                $errors[] = 'Password must be longer than 8 characters and contain at least 1 number, 1 lowercase character and 1 uppercase character';
            }
        }
        
        if(isset($user_info['email'])) {
            if(!is_email($user_info['email'])) {
                $errors[] = 'That is not a valid email address';
            } elseif($this->get_single_user('email', $user_info['email'])) {
                $errors[] = 'That email address is taken';
            }
        }
        
        if(!empty($errors)) {
            return $errors;
        } else {
            return true;
        }
    }
}
?>
