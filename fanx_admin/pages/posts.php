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
    Current file: fanx_admin/pages/posts.php
    First created: 20.8.2011

 *********************/

/**
 * The template for posts
 */
?>
<h1>Posts</h1>
<?php echo show_messages(); ?>

<p><a href="?page=posts&amp;action=all">All</a>(<?php echo $all_num; ?>)&nbsp;&nbsp;
<a href="?page=posts&amp;action=trashcan">Trash</a>(<?php echo $trash_num; ?>)</p>
<ul class="list heading">
    <li class="title">Title</li>
    <li class="date">Date</li>
    <li class="status">Status</li>
    <li class="tags">Tags</li>
</ul>
<?php if(empty($posts)): ?>
No posts to display
<?php else: ?>
<?php foreach($posts[$p] as $post): ?>
<?php if($post['status'] == 'unpublished'): ?>
<ul class="list inactive">
<?php elseif($post['status'] == 'trash'): ?>
<ul class="list trash">
<?php else: ?>
<ul class="list">
<?php endif; ?>
    <li class="title">
        <?php echo $post['title']; ?>
        <div>
            <?php if($post['status'] != 'trash'): ?>
            <a href="?page=posts&amp;action=edit&amp;id=<?php echo $post['id']; ?>">Edit</a>
            <a href="?page=posts&amp;action=trash&amp;id=<?php echo $post['id']; ?>">Move to trash</a>
            <?php else: ?>
            <a href="?page=posts&amp;action=restore&amp;id=<?php echo $post['id']; ?>">Restore</a>
            <a href="?page=posts&amp;action=delete&amp;id=<?php echo $post['id']; ?>" class="delete">Delete forever</a>
            <?php endif; ?>
        </div>
    </li>
    <li class="date">
        <?php echo $post['date']; ?>
    </li>
    <li class="status">
        <?php echo ucwords($post['status']); ?>
    </li>
    <li class="tags">
        <?php echo $post['tags']; ?>
    </li>
</ul>
<?php endforeach; ?>
<?php endif; ?>
