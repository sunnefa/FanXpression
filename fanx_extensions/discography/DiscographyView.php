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
    Current file: fanx_sections/discography/DiscographyView.php
    First created: 30.8.2011

 *********************/

/**
 * Handles the output of the discography section in relation to the theme
 */
class DiscographyView extends Theme {
    
    /**
     * An instance of this class
     * @var object 
     */
    private static $instance;
    
    /**
     * Returns an instance of this class
     * @return object 
     */
    public static function get_instance() 
    { 
        if (!self::$instance) { 
            self::$instance = new DiscographyView(); 
        } 

        return self::$instance; 
    }
    
    /**
     * Returns a formatted string of categories
     * @global string $section
     * @param array $categories
     * @param array $params
     * @return string 
     */
    public function show_discography_categories($categories, $params) {
        global $section;
        $returns = '';
        if(isset($params['before_list'])) {
            $returns .= $params['before_list'] . "\n";
        }
        foreach($categories as $cat) {
            if(isset($params['before_category'])) {
                $returns .= $params['before_category'] . "\n";
            }
            $depth = (($cat['depth'] + 1) / 10) + 1;
            $size = ceil(20 / $depth);
            $returns .= '<span style="font-size:' . $size . 'px">' . $cat['name'] . '</span>';
            if(isset($params['alb_list']) && !empty($cat['albums'])) {
                $returns .= $this->show_album_list($cat['albums'], $params['alb_list']);
            } else {
                if($cat['parent'] != 0) {
                    $returns .= '<p>No albums to display</p>';
                }
            }
            if(!empty($cat['children']) && isset($params['recurse'])) {
                if($params['recurse'] == true) {
                    $returns .= $this->show_discography_categories($cat['children'], $params);
                }
            }
            if(isset($params['after_category'])) {
                $returns .= $params['after_category'] . "\n";
            }
        }

        if(isset($params['after_list'])) {
            $returns .= $params['after_list'] . "\n";
        }

        return $returns;
    }
    
    /**
     * Returns a formatted string of albums
     * @global string $section
     * @param array $albums
     * @param array $params
     * @return string 
     */
    public function show_album_list($albums, $params) {
        global $section;
        $returns = '';
        if(isset($params['before_list'])) {
            $returns .= $params['before_list'];
        }
        
        foreach($albums as $album) {
            if(isset($params['before_album'])) {
                $returns .= $params['before_album'];
            }
            $returns .= '<a href="' . URL . 'extension/' . $section['id'] . '/' . urlencode(add_underscores($section['title'])) . '/album/' . $album['id'] . '/' . urlencode(add_underscores($album['title'])) . '/">';
            if(!empty($album['feature_cover'])) {
                $returns .= '<img alt="' . $album['title'] . '" src="' . URL . $album['feature_cover'] . '"';
                if(isset($params['max_cover_size'])) {
                    $returns .= ' width="' . $params['max_cover_size'] . '"';
                }
                $returns .= ' />';
            }
            
            $returns .= $album['title'] . '</a>';
            
            if(isset($params['after_album'])) {
                $returns .= $params['after_album'];
            }
        }
        
        if(isset($params['after_list'])) {
            $returns .= $params['after_list'];
        }
        
        return $returns;
    }
    
    /**
     * Returns a formatted string of songs
     * @param array $songs
     * @param array $params
     * @return string 
     */
    public function show_song_list($songs, $params) {
        $returns = '';
        if(isset($params['before_list'])) {
            $returns .= $params['before_list'];
        }
        
        if(!empty($songs)) {
            foreach($songs as $song) {
                if(isset($params['before_song'])) {
                    $returns .= $params['before_song'];
                }
                
                $returns .= '<p>' . $song['title'] . '</p>';
                $returns .= '<p>Length: ' . $song['length'] . '</p>';
                $returns .= '<p>Composer: ' . $song['composer'] . '</p>';
                
                if(isset($params['after_song'])) {
                    $returns .= $params['after_song'];
                }
            }
        }
        
        if(isset($params['after_list'])) {
            $returns .= $params['after_list'];
        }
        
        return $returns;
    }
    
    /**
     * Echoes the categories template
     * @param array $categories 
     */
    public function show_disco_cats($categories) {
        echo $this->output_temp('categories', $categories);
    }
    
    /**
     * Echoes the album template
     * @param string $album 
     */
    public function show_disco_album($album) {
        echo $this->output_temp('album', $album);
    }
    
    /**
     * Echoes a recursive list of categories
     * @param array $categories
     * @todo Check if this function is actually called anywhere 
     */
    public function show_recursive($categories) {
            echo $this->output_temp('categories', $categories);
    }
    
    /**
     * Returns the output of the template as a string
     * @param string $template
     * @param array $data
     * @return string 
     */
    private function output_temp($template, $data = array()) {
        extract($this->main_variables);
        extract($data);
        ob_start();
        $temp = THEMES . THEME . $template . '.php';
        if(file_exists($temp)) {
            include $temp;
        } else {
            include EXTENSIONS . 'discography/tpl/' . $template . '.php';
        }
        return ob_get_clean();
    }
    
}
?>