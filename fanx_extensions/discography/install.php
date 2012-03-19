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
    Current file: fanx_sections/discography/install.php
    First created: 8.9.2011

 *********************/

/**
 * Creates the database tables needed for the discography section
 */

$installModel = InstallModel::get_instance();

$success = $installModel->create_tables(EXTENSIONS . 'discography/db_structure.sql');
if(!$success) {
    $_SESSION['errors'][] = 'Could not create tables';
} else {
    $_SESSION['success'] = 'Tables created';
}
?>
