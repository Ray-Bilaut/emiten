<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Notification extends CI_Migration {

    public function up()
    {
        // notif push queue
        $this->db->query("
        CREATE TABLE {$this->db->dbprefix('user_push_queue')} (
            `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `user_id` int(11) NOT NULL,
            `referal_type` varchar(32) NOT NULL,
            `referal_id` int(11) NOT NULL,
            `title` varchar(255) NOT NULL,
            `message` text NOT NULL,
            `url` varchar(255) NOT NULL,
            `is_sent` int(1) NOT NULL DEFAULT 0,
            `is_read` int(1) NOT NULL DEFAULT 0,
            `is_active` int(1) NOT NULL DEFAULT 1,
            `scheduled_datetime` datetime NOT NULL,
            `created_date` datetime NOT NULL,
            `modified_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE CURRENT_TIMESTAMP
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        ");
        $this->db->query("CREATE INDEX user_push_queue_index ON {$this->db->dbprefix('user_push_queue')}(user_id)");

        // fcm token
        $this->db->query("
        CREATE TABLE {$this->db->dbprefix('push_token')} (
            `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `token_id` varchar(255) NOT NULL,
            `user_id` int(11) NOT NULL,
            `is_active` int(1) NOT NULL DEFAULT 1
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        ");
        $this->db->query("CREATE INDEX push_token_index ON {$this->db->dbprefix('push_token')}(user_id)");
    }

    public function down()
    {
        $this->dbforge->drop_table('push_token');
        $this->dbforge->drop_table('user_push_queue');
    }
}