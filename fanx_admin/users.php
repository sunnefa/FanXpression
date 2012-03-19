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
    Current file: fanx_admin/users.php
    First created: 12.7.2011

 *********************/

/**
 * Controller for the users
 */

$action = (isset($_GET['action'])) ? $_GET['action'] : 'all';
$user_model = UserModel::get_instance();
switch($action) {
    //get a list of users
    case 'all':
        $all_users = $user_model->get_all_users();
        
        $users = array_chunk($all_users, 10);
        
        $all_p = count($users);
        
        $p = (isset($_GET['p'])) ? $_GET['p']-1 : 0;
        
        include ADMIN_PAGES . 'users_all.php';
        include ADMIN_PAGES . 'pagination.php';
        break;
    
    //edit a single profile
    case 'profile':
        //if the profile form has been submitted
        if(isset($_POST['profile'])) {
            //get the old userdata back from the database
            $user = $user_model->get_single_user('id', $_POST['id']);
            //if no user was returned
            if(!$user) {
                //send an error message
                $_SESSION['errors'][] = 'Invalid user id';
                //we can't proceed
                $proceed = false;
            } 
            //if the old password matches the one in the database if id is not in the query string
            elseif(!empty($_POST['old_password']) && !isset($_GET['id'])) {
                //if the passwords don't match we can't proceed
                if(fanx_salty($_POST['old_password']) != $user['password']) {
                    $_SESSION['errors'][] = 'Password does not match';
                    $proceed = false;
                } else {
                    //if they do match we can
                    $proceed = true;
                }
            }
            //if the logged in user is an admin if the id is in the query string
            elseif(is_admin() && isset($_GET['id'])) {
                //we can proceed
                $proceed = true;
            }
            //if we can proceed we reload the page and show the error messages
            if(!$proceed) {
                reload();
            //if we can we go ahead and do some validation, then insert the data into the database
            } else {
                $fine = array();
                //Check if an image was uploaded
                if(!empty($_FILES['avatar']['name'])) {
                    $image = Images::get_instance();
                    $_FILES['avatar']['name'] = UPLOADS . '100' . $user['id'] . '/' . $_FILES['avatar']['name'];
                    $success = $image->upload_image($_FILES['avatar']);
                    if(!$success) {
                        $_SESSION['errors'][] = 'Could not upload avatar';
                        $fine[] = false;
                    } else {
                        $fine[] = true;
                        $user_avatar = str_replace(ROOT, '/', $_FILES['avatar']['name']);
                    }
                } else {
                    $user_avatar = $user['avatar'];
                    $fine[] = true;
                }
                
                //check that a new password was set
                if(!empty($_POST['new_password'])) {
                    $strong = strong_password($_POST['new_password']);
                    if(!$strong) {
                        $_SESSION['errors'][] = 'Password must be longer than 8 characters and have at least one number, one lowercase and one uppercase character';
                        $fine[] = false;
                    } else {
                        $user_password = fanx_salty($_POST['new_password']);
                        $fine[] = true;
                    }
                } else {
                    $fine[] = true;
                    $user_password = $user['password'];
                }
                
                //check that a new email was set
                if(!is_email($_POST['new_email'])) {
                    $fine[] = false;
                    $_SESSION['errors'][] = 'That is not a valid email address';
                } else {
                    $fine[] = true;
                    $user_email = $_POST['new_email'];
                }
                
                //Check if a new bio was given
                $user_bio = $_POST['new_bio'];
                //Check if a new role was given
                if(isset($_POST['role'])) {
                    $fine[] = true;
                    $user_role = $_POST['role'];
                } else {
                    $fine[] = true;
                    $user_role = $user['role'];
                }
                
                //check if everything was fine
                if(in_array(false, $fine)) {
                    reload();
                } else {
                    $success = $user_model->update_user($user['id'], $user['username'], $user_email, $user_password, $user_avatar, $user_bio, $user_role);
                    if(!$success) {
                        $_SESSION['errors'][] = 'Could not update profile';
                    } else {
                        $_SESSION['success'] = 'Profile successfully updated';
                    }
                    reload();
                }
            }
        //if the form has not been submitted
        } else {
            //if an id is not in the query string
            if(!isset($_GET['id'])) {
                //get the user with the username saved in the cookie or session
               $user = (isset($_COOKIE['fanx_admin_login']['username'])) ? $_COOKIE['fanx_admin_login']['username'] : $_SESSION['fanx_admin_login']['username'];
               $user_data = $user_model->get_single_user('username', $user);
            } else {
              //get the user with the id requested
              $user_data = $user_model->get_single_user('id', $_GET['id']);
            }
            
            //include the html template
            include ADMIN_PAGES . 'users_profile.php';
        }
        break;
    
    case 'add':
        if(isset($_POST['add'])) {
            if(is_admin()) {
                $proceed = true;
            } else {
                $_SESSION['errors'][] = 'You do not have permission to access this page';
                $proceed = false;
            }
            if(!$proceed) {
                reload();
            }
            
            $user_info = array();
            $errors = array();
            
            if(!empty($_POST['username'])) {
                $user_info['username'] = $_POST['username'];
            } else {
                $errors[] = 'Username must not be empty';
            }
            
            if(!empty($_POST['new_email'])) {
                $user_info['email'] = $_POST['new_email'];
            } else {
                $errors[] = 'Email must not be empty';
            }
            
            if(!empty($_POST['new_password'])) {
                $user_info['password'] = $_POST['new_password'];
            } else {
                $errors[] = 'Password must not be empty';
            }
            
            if(!empty($errors)) {
                foreach($errors as $error) {
                    $_SESSION['errors'][] = $error;
                }
                reload();
            } else {
                $valid = $user_model->validate_user_info($user_info);
                if(is_array($valid)) {
                    foreach($valid as $error) {
                        $_SESSION['errors'][] = $error;
                    }
                    reload();
                } else {
                    $insert = $user_model->add_user($_POST['username'], $_POST['new_email'], fanx_salty($_POST['new_password']), $_POST['new_bio'], $_POST['role'], time(), 'active');
                    if(is_numeric($insert)) {
                        if(!mkdir(UPLOADS . '100' . $insert, 0755)) $_SESSION['errors'][] = 'Could not create uploads folder for user';
                        $_SESSION['success'] = 'User successfully added';
                        reload('page=users&action=profile&id=' . $insert);
                    } else {
                        $_SESSION['errors'][] = $insert;
                        $_SESSION['errors'][] = 'Could not insert user';
                        reload();
                    }
                }
            }
            
        } else {
            include ADMIN_PAGES . 'users_profile.php';
        }
        break;
        
    case 'deactivate':
        if(is_admin()) {
            if(!isset($_GET['id'])) {
                $_SESSION['errors'][] = 'That is not a valid user id';
                reload('page=users&action=all');
            } else {
                $success = $user_model->update_single_field('status', 'inactive', $_GET['id']);
                if($success != true) {
                    $_SESSION['errors'][] = $success;
                    $_SESSION['errors'][] = 'Could not edit status';
                    reload('page=users&action=all');
                } else {
                    $_SESSION['success'] = 'User deactivated';
                    reload('page=users&action=all');
                }
            }
        } else {
            $_SESSION['errors'][] = 'You do not have permission to access this page';
            reload('page=users&action=all');
        }
        break;
    
    case 'activate':
        if(is_admin()) {
            if(!isset($_GET['id'])) {
                $_SESSION['errors'][] = 'That is not a valid user id';
                reload('page=users&action=all');
            } else {
                $success = $user_model->update_single_field('status', 'active', $_GET['id']);
                if($success != true) {
                    $_SESSION['errors'][] = $success;
                    $_SESSION['errors'][] = 'Could not edit status';
                    reload('page=users&action=all');
                } else {
                    $_SESSION['success'] = 'User activated';
                    reload('page=users&action=all');
                }
            }
        } else {
            $_SESSION['errors'][] = 'You do not have permission to access this page';
            reload('page=users&action=all');
        }
        break;
        
}
if(isset($_SESSION['errors'])) unset($_SESSION['errors']);
if(isset($_SESSION['success'])) unset($_SESSION['success']);
?>
