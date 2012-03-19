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
    Current file: fanx_extensions/discography/menu.php
    First created: 23.8.2011

 *********************/

/**
 * The main menu of the discography extension
 */
?>
<ul class="menu">
    <li><a href="?page=extensions&amp;action=extension&amp;name=discography">Discography</a></li>
    <li>
        <a href="?page=extensions&amp;action=extension&amp;name=discography&amp;daction=categories">Categories</a>
        <?php if($daction == 'categories'): ?>
        <ul>
            <li><a href="?page=extensions&amp;action=extension&amp;name=discography&amp;daction=categories&amp;caction=all">All categories</a></li>
            <li><a href="?page=extensions&amp;action=extension&amp;name=discography&amp;daction=categories&amp;caction=add">New category</a></li>
        </ul>
        <?php endif; ?>
    </li>
    <li>
        <a href="?page=extensions&amp;action=extension&amp;name=discography&amp;daction=albums">Albums</a>
        <?php if($daction == 'albums'): ?>
        <ul>
            <li><a href="?page=extensions&amp;action=extension&amp;name=discography&amp;daction=albums&amp;aaction=all">All albums</a></li>
            <li><a href="?page=extensions&amp;action=extension&amp;name=discography&amp;daction=albums&amp;aaction=add">Add new album</a></li>
        </ul>
        <?php endif; ?>
    </li>
    <li>
        <a href="?page=extensions&amp;action=extension&amp;name=discography&amp;daction=songs">Songs</a>
        <?php if($daction == 'songs'): ?>
        <ul>
            <li><a href="?page=extensions&amp;action=extension&amp;name=discography&amp;daction=songs&amp;saction=all">All songs</a></li>
            <li><a href="?page=extensions&amp;action=extension&amp;name=discography&amp;daction=songs&amp;saction=add">Add new song</a></li>
        </ul>
        <?php endif; ?>
    </li>
    <li><a href="?page=extensions&amp;action=edit&amp;id=<?php echo $section['id']; ?>">Edit settings</a></li>
</ul>
