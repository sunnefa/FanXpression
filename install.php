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
    Current file: install.php
    First created: 6.9.2011

 *********************/

/**
 * This is install.php. This file handles installing FanXpression
 */
//error_reporting('E_OFF');
session_start();
define('INSTALLING', true);
define('FANX', true);
include 'fanx_config/init.php';
ob_start('install_file');

if(is_installed()) {
    echo '<p>FanXpression is already installed on your server. Please wait while we redirect you to the admin panel.</p>';
    header('Refresh: 10;url=' . str_replace('install.php', 'fanx_admin/', $_SERVER['REQUEST_URI']));
} else {
    $http = (!empty($_SERVER['https'])) ? 'https://' : 'http://';
    $url = $http . $_SERVER['SERVER_NAME'] . str_replace('install.php', '', $_SERVER['REQUEST_URI']);
    ob_start();
    echo show_messages();
    $messages = ob_get_clean();
    $form_text = <<<EOT
<p>Welcome to the FanXpression 1 click installer.
Please fill in the information below and press the 'Install now' button.</p>
    $messages
    <form action="install.php" method="post">
        <ul>
            <li>
                <div style="border-top:1px solid #aaa; height:1px; background:#fdfdfd;"></div>
                <h2>User information:</h2>
                <p style="margin:-5px;">A little information about you</p>
            </li>
            <li>
                <label for="username">Username: </label> 
                <input type="text" name="username" id="username" />
                <p style="margin:-5px;"><small>(please choose carefully, usernames cannot be changed)</small></p>
            </li>
            <li>
                <label for="password">Password: </label>
                <input type="password" name="password" id="password" />
                <p style="margin:-5px;"><small>(passwords must be at least 8 characters, have 1 uppercase and 1 lowercase character)</small></p>
            </li>
            <li>
                <label for="email">Email address: </label>
                <input type="text" name="email" id="email" />
                <p style="margin:-5px;"><small>(eg myname@mysite.com)</small></p>
            </li>
            <li>
                <div style="border-top:1px solid #aaa; height:1px; background:#fdfdfd;"></div>
                <h2>Some settings:</h2>
                <p style="margin:-5px;">Don't worry, you can change these later</p>
            </li>
            <li>
                <label for="title">Fansite title:</label>
                <input type="text" name="title" id="title" value="FanXpression - Fansites made easy" />
            </li>
            <li>
                <label for="url">URL to your fansite</label>
                <input type="text" name="url" id="url" value="$url" />
                <p style="margin:-5px;"><small>(please only change this if you know what you are doing)</small></p>
            </li>
            
            <li>
                <div style="border-top:1px solid #aaa; height:1px; background:#fdfdfd;"></div>
                <h2>Database information:</h2>
                <p style="margin:-5px;">You should have gotten this information from your host</p>
            </li>
            <li>
                <label for="dbuser">Database username</label>
                <input type="text" name="dbuser" id="dbuser" />
            </li>
            <li>
                <label for="dbpass">Database password</label>
                <input type="text" name="dbpass" id="dbpass" />
            </li>
            <li>
                <label for="dbhost">Database host</label>
                <input type="text" name="dbhost" id="dbhost" value="localhost" />
                <p style="margin:-5px;"><small>(localhost is usually fine)</small></p>
            </li>
            <li>
                <label for="dbname">Database name</label>
                <input type="text" name="dbname" id="dbname" />
            </li>
            <li>
                <label for="dbprefix">Table prefix</label>
                <input type="text" name="dbprefix" id="dbprefix" value="fanx" />
                <p style="margin:-5px;"><small>(only change this if you have more than one install of FanXpression in the same database)</small></p>
            </li>
            
            <li>
                <div style="border-top:1px solid #aaa; height:1px; background:#fdfdfd;"></div>
                <p>That's all!</p>
                <p><input class="submit" type="submit" name="install" value="Install now" /></p>
            </li>
        </ul>
    </form>
EOT;
    
    if(isset($_POST['install'])) {
        //the username
        if(!empty($_POST['username'])) {
            if(!is_username($_POST['username'])) {
                $errors[] = 'Username must only contain alphanumeric characters and underscores';
            }
        } else {
            $errors[] = 'Username must not be empty';
        }
        
        //the password
        if(!empty($_POST['password'])) {
            if(!strong_password($_POST['password'])) {
                $errors[] = 'Password must be at least 8 characters and contain 1 uppercase and 1 lowercase character';
            }
        } else {
            $errors[] = 'Password must not be empty';
        }
        
        //the email
        if(!empty($_POST['email'])) {
            if(!is_email($_POST['email'])) {
                $errors[] = 'That is not a valid email address';
            }
        } else {
            $errors[] = 'Email must not be empty';
        }
        
        //the url
        if(!empty($_POST['url'])) {
            if(!preg_match('(http)', $_POST['url'])) {
                $errors[] = 'That is not a valid url';
            }
        } else {
            $errors[] = 'Site url must not be empty';
        }
        
        //the database info
        if(empty($_POST['dbuser'])) $errors[] = 'Database username must not be empty';
        if(empty($_POST['dbpass'])) $errors[] = 'Database password must not be empty';
        if(empty($_POST['dbhost'])) $errors[] = 'Database hostname must not be empty';
        if(empty($_POST['dbname'])) $errors[] = 'Database name must not be empty';
        if(empty($_POST['dbprefix'])) $errors[] = 'Database table prefix must not be empty';
        
        if(!empty($errors)) {
            $_SESSION['errors'] = $errors;
            reload();
        } else {
            
            $FANX_CONFIG['mysql_host'] = $_POST['dbhost'];
            $FANX_CONFIG['mysql_user'] = $_POST['dbuser'];
            $FANX_CONFIG['mysql_pass'] = $_POST['dbpass'];
            $FANX_CONFIG['mysql_data'] = $_POST['dbname'];
            $FANX_CONFIG['mysql_prefix'] = $_POST['dbprefix'];
            
            //writing the db config file
            $config_success = db_config_file($_POST['dbuser'], $_POST['dbpass'], $_POST['dbhost'], $_POST['dbname'], $_POST['dbprefix']);
            if(!$config_success) {
                $errors[] = 'Could not write db config file';
            } else {
                $success[] = 'Config file written successfully';
                //include 'fanx_config/db_config.php';
            }
            //Writing the .htaccess file
            $htaccess_success = htaccess_file($_POST['url']);
            if(!$htaccess_success) {
                $errors[] = 'Could not write .htaccess file';
            } else {
                $success[] = '.htaccess file written successfully';
            }
            
            //creating the tables
            $install_model = InstallModel::get_instance();
            $table_success = $install_model->create_tables('fanx_config/schema.sql');
            if(!$table_success) {
                $errors[] = 'Could not create tables';
            } else {
                $success[] = 'All tables created successfully';
            }
            
            //adding the admin user
            $user_model = new UserModel();
            $user_success = $user_model->add_user($_POST['username'], $_POST['email'], fanx_salty($_POST['password']), '', 'admin', time(), 'active');
            if(!$user_success) {
                $errors[] = 'Could not add admin user';
            } else {
                if(!file_exists(UPLOADS . '100' . $user_success . '/')) {
                    $mkdir_success = mkdir(UPLOADS . '100' . $user_success . '/', 0755);
                    if(!$mkdir_success) {
                        $errors[] = 'Could not create admin uploads folder';
                    }
                }
                $success[] = 'Admin user created';
            }
            
            //updating the settings
            $settings_model = new SettingsModel();
            $url_success = $settings_model->update_settings('url', $_POST['url']);
            if(!$url_success) {
                $errors[] = 'Could not update url';
            }
            $title_success = $settings_model->update_settings('site_title', $_POST['title']);
            if(!$title_success) {
                $errors[] = 'Could not update title';
            }
            
            if(!empty($errors)) {
                echo '<p>The following errors occured:';
                foreach($errors as $err) {
                    echo '<p>' . $err . '</p>';
                }
                echo '<p>FanXpression failed to install. Please delete all the folders in your fanx_uploads folder (if there are any), delete any database tables that may have been created (if you don\'t know how to do this you can ask you host to do it for you) and run the installer again.</p>
                    <p>When you are ready, <a href="install.php">click here</a> to go back to the install form.';
            } else {
                foreach($success as $succ) {
                    echo '<p>' . $succ . '</p>';
                }
                echo '<p>FanXpression was installed successfully. Please wait while we redirect you to the admin panel. If you do not wish to wait, please <a href="' . $_POST['url'] . 'fanx_admin/">click here</a>.</p>';
                header('Refresh: 10;url=' . str_replace('install.php', 'fanx_admin/', $_SERVER['REQUEST_URI']));
            }
            
        }
    } else {
        echo $form_text;
    }
}
ob_end_flush();

