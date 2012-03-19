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
    Current file: fanx_admin/pages/menu.php
    First created: 12.7.2011

 *********************/

/**
 * The main admin menu
 */
?>
<ul class="menu">
    <li><a href="?page=dashboard">Dashboard</a></li>
    <li><a href="?page=categories">Categories</a>
        <?php if($page == 'categories'): ?>
        <ul>
            <li><a href="?page=categories&amp;action=all">All categories</a></li>
            <li><a href="?page=categories&amp;action=add">Add new category</a></li>
        </ul>
        <?php endif; ?>
    </li>
    <li><a href="?page=posts">Posts</a>
        <?php if($page == 'posts'): ?>
        <ul>
            <li><a href="?page=posts&amp;action=all">All posts</a></li>
            <li><a href="?page=posts&amp;action=add">Add new post</a></li>
            <li><a href="?page=posts&amp;action=tags">Tags</a></li>
            <li><a href="?page=posts&amp;action=comments">Comments</a></li>
        </ul>
        <?php endif; ?>
    </li>
    <li><a href="?page=pages">Pages</a>
        <?php if($page == 'pages'): ?>
        <ul>
            <li><a href="?page=pages&amp;action=all">All pages</a></li>
            <li><a href="?page=pages&amp;action=add">Add new</a></li>
        </ul>
        <?php endif; ?>
    </li>
    <li><a href="?page=extensions">Extensions</a>
        <?php if($page == 'extensions'): ?>
        <ul>
        <?php foreach($section_links as $link): ?>
            <li><a href="?page=extensions&amp;action=extension&amp;name=<?php echo $link['name']; ?>"><?php echo ucwords($link['name']); ?></a></li>
        <?php endforeach; ?>
        </ul>
        <?php endif; ?>
    </li>
    <li><a href="?page=themes">Themes</a>
        <?php if($page == 'themes'): ?>
        <?php endif; ?>
    </li>
    <li><a href="?page=users">Users</a>
        <?php if($page == 'users'): ?>
        <ul>
            <li><a href="?page=users&amp;action=all">All users</a></li>
            <li><a href="?page=users&amp;action=profile">Edit your profile</a></li>
            <li><a href="?page=users&amp;action=add">Add a new user</a></li>
        </ul>
        <?php endif; ?>
    </li>
    <li><a href="?page=settings">Settings</a></li>
    <li><a href="?page=help">Help</a></li>
    <li><a href="?page=logout">Logout</a></li>
</ul>
