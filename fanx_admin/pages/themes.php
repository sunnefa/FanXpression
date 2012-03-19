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
    Current file: fanx_admin/pages/themes.php
    First created: 1.9.2011

 *********************/

/**
 * The template for themes
 */
?>
<h1>Themes</h1>
<?php echo show_messages(); ?>

<?php foreach($all_themes as $theme): ?>
<div style="float:left; margin:10px; width:150px; height:300px;">
<p>Name: <?php echo ucwords($theme['name']); ?></p>
<img width="150" src="<?php echo URL . $theme['thumbnail']; ?>" alt="Theme Thumbnail" />
<p><?php echo $theme['description']; ?></p>
<p>
    <?php if($theme['name'] == THEME): ?>
    <strong>Current theme</strong>
    <?php else: ?>
    <a href="?page=themes&action=activate&theme=<?php echo $theme['name']; ?>">Activate this theme</a>
    <?php endif; ?>
</p>
</div>
<?php endforeach; ?>

