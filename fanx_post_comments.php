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
    Current file: fanx_post_comments.php
    First created: 12.9.2011

 *********************/

/**
 * This is fanx_post_comments.php. It is responsible for adding comments to the database
 */
session_start();
define('FANX', true);
include 'fanx_config/init.php';
if(isset($_POST['add_comment'])) {
    if(isset($_POST['user_id'])) {
        $user_id = $_POST['user_id'];
        $name = null;
        $website = null;
        $email = null;
    } else {
        $user_id = null;


        if(empty($_POST['name']) && !isset($_POST['user_id'])) {
            $errors['name'] = 'Please fill in your name';
        } else {
            $name = $_POST['name'];
        }

        if(empty($_POST['website']) && !isset($_POST['user_id'])) {
            $errors['website'] = 'Please fill in your website';
        } else {
            $website = $_POST['website'];
        }

        if(empty($_POST['email']) && !isset($_POST['user_id'])) {
            $errors['email'] = 'Please fill in your email address';
        } elseif(!is_email($_POST['email']) && !isset($_POST['user_id'])) {
            $errors['email'] = 'That is not a valid email address';
        } else {
            $email = $_POST['email'];
        }
    }
    
    if(empty($_POST['comment'])) {
        $errors['comment'] = 'Please write a comment';
    } else {
        $comment = $_POST['comment'];
    }
    
    if(APPROVE_COMMENTS == 1) {
        $approved = 1;
    } elseif(isset($_POST['user_id'])) {
        $approved = 1;
    } else {
        $approved = 0;
    }
    
    if(!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header('Location: ' . URL . $_POST['permalink'] . '/');
    } else {
        $posts_model = PostsModel::get_instance();
        $success = $posts_model->add_post_comment($_POST['post_id'], $user_id, $name, $email, $website, $comment, $approved);
        if(!is_numeric($success)) {
            $_SESSION['errors']['adding_error'] = 'Could not add comment ' . $success;
        } else {
            if($approved == 1) {
                $_SESSION['success'] = 'Your comment has been added.';
            } else {
                $_SESSION['success'] = 'Your comment has been added. An administrator must approve it before it appears here.';
            }
        }
        header('Location: ' . URL . $_POST['permalink'] . '/');
    }
} else {
    die('You cannot view this page directly');
}
?>
