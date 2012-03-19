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
    Current file: fanx_admin/pages/dashboard.php
    First created: 6.9.2011

 *********************/

/**
 * The HTML template for the dashboard
 */
?>
<h1>Dashboard</h1>
<p>Welcome 
<?php if(isset($_SESSION['fanx_admin_login']['username'])): ?>
    <?php echo $_SESSION['fanx_admin_login']['username']; ?>
<?php elseif(isset($_COOKIE['fanx_admin_login']['username'])): ?>
    <?php echo $_COOKIE['fanx_admin_login']['username']; ?>
<?php endif; ?>
</p>
<p>Would you like to <a href="?page=posts&amp;action=add">add a post</a>? Or perhaps <a href="?page=pages&amp;action=add">a page</a>?</p>
<p>Below are the 5 latest posts and pages</p>
<div style="float:left;width:45%;">
    <p><strong>Posts:</strong></p>
    <ul class="list heading">
        <li class="title">Title:</li>
        <li class="date">Date:</li>
        <li class="tags">Excerpt:</li>
    </ul>
    <?php if(empty($posts)): ?>
        <p>No posts to display</p>
    <?php else: ?>
        <?php foreach($posts as $post): ?>
                <ul class="list">
                    <li class="title"><a href="?page=posts&amp;action=edit&amp;id=<?php echo $post['id']; ?>"><?php echo $post['title']; ?></a></li>
                    <li class="date"><?php echo $post['date']; ?></li>
                    <li class="tags"><?php echo substr(strip_tags($post['content']), 0, 20); ?>&hellip;</li>
                </ul>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<div style="float:left;width:45%; margin-left:10px;">
    <p><strong>Pages:</strong></p>
    <ul class="list heading">
        <li class="title">Title:</li>
        <li class="date">Date:</li>
        <li class="tags">Excerpt:</li>
    </ul>
    <?php if(empty($pages)): ?>
        <p>No pages to display</p>
    <?php else: ?>
        <?php foreach($pages as $page): ?>
                <ul class="list">
                    <li class="title"><a href="?page=pages&amp;action=edit&amp;id=<?php echo $page['id']; ?>"><?php echo $page['title']; ?></a></li>
                    <li class="date"><?php echo $page['date']; ?></li>
                    <li class="tags"><?php echo substr(strip_tags($page['content']), 0, 20); ?>&hellip;</li>
                </ul>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
