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
    Current file: fanx_themes/default/categories.php
    First created: 27.8.2011

 *********************/

?>
<h1><?php echo $name; ?></h1>
<p><?php echo $description; ?></p>
<?php show_category_links($links, array(
    'before_link_list' => '<ul class="cat_links">',
    'after_link_list' => '</ul>',
    'before_link' => '<li>',
    'after_link' => '</li>'
)); ?>
