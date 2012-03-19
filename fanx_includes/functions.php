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
    Current file: fanx_includes/functions.php
    First created: 11.7.2011

 *********************/

/**
 * Some important functions 
 */


/**
 * Autoloads classes
 * @param string $classname
 * @return void 
 */
function __autoload($classname) {
    $possibilities = array(
        INCLUDE_PATH . 'models' . DS . $classname . '.php',
        INCLUDE_PATH . 'views' . DS . $classname . '.php',
        INCLUDE_PATH . $classname . '.php',
        );
    if(isset($_GET['name'])) {
        $possibilities[] = EXTENSIONS . $_GET['name'] . '/' . $classname . '.php';
    }
    foreach($possibilities as $possible) {
        if(file_exists($possible) && is_file($possible)) {
            include $possible;
        }
    }
}

/**
 * Hashes a string with both sha1 and md5
 * @param string $string
 * @return hashed string 
 */
function fanx_salty($string) {
    return sha1(md5($string));
}

/**
 * If a session or cookie is set indicating a user is logged in this function returns true
 * @return boolean 
 */
function logged_in() {
    if(isset($_SESSION['fanx_admin_login']) || isset($_COOKIE['fanx_admin_login'])) return true;
    return false;
}

/**
 * Checks for a strong password
 * @param string $string
 * @return boolean
 */
function strong_password($string) {
    if(preg_match('(^.*(?=.{8})(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).*$)', $string)) return true;
    return false;
}

/**
 * Validates an email against a regular expression
 * @param string $string
 * @return boolean
 */
function is_email($string) {
    if(preg_match('(^.*[a-zA-Z0-9-_\.]+@.*[a-zA-Z0-9-_\.]+[\.]+.*[a-z\.]{2,6})', $string)) return true;
    return false;
}

/**
 * Checks if the logged in user is an administrator
 * @return boolean 
 */
function is_admin() {
    if(isset($_SESSION['fanx_admin_login'])) {
        if($_SESSION['fanx_admin_login']['role'] == 'admin') {
            return true;
        } else {
            return false;
        }
    } elseif(isset($_COOKIE['fanx_admin_login'])) {
        if($_COOKIE['fanx_admin_login']['role'] == 'admin') {
            return true;
        }
        else {
            return false;
        }
    }
    return false;
}

/**
 * Checks if the given username matches the one saved in the cookie or session
 * @param string $username
 * @return boolean
 */
function is_own_profile($username) {
    if(isset($_SESSION['fanx_admin_login']) && $_SESSION['fanx_admin_login']['username'] == $username) {
        return true;
    } elseif(isset($_COOKIE['fanx_admin_login']) && $_COOKIE['fanx_admin_login']['username'] == $username) {
        return true;
    }
    return false;
}

/**
 * Checks that a username doesn't have any illegal characters
 * @param string $username
 * @return boolean
 */
function is_username($username) {
    if(preg_match('([^-a-zA-Z0-9_])', $username)) return false;
    return true;
}

/**
 * Executes a header reload
 * @param string $where
 * @return void 
 */
function reload($where = '') {
    if(!empty($where)) {
        header('Location: ?' . $where);
        exit;
    } elseif(empty($_SERVER['QUERY_STRING'])) {
        header('Location: index.php');
        exit;
    } else {
        header('Location: ?' . $_SERVER['QUERY_STRING']);
        exit;
    }
}

/**
 * Gets the id of the currently logged in user
 * @return int
 */
function get_loggedin_userid() {
    $user_model = UserModel::get_instance();
    if(isset($_COOKIE['fanx_admin_login'])) $username = $_COOKIE['fanx_admin_login']['username'];
    elseif(isset($_SESSION['fanx_admin_login'])) $username = $_SESSION['fanx_admin_login']['username'];
    $user = $user_model->get_single_user('username', $username);
    return $user['id'];
}

