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
    Current file: fanx_admin/pages/index.php
    First created: 12.7.2011

 *********************/

/**
 * The main HTML template for the admin panel
 */
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>FanXpression - Admin panel</title>
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo URL; ?>fanx_admin/images/favicon.ico" />
        <link rel="stylesheet" href="<?php echo URL; ?>fanx_admin/css/admin_main.css" />
        <script type="text/javascript" src="<?php echo URL; ?>fanx_admin/js/tinymce/jquery-1.5.min.js"></script>
        <script type="text/javascript" src="<?php echo URL; ?>fanx_admin/js/tinymce/tiny_mce.js"></script>
        <script language="javascript" type="text/javascript" src="<?php echo URL; ?>fanx_admin/js/tinyupload.js"></script>
        <script type="text/javascript" src="<?php echo URL; ?>fanx_admin/js/tiny_init.js"></script>
        <script type="text/javascript" src="<?php echo URL; ?>fanx_admin/js/jquery.tag.editor-min.js"></script>
        <script type="text/javascript" src="<?php echo URL; ?>fanx_admin/js/delete_alert.js"></script>
    </head>
    <body>
        <div class="top_bar"><span class="logo"></span>&nbsp;&nbsp;&nbsp;
    <?php if(isset($user)): ?>
        Welcome <?php echo $user; ?> - 
    <?php endif; ?>
        Go back to <a href="<?php echo URL; ?>"><?php echo TITLE; ?></a></div>
    
    <?php if(isset($menu)): ?>
        <div class="menu_container">
            <?php echo $menu; ?>
        </div>
    <?php endif; ?>
        <?php if(isset($page)): ?>
        <div class="content_container">
            <?php if(isset($content)) echo $content; ?>
        </div>
        <?php else: ?>
        <?php if(isset($content)) echo $content; ?>
        <?php endif; ?>
    </body>
</html>
