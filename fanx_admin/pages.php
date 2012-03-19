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
    Current file: fanx_admin/pages.php
    First created: 22.7.2011

 *********************/

/**
 * Controller for the pages
 */

$pages_model = PagesModel::get_instance();
$super_model = CategoriesModel::get_instance();

$action = (isset($_GET['action'])) ? $_GET['action'] : 'all';

switch($action) {
    case 'all':
        $all_pages = $pages_model->get_all_pages("status != 'trash'");
        
        $all_num = count($all_pages);
        
        $pages = array_chunk($all_pages, 10);
        
        $all_p = count($pages);
        
        $p = (isset($_GET['p'])) ? $_GET['p']-1 : 0;
        
        $trash_num = count($pages_model->get_all_pages("status = 'trash'"));
        
        include ADMIN_PAGES . 'pages.php';
        include ADMIN_PAGES . 'pagination.php';
        break;
    
    case 'edit':
        if(!isset($_GET['id'])) {
            $_SESSION['errors'][] = 'That is not a valid id';
        } else {
            if(isset($_POST['edit_page'])) {
                
                if(empty($_POST['title'])) {
                    $errors[] = 'Pages must have a title';
                } else {
                    $page_title = $_POST['title'];
                }
                
                if(empty($_POST['category'])) {
                    $errors[] = 'Pages must have a category';
                }
                
                if(!empty($errors)) {
                    $_SESSION['errors'] = $errors;
                    reload();
                } else {
                    $success = $pages_model->update_page($_GET['id'], $page_title, $_POST['content'], $_POST['category'], $_POST['status']);
                    if(!is_bool($success)) {
                        $_SESSION['errors'][] = 'Could not update page ' . $success;
                        reload();
                    } else {
                        $_SESSION['success'] = 'Page updated';
                        reload();
                    }
                }
                
            } else {
                $single_page = $pages_model->get_single_page('p.id', $_GET['id']);

                $categories = $super_model->get_all_categories(0);
                ob_start();
                recurse_categories($categories, 'select', $single_page['category_id']);
                $cat_list = ob_get_clean();
                
                include ADMIN_PAGES . 'pages_form.php';
            }
        }
        break;
    
    case 'add':
        if(isset($_POST['add_page'])) {
            
            if(empty($_POST['title'])) {
                $errors[] = 'Page title must not be empty';
            }
            if(empty($_POST['category'])) {
                $errors[] = 'Category must not be empty';
            }
            
            if(!isset($_POST['status'])) {
                $errors[] = 'All pages must be either published or unpublished (drafts)';
            }
            
            if(!empty($errors)) {
                $_SESSION['errors'] = $errors;
                reload();
            } else {
                $user_id = get_loggedin_userid();
                $insert = $pages_model->add_page($_POST['title'], $_POST['content'], $_POST['category'], time(), $user_id, $_POST['status']);
                
                if(!is_numeric($insert)) {
                    $_SESSION['errors'][] = 'Could not add page';
                    reload();
                } else {
                    $_SESSION['success'] = 'Page added successfully';
                    reload('page=pages&action=edit&id=' . $insert);
                }
            }
        } else {
            $categories = $super_model->get_all_categories(0);
            ob_start();
            recurse_categories($categories, 'select', 0);
            $cat_list = ob_get_clean();
            
            include ADMIN_PAGES . 'pages_form.php';
        }
        break;
    
    case 'trash':
        $all = count($pages_model->get_all_pages("status != 'trash'"));
        if(!isset($_GET['id'])) {
            $_SESSION['errors'][] = 'Invalid page id';
        } else {
            $success = $pages_model->update_single_field('status', 'trash', $_GET['id']);
            if(!is_bool($success)) {
                $_SESSION['errors'][] = 'Could not move page to trash ' . $success;
            } else {
               $_SESSION['success'] = 'Page moved to trash';
            }
        }
        if($all > 1) {
            reload('page=pages');
        } else {
            reload('page=pages&action=trashcan');
        }
        break;
        
    case 'restore':
        
        $trashed = count($pages_model->get_all_pages("status = 'trash'"));
        
        if(!isset($_GET['id'])) {
            $_SESSION['errors'][] = 'Invalid page id';
        } else {
            $success = $pages_model->update_single_field('status', 'published', $_GET['id']);
            if(!is_bool($success)) {
                $_SESSION['errors'][] = 'Could not restore page ';
            } else {
                $_SESSION['success'] = 'Page restored';
            }
        }
        if($trashed > 1) {
            reload('page=pages&action=trashcan');
        } else {
            reload('page=pages');
        }
        break;
        
     case 'trashcan':
         $all_num = count($pages_model->get_all_pages("status != 'trash'"));
         
         $all_pages = $pages_model->get_all_pages("status = 'trash'");
         
         $pages = array_chunk($all_pages, 10);
         
         $all_p = count($pages);
         
         $trash_num = count($all_pages);
         
         $p = (isset($_GET['p'])) ? $_GET['p']-1 : 0;
         
         include ADMIN_PAGES . 'pages.php';
         include ADMIN_PAGES . 'pagination.php';
         
         break;
     
     case 'delete':
         $trashed = count($pages_model->get_all_pages("status = 'trash'"));
         if(!isset($_GET['id'])) {
             $_SESSION['errors'][] = 'Invalid id';
         } else {
             $success = $pages_model->delete_page($_GET['id']);
             if(!$success) {
                 $_SESSION['errors'][] = 'Could not delete page';
             } else {
                 $_SESSION['success'] = 'Page deleted forever. You cannot undo this action';
             }
         }
         if($trashed > 1) {
             reload('page=pages&action=trashcan');
         } else {
             reload('page=pages');
         }
         break;
}

if(isset($_SESSION['errors'])) unset($_SESSION['errors']);
if(isset($_SESSION['success'])) unset($_SESSION['success']);
?>
