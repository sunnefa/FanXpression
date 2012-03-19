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
    Current file: fanx_includes/models/SettingsModel.php
    First created: 19.7.2011

 *********************/

/**
 * Handles all CRU for the settings table (there is no D in the settings)
 */
class SettingsModel extends AbstractDatabase {
    
    /**
     * The class instance
     * @var object 
     */
    private static $instance;
    
   /**
    * Overriding the parent constructor and defining the settings as constants
    */
    public function __construct() {
        parent::__construct();
        
        if(is_installed()) {
            $settings = $this->get_settings();
            $this->define_settings($settings);
        }
    }
    
    /**
     * Returns an instance of this class
     * @return object
     */
    public static function get_instance() 
    { 
        if (!self::$instance) { 
            self::$instance = new SettingsModel(); 
        } 

        return self::$instance; 
    }
    
    /**
     * Fetches all settings from the database
     * @return array 
     */
    private function get_settings() {
        return $this->get_data('settings', array('setting_name', 'setting_value'));
    }
    
    /**
     * Defines all the loaded settings as constants if they have not already been defined
     * @param array $settings 
     */
    private function define_settings($settings) {
        foreach($settings as $setting) {
            if(!defined(strtoupper($setting['setting_name']))) {
                define(strtoupper($setting['setting_name']), $setting['setting_value']);
            }
        }
    }
    
    /**
     * Updates a single setting based on the name
     * @param string $setting_name
     * @param string $setting_value
     * @return boolean 
     */
    public function update_settings($setting_name, $setting_value) {
        return $this->update_data('settings', array('setting_value'), array($setting_value), "setting_name = '" . $setting_name . "'");
    }
    
    /**
     * Fetches only the setting given in the parameter
     * @param string $setting_name
     * @return boolean
     */
    public function get_single_setting($setting_name) {
        return $this->get_data('settings', array('setting_value'), "setting_name = '$setting_name'");
    }
}
?>