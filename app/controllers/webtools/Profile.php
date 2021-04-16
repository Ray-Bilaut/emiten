<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'core/APP_Webtools.php';
class Profile extends APP_Webtools {

	public function __construct()
	{
        parent::__construct();
        $this->_template_master_data['page_title'] = 'Profile';
	}

    public function index($error='')
    {
        $this->_data['error'] = $error;
        $this->_data['error_msg'] = $this->session->flashdata('error');
        $this->_data['success_msg'] = $this->session->flashdata('success');

        $user = $this->_template_master_data['user'];

        $this->_data['id'] = $user->id;
        $this->_data['admin'] = $this->db->get_where('admin', array('id'=>$user->id))->row();
        $this->_data['group'] = $this->db->get_where('admin_group', array('id>'=>1))->result();

        $this->_addScript('assets/adminlte/bower_components/moment/min/moment.min.js');
        $this->_addStyle('assets/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css');
        $this->_addScript('assets/adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js');
        $this->_addScript('assets/adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js');

        $jsx = "
            $(document).ready(function() {
                $('.datatable').DataTable({
                    'order': [[ 0, 'desc' ]],
                    'autoWidth': false,
                    'scrollY': 400,
                    'scrollX': 400,
                    'scroller': true
                });
            } );
        ";
        $this->_addScript($jsx, 'embed');

        $this->_template_master_data['page_subtitle'] = '&nbsp;';
        $this->_addContent($this->_data);
        $this->_render();
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

    public function edit($idx, $error='')
    {
        $this->_data['error'] = $error;
        $this->_data['error_msg'] = $this->session->flashdata('error');
        $this->_data['success_msg'] = $this->session->flashdata('success');

        $user = $this->_template_master_data['user'];

        $this->_data['id'] = $user->id;
        $this->_data['admin'] = $this->db->get_where('admin', array('id'=>$user->id))->row();
        $this->_data['group'] = $this->db->get_where('admin_group', array('id>'=>1))->result();

        $this->_addScript('assets/adminlte/bower_components/moment/min/moment.min.js');
        $this->_addStyle('assets/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css');
        $this->_addScript('assets/adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js');
        $this->_addScript('assets/adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js');

        $jsx = "
            $(document).ready(function() {
                $('.datatable').DataTable({
                    'order': [[ 0, 'desc' ]],
                    'autoWidth': false
                });
            } );
        ";
        $this->_addScript($jsx, 'embed');

        $this->_template_master_data['page_subtitle'] = '&nbsp;';
        $this->_addContent($this->_data);
        $this->_render();
    }

    public function editprocess($idx)
    {
        $idx = intval($idx);
        if($idx<=0){
            redirect(ADMIN_URL."/{$this->router->class}");
        }

        $data = $this->db->get_where('admin',['id'=>$idx])->row();

        if( empty($data->id)){
            redirect(ADMIN_URL."/{$this->router->class}");
        }

        $data_new = [
            'name' => trim($this->input->post('name')),
            'bio' => trim($this->input->post('bio'))
        ];

        $this->load->library('form_validation');
        
        $this->form_validation->set_message('required', '{field} can\'t be empty');
        $this->form_validation->set_message('max_length', '{field} max {param} characters');
        $this->form_validation->set_rules('name', 'Name', 'required');
        // $this->form_validation->set_rules('bio', 'Bio', 'required');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('error', validation_errors());
            redirect(ADMIN_URL."/{$this->router->class}/edit/{$idx}/error");
        }

        $this->load->library('mfupload');

        $img = $this->mfupload->image('image', './uploads/expert/', false, 'image_');
        if ($img->status==400) {
            $this->session->set_flashdata('error', $img->message);
            redirect(ADMIN_URL."/{$this->router->class}/edit/{$idx}/error");
        } elseif ($img->status==200) {
            $data_new['image'] = empty($img->image) ? '' : $img->image;
        }

        $data_new['slug_url'] = $this->slug_url($data_new['name'],true,$idx);

        if ($this->db->update('admin', $data_new, array('id'=>$idx))) {
            $this->session->set_flashdata('success', 'Edit data success');
            redirect(ADMIN_URL."/{$this->router->class}/edit/{$idx}/success");
        } else {
            $this->session->set_flashdata('error', 'Edit data failed, please try again!');
            redirect(ADMIN_URL."/{$this->router->class}/edit/{$idx}/error");
        }
    }

    public function delete($id)
    {
        $id = intval($id);
        
        if($id<=0){
            redirect(ADMIN_URL."/{$this->router->class}");
        }

        $res = $this->db->delete('admin', ['id' => $id]);

        if($res){
            $this->session->set_flashdata('success', 'Delete data success');
            redirect(ADMIN_URL."/{$this->router->class}/index/success");
        }else{
            $this->session->set_flashdata('error', 'Delete data failed');
            redirect(ADMIN_URL."/{$this->router->class}/index/error");
        }
    }
}