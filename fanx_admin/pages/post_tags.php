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
    Current file: fanx_admin/pages/post_tags.php
    First created: 22.8.2011

 *********************/

/**
 * The template for post tags
 */
?>
<h1>Tags</h1>
<?php echo show_messages(); ?>

<ul class="list heading">
    <li class="title">Name</li>
    <li class="tags">Description</li>
</ul>
<?php if(empty($tags)): ?>
No tags to display
<?php else: ?>
<?php foreach($tags[$p] as $tag): ?>
<ul class="list">
    <li class="title">
    <?php echo $tag['name']; ?>
        <div>
            <a href="?page=posts&amp;action=tags&amp;tag_action=edit&amp;id=<?php echo $tag['id']; ?>">Edit</a>
            <a href="?page=posts&amp;action=tags&amp;tag_action=delete&amp;id=<?php echo $tag['id']; ?>" class="delete">Delete forever</a>
        </div>
    </li>
    <li class="tags"><?php echo strip_tags($tag['description']); ?></li>
</ul>
<?php endforeach; ?>
<?php endif; ?>

