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
    Current file: fanx_admin/posts.php
    First created: 20.8.2011

 *********************/

/**
 * Controller for the posts
 */

$posts_model = PostsModel::get_instance();

$action = (isset($_GET['action'])) ? $_GET['action'] : 'all';

switch($action) {
    case 'all':
        
        $all_posts = $posts_model->get_all_posts("status != 'trash'");
        
        $all_num = count($all_posts);
        
        $posts = array_chunk($all_posts, 10);
        
        $all_p = count($posts);
        
        $p = (isset($_GET['p'])) ? $_GET['p']-1 : 0;
        
        $trash_num = count($posts_model->get_all_posts("status = 'trash'"));
        
        include ADMIN_PAGES . 'posts.php';
        include ADMIN_PAGES . 'pagination.php';
        
        break;
    
    case 'edit':
        if(isset($_POST['edit_post'])) {
            
            if(empty($_POST['title'])) {
                $errors[] = 'Posts must have a title';
            }

            //if the new tags field is not empty
            if(!empty($_POST['new_tags'])) {
                //make the new tags into an array
                $new_tags = explode(',', $_POST['new_tags']);
                //loop through them
                foreach($new_tags as $new_tag) {
                    //we don't want to add the tag if it already exists
                    $exists = $posts_model->get_single_post_tag('name', $new_tag);
                    if(!$exists) {
                        //add them to the database
                        $success = $posts_model->add_post_tag(trim($new_tag));
                        //if the database returns a boolean it didn't work
                        if(is_bool($success)) {
                            $errors[] = 'Cannot add new tags';
                        //otherwise we can add the relationship using the post id and the insert id from the model
                        } else {
                            //add the relation to the database
                            $relation = $posts_model->add_post_tag_relationship($_POST['id'], $success);
                            //if the database returns a boolean it didn't work
                            if(is_bool($relation)) {
                                $errors[] = 'Could not add post tag relationship';
                            }
                        } 
                    }
                }
            }
            
            if(!empty($_POST['old_tags'])) {
                $oldies = array();
                $old_tags = explode(',', $_POST['old_tags']);
                foreach($old_tags as $old) {
                    $tags_old = $posts_model->get_single_post_tag('name', $old);
                    $oldies[] = $tags_old['id'];
                }
            }
            
            if(!empty($_POST['tags'])) {
                $tags = $_POST['tags'];
                foreach($tags as $tag) {
                    $relationship = $posts_model->get_post_tag_relationship($_POST['id'], $tag);
                    if($relationship['num'] == 0) {
                        $success = $posts_model->add_post_tag_relationship($_POST['id'], $tag);
                    }
                }
            }
            
            if(isset($tags) && isset($oldies)) {
               $difference = array_diff($oldies, $tags); 
               foreach($difference as $diff) {
                   $success = $posts_model->remove_post_tag_relationship($_POST['id'], $diff);
                   if(!$success) {
                       $errors[] = 'Could not remove post tag relationship';
                   }
               }
            }
            
            if(empty($errors)) {
                $success = $posts_model->update_post($_POST['id'], $_POST['title'], $_POST['content'], $_POST['status']);
                if($success) {
                    $_SESSION['success'] = 'Post updated successfully';
                    reload();
                } else {
                    $_SESSION['errors'][] = 'Could not update post';
                    reload();
                }
            } else {
                $_SESSION['errors'] = $errors;
                reload();
            }
                
        } else {
            $post = $posts_model->get_single_post('p.id', $_GET['id']);
            
            $tags = $posts_model->get_all_post_tags();
            $old_tags = str_replace(', ', ',', $post['tags']);
            $old_tags = explode(',', $old_tags);
            
            include ADMIN_PAGES . 'posts_form.php';
        }
        
        break;
    
    case 'add':
        if(isset($_POST['add_post'])) {

            if(empty($_POST['title'])) {
                $errors[] = 'Posts must have a title';
            }
            
            if(empty($_POST['status'])) {
                $errors[] = 'Posts must be either published or unpublished (drafts)';
            }
            
            if(empty($errors)) {
                $post_id = $posts_model->add_post($_POST['title'], $_POST['content'], $_POST['status'], time(), get_loggedin_userid());
                if(is_bool($post_id)) {
                    $_SESSION['errors'][] = 'Could not add post';
                    reload();
                } else {
                    
                    //if the new tags field is not empty
                    if(!empty($_POST['new_tags'])) {
                        //make the new tags into an array
                        $new_tags = explode(',', $_POST['new_tags']);
                        //loop through them
                        foreach($new_tags as $new_tag) {
                            //we don't want to add the tag if it already exists
                            $exists = $posts_model->get_single_post_tag('name', $new_tag);
                            if(!$exists) {
                                //add them to the database
                                $success = $posts_model->add_post_tag(trim($new_tag));
                                //if the database returns a boolean it didn't work
                                if(is_bool($success)) {
                                    $errors[] = 'Cannot add new tags';
                                //otherwise we can add the relationship using the post id and the insert id from the model
                                } else {
                                    //add the relation to the database
                                    $relation = $posts_model->add_post_tag_relationship($post_id, $success);
                                    //if the database returns a boolean it didn't work
                                    if(is_bool($relation)) {
                                        $errors[] = 'Could not add post tag relationship';
                                    }
                                } 
                            }
                        }
                    }

                    if(!empty($_POST['tags'])) {
                        $tags = $_POST['tags'];
                        foreach($tags as $tag) {
                            $relationship = $posts_model->get_post_tag_relationship($post_id, $tag);
                            if($relationship['num'] == 0) {
                                $success = $posts_model->add_post_tag_relationship($post_id, $tag);
                            }
                        }
                    }
                    
                    if(empty($errors)) {
                       $_SESSION['success'] = 'Post added successfully';
                    reload('page=posts&action=edit&id=' . $post_id); 
                    } else {
                        $_SESSION['errors'] = $errors;
                        reload();
                    }
                }
            } else {
                $_SESSION['errors'] = $errors;
                reload();
            }
            
        } else {
            
            $post = null;
            
            $tags = $posts_model->get_all_post_tags();
            
            include ADMIN_PAGES . 'posts_form.php';
        }
        break;
    
    case 'trash':
        $all = count($posts_model->get_all_posts("status != 'trash'"));
        if(!isset($_GET['id'])) {
            $_SESSION['errors'][] = 'Invalid post id';
        } else {
            $success = $posts_model->update_single_post_field('status', 'trash', $_GET['id']);
            if(!$success) {
                $_SESSION['errors'][] = 'Could not move post to trash';
            } else {
                $_SESSION['success'] = 'Post moved to trash';
            }
        }
        if($all > 1) {
           reload('page=posts'); 
        } else {
            reload('page=posts&action=trashcan');
        }
        
        break;
    
    case 'restore':
        $trashed = count($posts_model->get_all_posts("status = 'trash'"));
        
        if(!isset($_GET['id'])) {
            $_SESSION['errors'][] = 'Invalid post id';
        } else {
            $success = $posts_model->update_single_post_field('status', 'published', $_GET['id']);
            if(!$success) {
                $_SESSION['errors'][] = 'Could not restore post';
            } else {
                $_SESSION['success'] = 'Post restored';
            }
        }
        if($trashed > 1) {
            reload('page=posts&action=trashcan');
        } else {
           reload('page=posts'); 
        }
        break;
        
    case 'trashcan':
        
        $all_num = count($posts_model->get_all_posts("status != 'trash'"));
        
        $all_posts = $posts_model->get_all_posts("status = 'trash'");
        
        $posts = array_chunk($all_posts, 10);
        
        $all_p = count($posts);
        
        $p = (isset($_GET['p'])) ? $_GET['p']-1 : 0;
        
        $trash_num = count($all_posts);
        
        include ADMIN_PAGES . 'posts.php';
        include ADMIN_PAGES . 'pagination.php';
        
        break;
    
    case 'delete':
        $trashed = count($posts_model->get_all_posts("status = 'trash'"));
        if(!isset($_GET['id'])) {
            $_SESSION['errors'][] = 'Invalid id';
        } else {
            $comments = $posts_model->get_all_post_comments('c.post_id = ' . $_GET['id']);
            foreach($comments as $comment) {
                $rmcomment = $posts_model->remove_post_comment($comment['id']);
                if(!$rmcomment) {
                    echo 'Could not remove comment';
                } else {
                    echo 'Comment removed';
                }
            }
            
            $rmtags = $posts_model->remove_post_tag_relationship_by_post_id($_GET['id']);
            if($rmtags) echo 'Tag relations removed';
            
            $success = $posts_model->delete_post($_GET['id']);
            if(!$success) {
                $_SESSION['errors'][] = 'Could not delete post';
            } else {
                $_SESSION['success'] = 'Post deleted forever. You cannot undo this action.';
            }
        }
        
        if($trashed > 1) {
            reload('page=posts&action=trashcan');
        } else {
            reload('page=posts');
        }
        break;
    
    case 'comments':
        $comment_action = (isset($_GET['comment_action'])) ? $_GET['comment_action'] : 'all';
        
        switch($comment_action) {
            case 'all':
                $all_comments = $posts_model->get_all_post_comments();
                
                $comments = array_chunk($all_comments, 10);
                
                $p = (isset($_GET['p'])) ? $_GET['p']-1 : 0;
                
                $all_p = count($comments);

                include ADMIN_PAGES . 'post_comments.php';
                include ADMIN_PAGES . 'pagination.php';
                break;
            
            case 'edit':
                if(!isset($_GET['id'])) {
                    $_SESSION['errors'][] = 'Invalid id';
                } else {
                    if(isset($_POST['edit_comment'])) {
                        if(isset($_POST['user_id'])) {
                            $author_name = '';
                            $author_email = '';
                            $author_website = '';
                        } else {
                           $author_name = $_POST['author_name'];
                           $author_email = $_POST['author_email'];
                           $author_website = $_POST['author_website'];
                        }
                        
                        $success = $posts_model->edit_post_comment($_GET['id'], $_POST['comment'], $author_name, $author_email, $author_website);
                        
                        if(!$success) {
                            $_SESSION['errors'][] = 'Could not edit comment';
                        } else {
                            $_SESSION['success'] = 'Comment updated';
                        }
                        reload();
                        
                    } else {
                        
                        $comment = $posts_model->get_single_post_comment('c.id', $_GET['id']);
                        
                        include ADMIN_PAGES . 'post_comments_form.php';
                    }
                }
                break;
            
            case 'approve':
                if(!isset($_GET['id'])) {
                    $_SESSION['errors'][] = 'Invalid id';
                } else {
                    $success = $posts_model->update_single_post_comment_field($_GET['id'], 'approved', 1);
                    if(!$success) {
                        $_SESSION['errors'][] = 'Could not approve comment';
                    } else {
                        $_SESSION['success'] = 'Comment approved';
                    }
                }
                reload('page=posts&action=comments');
                break;
            
            case 'deapprove':
                if(!isset($_GET['id'])) {
                    $_SESSION['errors'][] = 'Invalid id';
                } else {
                    $success = $posts_model->update_single_post_comment_field($_GET['id'], 'approved', 0);
                    if(!$success) {
                        $_SESSION['errors'][] = 'Could not deapprove comment';
                    } else {
                        $_SESSION['success'] = 'Comment deapproved';
                    }
                }
                reload('page=posts&action=comments');
                break;
            
            case 'delete':
                if(!isset($_GET['id'])) {
                    $_SESSION['errors'][] = 'Invalid id';
                } else {
                    $success = $posts_model->remove_post_comment($_GET['id']);
                    if(!$success) {
                        $_SESSION['errors'][] = 'Could not remove comment';
                    } else {
                        $_SESSION['success'] = 'Comment deleted forever. You cannot undo this action.';
                    }
                }
                reload('page=posts&action=comments');
                break;
        }
        
        break;
    
    case 'tags':
        $tag_action = (isset($_GET['tag_action'])) ? $_GET['tag_action'] : 'all';
        
        switch($tag_action) {
            case 'all':
                $all_tags = $posts_model->get_all_post_tags();
                
                $tags = array_chunk($all_tags, 10);
                
                $all_p = count($tags);
                
                $p = (isset($_GET['p'])) ? $_GET['p']-1 : 0;
        
                include ADMIN_PAGES . 'post_tags.php';
                include ADMIN_PAGES . 'pagination.php';
                break;
            
            case 'edit':
                if(!isset($_GET['id'])) {
                    $_SESSION['errors'][] = 'Invalid id';
                    reload('page=posts&action=tags');
                } else {
                    if(isset($_POST['edit_tag'])) {
                        if(empty($_POST['name'])) {
                            $errors[] = 'All tags must have a name';
                        }
                        
                        if(empty($errors)) {
                            $success = $posts_model->update_post_tag($_GET['id'], $_POST['name'], $_POST['description']);
                            if(!$success) {
                                $_SESSION['errors'][] = 'Could not update tag';
                            } else {
                                $_SESSION['success'] = 'Tag updated successfully';
                            }
                        } else {
                            $_SESSION['errors'] = $errors;
                        }
                        reload();
                    } else {
                        $tag = $posts_model->get_single_post_tag('id', $_GET['id']);
                        
                        include ADMIN_PAGES . 'tag_form.php';
                    }
                }
                break;
            
            case 'delete':
                if(!isset($_GET['id'])) {
                    $_SESSION['errors'][] = 'Invalid id';
                } else {
                    $success = $posts_model->remove_post_tag($_GET['id']);
                    if(!$success) {
                        $_SESSION['errors'][] = 'Could not remove tag';
                        reload('page=posts&action=tags');
                    } else {
                        $p_t_success = $posts_model->remove_post_tag_relationship_by_tag_id($_GET['id']);
                        if(!$success) {
                            $_SESSION['errors'][] = 'Could not remove post-tag relationships';
                        } else {
                            $_SESSION['success'] = 'Tag removed forever. You cannot undo this action';
                        }
                        reload('page=posts&action=tags');
                    }
                }
                break;
        }
        
        break;
}

if(isset($_SESSION['errors'])) unset($_SESSION['errors']);
if(isset($_SESSION['success'])) unset($_SESSION['success']);
?>
