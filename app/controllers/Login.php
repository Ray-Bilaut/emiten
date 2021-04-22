<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'core/APP_Frontend.php';
class Login extends APP_Frontend
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
            analyticLog('login_open', attr);
        });
        ";
        $this->_addScript($js, 'embed');
        $this->_data['subscribe_bottom'] = $this->_addTemplate(null, 'subscribe_bottom');
        $this->_addContent($this->_data);
        $this->_render();
    }

    public function addprocess()
    {
        $email  = $this->input->post('email');
        $password = $this->input->post('password');

        $user = $this->db->get_where('user', ['email' => $email])->row_array();
        if ($user) {
            if (password_verify($password, $user['password'])) {
                // send email here
                $theUser = new \stdClass();
                $theUser->email = $user['email'];
                $theUser->id = $user['id'];
                $theUser->name = $user['name'];
                $this->_set_session($theUser);
                echo json_encode(['code' => 200]);
                exit();
            } else {
                echo json_encode(['code' => 400]);
                exit();
            }
        }
    }

    public function logout()
    {
        $this->_unset_session();
        redirect();
    }
}
