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
    Current file: fanx_admin/pages/posts_form.php
    First created: 21.8.2011

 *********************/

/**
 * The form to add and edit posts
 */
?>
<h1>
    <?php if(isset($post)): ?>
    Editing <?php echo $post['title']; ?>
    <?php else: ?>
    Add new post
    <?php endif; ?>
</h1>

<?php echo show_messages(); ?>

<form method="post" action="?<?php echo str_replace('&', '&amp;', $_SERVER['QUERY_STRING']); ?>" enctype="multipart/form-data">
    <?php if(isset($post)): ?>
    <input type="hidden" name="id" value="<?php echo $post['id']; ?>" />
    <?php endif; ?>
    <ul>
        <li>
            <label for="title">Title</label> <input type="text" id="title" name="title" value="<?php if(isset($post)) echo $post['title']; ?>" />
        </li>
        <li>
            <label for="post_content">Content</label> <textarea id="post_content" name="content" cols="1" rows="1"><?php if(isset($post)) echo $post['content']; ?></textarea>
        </li>
                <li>
            <label for="new_tags">New tags</label> <input type="text" id="new_tags" name="new_tags" />
            <input type="hidden" name="old_tags" value="<?php if(isset($old_tags)) echo implode(',', $old_tags); ?>" />
            <ul>
                <?php $i = 0; foreach($tags as $tag): ?>
                <?php if($i % 10 == 0): ?>
                <li class="clear"></li>
                <?php endif; ?>
                <li style="float:left; margin-right:10px;">
                    <?php if(isset($old_tags)): ?>
                    <?php $checked = (in_array($tag['name'], $old_tags)) ? 'checked' : ''; ?>
                    <?php else: ?>
                    <?php $checked = ''; ?>
                    <?php endif; ?>
                    <input type="checkbox" <?php echo $checked; ?> class="radio" name="tags[]" value="<?php echo $tag['id']; ?>" /> <?php echo $tag['name']; ?>
                </li>
                <?php $i++; endforeach; ?>
                <li class="clear"></li>
            </ul>
        </li>
        <li>
            Status:
            <?php if(isset($post)): ?>
            <p><input type="radio" name="status" <?php if($post['status'] == 'unpublished') echo 'checked'; ?> value="unpublished" class="radio" />Unpublished (draft)
            <input type="radio" name="status" <?php if($post['status'] == 'published') echo 'checked'; ?> value="published" class="radio" />Published</p>
            <?php else: ?>
            <p><input type="radio" name="status" checked value="unpublished" class="radio" />Unpublished (draft)
            <input type="radio" name="status" value="published" class="radio" />Published</p>
            <?php endif; ?>
        </li>
        <li>
            <?php if(isset($post)): ?>
            <input type="submit" class="submit" name="edit_post" value="Save changes" />
            <?php else: ?>
            <input type="submit" class="submit" name="add_post" value="Add page" />
            <?php endif; ?>
        </li>
    </ul>
</form>
