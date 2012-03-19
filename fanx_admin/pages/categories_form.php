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
    Current file: fanx_admin/pages/categories_form.php
    First created: 21.7.2011

 *********************/

/**
 * The form to add and edit categories
 */
?>
<h1>
<?php if(isset($cat)): ?>
    Editing <?php echo $cat['name']; ?>
<?php else: ?>
    Add category
<?php endif; ?>
</h1>

<?php echo show_messages(); ?>

<form action="?<?php echo str_replace('&', '&amp;', $_SERVER['QUERY_STRING']); ?>" method="post">
    <ul>
        <li><label for="cat_name">Category name</label> <input type="text" name="cat_name" value="<?php if(isset($cat)) echo $cat['name']; ?>" id="cat_name" /></li>
        <li>
            <label for="cat_desc">Category description</label>
            <textarea name="cat_desc" id="cat_desc" cols="1" rows="1"><?php if(isset($cat)) echo $cat['description']; ?></textarea>
        </li>
        <li>
            <label for="parent_cat">Parent Category</label>
            <select name="parent_cat" id="parent_cat">
                <option value="0">No parent</option>
                <?php echo $cat_list; ?>
            </select>
        </li>
        <li><input type="submit" class="submit" name="<?php if(!isset($cat)): ?>add_super<?php else:?>edit_super<?php endif; ?>" value="<?php if(!isset($cat)): ?>Add category<?php else:?>Save changes<?php endif; ?>" /></li>
    </ul>
</form>
