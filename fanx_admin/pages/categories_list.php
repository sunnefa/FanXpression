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
    Current file: fanx_admin/pages/categories_list.php
    First created: 20.7.2011

 *********************/

/*
 * The list of categories
 */

?>

<?php if($category['depth'] > 0): ?>
<ul class="cat-list inactive" style="padding-left:<?php echo 10 * $category['depth']; ?>px;">
<?php else: ?>
<ul class="cat-list">
<?php endif; ?>
    <li class="title">
    <?php echo str_repeat('&mdash;&nbsp;', $category['depth']); ?><?php echo $category['name']; ?>
        <div>
            <a href="?page=categories&amp;action=edit&amp;id=<?php echo $category['id']; ?>">Edit category</a>
          - <a href="?page=categories&amp;action=remove&amp;id=<?php echo $category['id']; ?>" class="delete">Remove category</a>
        </div>
    </li>
    <li class="tags"><?php echo strip_tags(substr($category['description'], 0, 50)); ?>...</li>
</ul>
