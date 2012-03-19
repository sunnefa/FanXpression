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
    Current file: fanx_sections/discography/templates/albums_form.php
    First created: 25.8.2011

 *********************/

/**
 * The form to add and edit albums
 */
?>
<h1>
    <?php if(isset($album)): ?>
    Editing album <?php echo $album['title']; ?>
    <?php else: ?>
    Add new album
    <?php endif; ?>
</h1>
<?php echo show_messages(); ?>
<form method="post" action="?<?php echo str_replace('&', '&amp;', $_SERVER['QUERY_STRING']); ?>" enctype="multipart/form-data">
    <ul>
        <li>
            <label for="title">Title:</label> <input type="text" id="title" name="title" value="<?php if(isset($album)) echo $album['title']; ?>" />
        </li>
        <li>
            <label for="release_date">Release date</label> <small>(in the format MM/DD/YYYY)</small>
            <input type="text" name="release_date" id="release_date" value="<?php if(isset($album)) echo $album['date']; ?>"  />
        </li>
        <li>
            <?php if(isset($album)): ?>
            <?php if(!empty($album['feature_cover'])): ?>
            Cover:
            <div><img src="<?php echo URL; ?><?php echo $album['feature_cover']; ?>" width="100" /></div>
            <?php endif; ?>
            <?php endif; ?>
            <label for="feature_cover">Featured cover:</label> <input type="file" id="feature_cover" name="feature_cover" />
        </li>
        <li>
            <label for="category">Category</label>
            <select name="category" id="category">
                <option value="0">Select one</option>
                <?php echo $cat_list; ?>
            </select>
        </li>
        <li>
            <input type="submit" class="submit" name="<?php if(isset($album)) echo 'edit_album'; else echo 'add_album'; ?>" value="<?php if(isset($album)) echo 'Save changes'; else echo 'Add album'; ?>" />
        </li>
    </ul>
</form>
