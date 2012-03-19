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
    Current file: fanx_sections/discography/tpl/albums.php
    First created: 31.8.2011

 *********************/

/**
 * The albums template
 */
?>
<h2><?php echo $title; ?></h2>
<?php if(!empty($feature_cover)): ?>
<p><?php echo show_album_cover($feature_cover); ?></p>
<?php endif; ?>
<?php echo show_song_list($songs, array(
    'before_list' => '<ul>',
    'after_list' => '</ul>',
    'before_song' => '<li>',
    'after_song' => '</li>'
)); ?>
