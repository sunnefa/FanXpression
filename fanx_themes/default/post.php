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
    Current file: fanx_themes/default/post.php
    First created: 26.8.2011

 *********************/

?>
<div class="single_post">
    <h2><?php echo $title; ?></h2>
    <div><?php echo $content; ?></div>
    <div style="float:left;">Posted on <?php echo $date; ?> by <?php echo $username; ?></div>
    <div style="float:right"><a href="<?php echo $permalink; ?>">Read comments</a></div>
    <div style="clear:both;"></div>
    <div>Tags: <?php echo $tags; ?></div>
</div>
