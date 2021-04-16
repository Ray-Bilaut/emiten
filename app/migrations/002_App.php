<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_App extends CI_Migration {

        public function up()
        {
            // ads
            $qry = "
                CREATE TABLE {$this->db->dbprefix('ads')} (
                    `id` int(11) NOT NULL AUTO_INCREMENT,
                    `title` varchar(255) NOT NULL,
                    `image` varchar(255) NOT NULL,
                    `url` varchar(255) NOT NULL,
                    `position_id` int(11) NOT NULL,
                    `author_id` int(11) NOT NULL,
                    `is_active` tinyint(1) NOT NULL DEFAULT '0',
                    `is_delete` tinyint(1) NOT NULL DEFAULT '0',
                    `created_date` datetime NOT NULL,
                    `modified_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                    PRIMARY KEY (`id`)
                ) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4
           ";
           $this->db->query($qry);
           $this->db->query("CREATE INDEX ads_index ON {$this->db->dbprefix('ads')}(position_id,author_id)");

            // ads position
            $qry = "
                CREATE TABLE {$this->db->dbprefix('ads_position')} (
                    `id` int(11) NOT NULL AUTO_INCREMENT,
                    `name` varchar(155) NOT NULL,
                    PRIMARY KEY (`id`)
                  ) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4
           ";
           $this->db->query($qry);

           // category insert values
           $qry = "
           INSERT INTO {$this->db->dbprefix('ads_position')} (`id`, `name`) VALUES
           (1, 'Banner Home'),
           (2, 'News List 1'),
           (3, 'News List 2'),
           (4, 'News Detail 1'),
           (5, 'News Detail 2'),
           (6, 'Expert Views 1'),
           (7, 'Expert Views 2'),
           (8, 'Infographic List 1'),
           (9, 'Infographic List 2')
           ";
           $this->db->query($qry);

            // author
            $qry = "
                CREATE TABLE {$this->db->dbprefix('author')} (
                    `id` int(11) NOT NULL AUTO_INCREMENT,
                    `name` varchar(50) NOT NULL,
                    `slug_url` varchar(155) NOT NULL,
                    `created_date` datetime NOT NULL,
                    `modified_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                    PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4
           ";
           $this->db->query($qry);

           // category
           $qry = "
           CREATE TABLE {$this->db->dbprefix('category')} (
                    `id` int(11) NOT NULL AUTO_INCREMENT,
                    `title` varchar(50) NOT NULL,
                    `slug_url` varchar(155) NOT NULL,
                    `is_active` tinyint(1) NOT NULL DEFAULT '1',
                    `is_pinned` tinyint(1) NOT NULL DEFAULT '0',
                    `is_delete` tinyint(1) NOT NULL DEFAULT '0',
                    `parent_id` int(11) NOT NULL DEFAULT '0',
                    `created_date` datetime NOT NULL,
                    `modified_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                    PRIMARY KEY (`id`)
                ) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4
            ";
            $this->db->query($qry);
            $this->db->query("CREATE INDEX category_index ON {$this->db->dbprefix('category')}(parent_id)");

            // category insert values
            $qry = "
            INSERT INTO {$this->db->dbprefix('category')} (`id`, `title`, `slug_url`, `is_active`, `is_delete`, `parent_id`, `created_date`, `modified_date`) VALUES
            (1, 'Makro', 'makro', 1, 0, 0, '2020-12-13 22:42:26', '2020-12-13 15:42:26'),
            (2, 'Emiten', 'emiten', 1, 0, 0, '2020-12-13 22:48:04', '2020-12-13 15:48:04'),
            (3, 'Regulator', 'regulator', 1, 0, 0, '2020-12-13 22:49:44', '2020-12-13 15:49:44'),
            (4, 'Nasional', 'nasional', 1, 0, 0, '2020-12-14 00:02:57', '2020-12-13 17:02:57'),
            (5, 'Rileks', 'rileks', 1, 0, 0, '2021-01-11 11:45:55', '2021-01-11 04:45:55'),
            (6, 'Informasi', 'informasi', 1, 0, 0, '2021-01-11 12:08:20', '2021-01-11 05:08:20')
            ";
            $this->db->query($qry);

            // comment
            $qry = "
            CREATE TABLE {$this->db->dbprefix('comment')} (
                    `id` int(11) NOT NULL AUTO_INCREMENT,
                    `news_id` int(11) NOT NULL DEFAULT '0',
                    `podcast_id` int(11) NOT NULL DEFAULT '0',
                    `infographic_id` int(11) NOT NULL DEFAULT '0',
                    `user_id` int(11) NOT NULL,
                    `comment` varchar(255) CHARACTER SET latin1 NOT NULL,
                    `created_date` datetime NOT NULL,
                    `modified_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                    PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
            ";
            $this->db->query($qry);
            $this->db->query("CREATE INDEX comment_index ON {$this->db->dbprefix('comment')}(user_id,news_id,podcast_id,infographic_id)");

            // infographic
            $qry = "
            CREATE TABLE {$this->db->dbprefix('infographic')} (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `title` text NOT NULL,
              `description` text NOT NULL,
              `slug_url` varchar(255) NOT NULL,
              `thumb` varchar(100) NOT NULL,
              `image` varchar(100) NOT NULL,
              `image_mobile` varchar(100) NOT NULL,
              `category_id` int(3) NOT NULL DEFAULT '0',
              `author_id` int(11) NOT NULL DEFAULT '0',
              `expert_id` int(11) NOT NULL DEFAULT '0',
              `is_highlight` tinyint(1) NOT NULL DEFAULT '0',
              `is_active` tinyint(1) NOT NULL DEFAULT '0',
              `is_delete` tinyint(1) NOT NULL DEFAULT '0',
              `publish_date` datetime NOT NULL,
              `created_date` datetime NOT NULL,
              `modified_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
              PRIMARY KEY (`id`)
              ) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1
            ";
            $this->db->query($qry);
            $this->db->query("CREATE INDEX infographic_index ON {$this->db->dbprefix('infographic')}(category_id,author_id,expert_id)");

            // like
            $qry = "
            CREATE TABLE {$this->db->dbprefix('like')} (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `news_id` int(11) NOT NULL DEFAULT '0',
                `podcast_id` int(11) NOT NULL DEFAULT '0',
                `infographic_id` int(11) NOT NULL DEFAULT '0',
                `user_id` int(11) NOT NULL,
                `created_date` datetime NOT NULL,
                `modified_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`)
              ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4              
            ";
            $this->db->query($qry);
            $this->db->query("CREATE INDEX like_index ON {$this->db->dbprefix('like')}(news_id,podcast_id,infographic_id,user_id)");

            // news
            $qry = "
            CREATE TABLE {$this->db->dbprefix('news')} (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `title` text NOT NULL,
                `description` text NOT NULL,
                `slug_url` varchar(255) NOT NULL,
                `thumb` varchar(100) NOT NULL,
                `image` varchar(100) NOT NULL,
                `image_mobile` varchar(100) NOT NULL,
                `file_attachment` varchar(100) NOT NULL,
                `category_id` int(3) NOT NULL DEFAULT '0',
                `author_id` int(11) NOT NULL,
                `expert_id` int(11) NOT NULL DEFAULT '0',
                `is_highlight` tinyint(1) NOT NULL DEFAULT '0',
                `is_trending` tinyint(1) NOT NULL DEFAULT '0',
                `is_recommendation` tinyint(1) NOT NULL DEFAULT '0',
                `is_active` tinyint(1) NOT NULL DEFAULT '0',
                `is_delete` tinyint(1) NOT NULL DEFAULT '0',
                `publish_date` datetime NOT NULL,
                `created_date` datetime NOT NULL,
                `modified_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`)
                ) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1
            ";
            $this->db->query($qry);
            $this->db->query("CREATE INDEX news_index ON {$this->db->dbprefix('news')}(category_id,author_id,expert_id)");

            // podcast
            $qry = "
            CREATE TABLE {$this->db->dbprefix('podcast')} (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `title` text NOT NULL,
                `description` text NOT NULL,
                `slug_url` varchar(255) NOT NULL,
                `file_name` varchar(255) NOT NULL,
                `type` tinyint(1) NOT NULL,
                `thumb` varchar(100) NOT NULL,
                `image` varchar(100) NOT NULL,
                `image_mobile` varchar(100) NOT NULL,
                `category_id` int(11) NOT NULL,
                `author_id` int(11) NOT NULL,
                `is_active` tinyint(1) NOT NULL DEFAULT '1',
                `is_delete` tinyint(1) NOT NULL DEFAULT '0',
                `publish_date` datetime NOT NULL,
                `created_date` datetime NOT NULL,
                `modified_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`)
              ) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4
            ";
            $this->db->query($qry);
            $this->db->query("CREATE INDEX podcast_index ON {$this->db->dbprefix('podcast')}(category_id,author_id)");

             // tag
             $qry = "
             CREATE TABLE {$this->db->dbprefix('tag')} (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `title` varchar(200) NOT NULL,
                `slug_url` varchar(255) NOT NULL,
                `created_date` datetime NOT NULL,
                `modified_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`),
                UNIQUE KEY `title` (`title`)
                ) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4
             ";
             $this->db->query($qry);

             // tag relation
             $qry = "
             CREATE TABLE {$this->db->dbprefix('tag_relation')} (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `news_id` int(11) NOT NULL DEFAULT '0',
                `podcast_id` int(11) NOT NULL DEFAULT '0',
                `infographic_id` int(11) NOT NULL DEFAULT '0',
                `tag_id` int(11) NOT NULL,
                PRIMARY KEY (`id`)
                ) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8mb4
             ";
             $this->db->query($qry);
             $this->db->query("CREATE INDEX tag_relation_index ON {$this->db->dbprefix('tag_relation')}(news_id,podcast_id,infographic_id)");

             // user
             $qry = "
             CREATE TABLE {$this->db->dbprefix('user')} (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `name` varchar(50) NOT NULL,
                `email` varchar(50) NOT NULL,
                `password` varchar(192) NOT NULL,
                `activation_ticket` varchar(255) NOT NULL,
                `is_active` tinyint(1) NOT NULL DEFAULT '1',
                `is_confirm` tinyint(1) NOT NULL DEFAULT '0',
                `is_subscribe` tinyint(1) NOT NULL DEFAULT '1',
                `created_date` datetime NOT NULL,
                `modified_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
             ";
             $this->db->query($qry);

             // forgot token
             $qry = "
             CREATE TABLE {$this->db->dbprefix('forgot_token')} (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `user_id` int(11) NOT NULL,
                `code` varchar(255) NOT NULL,
                `is_active` tinyint(1) NOT NULL DEFAULT '1',
                `created_date` datetime NOT NULL,
                `modified_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`)
              ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4              
             ";
             $this->db->query($qry);
             $this->db->query("CREATE INDEX forgot_token_index ON {$this->db->dbprefix('forgot_token')}(user_id)");

        }

        public function down()
        {
                $this->dbforge->drop_table('ads');
                $this->dbforge->drop_table('ads_position');
                $this->dbforge->drop_table('author');
                $this->dbforge->drop_table('category');
                $this->dbforge->drop_table('comment');
                $this->dbforge->drop_table('infographic');
                $this->dbforge->drop_table('like');
                $this->dbforge->drop_table('news');
                $this->dbforge->drop_table('podcast');
                $this->dbforge->drop_table('tag');
                $this->dbforge->drop_table('tag_relation');
                $this->dbforge->drop_table('user');
                $this->dbforge->drop_table('forgot_token');
        }
}