<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'core/APP_Webtools.php';
class Ads extends APP_Webtools {

	public function __construct()
	{
        parent::__construct();
        $this->_template_master_data['page_title'] = 'Ads';
	}

    public function index($error='')
    {
        $this->_data['error'] = $error;
        $this->_data['error_msg'] = $this->session->flashdata('error');
        $this->_data['success_msg'] = $this->session->flashdata('success');

        $adsQry = "SELECT 
					a.*, ap.name
				FROM 
					{$this->db->dbprefix('ads')} a
                JOIN
                    {$this->db->dbprefix('ads_position')} ap
                ON
                    a.position_id=ap.id
				WHERE 
					a.is_delete=0
				";
        $this->_data['list'] = $this->db->query($adsQry)->result();
        $this->_data['adsPosition'] = $this->db->get_where('ads_position')->result();

        $this->_addScript('assets/adminlte/bower_components/moment/min/moment.min.js');
        $this->_addStyle('assets/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css');
        $this->_addScript('assets/adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js');
        $this->_addScript('assets/adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js');
        $this->_addScript('assets/adminlte/plugins/datatables/datetime-moment.js');

        $jsx = "
            $.fn.dataTable.moment('DD MMM YYYY - HH:mm');
            $(document).ready(function() {
                $('.datatable').DataTable({
                    'order': [[ 7, 'desc' ]],
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

    public function add($error='')
    {
        $this->_data['error'] = $error;
        $this->_data['error_msg'] = $this->session->flashdata('error');
        
        $this->_data['adsPosition'] = $this->db->get_where('ads_position')->result();

        $this->_template_master_data['page_subtitle'] = 'add';
        $this->_addContent($this->_data);
        $this->_render();
    }

    public function addprocess()
    {
        $this->load->library('form_validation'); 
        $this->form_validation->set_message('required', '{field} can\'t be empty');
        $this->form_validation->set_message('max_length', '{field} max {param} characters');
        $this->form_validation->set_rules('title', 'Title', 'required|max_length[255]');
        $this->form_validation->set_rules('url', 'Click Url', 'required|max_length[255]');
		
        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('error', validation_errors());
            redirect(ADMIN_URL."/{$this->router->class}/add/error");
        }

        $now = date('Y-m-d H:i:s');

        $data = [
            'title' => trim($this->input->post('title')),
            'url' => trim($this->input->post('url')),
            'position_id' => intval($this->input->post('position')),
            'is_active' => intval($this->input->post('is_active')),
			'created_date' => $now
        ];

        $this->load->library('mfupload');

        $img = $this->mfupload->image('image','./uploads/ads/',true,'ads_');
        if( $img->status==400 ){
            $this->session->set_flashdata('error', $img->message);
            redirect(ADMIN_URL."/{$this->router->class}/add/error");
        }else{
            $data['image'] = empty($img->image) ? '' : $img->image;
        }

        $data['author_id'] = $this->_template_master_data['user']->id;

        if ($this->db->insert('ads', $data)) {
            $new_id = $this->db->insert_id();
            if ($data['is_active'] == 1) {
                $this->db->update('ads', ['is_active' => 0], ['position_id' => $data['position_id'], 'id <>' => $new_id]);
            }

            $this->session->set_flashdata('success', 'Add data success');
            redirect(ADMIN_URL."/{$this->router->class}/edit/{$new_id}/success");
        } else {
            $this->session->set_flashdata('error', 'Add data failed, please try again!');
            redirect(ADMIN_URL."/{$this->router->class}/add/error");
        }
    }

    public function edit($idx,$error='')
    {
        $idx = intval($idx);
        if($idx<=0){
            redirect(ADMIN_URL."/{$this->router->class}");
        }

        $data = $this->db->get_where('ads',['id'=>$idx])->row();

        if( empty($data->id)){
            redirect(ADMIN_URL."/{$this->router->class}");
        }

        $this->_data['data'] = $data;
        $this->_data['id'] = $idx;
        $this->_data['error'] = $error;
        $this->_data['error_msg'] = $this->session->flashdata('error');
        $this->_data['success_msg'] = $this->session->flashdata('success');

        $this->_data['adsPosition'] = $this->db->get_where('ads_position')->result();

        $this->_template_master_data['page_subtitle'] = 'edit';
        $this->_addContent($this->_data);
        $this->_render();
    }

    public function editprocess($idx)
    {
        $idx = intval($idx);
        if($idx<=0){
            redirect(ADMIN_URL."/{$this->router->class}");
        }

        $data = $this->db->get_where('ads',['id'=>$idx])->row();

        if( empty($data->id)){
            redirect(ADMIN_URL."/{$this->router->class}");
        }

        $this->load->library('form_validation'); 
        $this->form_validation->set_message('required', '{field} can\'t be empty');
        $this->form_validation->set_message('max_length', '{field} max {param} characters');
        $this->form_validation->set_rules('title', 'Title', 'required|max_length[255]');
        $this->form_validation->set_rules('url', 'Click Url', 'required|max_length[255]');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('error', validation_errors());
            redirect(ADMIN_URL."/{$this->router->class}/edit/{$idx}/error");
        }

        $now = date('Y-m-d H:i:s');

        $data_new = [
            'title' => trim($this->input->post('title')),
            'url' => trim($this->input->post('url')),
            'position_id' => intval($this->input->post('position')),
            'is_active' => intval($this->input->post('is_active')),
			'created_date' => $now
        ];

        $this->load->library('mfupload');

        $img = $this->mfupload->image('image', './uploads/ads/', false, 'ads_');
        if ($img->status==400) {
            $this->session->set_flashdata('error', $img->message);
            redirect(ADMIN_URL."/{$this->router->class}/edit/{$idx}/error");
        } elseif ($img->status==200) {
            $data_new['image'] = empty($img->image) ? '' : $img->image;
        }

        if ($this->db->update('ads', $data_new, array('id'=>$idx))) {
            if ($data_new['is_active'] == 1) {
                $this->db->update('ads', ['is_active' => 0], ['position_id' => $data_new['position_id'], 'id <>' => $idx]);
            }

            $this->session->set_flashdata('success', 'Edit data success');
            redirect(ADMIN_URL."/{$this->router->class}/edit/{$idx}/success");
        } else {
            $this->session->set_flashdata('error', 'Edit data failed, please try again!');
            redirect(ADMIN_URL."/{$this->router->class}/add/error");
        }
    }

    public function delete($id)
    {
        $id = intval($id);
        
        if($id<=0){
            redirect(ADMIN_URL."/{$this->router->class}");
        }

        $res = $this->db->update('ads', ['is_delete' => 1], ['id' => $id]);

        if($res){
            $this->session->set_flashdata('success', 'Delete data success');
            redirect(ADMIN_URL."/{$this->router->class}/index/success");
        }else{
            $this->session->set_flashdata('error', 'Delete data failed');
            redirect(ADMIN_URL."/{$this->router->class}/index/error");
        }
    }
}