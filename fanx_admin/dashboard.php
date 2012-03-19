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
    Current file: fanx_admin/dashboard.php
    First created: 12.7.2011

 *********************/

/**
 * The dasboard 
 */

//The feature where this page displays 5 news items from fanxpression.com has been put on hold due to time constraints

$posts_model = PostsModel::get_instance();
$pages_model = PagesModel::get_instance();

$all_posts = $posts_model->get_all_posts("status = 'published'");
$posts = array_splice($all_posts, -5, 5);

$all_pages = $pages_model->get_all_pages("status = 'published'");
$pages = array_splice($all_pages, -5, 5);

include ADMIN_PAGES . 'dashboard.php';
?>
