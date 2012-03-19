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
    Current file: fanx_admin/pages/sections_form.php
    First created: 26.8.2011

 *********************/

/**
 * The form to edit settings on sections
 */
?>
<h1>Settings for <?php echo ucwords($section['name']); ?></h1>
<?php echo show_messages(); ?>

<form action="?<?php echo str_replace('&', '&amp;', $_SERVER['QUERY_STRING']); ?>" method="post">
    <input type="hidden" name="name_title" value="<?php echo ucwords($section['name']); ?>" />
    <ul>
        <li><label for="title">Title: </label> <input id="title" type="text" name="title" value="<?php echo $section['title']; ?>" /></li>
        <li>
            <label for="category">Category: </label>
            <select name="category" id="category">
                <option value="0">Select one</option>
                <?php echo $cat_list; ?>
            </select>
        </li>
        <li><input type="submit" class="submit" name="edit_section" value="Save changes" /></li>
    </ul>
</form>
