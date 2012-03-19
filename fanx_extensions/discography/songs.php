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
    Current file: fanx_sections/discography/songs.php
    First created: 23.8.2011

 *********************/

/**
 * Controller for discography songs
 */

$saction = (isset($_GET['saction'])) ? $_GET['saction'] : 'all';

switch($saction) {
    case 'all';
        $all_songs = $disco_model->get_all_songs();
        
        $songs = array_chunk($all_songs, 10);
        
        $p = (isset($_GET['p'])) ? $_GET['p']-1 : 0;
        
        $all_p = count($songs);
        
        if(isset($_GET['saction'])) {
            $path = str_replace('&', '&amp;', $_SERVER['QUERY_STRING']); 
            $path = str_replace('saction=all', '', $path);
        } else {
            $path = str_replace('&', '&amp;', $_SERVER['QUERY_STRING']) . '&amp;';
        }
        
        include 'templates/songs.php';
        include ADMIN_PAGES . 'pagination.php';
        break;
    
    case 'edit':
        if(!isset($_GET['id'])) {
            $_SESSION['errors'][] = 'Invalid id';
        } else {
            if(isset($_POST['edit_song'])) {
                if(empty($_POST['title'])) {
                    $errors[] = 'Title must not be empty';
                }
                
                if(empty($_POST['album']) || $_POST['album'] == 0) {
                    $errors[] = 'An album must be selected';
                }
                
                if(!empty($errors)) {
                    $_SESSION['errors'] = $errors;
                } else {
                    $success = $disco_model->update_song($_GET['id'], $_POST['title'], $_POST['length'], $_POST['composer'], $_POST['lyrics'], $_POST['album']);
                    if(!is_bool($success)) {
                        $_SESSION['errors'][] = 'Could not update song ' . $success;
                    } else {
                        $_SESSION['success'] = 'Song updated';
                    }
                }
                reload();
            } else {
                $song = $disco_model->get_single_song('s.id', $_GET['id']);
                
                $albums = $disco_model->get_all_albums();
                
                include 'templates/song_form.php';
            }
        }
        break;
    
    case 'add':
        if(isset($_POST['add_song'])) {
            if(empty($_POST['title'])) {
                $errors[] = 'Title must not be empty';
            }
            
            if(empty($_POST['album']) || $_POST['album'] == 0) {
                $errors[] = 'An album must be selected';
            }
            
            if(!empty($errors)) {
                $_SESSION['errors'] = $errors;
                reload();
            } else {
                $insert = $disco_model->add_song($_POST['title'], $_POST['length'], $_POST['composer'], $_POST['lyrics'], $_POST['album']);
                if(is_bool($insert)) {
                    $_SESSION['errors'][] = 'Could not add song';
                    reload();
                } else {
                    $_SESSION['success'] = 'Song added';
                    $reload = str_replace('add', 'edit', $_SERVER['QUERY_STRING']);
                    reload($reload . '&id=' . $insert);
                }
            }
        } else {
            $albums = $disco_model->get_all_albums();
            include 'templates/song_form.php';
        }
        break;
    
    case 'remove':
        if(!isset($_GET['id'])) {
            $_SESSION['errors'][] = 'Invalid id';
        } else {
            $success = $disco_model->remove_song('id', $_GET['id']);
            if(!is_bool($success)) {
                $_SESSION['errors'][] = 'Could not remove song ' . $success;
            } else {
                $_SESSION['success'] = 'Song removed. You cannot undo this action.';
            }
        }
        $reload = str_replace('&saction=remove&id=' . $_GET['id'], '', $_SERVER['QUERY_STRING']);
        reload($reload);
        break;
}
?>