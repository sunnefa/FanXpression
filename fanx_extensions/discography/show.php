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
    Current file: fanx_sections/discography/show.php
    First created: 29.8.2011

 *********************/

/**
 * Controller for showing the discography to the front end
 */

include EXTENSIONS . 'discography/functions.php';
$_GET['name'] = 'discography';
$disco_model = DiscographyModel::get_instance();
$disco_view = DiscographyView::get_instance();

$show = (isset($url[3])) ? $url[3] : 'cat_list';

switch($show) {
    case 'cat_list':
        $all_categories = $disco_model->get_all_categories(0);
        
        $all = get_recursive_albums($all_categories);
        
        $disco_view->name = $section['title'];
        
        ob_start();
        $disco_view->show_recursive($all);
        echo ob_get_clean();
        
        break;
    
    case 'album':
        $single_album = $disco_model->get_single_album('id', $url[4]);
        if(empty($single_album)) {
            $disco_view->site_title .= ' - 404 - Not Found';
            $disco_view->get_404();
        } else {
            $songs = $disco_model->get_all_songs('s.album_id = ' . $url[4]);
            $single_album['songs'] = $songs;
            $theme_class->site_title .= ' - ' . $single_album['title'];
            $disco_view->show_disco_album($single_album);
        }
        break;
    
    default:
        $disco_view->site_title = ' - 404 - Not Found';
        $disco_view->get_404();
}
?>
