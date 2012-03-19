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
    Current file: fanx_themes/default/comment_form.php
    First created: 12.9.2011

 *********************/

?>
<h3>Add a comment</h3>
<?php if(isset($_SESSION['errors']['adding_error'])) echo $_SESSION['errors']['adding_error']; ?>
<?php if(isset($_SESSION['success'])) echo $_SESSION['success']; ?>
<form action="<?php echo $site_url; ?>fanx_post_comments.php" method="post">
    <input type="hidden" value="<?php echo $post_id; ?>" name="post_id" />
    <input type="hidden" value="<?php echo $permalink; ?>" name="permalink" />
    <?php if(isset($logged_in_user)): ?>
    <input type="hidden" value="<?php echo $logged_in_user; ?>" name="user_id" />
    <p>You are logged in as <em><?php echo $username; ?></em>. <a href="<?php echo $site_url; ?>fanx_admin/?page=logout">Logout?</a></p>
    <?php endif; ?>
    <ul>
        <?php if(!isset($logged_in_user)): ?>
        <li>
            <label>Name:</label> <input type="text" name="name" /> <?php if(isset($_SESSION['errors']['name'])) echo $_SESSION['errors']['name']; ?>
        </li>
        <li>
            <label>Website: </label> <input type="text" name="website" /> <?php if(isset($_SESSION['errors']['website'])) echo $_SESSION['errors']['website']; ?>
        </li>
        <li>
            <label>Email: </label> <input type="email" name="email" /><?php if(isset($_SESSION['errors']['email'])) echo $_SESSION['errors']['email']; ?>
        </li>
        <?php endif; ?>
        <li>
            <label>Comment: </label>
            <textarea cols="1" rows="1" name="comment"></textarea><?php if(isset($_SESSION['errors']['comment'])) echo $_SESSION['errors']['comment']; ?>
        </li>
        <li><input type="submit" value="Add comment" name="add_comment" /></li>
    </ul>
</form>