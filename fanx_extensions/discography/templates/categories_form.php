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
    Current file: fanx_sections/discography/templates/categories_form.php
    First created: 23.8.2011

 *********************/

/**
 * The form to add and edit categories
 */
?>
<h2>
    <?php if(isset($cat)): ?>
    Editing category <?php echo $cat['name']; ?>
    <?php else: ?>
    Add new category
    <?php endif; ?>
</h2>
<?php echo show_messages(); ?>
<form method="post" action="?<?php echo str_replace('&', '&amp;', $_SERVER['QUERY_STRING']); ?>">
    <ul>
        <li>
            <label for="name">Name: </label><input type="text" id="name" name="name" value="<?php if(isset($cat)) echo $cat['name']; ?>" />
        </li>
        <li><label for="description">Description:</label></li>
        <li style="margin-top:10px;"><textarea name="description" id="description"><?php if(isset($cat)) echo $cat['description']; ?></textarea></li>
        <li>
            <label for="parent">Parent category</label>
            <select name="parent" id="parent">
                <option value="0">Select one</option>
                <?php echo $cat_list; ?>
            </select>
        </li>
        <li>
            <input type="submit" class="submit" name="<?php if(isset($cat)) echo 'update_cat'; else echo 'add_cat'; ?>" value="<?php if(isset($cat)) echo 'Save changes'; else echo 'Add category'; ?>" />
        </li>
    </ul>
</form>
