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
    Current file: fanx_admin/pages/users_profile.php
    First created: 13.7.2011

 *********************/

/**
 * The form to add and edit users
 */
?>
<?php if(isset($user_data)): ?>
<h1><?php echo $user_data['username']; ?>'s profile</h1>
<?php else: ?>
<h1>Add new user</h1>
<?php endif; ?>

<?php echo show_messages(); ?>

<form action="?<?php echo str_replace('&', '&amp;', $_SERVER['QUERY_STRING']); ?>" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php if(isset($user_data)) echo $user_data['id'];?>"/>
    <ul>
        <?php if(!isset($user_data)): ?>
        <li>
            <label for="username">Username:</label> <input type="text" id="username" name="username" />
        </li>
        <?php endif; ?>
        <li>
            <label for="email">Email:</label> <input type="text" id="email" name="new_email" value="<?php if(isset($user_data)) echo $user_data['email']; ?>" />
        </li>
        <li>
            <label for="new_password">New password:</label> <input type="password" id="new_password" name="new_password" />
        </li>
        
        <li>
            <label for="bio">Biography:</label> <textarea cols="1" id="bio" rows="1" name="new_bio"><?php if(isset($user_data)) echo $user_data['bio']; ?></textarea>
        </li>
        <?php if(isset($user_data)): ?>
        <li>
            <label for="avatar">Avatar: </label>
            <?php if(isset($user_data)): ?>
                <?php if(!empty($user_data['avatar'])): ?>
                <div>
                    <img src="<?php echo URL . $user_data['avatar']; ?>" alt="User avatar" style="float:left; margin:10px;" />
                </div>
                <?php endif; ?>
            <?php endif; ?>
             <input type="file" id="avatar" name="avatar" />
        </li>
        <?php endif; ?>
        <li class="clear"></li>
        <?php if(isset($user_data)): ?>
        <?php if(is_admin() && !is_own_profile($user_data['username'])): ?>
        <li>
            <label for="role">Role:</label> 
            <select name="role" id="role">
                <?php if($user_data['role'] == 'admin'): ?>
                <option selected value="admin">Admin</option>
                <option value="user">User</option>
                <?php else: ?>
                <option value="admin">Admin</option>
                <option selected value="user">User</option>
                <?php endif; ?>
            </select>
        </li>
        <?php endif; ?>
        <?php else: ?>
        <li>
            <label for="role">Role:</label> 
            <select name="role" id="role">
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
        </li>
        <?php endif; ?>
        <?php if(isset($user_data)): ?>
        <?php if(!is_admin() || is_own_profile($user_data['username'])): ?>
        <li>
            <label for="old_password">Old password (for confirmation)</label> <input type="password" id="old_password" name="old_password" />
        </li>
        <?php endif; ?>
        <?php endif; ?>
        
        <li>
            <?php if(!isset($user_data)): ?>
            <input type="submit" class="submit" name="add" value="Add user" />
            <?php else: ?>
            <input type="submit" class="submit" name="profile" value="Update profile" />
            <?php endif; ?>
            
        </li>
    </ul>
    
</form>