CREATE TABLE `$prefix_pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `date` int(11) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'published',
  `cat_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;

CREATE TABLE `$prefix_posts_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `comment` mediumtext NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `author_name` varchar(255) DEFAULT NULL,
  `author_email` varchar(255) DEFAULT NULL,
  `author_website` varchar(255) DEFAULT NULL,
  `approved` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  PRIMARY KEY (`id`,`post_id`)
) ENGINE=MyISAM;

CREATE TABLE `$prefix_posts_posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `date` int(11) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'published',
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`,`user_id`)
) ENGINE=MyISAM;

CREATE TABLE `$prefix_posts_p_t_relation` (
  `tag_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  PRIMARY KEY (`tag_id`,`post_id`)
) ENGINE=MyISAM;

CREATE TABLE `$prefix_posts_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` mediumtext,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;

CREATE TABLE `$prefix_sections` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(45) NOT NULL,
  `name` varchar(255) NOT NULL,
  `active` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;

CREATE TABLE `$prefix_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `setting_name` varchar(255) NOT NULL,
  `setting_value` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;

CREATE TABLE `$prefix_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `parent` int(11) DEFAULT '0',
  `description` mediumtext,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;

CREATE TABLE `$prefix_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role` varchar(45) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `bio` mediumtext,
  `status` varchar(255) NOT NULL,
  `date_registered` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;

INSERT INTO `$prefix_settings` VALUES(1, 'url', 'http://www.yoursite.com');
INSERT INTO `$prefix_settings` VALUES(2, 'title', 'FanXpression - Fansites made easy');
INSERT INTO `$prefix_settings` VALUES(3, 'theme', 'default');
INSERT INTO `$prefix_settings` VALUES(4, 'posts_per_page', '10');
INSERT INTO `$prefix_settings` VALUES(5, 'max_image_size', '200');
INSERT INTO `$prefix_settings` VALUES(6, 'approve_comments', '0');
INSERT INTO `$prefix_settings` VALUES(7, 'date_format', 'd/m/Y');
INSERT INTO `$prefix_settings` VALUES(8, 'timezone', 'UTC');

INSERT INTO `$prefix_posts_posts` VALUES(1, 'Your first post', '<p>This is your first post, edit or delete it, then start posting news about your favorite star, book, movie, sports team or band.</p>', $time, 'published', 1);

INSERT INTO `$prefix_posts_comments` VALUES(1, '<p>Nice fansite!</p>', NULL, 'Miss FanXpression', 'fanx@fanxpression.com', 'http://www.fanxpression.com', 1, 1);

INSERT INTO `$prefix_pages` VALUES(1, 'Your first page', '<p>This is your first page. Edit or delete it, then start writing about your favorite star, book, movie, sports team or band.</p>', $time, 'published', 1, 1);

INSERT INTO `$prefix_posts_p_t_relation` VALUES(1, 1);

INSERT INTO `$prefix_posts_tags` VALUES(1, 'A tag', '<p>This is your first tag. Edit or delete it, then start making your own.</p>');

INSERT INTO `$prefix_categories` VALUES(1, 'A category', 0, '<p>This is your first category. Edit or delete it, then start adding your own.</p>');