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
    Current file: fanx_admin/pages/pagination.php
    First created: 22.8.2011

 *********************/

/**
 * HTML template for the admin pagination
 */
?>
<p>
<?php for($i = 1; $i < $all_p+1; $i++): ?>
    <?php if($i == $p+1): ?>
    Page <?php echo $i; ?>
    <?php else: ?>
    <a href="?<?php echo str_replace('&', '&amp;', $_SERVER['QUERY_STRING']); ?>&amp;p=<?php echo $i; ?>">Page <?php echo $i; ?></a>
    <? endif; ?>
<?php endfor; ?>
</p>
