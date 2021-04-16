<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH.'core/APP_Webtools_Login.php';
class Auth extends APP_Webtools_Login
{

    public function index()
    {
        if (!$this->_check_session()) {
            admin_redirect('auth/login');
        }
        
        admin_redirect($this->config->item('app_webtools_default_page'));
    }

    public function login($err = 0)
    {
        if ($this->_check_session()) {
            admin_redirect($this->config->item('app_webtools_default_page'));
        }

        $this->_data['err'] = $err;
        $this->_data['msg'] = $this->session->flashdata('msg');
        $this->_data['captcha'] = $this->create_captcha();

        $this->_addContent($this->_data);
        $this->_render(false);
    }

    public function create_captcha()
    {
        if (!is_dir("./uploads/")) {
            $oldmask = umask(0);
            mkdir("./uploads/", 0775);
            umask($oldmask);
        }

        if (!is_dir("./uploads/captcha/")) {
            $oldmask = umask(0);
            mkdir("./uploads/captcha/", 0775);
            umask($oldmask);
        }

        $this->load->helper('captcha');

        $vals = array(
                'img_path'      => './uploads/captcha/',
                'img_url'       => base_url('uploads/captcha/'),
                'font_path'     => '/assets/fonts/X-SCALE_.TTF',
                'img_width'     => '320',
                'img_height'    => 50,
                'expiration'    => (60*10),
                'word_length'   => 6,
                'font_size'     => 24,
                // 'img_id'        => 'Imageid',
                'pool'          => '023456789abcdefghijklmnopqrstuvwxyzACDEFGHJKLMNPQRTUVWXYZ',

                // White background and border, black text and red grid
                'colors'        => array(
                        'background' => array(255, 0, 0),
                        'border' => array(0, 0, 0),
                        'text' => array(255,255,255),
                        'grid' => array(0,0,0)
                )
        );

        $cap = create_captcha($vals);

        $data = array(
                'captcha_time'  => $cap['time'],
                'ip_address'    => $this->input->ip_address(),
                'word'          => $cap['word']
        );

        $query = $this->db->insert_string('captcha', $data);
        $this->db->query($query);

        return $cap['image'];
    }

    public function check_captcha($word)
    {
        // First, delete old captchas
        $expiration = time() - (60*10);
        $this->db->where('captcha_time < ', $expiration)->delete('captcha');

        // Then see if a captcha exists:
        $sql = "SELECT COUNT(*) AS count FROM {$this->db->dbprefix('captcha')} WHERE word = ? AND captcha_time > ?";
        $binds = array($word, $expiration);
        $query = $this->db->query($sql, $binds);
        $row = $query->row();

        if ($row->count >= 1) {
            return true;
        }

        return false;
    }

    public function login_process()
    {
        if ($this->_check_session()) {
            admin_redirect($this->config->item('app_webtools_default_page'));
        }

        if (!$this->check_captcha($this->input->post('word'))) {
            $this->session->set_flashdata('msg', 'Kode keamanan salah');
            admin_redirect('auth/login/1');
        }

        $username = strtolower($this->input->post('username'));
        $password = $this->input->post('password');

        if (empty($username) || empty($password)) {
            $this->session->set_flashdata('msg', 'invalid username or password');
            admin_redirect('auth/login/2');
        }

        $this->db->select('admin.*, admin_group.name AS group_name');
        $this->db->from('admin');
        $this->db->join('admin_group', 'admin.group=admin_group.id', 'left');
        $this->db->where(array('admin.username'=>$username));
        $this->db->limit(1);
        $res = $this->db->get()->row();

        if (isset($res->id) && intval($res->id) > 0) {
            //cek apakah tidak active?
            if ($res->is_active==0) {
                $this->session->set_flashdata('msg', 'Your account is inactive');
                admin_redirect('auth/login/5');
            }
            
            $this->load->library('password', array(
                'rotations' => $this->config->item('app_password_rotations'),
                'salt' => $this->config->item('app_password_salt')
            ));

            if ($this->password->is_valid_password($password, $res->password)) {
                $this->_set_session($res);
                admin_redirect($this->config->item('app_webtools_default_page'));
            } else {
                $this->session->set_flashdata('msg', 'invalid username or password');
                admin_redirect('auth/login/4');
            }
        } else {
            $this->session->set_flashdata('msg', 'invalid username or password');
            admin_redirect('auth/login/3');
        }

        exit;
    }

    public function create_password()
    {
        $username = '';
        $password = '';

        $this->load->library('password', array(
                'rotations' => $this->config->item('app_password_rotations'),
                'salt' => $this->config->item('app_password_salt')
            ));
        $passwd = $this->password->encrypt_password($password, $username);

        echo strlen($passwd) . '<hr />';
        echo $passwd;
        exit;
    }

    public function logout()
    {
        $this->_unset_session();
        admin_redirect('auth');
    }
}
