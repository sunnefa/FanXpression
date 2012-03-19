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
    Current file: fanx_admin/pages/pages_form.php
    First created: 25.7.2011

 *********************/

/**
 * The HTML form to edit and create pages
 */
?>
<h1>
<?php if(isset($single_page)): ?>
Editing <?php echo $single_page['title']; ?>
<?php else: ?>
Add new page
<?php endif; ?>
</h1>
<?php echo show_messages(); ?>

<form action="?<?php echo str_replace('&', '&amp;', $_SERVER['QUERY_STRING']); ?>" method="post" enctype="multipart/form-data">
    <?php if(isset($single_page)): ?>
    <input type="hidden" value="<?php echo $single_page['id']; ?>" />
    <?php endif; ?>
    <ul>
        <li><label for="title">Title:</label> <input name="title" id="title" type="text" value="<?php if(isset($single_page)) echo $single_page['title']; ?>" /></li>
        <li><label for="page_content">Content:</label> <textarea id="page_content" name="content" cols="1" rows="1"><?php if(isset($single_page)) echo html_entity_decode($single_page['content']); ?></textarea></li>
        
        <li>
            <label for="category">Category</label>
            <select name="category" id="category">
                <option value="0">Select one</option>
                <?php echo $cat_list; ?>
            </select>
        </li>
        <li>
            Status:
            <?php if(isset($single_page)): ?>
            <p><input type="radio" name="status" <?php if(isset($single_page)) if($single_page['status'] == 'unpublished') echo 'checked'; ?> value="unpublished" class="radio" />Unpublished (draft)
            <input type="radio" name="status" <?php if(isset($single_page)) if($single_page['status'] == 'published') echo 'checked'; ?> value="published" class="radio" />Published</p>
            <?php else: ?>
            <p><input type="radio" name="status" checked value="unpublished" class="radio" />Unpublished (draft)
            <input type="radio" name="status" value="published" class="radio" />Published</p>
            <?php endif; ?>
        </li>
        <li>
            <?php if(isset($single_page)): ?>
            <input type="submit" class="submit" name="edit_page" value="Save changes" />
            <?php else: ?>
            <input type="submit" class="submit" name="add_page" value="Add page" />
            <?php endif; ?>
        </li>
    </ul>
</form>

