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
    Current file: fanx_includes/Theme.php
    First created: 26.8.2011

 *********************/

/**
 * Handles parsing of themes
 */
class Theme {
    
    /**
     * An instance of this class
     * @var object
     */
    private static $instance;
    
    /**
     * Holds some main variables needed in the theme
     * @var array
     */
    protected $main_variables = array();
    
    /**
     * Returns an instance of this class
     * @return object
     */
    public static function get_instance() { 
        if (!self::$instance) { 
            self::$instance = new Theme(); 
        } 
        return self::$instance; 
    }
    
    /**
     * Returns the value of one of the main variables
     * @param string $name
     * @return string
     */
    public function __get($name) {
        return $this->main_variables[$name];
    }
    
    /**
     * Sets the value of one of the main variables
     * @param string $name
     * @param string $value 
     */
    public function __set($name, $value) {
        $this->main_variables[$name] = $value;
    }
    
    /**
     * Echoes the header
     */
    public function get_header() {
        echo $this->output_template('header');
    }
    
    /**
     * Echoes the footer
     */
    public function get_footer() {
        echo $this->output_template('footer');
    }
    
    /**
     * Echoes the 404 template
     */
    public function get_404() {
        echo $this->output_template('404');
    }
    
    /**
     * Parses the template given into a string
     * @param string $template
     * @param array $data
     * @return string
     */
    private function output_template($template, $data = array()) {
        extract($this->main_variables);
        extract($data);
        ob_start();
        $temp = THEMES . THEME . $template . '.php';
        if(file_exists($temp)) {
            include $temp;
        } else {
            include DEFAULT_THEME . $template . '.php';
        }
        return ob_get_clean();
    }
    
    /**
     * Returns a formatted string of menu items for the main menu
     * @param array $all_super_categories
     * @param array $all_sections
     * @param array $params
     * @return string 
     */
    public function main_menu($all_super_categories, $all_sections, $params = array()) {
        $menu_items = array();
        if(!empty($all_super_categories)) {
           foreach($all_super_categories as $key => $super) {
               $menu_items[$key]['name'] = $super['name'];
               $menu_items[$key]['link'] = 'category/' . $super['id'] . '/' . urlencode(add_underscores($super['name'])) . '/';
           } 
        }

        if(!empty($all_sections)) {
            foreach($all_sections as $key => $section) {
                $menu_items[$key + count($all_super_categories)]['name'] = $section['title'];
                $menu_items[$key + count($all_super_categories)]['link'] = 'extension/' . $section['id'] . '/' . $section['name'] . '/';
            }
        }
        $returns = "";
        if(isset($params['before_menu'])) {
            $returns .= $params['before_menu'] . "\n";
        }

        if(isset($params['include_home_link'])) {
            if(isset($params['before_link'])) {
                $returns .= $params['before_link'] . "\n";
            }
            $returns .= '<a href="' . URL . '">' . TITLE . '</a>' . "\n";

            if(isset($params['after_link'])) {
                $returns .= $params['after_link'] . "\n";
            }
        }

        foreach($menu_items as $item) {
            if(isset($params['before_link'])) {
                $returns .= $params['before_link'] . "\n";
            }
            $returns .= '<a href="' . URL . $item['link'] . '">' . $item['name'] . '</a>' . "\n";
            if(isset($params['after_link'])) {
                $returns .= $params['after_link'] . "\n";
            }
        }
        if(isset($params['after_menu'])) {
            $returns .= $params['after_menu'] . "\n";
        }

        return $returns;
    }
    
    /**
     * Echoes the post template
     * @param array $posts 
     */
    public function show_posts($posts) {
        if(isset($posts[0])) {
            foreach($posts as $post) {
                $post['permalink'] = URL . 'post/' . $post['id'] . '/' . urlencode(add_underscores($post['title'])) . '/';
                $post['tags'] = $this->make_tags_links($post['tags']);
                echo $this->output_template('post', $post);
            }
        } else {
            $posts['permalink'] = URL . 'post/' . $posts['id'] . '/' . urlencode(add_underscores($posts['title'])) . '/';
            $posts['tags'] = $this->make_tags_links($posts['tags']);
            echo $this->output_template('post', $posts);
        }
    }
    
    /**
     * Returns a formatted string with tag links
     * @param array $tags
     * @return string 
     */
    private function make_tags_links($tags) {
        $tags_array = explode(',', $tags);
        $last_tag = array_keys($tags_array);
        $last_tag = end($last_tag);
        $tag_string = '';
        foreach($tags_array as $key => $tag) {
            $tag_string .= '<a href="' . URL . 'tag/' . urlencode(add_underscores(trim($tag))) . '/">' . $tag . '</a>';
            if($key != $last_tag) {
                $tag_string .= ', ';
            }
        }
        
        return $tag_string;
    }
    
    /**
     * Echoes the comments template
     * @param array $comments 
     */
    public function show_comments($comments) {
        foreach($comments as $comment) {
            echo $this->output_template('comments', $comment);
        }
    }
    
    /**
     * Echoes a template for the pagination
     * @param int $all_pages
     * @param int $current_page
     * @param string $type 
     */
    public function show_pagination($all_pages, $current_page, $type) {
        for($i = 1; $i < $all_pages+1; $i++) {
            if($i == $current_page+1) {
                echo 'Page ' . $i;
            } else {
                echo '&nbsp;<a href="' . URL . $type . '/' . $i . '/">Page ' . $i . '</a>';
            }
        }
    }
    
    /**
     * Echoes the tag template
     * @param array $tag 
     */
    public function show_tag_page($tag) {
        echo $this->output_template('tag', $tag);
    }
    
    /**
     * Echoes the category template
     * @param array $category 
     */
    public function show_category($category) {
        echo $this->output_template('categories', $category);
    }
    
    /**
     * Echoes the page template
     * @param array $page 
     */
    public function show_page($page) {
        echo $this->output_template('page', $page);
    }
    
    /**
     * Echoes the comment form
     * @param array $data 
     */
    public function show_comment_form($data) {
        echo $this->output_template('comment_form', $data);
    }
}
?>