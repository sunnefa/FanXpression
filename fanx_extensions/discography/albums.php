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
    Current file: fanx_sections/discography/albums.php
    First created: 23.8.2011

 *********************/

/**
 * Controller for discography albums
 */

$aaction = (isset($_GET['aaction'])) ? $_GET['aaction'] : 'all';

switch($aaction) {
    case 'all':
        $all_albums = $disco_model->get_all_albums();
        
        $albums = array_chunk($all_albums, 10);
        
        $p = (isset($_GET['p'])) ? $_GET['p']-1 : 0;
        
        $all_p = count($albums);
        
        include 'templates/albums.php';
        include ADMIN_PAGES . 'pagination.php';
        
        break;
    
    case 'edit':
        if(!isset($_GET['id'])) {
            $_SESSION['errors'][] = 'Invalid id';
        } else {
            if(isset($_POST['edit_album'])) {
                
                if(empty($_POST['title'])) {
                    $errors[] = 'Album title must not be empty';
                }
                
                if(!empty($_POST['release_date'])) {
                    if(preg_match('(/)', $_POST['release_date'])) {
                        $dates = explode('/', $_POST['release_date']);
                        if(checkdate($dates[0], $dates[1], $dates[2])) {
                            $timestamp = mktime(0, 0, 0, $dates[0], $dates[1], $dates[2]);
                        } else {
                            $errors[] = 'Invalid date format';
                        }
                    } else {
                        $errors[] = 'Invalid date format';
                    }
                } else {
                    $timestamp = null;
                }
                
                if(!empty($_FILES['feature_cover']['name'])) {
                    $name = str_replace(' ', '_', $_POST['title']) . '.';
                    $arr = explode('.', $_FILES['feature_cover']['name']);
                    $match = end($arr);
                    $name .= $match;
                    $images = Images::get_instance();
                    $_FILES['feature_cover']['name'] = EXTENSIONS . 'discography/covers/' . $name;
                    $success = $images->upload_image($_FILES['feature_cover']);
                    if(!$success) {
                        $errors[] = 'Could not upload featured image';
                    } else {
                        $feature_cover = str_replace(ROOT, '/', $_FILES['feature_cover']['name']);
                    }
                }
                
                if(!empty($errors)) {
                    $_SESSION['errors'] = $errors;
                } else {
                    $success = $disco_model->update_album($_GET['id'], $_POST['title'], $timestamp, $feature_cover, $_POST['category']);
                    if(!is_bool($success)) {
                        $_SESSION['errors'][] = 'Could not update album' . $success;
                    } else {
                        $_SESSION['success'] = 'Album updated';
                    }
                }
                reload();
                
            } else {
                $album = $disco_model->get_single_album('a.id', $_GET['id']);
                
                $categories = $disco_model->get_all_categories(0);
                ob_start();
                recurse_disco_cats($categories, 'select', $album['category_id']);
                $cat_list = ob_get_clean();
                
                include 'templates/albums_form.php'; 
            }
        }
        break;
    
    case 'add':
        if(isset($_POST['add_album'])) {
            if(empty($_POST['title'])) {
                $errors[] = 'Album title must not be empty';
            }

            if(!empty($_POST['release_date'])) {
                if(preg_match('(/)', $_POST['release_date'])) {
                    $dates = explode('/', $_POST['release_date']);
                    if(checkdate($dates[0], $dates[1], $dates[2])) {
                        $timestamp = mktime(0, 0, 0, $dates[0], $dates[1], $dates[2]);
                    } else {
                        $errors[] = 'Invalid date format';
                    }
                } else {
                    $errors[] = 'Invalid date format';
                }
            } else {
                $timestamp = null;
            }

            if(!empty($_FILES['feature_cover']['name'])) {
                $name = str_replace(' ', '_', $_POST['title']) . '.';
                $exp = explode('.', $_FILES['feature_cover']['name']);
                $match = end($exp);
                $name .= $match;
                $images = Images::get_instance();
                $_FILES['feature_cover']['name'] = EXTENSIONS . 'discography/covers/' . $name;
                $success = $images->upload_image($_FILES['feature_cover']);
                if(!$success) {
                    $errors[] = 'Could not upload featured image';
                } else {
                    $feature_cover = str_replace(ROOT, '/', $_FILES['feature_cover']['name']);
                }
            } else {
				$feature_cover = '';	
			}
            
            if(!empty($errors)) {
                $_SESSION['errors'] = $errors;
                reload();
            } else {
                $insert = $disco_model->add_album($_POST['title'], $timestamp, $feature_cover, $_POST['category']);
                if(is_bool($insert)) {
                    $_SESSION['errors'][] = 'Could not add album';
                    reload();
                } else {
                    $_SESSION['success'] = 'Album added successfully';
                    $reload = str_replace('add', 'edit', $_SERVER['QUERY_STRING']);
                    reload($reload . '&id=' . $insert);
                }
            }
        } else {
            $categories = $disco_model->get_all_categories(0);
            ob_start();
            recurse_disco_cats($categories, 'select', 0);
            $cat_list = ob_get_clean();

            include 'templates/albums_form.php'; 
        }
        break;
    
    case 'remove':
        if(!isset($_GET['id'])) {
            $_SESSION['errors'][] = 'Invalid id';
        } else {
            $success = $disco_model->remove_album('id', $_GET['id']);
            if(!$success) {
                $_SESSION['errors'][] = 'Could not remove album';
            } else {
                $_SESSION['success'] = 'Album removed. You cannot undo this action.';
            }
        }
        $reload = str_replace('&aaction=remove&id=' . $_GET['id'], '', $_SERVER['QUERY_STRING']);
        reload($reload);
        break;
}
?>