/**
 * Returns a formatted string with any error or success messages that have been saved in the session
 * @return string
 */
function show_messages() {
    ob_start();
    include ADMIN_PAGES . 'messages.php';
    return ob_get_clean();
}

function send_new_password($email, $password, $username) {
    $user_model = UserModel::get_instance();
    $admin = $user_model->get_single_user('id', 1);
    $title = TITLE;
    $url = substr_replace(URL, '', -1, 1);
    $to = $email;
    $subject = 'Your username and a new password at ' . $title;
    $message = <<<EOT
    <p>Hi $username!</p>
        <p>You or someone using your email address requested a new password for your account at $title</p>
        <p>Your username is: $username</p>
        <p>Your new password is: $password</p>
        <p>You can log in <a href="$url/fanx_admin">here</a> and change your password to something more memorable</p>
        <p>Best regards,</p>
        <p>The $title team</p>
EOT;
    $message = wordwrap($message, 70);
    
    $headers = "From: " . $admin['username'] . "<" . $admin['email'] . ">\r\n";
    $headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
    
    $sending = mail($to, $subject, $message, $headers);
    if(!$sending) return false;
    else return true;
}

function generate_password($length = 10) {
    $pass = "";
    $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
    $arr = str_split($chars);
    for($i = 0; $i < $length; $i++) {
        $rand = array_rand($arr);
        $pass .= $arr[$rand];
    }
    return array('pass' => $pass, 'enc_pass' => fanx_salty($pass));
}

/**
 * Parses the url in the $_SERVER[REQUEST_URI] into an array
 * @return array
 */
function url_parser() {
    //if there is no trailing slash in the url we add it
    if (substr($_SERVER["REQUEST_URI"], -1, 1) != "/") $_SERVER["REQUEST_URI"] .= "/";

    //separate the uri into an array by slashes
    $queries = explode("/", $_SERVER["REQUEST_URI"]);
    //remove the first element because it's empty
    array_shift($queries);
    //remove the last element because it's empty
    array_pop($queries);

    //separate the default url into an array by slashes
    $paths = explode("/", URL);

    //check if any of the items in the $queries array are equal to the items in the $paths array and remove them if they are
    foreach ($queries as $key => $query) {
        foreach($paths as $path) {
            if($query == $path) {
                    unset($queries[$key]);	
            }
        }
    }

    //to make sure that the indexes are always right, we recalculate them
    $queries = array_values($queries);

    return $queries;
}

/**
 * Strips underscores from a string
 * @param string $string
 * @return string
 */
function strip_underscores($string) {
    return str_replace('_', ' ', $string);
}

/**
 * Replaces all underscores with spaces
 * @param string $string
 * @return string
 */
function add_underscores($string) {
    return str_replace(' ', '_', $string);
}

/**
 * Recursively displays a list of categories
 * @param array $categories
 * @param string $template
 * @param int $parent 
 */
function recurse_categories($categories, $template, $parent = 0) {
        foreach($categories as $category) {
            $selected = ($parent == $category['id']) ? 'selected' : '';
            include ADMIN_PAGES . 'categories_' . $template . '.php';
            if(!empty($category['children'])) {
                recurse_categories($category['children'], $template, $parent);
            }
        }
    }

/**
 * Returns a formatted string of the main menu, with categories and sections
 * @global Theme $theme_class
 * @param array $params
 * @return string
 */
function main_menu($params) {
    
    $super_model = CategoriesModel::get_instance();
    $section_model = SectionModel::get_instance();
    $theme_class = Theme::get_instance();

    $all_categories = $super_model->get_all_categories(0, 0, false);
    $all_sections = $section_model->get_all_sections("s.active = 1 AND s.cat_id = 0");
    
    echo $theme_class->main_menu($all_categories, $all_sections, $params);
}

