<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Badwords extends CI_Migration {

    public function up()
    {
        // badword
        $this->db->query("
        CREATE TABLE {$this->db->dbprefix('badword')} (
            `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `word` varchar(255) NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        ");
    }

    public function down()
    {
        $this->dbforge->drop_table('badword');
    }
}