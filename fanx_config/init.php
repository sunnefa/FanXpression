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
    Current file: fanx_config/init.php
    First created: 11.7.2011

 *********************/

error_reporting('E_OFF');

/**
 * Includes some neccesary files
 */

if(!defined('FANX')) {
    die('Not in FanXpression...');
}

/**
 * The path definitions
 */
include 'paths.php';

/**
 * The database definitions
 */
if(!defined('INSTALLING')) {
    include 'db_config.php';
}


/**
 * Some important helper functions
 */
include INCLUDE_PATH . 'functions.php';

/**
 * Initiate the settings
 */
$settings = SettingsModel::get_instance();

/**
 * Setting the default timezone
 */
if(defined('TIMEZONE')) {
    date_default_timezone_set(TIMEZONE);
} else {
    date_default_timezone_set('UTC');
}
?>