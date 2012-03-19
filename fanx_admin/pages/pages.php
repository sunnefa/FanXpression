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
    Current file: fanx_admin/pages/pages.php
    First created: 24.7.2011

 *********************/

/**
 * HTML template for pages
 */
?>
<h1>Pages</h1>
<?php echo show_messages(); ?>
<p><a href="?page=pages&amp;action=all">All</a>(<?php echo $all_num; ?>)&nbsp;&nbsp;
<a href="?page=pages&amp;action=trashcan">Trash</a>(<?php echo $trash_num; ?>)</p>
<ul class="list heading">
    <li class="title">Title</li>
    <li class="date">Date</li>
    <li class="tags">Category</li>
    <li class="status">Status</li>
</ul>
<?php if(empty($pages)): ?>
No pages to display
<?php else: ?>
<?php foreach($pages[$p] as $single_page): ?>
<?php if($single_page['status'] == 'unpublished'): ?>
<ul class="list inactive">
<?php elseif($single_page['status'] == 'trash'): ?>
<ul class="list trash">
<?php else: ?>
<ul class="list">
<?php endif; ?>
    <li class="title">
        <?php echo $single_page['title']; ?>
        <div>
            <?php if($single_page['status'] != 'trash'): ?>
            <a href="?page=pages&amp;action=edit&amp;id=<?php echo $single_page['id']; ?>">Edit</a> - 
            <a href="?page=pages&amp;action=trash&amp;id=<?php echo $single_page['id']; ?>">Move to trash</a>
            <?php else: ?>
            <a href="?page=pages&amp;action=restore&amp;id=<?php echo $single_page['id']; ?>">Restore</a>
            <a href="?page=pages&amp;action=delete&amp;id=<?php echo $single_page['id']; ?>" class="delete">Delete forever</a>
            <?php endif; ?>
        </div>
    </li>
    <li class="date"><?php echo $single_page['date']; ?></li>
    <li class="tags"><?php echo $single_page['category']; ?></li>
    <li class="status"><?php echo ucwords($single_page['status']); ?></li>
</ul>
<?php endforeach; ?>
<?php endif; ?>