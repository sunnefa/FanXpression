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
    Current file: fanx_admin/themes.php
    First created: 1.9.2011

 *********************/

/**
 * Controller for the themes
 */

$action = isset($_GET['action']) ? $_GET['action'] : 'all';

switch($action) {
    case 'all':
        
        $all_themes[0]['name'] = THEME;
        $all_themes[0]['description'] = (file_exists(THEMES . THEME .'/description.txt')) ? file_get_contents(THEMES . THEME . '/description.txt') : '';
        $all_themes[0]['thumbnail'] = (file_exists(THEMES . THEME . '/thumb.jpg')) ? 'fanx_themes/' . THEME . '/thumb.jpg' : 'fanx_admin/images/noimage.jpg';
        
        $themes = scandir(THEMES);
        unset($themes[0], $themes[1]);
        foreach($themes as $key => $theme) {
            if($theme != THEME) {
                $all_themes[$key+1]['name'] = $theme;
                $all_themes[$key+1]['description'] = (file_exists(THEMES . $theme . '/description.txt')) ? file_get_contents(THEMES . $theme . '/description.txt') : '';
                $all_themes[$key+1]['thumbnail'] = (file_exists(THEMES . $theme . '/thumb.jpg')) ? 'fanx_themes/' . $theme . '/thumb.jpg' : 'fanx_admin/images/noimage.jpg';
            }
        }
        
        include ADMIN_PAGES . 'themes.php';
        break;
    
    case 'edit':
        //this feature has been moved to the wishlist
        //it will likely not be made for version 1.0
        break;
    
    case 'activate':
        if(!isset($_GET['theme'])) {
            $_SESSION['errors'][] = 'Invalid theme';
        } else {
            $settings_model = SettingsModel::get_instance();
            $success = $settings_model->update_settings('theme', $_GET['theme']);
            if(!$success) {
                $_SESSION['errors'][] = 'Could not activate theme';
            } else {
                $_SESSION['success'] = 'Theme ' . $_GET['theme'] . ' activated';
            }
        }
        reload('page=themes');
        break;
}
?>
