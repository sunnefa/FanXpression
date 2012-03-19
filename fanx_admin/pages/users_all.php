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
    Current file: fanx_admin/pages/users_all.php
    First created: 12.7.2011

 *********************/

/**
 * The template for the user list
 */
?>
<h1>Users</h1>
<?php echo show_messages(); ?>
<ul class="list heading">
    <li class="title">Username</li>
    <li class="tags">Email address</li>
    <li class="date">Date registered</li>
    <li class="status">Status</li>
</ul>
<?php foreach($users[$p] as $user): ?>
<?php if($user['status'] == 'inactive'): ?>
<ul class="list inactive">
<?php else: ?>
<ul class="list">
<?php endif; ?>
    <li class="title">
        <?php echo $user['username']; ?>
        <div>
            <a href="?page=users&amp;action=profile&amp;id=<?php echo $user['id']; ?>">Edit profile</a> -
            <?php if($user['id'] == 1): ?>
            Deactivate user
            <?php elseif($user['status'] != 'inactive'): ?>
            <a href="?page=users&amp;action=deactivate&amp;id=<?php echo $user['id']; ?>">Deactivate user</a>
            <?php else: ?>
            <a href="?page=users&amp;action=activate&amp;id=<?php echo $user['id']; ?>">Activate user</a>
            <?php endif; ?>
        </div>
    </li>
    <li class="tags"><?php echo $user['email']; ?></li>
    <li class="date"><?php echo $user['date']; ?></li>
    <li class="status"><?php echo ucfirst($user['status']); ?></li>
</ul>
<?php endforeach; ?>