//some functions to help with the install

/**
 * Writes the database configuration file
 * @param string $dbuser
 * @param string $dbpass
 * @param string $dbhost
 * @param string $dbname
 * @param string $dbprefix 
 * @return boolean
 */
function db_config_file($dbuser, $dbpass, $dbhost, $dbname, $dbprefix) {
    $file_content = <<<EOT
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
    Current file: fanx_config/db_config.php
    First created: 11.7.2011

 *********************/

/**
 * The database configurations
 */

\$FANX_CONFIG['mysql_host'] = '$dbhost';

\$FANX_CONFIG['mysql_user'] = '$dbuser';

\$FANX_CONFIG['mysql_pass'] = '$dbpass';

\$FANX_CONFIG['mysql_data'] = '$dbname';

\$FANX_CONFIG['mysql_prefix'] = '$dbprefix';
?>
EOT;
    
    if(file_put_contents('fanx_config/db_config.php', $file_content)) {
        return true;
    } else {
        return false;
    }
}

/**
 * Writes the .htaccess file
 * @param string $url
 * @return boolean
 */
function htaccess_file($url) {
    $url = str_replace($_SERVER['SERVER_NAME'], '', $url);
    $url = (preg_match('(https)', $url)) ? str_replace('https://', '', $url) : str_replace('http://', '', $url);
    $file_content = <<<EOT
<IfModule mod_rewrite.c>

    RewriteEngine On
    RewriteBase $url
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule (.*)/$ index.php [L]

</IfModule>
EOT;
    
    if(file_put_contents('.htaccess', $file_content)) {
        return true;
    } else {
        return false;
    }
}

if(isset($_SESSION['errors'])) unset($_SESSION['errors']);
if(isset($_SESSION['success'])) unset($_SESSION['success']);
?>
