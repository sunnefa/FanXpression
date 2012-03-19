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
    Current file: fanx_admin/fanx_login.php
    First created: 12.7.2011

 *********************/

/**
 * Handles everything to do with logging in and resetting passwords
 */

//get an instance of the user model
$user_model = UserModel::get_instance();

$laction = isset($_GET['laction']) ? $_GET['laction'] : 'login';

switch($laction) {
    case 'login':
        //if the login form has been submitted
        if(isset($_POST['login'])) {
            //get a single user back based on the username
            $user_data = $user_model->get_single_user('username', $_POST['username']);
            //check if the 'remember me' check box was checked
            $remember = (isset($_POST['remember'])) ? 'on' : 'off';
            if(!empty($user_data)) {
                //check if the inputted password matches the one in the database
                if($user_data['password'] == fanx_salty($_POST['password'])) {
                    //set a session holding the username
                    $_SESSION['fanx_admin_login']['username'] = $user_data['username'];
                    //set a session holding the time the user logged in
                    $_SESSION['fanx_admin_login']['time'] = time();
                    //set a session holding the role of the user
                    $_SESSION['fanx_admin_login']['role'] = $user_data['role'];

                    //if the remember me is on
                    if($remember == 'on') {
                        //the cookie will expire in 30 days
                        $expire = time() + 30 * 24 * 60 * 60;
                        //set a cookie with the username
                        setcookie('fanx_admin_login[username]', $user_data['username'], $expire, '/');
                        //set a cookie with the login time
                        setcookie('fanx_admin_login[time]', time(), $expire, '/');
                        //set a cookie with the user's role
                        setcookie('fanx_admin_login[role]', $user_data['role'], $expire, '/');
                    }
                    //reload the page
                    reload();
                } else {
                    //if the password didn't match there is an error
                    $_SESSION['errors'][] = 'Incorrect password';
                    //reload the page
                    reload();
                }
            } else {
                $_SESSION['errors'][] = 'Incorrect username';
                reload();
            }
        //if the form has not been submitted
        } else {
            //include the login form
            include ADMIN_PAGES . 'login.php';
        }
        break;
    
    case 'forgot':
        if(isset($_POST['forgot'])) {
            if(empty($_POST['email'])) {
                $errors[] = 'Please fill in you email address';
            } elseif(!is_email($_POST['email'])) {
                $errors[] = 'That is not a valid email address';
            }
            
            if(!empty($errors)) {
               $_SESSION['errors'] = $errors;
            } else {
                $user_data = $user_model->get_single_user('email', $_POST['email']);
                if(!empty($user_data)) {
                    $password = generate_password(10);
                    $update = $user_model->update_single_field('password', $password['enc_pass'], $user_data['id']);
                    if($update === true) {
                        $sending = send_new_password($_POST['email'], $password['pass'], $user_data['username']);
                        if(!$sending) {
                            $_SESSION['errors'][] = 'Could not send email';
                        } else {
                            $_SESSION['success'] = 'We have sent you your username and a new password';
                        }
                    } else {
                        $_SESSION['errors'][] = 'Could not change password';
                    }
                } else {
                    $_SESSION['errors'][] = 'That email is not registered';
                }
            }
            reload();
        } else {
            include ADMIN_PAGES . 'forgot_form.php';
        }
        break;
}
if(isset($_SESSION['errors'])) unset($_SESSION['errors']);
if(isset($_SESSION['success'])) unset($_SESSION['success']);
?>