function show_category_links($links, $params = array()) {
    $returns = "";
    
    if(isset($params['before_link_list'])) {
        $returns .= $params['before_link_list'];
    }
    
    foreach($links as $link) {
        if(isset($params['before_link'])) {
            $returns .= $params['before_link'];
        }
        $returns .= '<a href="' . URL . $link['permalink'] . '">' . $link['name'] . '</a>';
        if(isset($params['after_link'])) {
            $returns .= $params['after_link'];
        }
    }
    
    if(isset($params['after_link_list'])) {
        $returns .= $params['after_link_list'];
    }
    
    echo $returns;
}

function sidebar() {
    ob_start();
    if(file_exists(THEMES . THEME . 'sidebar.php')) {
        include THEMES . THEME . 'sidebar.php';
    } else {
        include DEFAULT_THEME . 'sidebar.php';
    }
    echo ob_get_clean();
}

/**
 * Checks if the script is installed by checking several things
 * @return boolean
 */
function is_installed() {
    $user_model = UserModel::get_instance();
    $success = $user_model->get_single_user('id', 1);
    if(!empty($success) && is_array($success)) {
        return true;
    }
    
    return false;
}

/**
 * Outputs the template for the install file
 * @param string $buffer
 * @return string 
 */
function install_file($buffer) {
    $returns = <<<EOT
<!DOCTYPE html>
<html>
    <head>
        <title>FanXpression Installer</title>
        <style type="text/css">
            body {
                background: #ddd;
                font-family: Georgia, serif;
                font-size: 16px;
                margin:0;
            }
            #main {
                width:85%;
                margin:0 auto;
            }
            .box {
                width:90%;
                text-align:center;
                background: #eee;
                padding:20px;
                border:1px solid #bbb;
                margin:30px;
            }
    
            textarea {
                height:100px;
                width:400px;
                border:1px solid #bbb;
            }


            input {
                border:1px solid #bbb;
                width:510px;
                height:20px;
                padding:5px;
                margin-left:-1px;
                margin-bottom:5px;	
            }
    
            input.submit {
                border:1px solid #aaa;
                height:30px;
                background-color:#fdfdfd;
                font-family:Georgia, serif;
                font-size:15px;
                width:310px;
            }

            input.radio {
                width:20px;
                height:auto;
            }

            select {
                border:1px solid #bbb;
                width:302px;
                height:30px;
                padding:5px;
                margin-left:-1px;	
            }

            form ul {
                list-style:none;	
            }

            form ul li {
                padding:10px 0;
            }

            form ul li label {
                display:block;
                float:left;	
                width:150px;
                padding:5px 20px 0 0;
            }
        </style>
    </head>
    <body>
        <div id="main">
            <div class="box">
                <img src="fanx_admin/images/full-logo-big.png" alt="Logo" />
                $buffer
            </div>
        </div>
    </body>
</html>
EOT;
    return $returns;
}

/**
 * Error handling function, shows a 404 error page upon errors
 * @param string $type
 * @param string $message
 * @param string $file
 * @param string $line 
 */
function fanx_errors($type, $message, $file, $line) {
    $error_message = 'Error ' . $type . ': ' . $message . ' in ' . $file . ' on line ' . $line . "\n";
    if(function_exists('error_log')) {
        error_log($error_message, 3, 'error.log');
    } else {
        if(file_exists('error_log')) {
            $contents = file_get_contents('error.log');
            file_put_contents('error.log', $contents . $error_message);
        } else {
            file_put_contents('error.log', $error_message);
        }
    }
    @ob_end_clean();
    //echo 'Error ' . $type . ': ' . $message . ' in ' . $file . ' on line ' . $line . "\n", 3, 'error_log';
    $theme_class = Theme::get_instance();
    $theme_class->site_title = TITLE . ' - 404 - Not found';
    $theme_class->site_url = URL;
    $theme_class->theme_path = URL . 'fanx_themes/' . THEME;

    $theme_class->get_header();
    $theme_class->get_404();
    $theme_class->get_footer();
    exit;
}
?>
