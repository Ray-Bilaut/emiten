<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH.'core/APP_Core.php';
class Cron extends APP_Core
{
    
    public function __construct()
    {       
        parent::__construct(array(
        	'log' => FALSE
        ));
        //$this->benchmark->mark('cron_start');
        
        $this->config->set_item('base_url', $this->config->item('app_cron_base'));       
        
        //Cek CLI
        if(!is_cli()) {
            redirect();
            exit("Error");
        }
        
        $this->load->model("notif_model");
    }
    
    public function notification_push() {
        $now = date('Y-m-d H:i:s');
    	$get_lists = $this->db->query("SELECT * FROM ".$this->db->dbprefix('user_push_queue')." WHERE is_sent = 0 AND scheduled_datetime <= '".$now."' ORDER BY id ASC LIMIT 0,100")->result_array();

        $url = $this->_FCM_SEND_URL;
        $server_key = $this->_FCM_SERVER_KEY;
        $headers = array(
            'Content-Type:application/json',
            'Authorization:key='.$server_key
        );

    	foreach ($get_lists as $key => $value) {
            $data = [
                        "priority" => 'high',
                        "mutable_content"=>true,
                        "notification" => [
                            "title" => $value['title'],
                            "body" => $value['message'],
                            "url" => $value['url'],
                            "icon" => base_url('assets/images/logo.png'),
                        ],
                        "data" => [
                            "notification" => [
                                "title" => $value['title'],
                                "body" => $value['message'],
                                "type" => $value['referal_type'],
                                "id" => $value['referal_id'],
                                "url" => $value['url'],
                                "icon" => base_url('assets/images/logo.png'),
                            ],
                        ]
                    ];

            if($value['user_id'] != 0) {
                $tkn = $this->notif_model->get_user_token($value['user_id']);
                $data['registration_ids'] = array($tkn);
                $data['notification']['badge'] = $this->notif_model->get_unread_count($value['user_id']);
                if($tkn == FALSE) {
                    $this->db->update('user_push_queue',['is_sent'=>1],['id'=>$value['id']]);
                    continue;
                }
            } else {
                $data['to'] = '/topics/emitennews';
            }

            $data = json_encode($data);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
            $result = curl_exec($ch);

            var_dump($result);

            if ($result === FALSE) {
                echo 'Oops! FCM Send Error: ' . curl_error($ch).'<br>';
            } else {
                echo 'Sent: ' . $value['id'].'<br>';
                $this->db->update('user_push_queue',['is_sent'=>1],['id'=>$value['id']]);
            }
            curl_close($ch);
    	}
    }
    
}