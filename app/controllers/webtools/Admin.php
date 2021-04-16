<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH.'core/APP_Webtools.php';
class Admin extends APP_Webtools
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index($error = '')
    {
        $this->_data['error'] = $error;
        $this->_data['error_msg'] = $this->session->flashdata('error');
        $this->_data['success_msg'] = $this->session->flashdata('success');

        $qry = "SELECT 
					a.*,
					ag.name 
				FROM 
					{$this->db->dbprefix('admin')} a 
					LEFT JOIN {$this->db->dbprefix('admin_group')} ag 
					ON a.group=ag.id 
				WHERE 
					a.is_delete=0
					and a.group>1
				";
        $this->_data['list'] = $this->db->query($qry)->result();

        $this->_addStyle('assets/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css');
        $this->_addScript('assets/adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js');
        $this->_addScript('assets/adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js');

        $jsr = "
			$(document).ready(function() {
			    $('.datatable').DataTable();
			} );
		";
        $this->_addScript($jsr, 'embed');

        $this->_template_master_data['page_title'] = 'Admin';
        $this->_template_master_data['page_subtitle'] = 'list';
        $this->_addContent($this->_data);
        $this->_render();
    }

    public function add($error = '')
    {
        $this->_data['error'] = $error;
        $this->_data['error_msg'] = $this->session->flashdata('error');

        $this->_data['group'] = $this->db->get_where('admin_group', array('id>'=>1))->result();

        $this->_template_master_data['page_title'] = 'Admin';
        $this->_template_master_data['page_subtitle'] = 'add';
        $this->_addContent($this->_data);
        $this->_render();
    }

    public function addprocess()
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('group', 'Group', 'required|numeric');
        $this->form_validation->set_rules('username', 'Username', 'trim|required|alpha_numeric|min_length[4]|max_length[12]|callback_username_check');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]');
        
        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('error', validation_errors());
            redirect(ADMIN_URL.'/admin/add/error');
        }

        $data = array(
                'name' => trim($this->input->post('name')),
                'username' => strtolower($this->input->post('username', true)),
                'group' => intval($this->input->post('group', true)),
                'created_date' => date('Y-m-d H:i:s')
            );

        //generate password
        $this->load->library('password', array(
                'rotations' => $this->config->item('app_password_rotations'),
                'salt' => $this->config->item('app_password_salt')."webt00ls"
            ));
        $data['password'] = $this->password->encrypt_password($this->input->post('password', true), $data['username']);
        $data['slug_url'] = $this->slug_url($data['name']);
        
        if ($this->db->insert('admin', $data)) {
            $nid = $this->db->insert_id();
            $this->session->set_flashdata('success', 'Add admin success');
            redirect(ADMIN_URL."/admin/edit/{$nid}/success");
        } else {
            $this->session->set_flashdata('error', 'Add admin failed, please try again!');
            redirect(ADMIN_URL.'/admin/add/error');
        }
    }
    public function username_check($str)
    {
        $user = $this->db->get_where('admin', array('username' => $str))->row();
        if (!empty($user->id) && intval($user->id)>0) {
            $this->form_validation->set_message('username_check', 'The {field} already used');
            return false;
        } else {
            return true;
        }
    }

    protected function slug_url($word,$edit=false,$edit_id=0)
    {
        $url = url_title($word,"-",true);
        $no = 1;
        $subfix = "";
        $get = false;

        while(!$get){

            if($edit){
                $res = $this->db->get_where('admin',['slug_url' => $url.$subfix, 'id <>' => $edit_id])->num_rows();
            }else{
                $res = $this->db->get_where('admin',['slug_url' => $url.$subfix])->num_rows();
            }

            if( intval($res)<=0 ){
                $get = true;
                $url = $url.$subfix;
            }

            $no = $no + 1;
            $subfix = "-".$no;
        }

        return $url;
    }

    public function edit($idx = 0, $error = '')
    {
        $idx=intval($idx);
        if ($idx<=0) {
            redirect(ADMIN_URL.'/admin');
        }

        $admin = $this->db->get_where('admin', array('id'=>$idx))->row();

        $this->_data['group'] = $this->db->get_where('admin_group', array('id>'=>1))->result();

        $this->_data['admin'] = $admin;
        $this->_data['id'] = $idx;
        $this->_data['error'] = $error;
        $this->_data['error_msg'] = $this->session->flashdata('error');
        $this->_data['success_msg'] = $this->session->flashdata('success');

        $this->_template_master_data['page_title'] = 'Admin';
        $this->_template_master_data['page_subtitle'] = 'edit';
        $this->_addContent($this->_data);
        $this->_render();
    }

    public function editprocess($idx = 0)
    {
        $idx=intval($idx);
        if ($idx<=0) {
            redirect(ADMIN_URL.'/admin');
        }

        $this->load->library('form_validation');

        $this->form_validation->set_rules('group', 'Group', 'required|numeric');
        $this->form_validation->set_rules('active', 'Active', 'required|numeric');

        if ($this->input->post('password') != '') {
            $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]');
        }
        
        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('error', validation_errors());
            redirect(ADMIN_URL."/admin/edit/{$idx}/error");
        }

        $admin = $this->db->get_where('admin', array('id'=>$idx))->row();

        $data = array(
                'name' => trim($this->input->post('name')),
                'group' => intval($this->input->post('group', true)),
                'is_active' => intval($this->input->post('active', true))
            );

        if ($this->input->post('password') != '') {
            //generate password
            $this->load->library('password', array(
                    'rotations' => $this->config->item('app_password_rotations'),
                    'salt' => $this->config->item('app_password_salt')."webt00ls"
                ));
            $data['password'] = $this->password->encrypt_password($this->input->post('password', true), $admin->username);
        }

        $data_new['slug_url'] = $this->slug_url($data_new['name'],true,$idx);
        
        if ($this->db->update('admin', $data, "id = $idx")) {
            $this->session->set_flashdata('success', 'Edit admin success');
            redirect(ADMIN_URL."/admin/edit/{$idx}/success");
        } else {
            $this->session->set_flashdata('error', 'Edit admin failed, please try again!');
            redirect(ADMIN_URL."/admin/edit/{$idx}/error");
        }
    }

    public function delete($idx = 0)
    {
        $idx=intval($idx);
        if ($idx<=0) {
            redirect(ADMIN_URL.'/admin');
        }

        if ($this->db->update('admin', array('is_delete'=>1), "id = $idx")) {
            $this->session->set_flashdata('success', 'Delete admin success!');
            redirect(ADMIN_URL."/admin/index/success");
        } else {
            $this->session->set_flashdata('error', 'Delete admin failed, please try again!');
            redirect(ADMIN_URL."/admin/index/error");
        }
    }
}
