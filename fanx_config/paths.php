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
    Current file: fanx_config/paths.php
    First created: 11.7.2011

 *********************/

/**
 * Defines some important path constants
 */

/**
 * The directory separator
 */
define('DS', DIRECTORY_SEPARATOR);

/**
 * The root path
 */
define('ROOT', dirname(dirname(__FILE__)) . DS);

/**
 * The path to fanx_includes
 */
define('INCLUDE_PATH', ROOT . 'fanx_includes' . DS);

/**
 * The path to admin html templates
 */
define('ADMIN_PAGES', ROOT . 'fanx_admin' . DS . 'pages' . DS);

/**
 * The path to admin javascript folder
 */
define('ADMIN_JS', ROOT . 'fanx_admin' . DS . 'js' . DS);

/**
 * The path to the uploads folder
 */
define('UPLOADS', ROOT . 'fanx_uploads' . DS);

/**
 * The path to the extensions folder
 */
define('EXTENSIONS', ROOT . 'fanx_extensions' . DS);

/**
 * The path to the themes folder
 */
define('THEMES', ROOT . 'fanx_themes' . DS);

/**
 * The path to the default theme folder
 */
define('DEFAULT_THEME', THEMES . 'default' . DS);

/**
 * The path to the docs folder
 */
define('DOCS', ROOT . 'docs' . DS);
?>
