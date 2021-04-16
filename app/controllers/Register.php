<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH.'core/APP_Frontend.php';
class Register extends APP_Frontend
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $email = $this->input->get('email');

        $this->_data['email'] = $email;
        $js = "
        var attr = {};
        $(document).ready(function() {
            analyticLog('register_open', attr);
        });
        ";
        $this->_addScript($js,'embed');
        $this->_addContent($this->_data);
        $this->_render();
    }

    public function customAlpha($str)
    {
        $this->load->helper('text');
        $str = ascii_to_entities($str, true);
    
        if (strpos($str, '&#') !== false) {
            return false;
        } else {
            return true;
        }
    }

    public function addprocess()
    {
        $data = [
            'name' => trim($this->input->post('name')),
            'email' => trim($this->input->post('email')),
            'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
            'is_subscribe' => intval($this->input->post('is_subscribe')),
            'created_date' => date('Y-m-d H:i:s')
        ];
        
        $activation_ticket = hash('sha256', $data['name'].$data['email'].$data['created_date']);
        $data['activation_ticket'] = $activation_ticket;

        $this->load->library('form_validation'); 
        $this->form_validation->set_message('required', '{field} can\'t be empty');
        $this->form_validation->set_message('max_length', '{field} max {param} characters');
        $this->form_validation->set_rules('name', 'NAME', 'required|max_length[50]|callback_customAlpha');
        $this->form_validation->set_rules('email', 'EMAIL', 'required|valid_email|max_length[50]|is_unique[em_user.email]');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('confirmpassword', 'Confirm Password', 'required|matches[password]');

        if ($this->form_validation->run() == false) {
            echo json_encode(['code' => 400]);
            exit();
        } else {
            if ($this->db->insert('user',$data)) {
                // send email here
                echo json_encode(['code' => 200]);
                exit();
                redirect('login');
            } else {
                echo json_encode(['code' => 400]);
                exit();
                redirect('');
            }
        }
    }

    public function confirm($ticket='') {
        $user = $this->db->get_where('user', ['activation_ticket' => $ticket])->row();

        if (empty($user) || $ticket == '') {
            redirect('404');
        } else {
            if ($this->db->update('user',['is_confirm'=>1],['id'=>$user->id])) {
                // send email here
                $this->_addContent($this->_data);
                $this->_render();
            } else {
                redirect('404');
            }
        }
    }
}
