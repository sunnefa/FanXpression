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
    Current file: fanx_sections/discography/templates/albums.php
    First created: 24.8.2011

 *********************/

/**
 * Shows an album list in the admin panel
 */
?>
<h2>Albums</h2>
<?php echo show_messages(); ?>

<ul class="list heading">
    <li class="title">Title</li>
    <li class="tags">Release date</li>
    <li class="tags">Category</li>
</ul>
<?php if(empty($albums)): ?>
<p>No albums to display</p>
<?php else: ?>
<?php foreach($albums[$p] as $album): ?>
<ul class="list">
    <li class="title">
        <?php if(!empty($album['feature_cover'])): ?>
        <img alt="Cover for <?php echo $album['title']; ?>" src="<?php echo URL; ?><?php echo $album['feature_cover']; ?>" style="float:left;" height="30" />
        <?php endif; ?>
        <?php echo $album['title']; ?>
        <div>
            <a href="?<?php echo str_replace('&', '&amp;', $_SERVER['QUERY_STRING']); ?>&amp;aaction=edit&amp;id=<?php echo $album['id']; ?>">Edit</a> - <a href="?<?php echo str_replace('&', '&amp;', $_SERVER['QUERY_STRING']); ?>&amp;aaction=remove&amp;id=<?php echo $album['id']; ?>" class="delete">Remove</a>
        </div>
    </li>
    <li class="tags">
        <?php echo $album['date']; ?>
    </li>
    <li class="tags">
        <?php if(empty($album['category'])): ?>
        No category
        <?php else: ?>
        <?php echo $album['category']; ?>
        <?php endif; ?>
    </li>
</ul>
<?php endforeach; ?>
<?php endif; ?>

