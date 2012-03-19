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
    Current file: fanx_admin/pages/post_comments.php
    First created: 22.8.2011

 *********************/

/**
 * The template for the comments
 */
?>
<h1>Comments</h1>
<?php echo show_messages(); ?>

<ul class="list heading">
    <li class="title">Comment</li>
    <li class="date">User</li>
    <li class="status">Approved</li>
    <li class="tags">Post title</li>
</ul>
<?php if(empty($comments)): ?>
No comments to display
<?php else: ?>
<?php foreach($comments[$p] as $comment): ?>
<ul class="list">
    <li class="title">
        <?php echo substr(strip_tags($comment['comment']), 0, 20); ?>...
        <div>
            <?php if($comment['approved'] == 0): ?>
            <a href="?page=posts&amp;action=comments&amp;comment_action=approve&amp;id=<?php echo $comment['id']; ?>">Approve</a> - 
            <?php else: ?>
            <a href="?page=posts&amp;action=comments&amp;comment_action=deapprove&amp;id=<?php echo $comment['id']; ?>">Deapprove</a> - 
            <?php endif; ?>
            <a href="?page=posts&amp;action=comments&amp;comment_action=edit&amp;id=<?php echo $comment['id']; ?>">Edit</a> - 
            <a href="?page=posts&amp;action=comments&amp;comment_action=delete&amp;id=<?php echo $comment['id']; ?>" class="delete">Delete forever</a>
        </div>
    </li>
    <li class="date">
        <?php if(!empty($comment['author_website'])): ?>
        <a href="<?php echo $comment['author_website']; ?>"><?php echo $comment['author_name']; ?></a>
        <?php else: ?>
        <?php echo $comment['author_name']; ?>
        <?php endif; ?>
        <?php if(!empty($comment['user_id'])) echo ' - Registered'; ?>
        <div>
            <?php echo $comment['author_email']; ?>
        </div>
    </li>
    <li class="status"><?php if($comment['approved'] == 0) echo 'No'; else echo 'Yes'; ?></li>
    <li class="tags"><?php echo $comment['title']; ?></li>
</ul>
<?php endforeach; ?>
<?php endif; ?>

