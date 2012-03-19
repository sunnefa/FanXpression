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
    Current file: fanx_admin/pages/messages.php
    First created: 26.8.2011

 *********************/

/**
 * The HTML template for displaying session messages
 */
?>
<?php if(isset($_SESSION['errors'])): ?>
<?php foreach($_SESSION['errors'] as $error): ?>
<p style="color:red"><?php echo $error; ?></p>
<?php endforeach; ?>
<?php endif; ?>
<?php if(isset($_SESSION['success'])): ?>
<p style="color:blue"><?php echo $_SESSION['success']; ?></p>
<?php endif; ?>
