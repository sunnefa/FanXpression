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
    Current file: fanx_includes/Images.php
    First created: 13.7.2011

 *********************/

/**
 * Handles uploading and resizing of images
 */
class Images {
    /**
     * An instance of this class
     * @var object
     */
    private static $instance;
    
    /**
     * Returns an instance of this class
     * @return object
     */
    public static function get_instance() { 
        if (!self::$instance) { 
            self::$instance = new Images(); 
        } 
        return self::$instance; 
    }
    
    /**
     * Hanles the uploading of a file from $_FILES
     * @param array $file
     * @return boolean
     */
    public function upload_image($file) {
        if($this->is_image($file['name'])) {
            switch($file['error']) {
                case 0:
                    if(move_uploaded_file($file['tmp_name'], $file['name'])) {
                        list($width, $height) = getimagesize($file['name']);
                        if($width > MAX_IMAGE_SIZE) {
                            $percentage = MAX_IMAGE_SIZE / $width;
                        } elseif($height > MAX_IMAGE_SIZE) {
                            $percentage = MAX_IMAGE_SIZE / $height;
                        } else {
                            $percentage = 1;
                        }
                        $new_width = round($width * $percentage);
                        $new_height = round($height * $percentage);
                        $success = $this->resize_image($file['name'], $new_width, $new_height, $width, $height);
                        if(!$success) {
                            echo 'Crap!';
                        }
                        
                        return true;
                    } else {
                       return false; 
                    }
                    break;
                default:
                    return false;
            }
        } else {
            return false;
        } 
    }
    
    /**
     * Resizes an image from the old width and height to the new width and height
     * @param string $filename
     * @param int $new_width
     * @param int $new_height
     * @param int $old_width
     * @param int $old_height
     * @return boolean 
     */
    private function resize_image($filename, $new_width, $new_height, $old_width, $old_height) {
        if($new_width == $old_width && $new_height == $old_height) {
            return true;
        } else {
            $ext = $this->get_ext($filename);
            switch($ext) {
                case 'jpg':
                case 'jpeg':
                    $original = imagecreatefromjpeg($filename);
                    $blank = imagecreatetruecolor($new_width, $new_height);
                    $success = imagecopyresampled($blank, $original, 0, 0, 0, 0, $new_width, $new_height, $old_width, $old_height);
                    if($success) {
                        $saved = imagejpeg($blank, $filename, 100);
                        if($saved) {
                            return true;
                        }
                    }
                    return false;
                    break;
                
                case 'gif':
                    $original = imagecreatefromgif($filename);
                    $blank = imagecreatetruecolor($new_width, $new_height);
                    $success = imagecopyresampled($blank, $original, 0, 0, 0, 0, $new_width, $new_height, $old_width, $old_height);
                    if($success) {
                        $saved = imagegif($blank, $filename);
                        if($saved) {
                            return true;
                        }
                    }
                    return false;
                    break;
                
                case 'png':
                    $original = imagecreatefrompng($filename);
                    $blank = imagecreatetruecolor($new_width, $new_height);
                    $success = imagecopyresampled($blank, $original, 0, 0, 0, 0, $new_width, $new_height, $old_width, $old_height);
                    if($success) {
                        $saved = imagepng($blank, $filename);
                        if($saved) {
                            return true;
                        }
                    }
                    return false;
                    break;
                
                default:
                    return false;
            }
        }
    }
    
    /**
     * Checks if a file has an image extension
     * @param string $file
     * @return boolean
     */
    private function is_image($file) {
        if(preg_match('(.jpg|.jpeg|.gif|.png)', $file)) {
            return true;
        }
        return false;
    }
    
    /**
     * Returns the extension of an image
     * @param string $filename
     * @return string
     */
    private function get_ext($filename) {
        $arr = explode('.', $filename);
        return end($arr);
    }
        
}
?>