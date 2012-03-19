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
    Current file: fanx_admin/categories.php
    First created: 19.7.2011

 *********************/

/**
 * Controller for the categories
 */

$super_model = CategoriesModel::get_instance();


$action = (isset($_GET['action'])) ? $_GET['action'] : 'all';

switch($action) {
    case 'all':
        
        $all_categories = $super_model->get_all_categories(0);
        
        $categories = array_chunk($all_categories, 10);
        
        $all_p = count($categories);
        
        $p = (isset($_GET['p'])) ? $_GET['p']-1 : 0;
        
        ob_start();
        recurse_categories($categories[$p], 'list');
        $cat_list = ob_get_clean();

        include ADMIN_PAGES . 'categories.php';
        include ADMIN_PAGES . 'pagination.php';
        
        break;
    
    case 'add':
        
        if(isset($_POST['add_super'])) {
            
            $errors = array();
            
            if(empty($_POST['cat_name'])) {
                $errors[] = 'Category name must not be empty';
            } else {
                $name = $_POST['cat_name'];
            }
            
            if(empty($_POST['parent_cat'])) {
                $parent = 0;
            } else {
                $parent = $_POST['parent_cat'];
            }
            
            if(!empty($errors)) {
                $_SESSION['errors'] = $errors;
                reload();
            } else {
                $result = $super_model->add_category($name, $_POST['cat_desc'], $parent);
                if(!is_numeric($result)) {
                    $_SESSION['errors'][] = $result;
                    reload();
                } else {
                    $_SESSION['success'] = 'Category added successfully';
                    reload('page=categories&action=edit&id=' . $result);
                }
            }
            
        } else {
            $categories = $super_model->get_all_categories(0);
            ob_start();
            recurse_categories($categories, 'select');
            $cat_list = ob_get_clean();
            include ADMIN_PAGES . 'categories_form.php';
        }
        
        break;
    
    case 'edit':
        if(!isset($_GET['id'])) {
            $_SESSION['errors'][] = 'That is not a valid id';
            reload('page=categories&action=all');
        } else {
            if(isset($_POST['edit_super'])) {
                
                if($_POST['parent_cat'] == $_GET['id']) {
                    $errors[] = "A category cannot be it's own parent";
                }
                
               $children = $super_model->get_all_categories($_GET['id']);
               if(!empty($children)) {
                   foreach($children as $child) {
                       if($child['id'] == $_POST['parent_cat']) {
                           $errors[] = "A category cannot be the child of it's own children";
                       }
                   }
               }
               
               if(empty($_POST['cat_name'])) {
                   $errors[] = 'A category needs to have a name';
               }
                
                if(!empty($errors)) {
                    $_SESSION['errors'] = $errors;
                    reload();
                } else {
                   $result = $super_model->update_category($_POST['cat_name'], $_POST['cat_desc'], $_POST['parent_cat'], $_GET['id']);
                   if(!is_bool($result)) {
                       $_SESSION['errors'][] = $result;
                       reload();
                   } else {
                       $_SESSION['success'] = 'Category updated successfully';
                       reload();
                   }
                }
            } else {
                
                $cat = $super_model->get_single_category('id', $_GET['id']);
                
                $categories = $super_model->get_all_categories(0);
                ob_start();
                recurse_categories($categories, 'select', $cat['parent']);
                $cat_list = ob_get_clean();
                
                include ADMIN_PAGES . 'categories_form.php';
            }
        }
        break;
    
    case 'remove':
        if(!isset($_GET['id'])) {
            $_SESSION['errors'][] = 'That is not a valid id';
        } else {
           $children = $super_model->get_all_categories($_GET['id']);
           $deleted_cat = $super_model->get_single_category('id', $_GET['id']);
           if(is_array($children)) {
               foreach($children as $child) {
                   if($child['parent'] == $_GET['id']) {
                       $res = $super_model->update_single_field('parent', $deleted_cat['parent'], $child['id']);
                       if(!is_bool($res)) $errors[] = $res;
                   }
               }
           }
           $section_model = SectionModel::get_instance();
           $sections = $section_model->get_all_sections('cat_id = ' . $_GET['id']);
           if(!empty($sections)) {
               foreach($sections as $section) {
                   $success = $section_model->update_single_section_field($section['id'], 'active', 0);
                   if(!$success) {
                       $errors[] = 'Could not deactive ' . $section['name'];
                   }
               }
           }
           
           $pages_model = PagesModel::get_instance();
           $pages = $pages_model->get_all_pages('cat_id = ' . $_GET['id']);
           if(!empty($pages)) {
               foreach($pages as $single_page) {
                   $success = $pages_model->delete_page($single_page['id']);
                   if(!$success) {
                       $errors[] = 'Could not delete all pages';
                   }
               }
           }
           
           $del = $super_model->remove_category($_GET['id']);
           if(!is_bool($del)) $errors[] = $del;
           
           if(!empty($errors)) {
               $_SESSION['errors'] = $errors;
           } else {
               $_SESSION['success'] = 'Category deleted. You cannot undo this action';
           }
           reload('page=categories');
        }
        break;
}

if(isset($_SESSION['errors'])) unset($_SESSION['errors']);
if(isset($_SESSION['success'])) unset($_SESSION['success']);
