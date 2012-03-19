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
    Current file: fanx_admin/sections.php
    First created: 23.8.2011

 *********************/

/**
 * Controller for the sections
 */

$section_model = SectionModel::get_instance();
$super_model = CategoriesModel::get_instance();

$action = (isset($_GET['action'])) ? $_GET['action'] : 'all';

$section_links = $section_model->get_all_sections('s.active != 0');

switch($action) {
    
    case 'all':
        $show = (isset($_GET['show'])) ? $_GET['show'] : 'all';
        switch($show) {
            case 'active':
                $all_sections = $section_model->get_all_sections('s.active != 0');
                break;
            case 'inactive':
                $all_sections = $section_model->get_inactive_sections();
                break;
            case 'all':
                $active_sections = $section_model->get_all_sections('s.active != 0');
                $inactive_sections = $section_model->get_inactive_sections();
                if(empty($active_sections)) {
                    $all_sections = $inactive_sections;
                } elseif(empty($inactive_sections)) {
                    $all_sections = $active_sections;
                } else {
                    $all_sections = $active_sections;
                    foreach($inactive_sections as $inactive) {
                        $all_sections[] = $inactive;
                    }
                }
                break;
        }
        $sections = array_chunk($all_sections, 10);

        $p = (isset($_GET['p'])) ? $_GET['p']-1 : 0;

        $all_p = count($sections);
        
        include ADMIN_PAGES . 'sections.php';
        include ADMIN_PAGES . 'pagination.php';
        break;
    
    case 'add_new':
        //as of version 0.6 this feature has been added to the wish list
        break;
    
    case 'edit':
        if(!isset($_GET['id'])) {
            $_SESSION['errors'][] = 'Invalid id';
            reload('page=extensions');
        } else {
            if(isset($_POST['edit_section'])) {
                if(empty($_POST['title'])) {
                    $title = $_POST['name_title'];
                } else {
                    $title = $_POST['title'];
                }
                
                $success = $section_model->update_section($_GET['id'], $title, $_POST['category']);
                if(!is_bool($success)) {
                    $_SESSION['errors'][] = 'Could not update extension settings';
                } else {
                    $_SESSION['success'] = 'Extension settings updated';
                }
                reload();
            } else {
                $section = $section_model->get_single_section('id', $_GET['id']);
                
                $categories = $super_model->get_all_categories(0);
                ob_start();
                recurse_categories($categories, 'select', $section['cat_id']);
                $cat_list = ob_get_clean();
                
                include ADMIN_PAGES . 'sections_form.php';
                
            }
        }
        break;
    
    case 'deactivate':
        if(!isset($_GET['id'])) {
            $_SESSION['errors'][] = 'Invalid id';
        } else {
            $success = $section_model->update_single_section_field($_GET['id'], 'active', 0);
            echo $success;
            if(!$success) {
                $_SESSION['errors'][] = 'Could not deactivate extension';
            } else {
                $_SESSION['success'] = 'Extension deactivated';
            }
        }
        reload('page=extensions');
        break;
    
    case 'activate':
        if(!isset($_GET['name'])) {
            $_SESSION['errors'][] = 'Invalid extension name';
        }
        else {
            $added = $section_model->get_single_section('s.name', $_GET['name']);
            if(!empty($added)) {
                $success = $section_model->update_single_section_field($added['id'], 'active', 1);
                if(!$success) {
                    $_SESSION['errors'][] = 'Could not activate extension';
                } else {
                    $_SESSION['success'] = 'Extension activated';
                }
            } else {
                $success = $section_model->add_section(ucwords($_GET['name']), $_GET['name'], 1, 0);
                if(is_bool($success)) {
                    $_SESSION['errors'][] = 'Could not activate extension';
                } else {
                    if(file_exists(EXTENSIONS . $_GET['name'] . '/install.php')) {
                        include EXTENSIONS . $_GET['name'] . '/install.php';
                    }
                    $_SESSION['success'] = 'Extension activated';
                }
            }
        }
        reload('page=extensions');
        break;
    
    case 'remove':
        //this feature has as of version 0.6 been added to the wish list
        break;
    
    case 'extension':
        if(!isset($_GET['name'])) {
            $_SESSION['errors'][] = 'Invalid extension selected';
            reload('page=extensions');
        } else {
            $section = $section_model->get_single_section('name', $_GET['name']);
            if(is_array($section)) {
                if($section['active'] == 1) {
                    include EXTENSIONS . $section['name'] . '/' . 'index.php';
                } else {
                    $_SESSION['errors'][] = 'That extension is not active';
                    reload('page=extensions');
                }
            } else {
                $_SESSION['errors'][] = 'No extension with that name was found';
                reload('page=extensions');
            }
        }
        break;
    
}
if(isset($_SESSION['errors'])) unset($_SESSION['errors']);
if(isset($_SESSION['success'])) unset($_SESSION['success']);
?>
