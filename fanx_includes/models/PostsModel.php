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
    Current file: fanx_includes/models/PostsModel.php
    First created: 20.8.2011

 *********************/

/**
 * Handles all CRUD related to the posts, posts_comments, posts_tags and p_t_relation tables
 */
class PostsModel extends AbstractDatabase {
    
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
            self::$instance = new PostsModel(); 
        } 

        return self::$instance; 
    }
    
    /**
     * Fetches all posts from the database
     * @global array $FANX_CONFIG
     * @param string $where
     * @param array $joins
     * @return array
     */
    public function get_all_posts($where = '', $joins = array()) {
        global $FANX_CONFIG;
        return $this->get_data('posts_posts AS p', array(
            'p.id',
            'p.title', 
            'p.content', 
            "p.date", 
            'p.status', 
            "(SELECT GROUP_CONCAT(t.name ORDER BY t.name ASC separator ', ') FROM " . $FANX_CONFIG['mysql_prefix'] . "_posts_tags AS t JOIN " . $FANX_CONFIG['mysql_prefix'] . "_posts_p_t_relation AS tag ON tag.tag_id = t.id WHERE tag.post_id = p.id) AS tags",
            '(SELECT u.username FROM ' . $FANX_CONFIG['mysql_prefix'] . '_users AS u WHERE p.user_id = u.id) AS username'), $where, 'p.date DESC', false, $joins);
    }
    
    /**
     * Fetches a single post from the database
     * @global array $FANX_CONFIG
     * @param string $field
     * @param string $value
     * @return array 
     */
    public function get_single_post($field, $value) {
        global $FANX_CONFIG;
        return $this->get_data('posts_posts AS p', array(
            'p.id', 
            'p.title', 
            'p.status',
            "p.date",
            'p.content', 
            "(SELECT GROUP_CONCAT(t.name ORDER BY t.name ASC separator ', ') FROM " . $FANX_CONFIG['mysql_prefix'] . "_posts_tags AS t JOIN " . $FANX_CONFIG['mysql_prefix'] . "_posts_p_t_relation AS tag ON tag.tag_id = t.id WHERE tag.post_id = p.id) AS tags",
            '(SELECT u.username FROM ' . $FANX_CONFIG['mysql_prefix'] . '_users AS u WHERE p.user_id = u.id) AS username'), "$field = '$value'", NULL, true);
    }
    
    /**
     * Updates a single post
     * @param int $id
     * @param string $title
     * @param string $content
     * @param string $status
     * @return boolean 
     */
    public function update_post($id, $title, $content, $status) {
       return $this->update_data('posts_posts', array('title', 'content', 'status'), array($title, $content, $status), "id = $id");
    }
    
    /**
     * Adds a single post
     * @param string $title
     * @param string $content
     * @param string $status
     * @param int $date
     * @param int $userid
     * @return int
     */
    public function add_post($title, $content, $status, $date, $userid) {
        return $this->add_data('posts_posts', array('title', 'content', 'status', 'date', 'user_id'), array($title, $content, $status, $date, $userid));
    }
    
    /**
     * Updates a single field on a single post's record
     * @param string $field
     * @param string $value
     * @param int $id
     * @return boolean 
     */
    public function update_single_post_field($field, $value, $id) {
        return $this->update_data('posts_posts', array($field), array($value), "id = $id");
    }
    
    /**
     * Deletes a single post
     * @param int $id
     * @return boolean 
     */
    public function delete_post($id) {
        return $this->remove_data('posts_posts', "id = $id");
    }
    
    /**
     * Fetches all tags
     * @return array 
     */
    public function get_all_post_tags() {
        return $this->get_data('posts_tags', array('*'));
    }
    
    /**
     * Fetches a single tag
     * @param string $field
     * @param string $value
     * @return array 
     */
    public function get_single_post_tag($field, $value) {
        return $this->get_data('posts_tags', array('*'), "$field = '$value'", NULL, true);
    }
    
    /**
     * Updates a single tag
     * @param int $id
     * @param string $name
     * @param string $description
     * @return boolean
     */
    public function update_post_tag($id, $name, $description) {
        return $this->update_data('posts_tags', array('name', 'description'), array($name, $description), "id = $id");
    }
    
    /**
     * Adds a single tag
     * @param string $name
     * @return boolean 
     */
    public function add_post_tag($name) {
        return $this->add_data('posts_tags', array('name'), array($name));
    }
    
    /**
     * Removes a single tag
     * @param int $id
     * @return boolean
     */
    public function remove_post_tag($id) {
        return $this->remove_data('posts_tags', "id = $id");
    }
    
    /**
     * Adds a relationship between a post and a tag to the p_t_relation table
     * @param int $post
     * @param int $tag
     * @return int
     */
    public function add_post_tag_relationship($post, $tag) {
        return $this->add_data('posts_p_t_relation', array('tag_id', 'post_id'), array($tag, $post));
    }
    
    /**
     * Removes a relation between post and tag based on a tag id
     * This is used if a tag is deleted
     * @param int $tag
     * @return boolean 
     */
    public function remove_post_tag_relationship_by_tag_id($tag) {
        return $this->remove_data('posts_p_t_relation', "tag_id = $tag");
    }
    
    /**
     * This is used if a post is deleted
     * @param int $post
     * @return boolean
     */
    public function remove_post_tag_relationship_by_post_id($post) {
        return $this->remove_data('posts_p_t_relation', "post_id = $post");
    }
    
    /**
     * Gets the relationship between a post and a tag, to check if there is one
     * @param int $post
     * @param int $tag
     * @return array 
     */
    public function get_post_tag_relationship($post, $tag) {
        return $this->get_data('posts_p_t_relation', array('COUNT(*) AS num'), 'tag_id = ' . $tag . ' AND ' . 'post_id = ' . $post, NULL, true);
    }
    
    /**
     * Removes a post tag relationship when both the tag id and post id are known
     * @param int $post
     * @param int $tag
     * @return boolean 
     */
    public function remove_post_tag_relationship($post, $tag) {
        return $this->remove_data('posts_p_t_relation', "post_id = $post AND tag_id = $tag");
    }
    
    /**
     * Fetches all comments and if the comments was written by a registered user, gets their username
     * @global array $FANX_CONFIG
     * @param string $where
     * @return array 
     */
    public function get_all_post_comments($where = "") {
        global $FANX_CONFIG;
        $comments = $this->get_data('posts_comments AS c', array(
            'c.id',
            'c.comment',
            'c.post_id',
            '(SELECT p.title FROM ' . $FANX_CONFIG['mysql_prefix'] . '_posts_posts AS p WHERE p.id = c.post_id) AS title',
            'c.author_email',
            'c.author_name',
            'c.author_website',
            'c.user_id',
            'c.approved'
        ), $where);

        $returned_comments = array();
        
        if(is_array($comments)) {
            foreach($comments as $comment) {
                if(!empty($comment['user_id'])) {
                    $author = $this->get_data('users', array('username', 'email'), 'id = ' . $comment['user_id'], NULL, true);
                    $comment['author_name'] = $author['username'];
                    $comment['author_email'] = $author['email'];
                }
                $returned_comments[] = $comment;
            }
        }
        
        return $returned_comments;
    }
    
    /**
     * Fetches a single comment and if the comment was written by a registered user their  username
     * @global array $FANX_CONFIG
     * @param string $field
     * @param string $value
     * @return array 
     */
    public function get_single_post_comment($field, $value) {
        global $FANX_CONFIG;
        $comment = $this->get_data('posts_comments AS c', array(
            'c.id',
            'c.comment',
            'c.post_id',
            'p.title',
            'c.author_email',
            'c.author_name',
            'c.author_website',
            'c.user_id',
            'c.approved'
        ), "$field = '$value'", NULL, true, array($FANX_CONFIG['mysql_prefix'] . '_posts_posts AS p' => 'c.post_id = p.id'));
        
        if(!empty($comment['user_id'])) {
            $author = $this->get_data('users', array('username', 'email'), 'id = ' . $comment['user_id'], true);
            $comment['author_name'] = $author['username'];
            $comment['author_email'] = $author['email'];
        }
        
        return $comment;
    }
    
    /**
     * Adds a comment to the database
     * @param int $post_id
     * @param int $user_id
     * @param string $name
     * @param string $email
     * @param string $website
     * @param string $comment
     * @param int $approved
     * @return int
     */
    public function add_post_comment($post_id, $user_id, $name, $email, $website, $comment, $approved) {
        return $this->add_data('posts_comments', array('post_id', 'user_id', 'author_name', 'author_email', 'author_website', 'comment', 'approved'), array($post_id, $user_id, $name, $email, $website, $comment, $approved));
    }
    
    /**
     * Updates a single comment
     * @param int $id
     * @param string $comment
     * @param string $author_name
     * @param string $author_email
     * @param string $author_website
     * @return boolea
     */
    public function edit_post_comment($id, $comment, $author_name, $author_email, $author_website) {
        return $this->update_data('posts_comments', array('comment', 'author_name', 'author_email', 'author_website'), array($comment, $author_name, $author_email, $author_website), "id = $id");
    }
    
    /**
     * Removes a single comment
     * @param int $id
     * @return boolean 
     */
    public function remove_post_comment($id) {
        return $this->remove_data('posts_comments', "id = $id");
    }
    
    /**
     * Updates a single field on a single comment
     * @param int $id
     * @param string $field
     * @param string $value
     * @return array 
     */
    public function update_single_post_comment_field($id, $field, $value) {
        return $this->update_data('posts_comments', array($field), array($value), "id = $id");
    }
}
?>