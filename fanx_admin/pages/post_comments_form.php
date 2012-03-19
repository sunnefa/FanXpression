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
    Current file: fanx_admin/pages/post_comments_form.php
    First created: 22.8.2011

 *********************/

/**
 * The form to edit comments
 */
?>
<h1>Editing comment on <?php echo $comment['title']; ?></h1>
<?php echo show_messages(); ?>

<form action="?<?php echo str_replace('&', '&amp;', $_SERVER['QUERY_STRING']); ?>" method="post">
    <?php if(!empty($comment['user_id'])): ?>
    <input type="hidden" value="<?php echo $comment['user_id']; ?>" name="user_id" />
    <?php endif; ?>
    <ul>
        <li>
            <?php if(empty($comment['user_id'])): ?>
            <label for="author_name">Author name</label> <input type="text" id="author_name" name="author_name" value="<?php echo $comment['author_name']; ?>" />
            <?php else: ?>
            By <strong><?php echo $comment['author_name']; ?></strong>
            <?php endif; ?>
        </li>
        
        <li>
            <?php if(empty($comment['user_id'])): ?>
            <label for="author_email">Author email:</label> <input type="text" id="author_email" name="author_email" value="<?php echo $comment['author_email']; ?>" />
            <?php else: ?>
            <strong><?php echo $comment['author_email']; ?></strong>
            <?php endif; ?>
        </li>
        
        <li>
            <?php if(empty($comment['user_id'])): ?>
            <label for="author_website">Author website:</label> <input type="text" id="author_website" name="author_website" value="<?php echo $comment['author_website']; ?>" />
            <?php endif; ?>
        </li>
        
        <li>
            <label for="comment">Comment</label> <textarea id="comment" name="comment" cols="1" rows="1"><?php echo $comment['comment']; ?></textarea>
        </li>
        
        <li>
            <input type="submit" class="submit" name="edit_comment" value="Save changes" />
        </li>
    </ul>
</form>
