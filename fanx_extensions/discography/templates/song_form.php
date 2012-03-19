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
    Current file: fanx_sections/discography/templates/song_form.php
    First created: 25.8.2011

 *********************/

/**
 * The form to add and edit songs
 */
?>
<h2>
    <?php if(isset($song)): ?>
    Editing <?php echo $song['title']; ?>
    <?php else: ?>
    Add new song
    <?php endif; ?>
</h2>
<?php echo show_messages(); ?>

<form action="?<?php echo str_replace('&', '&amp;', $_SERVER['QUERY_STRING']); ?>" method="post">
    <ul>
        <li><label for="title">Title:</label> <input id="title" type="text" name="title" value="<?php if(isset($song)) echo $song['title']; ?>" /></li>
        <li><label for="length">Length:</label><input id="length" type="text" name="length" value="<?php if(isset($song)) echo $song['length']; ?>" /> <small>(optional)</small> </li>
        <li><label for="composer">Composer:</label><input id="composer" type="text" name="composer" value="<?php if(isset($song)) echo $song['composer']; ?>" /> <small>(optional)</small> </li>
        <li><label for="lyrics">Lyrics:</label> <small>(optional)</small></li>
        <li style="margin-top:10px;">
            <textarea id="lyrics" name="lyrics" cols="1" rows="1"><?php if(isset($song)) echo $song['lyrics'] ?></textarea>
        </li>
        </li>
        <li>
            <label for="album">Album:</label>
            <select name="album" id="album">
                <option value="0">Select one</option>
                <?php foreach($albums as $album): ?>
                <option <?php if(isset($song)) if($album['id'] == $song['album_id']) echo 'selected'; ?> value="<?php echo $album['id']; ?>"><?php echo $album['title']; ?></option>
                <?php endforeach; ?>
            </select>
        </li>
        <li><input type="submit" class="submit" name="<?php if(isset($song)) echo 'edit_song'; else echo 'add_song'; ?>" value="<?php if(isset($song)) echo 'Save Changes'; else echo 'Add song'; ?>" /></li>
    </ul>
</form>
