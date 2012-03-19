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
    Current file: fanx_sections/discography/functions.php
    First created: 23.8.2011

 *********************/

/**
 * Functions needed with the discography section 
 */

/**
 * Recursively displays a list of categories
 * @param array $categories
 * @param string $template
 * @param itn $parent 
 */
function recurse_disco_cats($categories, $template, $parent = 0) {
    foreach($categories as $category) {
        $selected = ($parent == $category['id']) ? 'selected' : '';
        include 'templates/cats_' . $template . '.php';
        if(!empty($category['children'])) {
            recurse_disco_cats($category['children'], $template, $parent);
        }
    }
}

/**
 * Returns a string of formatted categories
 * @global object $disco_view
 * @param array $links
 * @param array $params
 * @return string 
 */
function show_discography_categories($links, $params) {
    global $disco_view;
    return $disco_view->show_discography_categories($links, $params);
}

/**
 * Returns a string of formatted albums
 * @global object $disco_view
 * @param array $links
 * @param array $params
 * @return string 
 */
function show_album_list($links, $params) {
    global $disco_view;
    return $disco_view->show_album_list($links, $params);
}

/**
 * Returns a formatted string with an album cover as an img tag
 * @param string $cover
 * @return string 
 */
function show_album_cover($cover) {
    return '<img src="' . URL . $cover . '" alt="Cover" />';
}

/**
 * Returns a formatted string of songs
 * @global object $disco_view
 * @param array $songs
 * @param array $params
 * @return string 
 */
function show_song_list($songs, $params) {
    global $disco_view;
    return $disco_view->show_song_list($songs, $params);
}

/**
 * Recursively adds albums to an array of categories
 * @global object $disco_model
 * @param array $categories
 * @param array $cats
 * @return array
 */
function get_recursive_albums($categories, $cats = array()) {
    global $disco_model;
    foreach($categories as $key => $category) {
        $cats[$key] = $category;
        $cats[$key]['albums'] = $disco_model->get_all_albums("a.category_id = " . $category['id']);
        if(!empty($category['children'])) {
            $cats[$key]['children'] = get_recursive_albums($category['children'], $cats);
        }
    }
    return $cats;
}
?>
