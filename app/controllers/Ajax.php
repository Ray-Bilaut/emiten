<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH.'core/APP_Frontend.php';
class Ajax extends APP_Frontend
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('notif_model');
    }

    public function addFcmToken()
    {
        header('Content-Type: application/json');

        $userId = 0;
        if (!empty($this->_user)) {
            $userId = $this->_user->id;
        }

        $token = $this->input->post('token');
        $oldToken = $this->input->post('old_token');

        $set = $this->notif_model->update_fcm_token($userId, $token, $oldToken);

        $url = 'https://iid.googleapis.com/iid/v1:batchAdd';
        $server_key = $this->_FCM_SERVER_KEY;
        
        $headers = array(
            'Content-Type:application/json',
            'Authorization:key='.$server_key
        );

        $fields = array(
            'to' => '/topics/emitennews',
            'registration_tokens' => [$token]
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        curl_close($ch);


        if(isset($set) and $set != FALSE) {
            echo json_encode([
                'status' => true,
                'message' => 'success',
                'code' => 200,
                'result' => $result,
            ]);
        } else {
            echo json_encode([
                'status' => false,
                'message' => 'failed',
                'code' => 400
            ]);
        }
    }

    public function like($identifier, $idx, $type) {
        if (empty($this->_user->id)) {
            echo json_encode([
                'status' => false,
                'message' => 'forbidden',
                'code' => 401
            ]);
        } else {
            $result = $this->news->like($identifier, $idx, $this->_user->id, $type);
            if ($result !== FALSE) {
                echo json_encode([
                    'status' => true,
                    'message' => 'success',
                    'code' => 200,
                    'result' => $result
                ]);
            } else {
                echo json_encode([
                    'status' => false,
                    'message' => 'failed',
                    'code' => 400,
                    'result' => $result
                ]);
            }
        }
    }

    public function comment($identifier, $idx, $type) {
        if (empty($this->_user->id)) {
            echo json_encode([
                'status' => false,
                'message' => 'Please login first.',
                'code' => 400
            ]);
        } else {
            $comment = $this->input->post('comment');

            $object = new \stdClass();
            switch ($type) {
                case 'podcast':
                    $object = $this->podcast->getPodcastByID($idx);
                    break;
                case 'infographic':
                    $object = $this->infographic->getInfographicByID($idx);
                    break;
                default:
                    $object = $this->news->getNewsByID($idx);
                    break;
            }

            if($object == FALSE) {
                echo json_encode([
                    'status' => false,
                    'message' => 'News not found.',
                    'code' => 401
                ]);
            }

            if ($this->news->comment($identifier, $idx, $this->_user->id, $comment)) {
                echo json_encode([
                    'status' => true,
                    'message' => 'Comment successfully sent.',
                    'code' => 200
                ]);
            } else {
                echo json_encode([
                    'status' => false,
                    'message' => 'Failed',
                    'code' => 400
                ]);
            }
        }
    }

    public function subscribe($is_subscribe) {
        if (empty($this->_user->id)) {
            echo json_encode([
                'status' => false,
                'message' => 'Change preference failed.',
                'code' => 400
            ]);
        } else {
            if ($this->user->subscribe($is_subscribe, $this->_user->id) != FALSE) {
                echo json_encode([
                    'status' => true,
                    'message' => 'Change preference success.',
                    'code' => 200
                ]);
            } else {
                echo json_encode([
                    'status' => false,
                    'message' => 'Change preference failed.',
                    'code' => 401
                ]);
            }
        }
    }

    public function changepassword() {
        if (empty($this->_user->id)) {
            echo json_encode([
                'status' => false,
                'message' => 'Change preference failed.',
                'code' => 400
            ]);
        } else {
            $this->load->library('form_validation'); 
            $this->form_validation->set_message('required', '{field} can\'t be empty');
            $this->form_validation->set_rules('password', 'Password', 'required');
            $this->form_validation->set_rules('confirmpassword', 'Confirm Password', 'required|matches[password]');
    
            if ($this->form_validation->run() == false) {
                echo json_encode(['code' => 400, 'message' => validation_errors()]);
                exit();
            } else {

                $data = [
                    'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                ];

                if ($this->db->update('user',$data,['id'=>$this->_user->id])) {
                    echo json_encode(['code' => 200]);
                    exit();
                } else {
                    echo json_encode(['code' => 400]);
                    exit();
                }
            }
        
        }
    }
}
