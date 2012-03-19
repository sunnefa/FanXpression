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
    Current file: fanx_sections/discography/tpl/categories.php
    First created: 31.8.2011

 *********************/

/**
 * The categories template
 */
?>
<h1><?php echo $name; ?></h1>
<?php echo show_discography_categories($data, array(
    'before_list' => '<ul style="clear:both; list-style:none;">',
    'after_list' => '</ul>',
    'before_category' => '<li style="clear:both;">',
    'after_category' => '</li>',
    'recurse' => true,
    'alb_list' => array(
        'before_list' => '<ul style="list-style:none;">',
        'after_list' => '<li style="clear:both;"></li></ul>',
        'before_album' => '<li style="float:left; width:100px; margin:20px;">',
        'after_album' => '</li>',
        'max_cover_size' => '100'
    )
)); ?>
