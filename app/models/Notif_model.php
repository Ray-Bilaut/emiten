<?php
class Notif_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get($id='') {
        $this->db->select("*", FALSE);
        $this->db->from('user_push_queue');
        $this->db->where(['id' => $id]);
        
        $i = $this->db->get();

        return $var = ($i->num_rows() > 0) ? $i->row() : FALSE;
    }

    function get_by_referal($referal_type='', $referal_id=0) {
        $this->db->select("*", FALSE);
        $this->db->from('user_push_queue');
        $this->db->where(['referal_type' => $referal_type, 'referal_id' => $referal_id]);
        
        $i = $this->db->get();

        return $var = ($i->num_rows() > 0) ? $i->row() : FALSE;
    }

    function get_editable($id='') {
        $this->db->select("*", FALSE);
        $this->db->from('user_push_queue');
        $this->db->where(['id' => $id, 'is_sent' => 0, 'user_id' => 0]);
        
        $i = $this->db->get();

        return $var = ($i->num_rows() > 0) ? $i->row() : FALSE;
    }

    function update($id,$data=array()) {
        $data['modified_date'] = date('Y-m-d H:i:s');
        $this->db->where('id',$id);      
        $update = $this->db->update('user_push_queue',$data);

        if($update){
            return true;
        }else{
            return false;
        }
    }

    function update_fcm_token($uid, $token, $oldToken = '') {
        $rows = $this->db->query('
            SELECT *
            FROM '.$this->db->dbprefix('push_token').'
            WHERE user_id = "'.$uid.'" AND user_id <> 0')->result();

        $d = array(
            'token_id' => $token,
            'user_id' => $uid,
        );
        
        if(count($rows) == 0) {
            $exist = $this->db->query('
                SELECT *
                FROM '.$this->db->dbprefix('push_token').'
                WHERE token_id = "'.$oldToken.'"')->result();

            if(count($exist) == 0) {
                return $this->db->insert('push_token', $d);
            } else {
                return $this->db->update('push_token', $d, array('token_id'=>$oldToken));
            }
        } else {
            return $this->db->update('push_token', $d, array('user_id'=>$uid));
        }
    }

    function get_user_token($uid) {
    	$get = $this->db->get_where('push_token',['user_id'=>$uid,'is_active'=>1])->row();
    	return (isset($get->token_id)) ? $get->token_id : FALSE;
    }

    function get_unread_count($uid) {
        if($uid == 0) {
            return 0;
        }
        return $this->db->get_where('user_push_queue',['user_id'=>$uid,'is_read'=>0,'is_active'=>1])->num_rows();
    }

    function get_active_tokens() {
        
        return $this->db->get_where('push_token', array('is_active' => 1))->result();
    }

    function get_push_queue($uid,$offset = [],$date_endpoint = NULL) {
        $pagination = "";
        
    	if(isset($offset[0]) and isset($offset[1])) {
    		$pagination = " LIMIT ".$offset[0].",".$offset[1];
    	}

        $now = date('Y-m-d H:i:s');
        $endpoint = (isset($date_endpoint)) ? ' AND created_date >= "'.$date_endpoint.'" ' : '';
        $query = 'SELECT * FROM '.$this->db->dbprefix('user_push_queue').' WHERE (user_id = '.$uid.' OR user_id = 0) AND is_active = 1 '.$endpoint.' AND scheduled_datetime <= "'.$now.'" ORDER BY created_date DESC';

    	$rows = $this->db->query($query.$pagination)->result_array();
    	$total = $this->db->query($query)->num_rows();
    
    	return [
    		'rows' => $rows,
    		'total_row' => $total
    	];
    }

    function clear_read($uid, $notifid) {
        return $this->db->update('user_push_queue',['is_read'=>1],['user_id'=>$uid,'id'=>$notifid]);
    }

    public function set_push_queue($options,$scheduled_datetime = NULL) {
    	$user_id 		= (isset($options['user_id'])) ? $options['user_id'] : 0;
    	$referal_type 	= (isset($options['referal_type'])) ? $options['referal_type'] : NULL;
    	$referal_id 	= (isset($options['referal_id'])) ? $options['referal_id'] : 0;
    	$title 			= (isset($options['title'])) ? $options['title'] : NULL;
    	$message 		= (isset($options['message'])) ? $options['message'] : NULL;
        $url 		= (isset($options['url'])) ? $options['url'] : NULL;
    
    	if(!isset($referal_type) or !isset($title) or !isset($message)) {
    		return FALSE;
    	} 

        if($scheduled_datetime == NULL) {
            $scheduled_datetime = date('Y-m-d H:i:s');
        }

    	return $this->db->insert('user_push_queue',[
            'user_id' => $user_id,
            'referal_type' => $referal_type,
            'referal_id' => $referal_id,
            'title' => $title,
            'message' => $message,
            'is_sent' => 0,
            'scheduled_datetime' => $scheduled_datetime,
            'url' => $url,
            'created_date' => date('Y-m-d H:i:s')
            ]);
    }
}