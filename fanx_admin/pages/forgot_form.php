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
    Current file: fanx_admin/pages/forgot_form.php
    First created: 26.8.2011

 *********************/

/**
 * The HTML form for forgotten password
 */
?>
<div class="login">
<h1>Recover user details</h1>
<p>Please type in your email address below and we will send you your username and a new password</p>
<?php echo show_messages(); ?>
<form action="" method="post">
    <ul>
        <li><label for="email">Email address:</label> <input type="text" name="email" /></li>
        <li><input type="submit" class="submit" value="Send details" name="forgot" /></li>
        <li><a href="index.php">Login</a></li>
    </ul>
</form>
<p><a href="<?php echo URL; ?>">Return to <?php echo TITLE; ?></a></p>
</div>
