<?php
class User_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function subscribe($is_subscribe, $uid) {
        return $this->db->update('user',['is_subscribe'=>$is_subscribe],['id'=>$uid]);
    }
}