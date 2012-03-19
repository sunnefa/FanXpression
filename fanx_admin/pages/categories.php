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
    Current file: fanx_admin/pages/categories.php
    First created: 21.7.2011

 *********************/

/**
 * The template for categories
 */

?>
<h1>Categories</h1>

<?php echo show_messages(); ?>

<ul class="cat-list heading">
    <li class="title">Name</li>
    <li class="tags">Description</li>
</ul>
<?php if(empty($categories)): ?>
No categories to display
<?php else: ?>
<?php echo $cat_list; ?>
<?php endif; ?>
