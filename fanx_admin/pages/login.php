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
    Current file: fanx_admin/pages/login.php
    First created: 12.7.2011

 *********************/

/**
 * The login form
 */

?>
<div class="login">
<h1>Log in to FanXpression</h1>
<?php echo show_messages(); ?>
<form action="" method="post">
    <ul>
        <li><label for="username">Username:</label> <input type="text" name="username" /></li>
        <li><label for="password">Password:</label> <input type="password" name="password" /></li>
        <li><label for="remember">Remember me:</label> <input class="radio" type="checkbox" name="remember" /></li>
        <li><input type="submit" class="submit" name="login" value="Login" /></li>
        <li><a href="?laction=forgot">I forgot my username or password</a></li>
    </ul>
</form>
<p><a href="<?php echo URL; ?>">Return to <?php echo TITLE; ?></a></p>
</div>
