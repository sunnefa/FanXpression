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
    Current file: fanx_admin/index.php
    First created: 12.7.2011

 *********************/

/**
 * Handles all admin page requests
 */

//prove that this is a fanx page
define('FANX', true);

//include the init which includes all the necessary functions and classes
include '../fanx_config/init.php';

if(!is_installed()) {
    header('Location: ../install.php');
}
set_error_handler("fanx_errors");
//start our session
session_start();

//start output buffering
ob_start();

//check if a user is logged in
if(!logged_in()) {
    //if no one is logged in we need to display the login form and do things connected to that
    include 'fanx_login.php';
} else {
    //if someone is logged in we can safely go a head and display the dashboard and the menu
    $page = (isset($_GET['page'])) ? $_GET['page'] : 'dashboard';

    include $page . '.php';
    
    ob_start();
    include ADMIN_PAGES . 'menu.php';
    $menu = ob_get_clean();
}

if(isset($_COOKIE['fanx_admin_login']['username'])) $user = $_COOKIE['fanx_admin_login']['username'];
elseif(isset($_SESSION['fanx_admin_login']['username'])) $user = $_SESSION['fanx_admin_login']['username'];

$content = ob_get_clean();

include ADMIN_PAGES . 'index.php';

?>