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
    Current file: fanx_admin/pages/setings.php
    First created: 19.7.2011

 *********************/

/**
 * The form to update settings
 */
?>
<h1>Settings</h1>
<?php echo show_messages(); ?>

<form action="?<?php echo str_replace('&', '&amp;', $_SERVER['QUERY_STRING']); ?>" method="post">
    <ul>
        <li><label for="title">Title</label><input type="text" id="title" name="title" value="<?php echo TITLE; ?>" /></li>
        <li>
            <label for="url">Default url</label>
            <input type="text" name="url" id="url" value="<?php echo URL; ?>" />
            <p style="margin:0;">(<small>please only change this if you know what you're doing</small>)</p>
        </li>
        <li><label for="posts_per_page">Posts per page</label>
        <input type="text" name="posts_per_page" id="posts_per_page" value="<?php echo POSTS_PER_PAGE; ?>" /></li>
        <li><label for="theme">Theme:</label>
            <select name="theme">
                <?php foreach($themes as $theme): ?>
                <option value="<?php echo $theme; ?>"><?php echo ucfirst($theme); ?></option>
                <?php endforeach; ?>
            </select>
        </li>
        <li><label for="max_image_size">Max size of uploaded images (in pixels): </label><input type="text" name="max_image_size" id="max_image_size" value="<?php echo MAX_IMAGE_SIZE; ?>" /></li>
        <li>
            <label for="approve_comments">Automatically approve comments?</label>
            <select name="approve_comments" id="approve_comments">
                <?php if(APPROVE_COMMENTS == 1): ?>
                <option value="1" selected>Yes</option>
                <option value="0">No</option>
                <?php else: ?>
                <option value="0" selected>No</option>
                <option value="1">Yes</option>
                <?php endif; ?>
            </select>
        </li>
        <li>
            <label for="date_format">Date format:</label>
            <input type="text" name="date_format" id="date_format" value="<?php echo DATE_FORMAT; ?>" />
            <p><a href="http://php.net/manual/en/function.date.php">Documentation on date and time formats</a></p>
        </li>
        <li>
            <label for="timezone">Timezone:</label>
            <select name="timezone" id="timezone">
                <?php foreach($timezones as $timezone): ?>
                <?php $selected = ($timezone == TIMEZONE) ? 'selected' : ''; ?>
                <option value="<?php echo $timezone; ?>" <?php echo $selected; ?>><?php echo $timezone; ?></option>
                <?php endforeach; ?>
            </select>
            <p style="margin:0;">(<small>Select your city or the city closest to you</small>)</p>
        </li>
        <li><input type="submit" class="submit" name="update_settings" value="Save changes" /></li>
    </ul>
</form>


