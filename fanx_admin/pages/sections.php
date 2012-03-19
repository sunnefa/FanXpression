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
    Current file: fanx_admin/pages/sections.php
    First created: 23.8.2011

 *********************/

/**
 * The template for sections
 */
?>
<h1>Extensions - <?php echo ucwords($show); ?></h1>
<?php echo show_messages(); ?>
<p>
    <a href="?page=extensions&amp;action=all&amp;show=all">All</a> - 
    <a href="?page=extensions&amp;action=all&amp;show=active">Active</a> - 
    <a href="?page=extensions&amp;action=all&amp;show=inactive">Inactive</a>
</p>
<ul class="list heading">
    <li class="tags">Name</li>
    <li class="date">Title</li>
    <li class="date">Category</li>
    <li class="status">Status</li>
</ul>
<?php if(empty($sections)): ?>
<p>No extensions to display</p>
<?php else: ?>
<?php foreach($sections[$p] as $section): ?>
<ul class="list <?php if($section['active'] == 0) echo 'inactive'; ?>">
    <li class="tags">
    <?php echo ucwords($section['name']); ?>
        <div>
            <?php if($section['active'] != 0): ?>
            <a href="?page=extensions&amp;action=edit&amp;id=<?php echo $section['id']; ?>">Settings</a>
            <a href="?page=extensions&amp;action=deactivate&amp;id=<?php echo $section['id']; ?>">Deactivate</a>
            <?php else: ?>
            <a href="?page=extensions&amp;action=activate&amp;name=<?php echo $section['name']; ?>">Activate</a>
            <?php endif; ?>
        </div>
    </li>
    <li class="date"><?php echo $section['title']; ?></li>
    <li class="date"><?php echo $section['category']; ?></li>
    <li class="status"><?php if($section['active'] == 0) echo 'Inactive'; else echo 'Active'; ?></li>
</ul>
<?php endforeach; ?>
<?php endif; ?>