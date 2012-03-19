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
    Current file: fanx_sections/discography/templates/categories_select.php
    First created: 23.8.2011

 *********************/

/**
 * A dropdown of categories
 */
?>
<option <?php echo $selected; ?> value="<?php echo $category['id']; ?>"><?php echo str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $category['depth']); ?><?php echo $category['name']; ?></option>
