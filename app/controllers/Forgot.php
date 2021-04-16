<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH.'core/APP_Frontend.php';
class Forgot extends APP_Frontend
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $js = "
        var attr = {};
        $(document).ready(function() {
            analyticLog('forgot_password_open', attr);
        });
        ";
        $this->_addScript($js,'embed');

        $this->_addContent($this->_data);
        $this->_render();
    }

    public function addprocess()
    {
        $email = trim($this->input->post('email'));

        $user = $this->db->get_where('user', ['email' => $email])->row();
		if (!empty($user)) {

            $now = date('Y-m-d H:i:s');

            $data = [
                'user_id' => $user->id,
                'is_active' => 1,
                'created_date' => $now
            ];
            
            $code = hash('sha256', $user->email . $data['user_id'] . $data['created_date']);
            $data['code'] = $code;

            $forgot_token = $this->db->get_where('forgot_token', ['user_id' => $user->id, 'is_active'=>1])->row();

            if (empty($forgot_token)) {
                if ($this->db->insert('forgot_token', $data)) {
                    // send email here (expired in i day)
                    echo json_encode(['code' => 200]);
                    exit();
                } else {
                    echo json_encode(['code' => 400]);
                    exit();
                }
            } else {
                $expired = strtotime("+1 day", strtotime($forgot_token->created_date));
                $expired = date('Y-m-d H:i:s', $expired);

                if ($now < $expired) {
                    
                    // send email here (expired in i day)
                    echo json_encode(['code' => 200]);
                    exit();
                } else {
                    $this->db->update('forgot_token',['is_active'=>0],['id'=>$forgot_token->id]);
                    if ($this->db->insert('forgot_token', $data)) {
                        // send email here (expired in i day)
                        echo json_encode(['code' => 200]);
                        exit();
                    } else {
                        echo json_encode(['code' => 400]);
                        exit();
                    }
                }
            }
		} else {
            echo json_encode(['code' => 400]);
            exit();
        }
    }

    public function reset($code='') {
        $forgot = $this->db->get_where('forgot_token', ['code' => $code, 'is_active' => 1])->row();

        if (empty($forgot) || $forgot == '') {
            redirect('404');
            // $this->_addContent($this->_data);
            // $this->_render();
        } else {
            $now = date('Y-m-d H:i:s');

            $expired = strtotime("+1 day", strtotime($forgot->created_date));
            $expired = date('Y-m-d H:i:s', $expired);

            if ($now < $expired) {
                $this->_data['code'] = $code;
                $this->_addContent($this->_data);
                $this->_render();
            } else {
                $this->db->update('forgot_token',['is_active'=>0],['id'=>$forgot->id]);
                redirect('404');
            }
        }
    }

    public function editprocess($code='') {
        $this->load->library('form_validation'); 
        $this->form_validation->set_message('required', '{field} can\'t be empty');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('confirmpassword', 'Confirm Password', 'required|matches[password]');

        if ($this->form_validation->run() == false || $code == '') {
            echo json_encode(['code' => 400, 'message' => 'Password can\'t be empty']);
            exit();
        }

        $user = $this->db->query('
            SELECT u.id, ft.id as forgot_id
            FROM '.$this->db->dbprefix('user').' u
            LEFT JOIN '.$this->db->dbprefix('forgot_token').' ft
            ON u.id=ft.user_id
            WHERE ft.code = "'.$code.'"')->row();

        if (empty($user)) {
            echo json_encode(['code' => 400, 'message' => 'User not found']);
            exit();
        }

        $data = [
            'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
        ];

        if ($this->db->update('user',$data,['id'=>$user->id])) {
            $this->db->update('forgot_token',['is_active'=>0],['id'=>$user->forgot_id]);
            echo json_encode(['code' => 200]);
            exit();
        } else {
            echo json_encode(['code' => 400]);
            exit();
        }
    }
}
