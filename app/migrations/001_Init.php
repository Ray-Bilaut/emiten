<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Init extends CI_Migration {

        public function up()
        {
                //table captcha
                $this->dbforge->add_field("`captcha_id` bigint(13) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY");
                $this->dbforge->add_field([
                        'captcha_time' => [
                                'type' => 'INT',
                                'constraint' => '10',
                                'null' => FALSE,
                                'unsigned' => TRUE
                        ],
                        'ip_address' => [
                                'type' => 'VARCHAR',
                                'constraint' => '45',
                                'null' => FALSE
                        ],
                        'word' => [
                                'type' => 'VARCHAR',
                                'constraint' => '20',
                                'null' => FALSE
                        ]
                ]);
                $this->dbforge->create_table('captcha');

                //table admin
                $this->dbforge->add_field("`id` smallint(5) NOT NULL AUTO_INCREMENT PRIMARY KEY");
                $this->dbforge->add_field([
                        'username' => [
                                'type' => 'VARCHAR',
                                'constraint' => '15',
                                'null' => FALSE
                        ],
                        'name' => [
                                'type' => 'VARCHAR',
                                'constraint' => '255',
                                'null' => FALSE
                        ],
                        'bio' => [
                                'type' => 'TEXT',
                                'null' => FALSE
                        ],
                        'slug_url' => [
                                'type' => 'VARCHAR',
                                'constraint' => '15',
                                'null' => FALSE
                        ],
                        'image' => [
                                'type' => 'VARCHAR',
                                'constraint' => '255',
                                'null' => FALSE
                        ],
                        'top_order' => [
                                'type' => 'TINYINT',
                                'constraint' => '2',
                                'null' => FALSE,
                                'default' => 0
                        ],
                        'password' => [
                                'type' => 'VARCHAR',
                                'constraint' => '192',
                                'null' => FALSE
                        ],
                        'group' => [
                                'type' => 'TINYINT',
                                'constraint' => '2',
                                'null' => FALSE
                        ],
                        'is_active' => [
                                'type' => 'TINYINT',
                                'constraint' => '1',
                                'null' => FALSE,
                                'default' => 0
                        ],
                        'is_delete' => [
                                'type' => 'TINYINT',
                                'constraint' => '1',
                                'null' => FALSE,
                                'default' => 0
                        ],
                        'created_date' => [
                                'type' => 'DATETIME',
                                'null' => FALSE
                        ]
                ]);
                $this->dbforge->add_field("`modified_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP");
                $this->dbforge->create_table('admin');

                $data = [
                        ['id' => 1, 'username' => 'superman', 'password' => '649550f40da69c957165a9232f689881d1e2ac47ec09c84d725df5ef2bb2e5f15cf283aa85534187e1b0220bc1e8bca135544943c5b2177d7e99a6a561a18d0f649550f40da69c957165a9232f689881d1e2ac47ec09c84d725df5ef2bb2e5f1', 'group' => 1, 'is_active' => 1, 'created_date' => date('Y-m-d H:i:s')],
                        ['id' => 2, 'username' => 'editor', 'password' => '6541b8da713c6fbce1a21ccc36b9b978a3789f0112ef953278f6a40038f18edd72c26548faab2288901d0a4e99d22529ac439f18aba6d7ba4e9dbaa173d96d2b6541b8da713c6fbce1a21ccc36b9b978a3789f0112ef953278f6a40038f18edd', 'group' => 2, 'is_active' => 1, 'created_date' => date('Y-m-d H:i:s')]
                ];
                $this->db->insert_batch('admin', $data);

                //table admin_access
                $this->dbforge->add_field("`id` int(10) NOT NULL AUTO_INCREMENT PRIMARY KEY");
                $this->dbforge->add_field([
                        'controller' => [
                                'type' => 'VARCHAR',
                                'constraint' => '75',
                                'null' => FALSE
                        ],
                        'method' => [
                                'type' => 'VARCHAR',
                                'constraint' => '75',
                                'null' => FALSE
                        ],
                        'groups' => [
                                'type' => 'VARCHAR',
                                'constraint' => '100',
                                'null' => FALSE
                        ]
                ]);
                $this->dbforge->create_table('admin_access');

                // $data = [];
                // $this->db->insert_batch('admin_access', $data);
                
                // admin access insert values
                $qry = "
                INSERT INTO {$this->db->dbprefix('admin_access')} (`id`, `controller`, `method`, `groups`) VALUES
                (1, 'welcome', '*', '3,4'),
                (2, 'newsreporter', '*', '3,4'),
                (3, 'profile', '*', '3,4')
                ";
                $this->db->query($qry);

                //table admin_group
                $this->dbforge->add_field("`id` tinyint(2) NOT NULL AUTO_INCREMENT PRIMARY KEY");
                $this->dbforge->add_field([
                        'name' => [
                                'type' => 'VARCHAR',
                                'constraint' => '15',
                                'null' => FALSE
                        ]
                ]);
                $this->dbforge->create_table('admin_group');

                $data = [
                        ['id' => 1, 'name' => 'superadmin'],
                        ['id' => 2, 'name' => 'editor'],
                        ['id' => 3, 'name' => 'reporter'],
                        ['id' => 4, 'name' => 'expert']
                ];
                $this->db->insert_batch('admin_group', $data);

                //table admin_logs
                $this->dbforge->add_field([
                        'user_id' => [
                                'type' => 'INT',
                                'constraint' => '10',
                                'null' => FALSE,
                                'default' => '0'
                        ],
                        'ip_address' => [
                                'type' => 'VARCHAR',
                                'constraint' => '45',
                                'null' => FALSE,
                                'default' => '0'
                        ],
                        'controller' => [
                                'type' => 'VARCHAR',
                                'constraint' => '45',
                                'null' => FALSE,
                                'default' => '0'
                        ],
                        'function' => [
                                'type' => 'VARCHAR',
                                'constraint' => '45',
                                'null' => FALSE,
                                'default' => '0'
                        ],
                        'referrer' => [
                                'type' => 'TEXT',
                                'null' => TRUE
                        ],
                        'browser' => [
                                'type' => 'VARCHAR',
                                'constraint' => '55',
                                'null' => FALSE
                        ],
                        'version' => [
                                'type' => 'VARCHAR',
                                'constraint' => '25',
                                'null' => FALSE
                        ],
                        'mobile' => [
                                'type' => 'VARCHAR',
                                'constraint' => '100',
                                'null' => FALSE
                        ],
                        'refid' => [
                                'type' => 'VARCHAR',
                                'constraint' => '155',
                                'null' => FALSE
                        ],
                        'raw_data' => [
                                'type' => 'TEXT',
                                'null' => TRUE
                        ],
                        'created_date' => [
                                'type' => 'DATETIME',
                                'null' => FALSE
                        ]
                ]);
                $this->dbforge->create_table('admin_logs');

        }

        public function down()
        {
                $this->dbforge->drop_table('captcha');
                $this->dbforge->drop_table('admin');
                $this->dbforge->drop_table('admin_group');
                $this->dbforge->drop_table('admin_access');
                $this->dbforge->drop_table('admin_logs');
        }
}