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
    Current file: fanx_admin/pages/tag_form.php
    First created: 22.8.2011

 *********************/

/**
 * The form to edit tags
 */
?>
<h1>Editing <?php echo $tag['name']; ?></h1>
<?php echo show_messages(); ?>
<form action="?<?php echo str_replace('&', '&amp;', $_SERVER['QUERY_STRING']); ?>" method="post">
    <ul>
        <li><label for="name">Name: </label> <input type="text" id="name" name="name" value="<?php echo $tag['name']; ?>" /></li>
        <li>
            <label for="description">Description: </label> <textarea name="description" id="description" cols="1" rows="1"><?php echo $tag['description']; ?></textarea>
        </li>
        <li><input type="submit" class="submit" name="edit_tag" value="Save changes" /></li>
    </ul>
</form>
