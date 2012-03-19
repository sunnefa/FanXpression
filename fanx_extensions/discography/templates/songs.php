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
    Current file: fanx_sections/discography/templates/songs.php
    First created: 25.8.2011

 *********************/

/**
 * Shows a song list
 */
?>
<h2>Songs</h2>
<?php echo show_messages(); ?>

<ul class="list heading">
    <li class="title">Title</li>
    <li class="status">Length</li>
    <li class="date">Album</li>
</ul>
<?php if(empty($songs)): ?>
<p>No songs to display</p>
<?php else: ?>
<?php foreach($songs[$p] as $song): ?>
<ul class="list">
    <li class="title">
        <?php echo $song['title']; ?>
        <div>
            <a href="?<?php echo $path; ?>saction=edit&amp;id=<?php echo $song['id']; ?>">Edit</a> - <a href="?<?php echo $path; ?>saction=remove&amp;id=<?php echo $song['id']; ?>" class="delete">Remove</a>
        </div>
    </li>
    <li class="status"><?php echo $song['length']; ?></li>
    <li class="date"><?php echo $song['album']; ?></li>
</ul>
<?php endforeach; ?>
<?php endif; ?>

