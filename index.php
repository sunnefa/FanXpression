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
    Current file: index.php
    First created: 11.7.2011

 *********************/

/**
 * This is index.php. This file acts as a controller for the entrie front end
 */
 
 
session_start();
define('FANX', true);
include('fanx_config/init.php');

if(!is_installed()) {
    header('Location: install.php');
}
set_error_handler("fanx_errors");
$url = url_parser();
$theme_class = Theme::get_instance();
$posts_model = PostsModel::get_instance();
$pages_model = PagesModel::get_instance();
$super_model = CategoriesModel::get_instance();
$section_model = SectionModel::get_instance();

$theme_class->site_title = TITLE;
$theme_class->site_url = URL;
$theme_class->theme_path = URL . 'fanx_themes/' . THEME;

ob_start();

$showing = (isset($url[0])) ? $url[0] : 'all_posts';
switch($showing) {
    case 'post':
        $post = $posts_model->get_single_post('id', $url[1]);
        if(empty($post)) {
            $theme_class->site_title .= " - 404 - Not found";
            $theme_class->get_404();
        } else {
            $theme_class->site_title .= ' - ' . $post['title'];
            $theme_class->show_posts($post);
            $comments = $posts_model->get_all_post_comments('c.post_id = ' . $post['id'] . ' AND c.approved = 1');
            if(!empty($comments)) {
                $theme_class->show_comments($comments);
            }
            $data['post_id'] = $post['id'];
            $data['permalink'] = implode('/', $url);
            if(isset($_COOKIE['fanx_admin_login']) || isset($_SESSION['fanx_admin_login'])) {
                $data['logged_in_user'] = get_loggedin_userid();
                $data['username'] = (isset($_SESSION['fanx_admin_login'])) ? $_SESSION['fanx_admin_login']['username'] : $_COOKIE['fanx_admin_login']['username'];
            }
            $theme_class->show_comment_form($data);
        }
        break;
    
    case 'extension':
        $section = $section_model->get_single_section('id', $url[1]);
        if(empty($section)) {
            $theme_class->site_title .= " - 404 - Not found";
            $theme_class->get_404();
        } else {
            if($section['active'] != 1) {
                $theme_class->site_title .= " - 404 - Not found";
                $theme_class->get_404();
            } else {
                include EXTENSIONS . $section['name'] . '/show.php';
            }
        }
        break;
    
    case 'category':
        $category = $super_model->get_single_category('id', $url[1]);
        if(empty($category)) {
            $theme_class->site_title .= ' - 404 - Not found';
            $theme_class->get_404();
        } else {
            $children = $super_model->get_all_categories($category['id'], 0, false);
            $sections = $section_model->get_all_sections("cat_id = {$category['id']} AND active = 1");
            $pages = $pages_model->get_all_pages("cat_id = {$category['id']} AND status = 'published'");
            
            $linkage = array_merge($children, $sections, $pages);
            
            $links = array();
            
            if(!empty($linkage)) {
                foreach($linkage as $key => $link) {
                    if(isset($link['description'])) {
                        $appendix = 'category';
                    } elseif(isset($link['active'])) {
                        $appendix = 'extension';
                    } elseif(isset($link['content'])) {
                        $appendix = 'page';
                    }
                    $links[$key]['name'] = $link['title'];
                    $links[$key]['permalink'] = $appendix . '/' . $link['id'] . '/' . urlencode(add_underscores($link['title'])) . '/';
                }
            }
            
            unset($children, $pages, $sections, $linkage);
            
            $category['links'] = $links;
            $theme_class->site_title .= ' - ' . $category['name'];
            $theme_class->show_category($category);
        }
        break;
    
    case 'page':
        $page = $pages_model->get_single_page('p.id', $url[1]);
        if(empty($page)) {
            $theme_class->site_title .= ' - 404 - Not Found';
            $theme_class->get_404();
        } else {
            $theme_class->site_title .= ' - ' . $page['title'];
            $theme_class->show_page($page);
        }
        break;
    
    case 'index.php':
    case 'all_posts':
        $all_posts = $posts_model->get_all_posts("p.status = 'published'");
        if(empty($all_posts)) {
            $theme_class->site_title .= " - 404 - Not found";
            $theme_class->get_404();
        } else {
            $p = (isset($url[1])) ? $url[1]-1 : 0;
            $posts = array_chunk($all_posts, POSTS_PER_PAGE);
            $all_p = count($posts);
            $theme_class->show_posts($posts[$p]);
            $theme_class->show_pagination($all_p, $p, 'all_posts');
        }
        break;
    
    case 'tag':
        $tag = $posts_model->get_single_post_tag('name', urldecode(strip_underscores($url[1])));
        if(empty($tag)) {
            $theme_class->site_title .= " - 404 - Not found";
            $theme_class->get_404();
        } else {
            $theme_class->site_title .= " - " . ucwords($tag['name']);
            $theme_class->show_tag_page($tag);
            $all_posts = $posts_model->get_all_posts("p.status = 'published' AND pt.tag_id = " . $tag['id'], array($FANX_CONFIG['mysql_prefix'] . '_posts_p_t_relation AS pt' => 'pt.post_id = p.id'));
            if(!empty($all_posts)) {
                $p = (isset($url[2])) ? $url[2]-1 : 0;
                $posts = array_chunk($all_posts, POSTS_PER_PAGE);
                $all_p = count($posts);
                $theme_class->show_posts($posts[$p]);
                $theme_class->show_pagination($all_p, $p, 'tag/' . $url[1]);
            }
        }
        break;
    
    default:
        $theme_class->site_title .= ' - 404 - Not found';
        $theme_class->get_404();
}

$content = ob_get_clean();

$theme_class->get_header();
echo $content;
$theme_class->get_footer();

if(isset($_SESSION['errors'])) unset($_SESSION['errors']);
if(isset($_SESSION['success'])) unset($_SESSION['success']);
?>
