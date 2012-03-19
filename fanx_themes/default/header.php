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
    Current file: fanx_themes/default/header.php
    First created: 26.8.2011

 *********************/

?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $site_title; ?></title>
        <style type="text/css">
            body {
                background:#f1f1f1;
                font-family:Georgia, "Times New Roman", Times, serif;
                font-size:14px;
                color:#000;
            }
            
            #footer {
                text-align: center;
                margin:20px;
            }
            
            #main_container {
                width:850px;
                background:#fff;
                border:1px solid #e1e1e1;
                margin:0 auto;
                padding:20px;
            }
            
            #title_bar {
                height:40px;
                font-size:30px;
                text-align:center;
                margin:5px auto;
            }
            
            #menu_bar {
                height:30px;
                background:#000;
                margin:0;
                padding:5px;
                color:#fff;
            }
            
            #menu_bar a {
                color:#fff;
            }
            
            #pic_bar {
                height:200px;
                border-bottom:2px solid #000;
                border-top:2px solid #000;
                background:url(<?php echo $theme_path; ?>/images/top.jpg) no-repeat;
            }
            
            #content_container {
                width:100%;
            }
            
            a {
                color:#000;
                font-family: Tahoma, serif;
                font-size:12px;
            }
            
            a:hover {
                color: #aaa;
            }
            
            h1 {
                font-size:20px;
                font-weight:700;
                text-transform:uppercase;
                margin-bottom:20px;
            }
            
            h2 {
                font-size:18px;
                font-weight:700;
                margin:10px 0 -5px -5px;
            }
            
            ul.cat_links {
                list-style:none;
                margin:0;
            }
            
            ul.cat_links li {
                border-bottom:1px solid #aaa;
                padding: 5px;
            }
            
            ul.cat_links li a {
                text-decoration:none;
            }
            
            ul.menu {
                list-style:none;
                margin:0;
            }
            
            ul.menu li {
               display:inline;
               margin:5px;
            }
            
            ul.menu li a {
                font-size:15px;
                color:#fff;
                text-decoration:none;
            }
            
            div.single_post {
                margin-bottom:30px;
                padding-bottom:20px;
                border-bottom:1px solid #aaa;
            }
            
            div.comment {
                margin-top:20px;
                border:1px solid #aaa;
            }
            
            textarea {
                height:100px;
                width:400px;
                border:1px solid #bbb;
            }
            
            form ul {
                list-style:none;	
            }

            form ul li {
                padding:10px 0;
            }

            form ul li label {
                display:block;
                float:left;	
                width:150px;
                padding:5px 20px 0 0;
            }
            
            .clear {
                clear:both;
            }
        </style>
    </head>
    <body>
        <div id="main_container">
            <div id="title_bar"><?php echo $site_title; ?></div>
            <div id="pic_bar">&nbsp;</div>
            <div id="menu_bar">
                <?php main_menu(array(
                    'before_menu' => '<ul class="menu">',
                    'after_menu' => '</ul>',
                    'before_link' => '<li>',
                    'after_link' => '&nbsp;&nbsp;&hearts;&nbsp;&nbsp;</li>',
                    'include_home_link' => true
                )); ?>
            </div>
            <div id="content_container">
                    <!-- this is where the dynamic content comes in -->
