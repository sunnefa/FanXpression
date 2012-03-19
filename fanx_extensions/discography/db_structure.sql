CREATE TABLE `$prefix_disco_albums` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `release_date` int(11) DEFAULT NULL,
  `feature_cover` varchar(255) DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;

CREATE TABLE `$prefix_disco_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `parent` int(11) DEFAULT '0',
  `description` mediumtext,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;

CREATE TABLE `$prefix_disco_songs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `length` varchar(255) DEFAULT NULL,
  `composer` varchar(255) DEFAULT NULL,
  `lyrics` mediumtext,
  `album_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;