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
    Current file: fanx_admin/logout.php
    First created: 12.7.2011

 *********************/

/**
 * Handles logging a user out
 */

if(isset($_SESSION['fanx_admin_login'])) {
    session_destroy();
}
if(isset($_COOKIE['fanx_admin_login'])) {
    $expire = time() - 30 * 24 * 60 * 60;
    setcookie('fanx_admin_login[username]', '', $expire, '/');
    setcookie('fanx_admin_login[time]', '', $expire, '/');
    setcookie('fanx_admin_login[role]', '', $expire, '/');
}
header('Location: index.php');
?>
