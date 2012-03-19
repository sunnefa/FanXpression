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
    Current file: fanx_admin/settings.php
    First created: 19.7.2011

 *********************/

/**
 * Controller for the settings
 */

$settings = SettingsModel::get_instance();

if(is_admin()) {
    if(isset($_POST['update_settings'])) {
        unset($_POST['update_settings']);
        foreach($_POST as $field => $value) {
            $success = $settings->update_settings($field, $value);
            if(!$success) {
                $_SESSION['errors'][] = 'Could not update ' . $field;
            } else {
                $_SESSION['success'] = 'Settings saved';
            }
        }
        reload();
    } else {
        
        $timezones = timezone_identifiers_list();

        $themes = scandir(THEMES);
        unset($themes[0], $themes[1]);
        include ADMIN_PAGES . 'settings.php';
        if(isset($_SESSION['errors'])) unset($_SESSION['errors']);
        if(isset($_SESSION['success'])) unset($_SESSION['success']);
    }
} else {
    echo 'You do not have access to this page';
}

?>
