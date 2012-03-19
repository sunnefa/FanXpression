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
    Current file: fanx_sections/discography/categories.php
    First created: 23.8.2011

 *********************/

/**
 * Controller for discography categories
 */

$caction = (isset($_GET['caction'])) ? $_GET['caction'] : 'all';
switch($caction) {
    
    case 'all':
        $all_categories = $disco_model->get_all_categories(0);
        if(!empty($all_categories)) {
			$categories = array_chunk($all_categories, 10);
			
			$p = (isset($_GET['p'])) ? $_GET['p']-1 : 0;
			
			$all_p = count($categories);
			
			ob_start();
			recurse_disco_cats($categories[$p], 'list');
			$catlist = ob_get_clean();
		} else {
			$catlist = '<p>No categories to display</p>';
			$all_p = 0;	
		}
        
        include 'templates/categories.php';
        include ADMIN_PAGES . 'pagination.php';
        break;
    
    case 'edit':
        if(!isset($_GET['id'])) {
            $_SESSION['errors'][] = 'Invalid category id';
        } else {
            if(isset($_POST['update_cat'])) {
                
                if(empty($_POST['name'])) {
                    $errors[] = 'Name must not be empty';
                }
                
                if($_POST['parent'] == $_GET['id']) {
                    $errors[] = "A category cannot be it's own parent";
                }
                
                $kids = $disco_model->get_all_categories($_GET['id']);
                if(!empty($kids)) {
                    foreach($kids as $kid) {
                        if($kid['id'] == $_POST['parent']) {
                            $errors[] = "A category cannot be the child of it's own children";
                        }
                    }
                }
                
                if(!empty($errors)) {
                    $_SESSION['errors'] = $errors;
                } else {
                    $success = $disco_model->update_category($_GET['id'], $_POST['name'], $_POST['description'], $_POST['parent']);
                    if(!is_bool($success)) {
                        $_SESSION['errors'][] = $success;
                    } else {
                        $_SESSION['success'] = 'Category updated successfully';
                    }
                }
                reload();
                
            } else {
                $cat = $disco_model->get_single_category('id', $_GET['id']);
                
                $categories = $disco_model->get_all_categories(0);
                ob_start();
                recurse_disco_cats($categories, 'select', $cat['parent']);
                $cat_list = ob_get_clean();
                
                include 'templates/categories_form.php';
            }
        }
        break;
    
    case 'add':
        if(isset($_POST['add_cat'])) {
            
            if(empty($_POST['name'])) {
                $errors[] = 'Name must not be empty';
            }
            
            if(!empty($errors)) {
                $_SESSION['errors'] = $errors;
                reload();
            } else {
                $insert = $disco_model->add_category($_POST['name'], $_POST['description'], $_POST['parent']);
                if(!is_numeric($insert)) {
                    $_SESSION['errors'][] = 'Could not add category';
                    reload();
                } else {
                    $_SESSION['success'] = 'Category added successfully';
                    $reload = str_replace('add', 'edit', $_SERVER['QUERY_STRING']);
                    reload($reload . '&id=' . $insert);
                }
            }
        } else {
            $categories = $disco_model->get_all_categories(0);
            ob_start();
            recurse_disco_cats($categories, 'select', 0);
            $cat_list = ob_get_clean();

            include 'templates/categories_form.php';
        }
        break;
    
    case 'delete':
        if(!isset($_GET['id'])) {
            $_SESSION['errors'][] = 'Invalid id';
        } else {
            $children = $disco_model->get_all_categories($_GET['id']);
            $deleted_cat = $disco_model->get_single_category('id', $_GET['id']);
            if(is_array($children)) {
               foreach($children as $child) {
                   if($child['parent'] == $_GET['id']) {
                       $res = $disco_model->update_single_category_field($child['id'], 'parent', $deleted_cat['parent']);
                       if(!is_bool($res)) $errors[] = $res;
                   }
               }
            }
            
            $albums = $disco_model->get_all_albums('a.category_id = ' . $_GET['id']);
            if(!empty($albums)) {
                foreach($albums as $album) {
                    $success = $disco_model->update_single_album_field($album['id'], 'category_id', 0);
                    if(!$success) {
                        $errors[] = 'Could not move albums from category';
                    }
                }
            }
            
            $del = $disco_model->remove_category($_GET['id']);
            if(!is_bool($del)) $errors[] = $del;
            
            if(!empty($errors)) {
                $_SESSION['errors'] = $errors;
            } else {
                $_SESSION['success'] = 'Category deleted. You cannot undo this action.';
            }
        }
        $reload = str_replace('&caction=delete&id=' . $_GET['id'], '', $_SERVER['QUERY_STRING']);
        reload($reload);
        break;
}
?>