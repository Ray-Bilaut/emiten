<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'core/APP_Webtools.php';
// class Category extends APP_Webtools {

// 	public function __construct()
// 	{
//         parent::__construct();
//         $this->_template_master_data['page_title'] = 'Category';
// 	}

//     public function index($error='')
//     {
//         $this->_data['error'] = $error;
//         $this->_data['error_msg'] = $this->session->flashdata('error');
//         $this->_data['success_msg'] = $this->session->flashdata('success');

//         $qry = "SELECT 
// 					c.*,
// 					cat.title as parent 
// 				FROM 
// 					{$this->db->dbprefix('category')} c
// 					LEFT JOIN {$this->db->dbprefix('category')} cat
// 					ON cat.id=c.parent_id
// 				WHERE 
// 					c.is_delete=0
// 				";
//         $this->_data['categories'] = $this->db->query($qry)->result();

//         $this->_addScript('assets/adminlte/bower_components/moment/min/moment.min.js');
//         $this->_addStyle('assets/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css');
//         $this->_addScript('assets/adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js');
//         $this->_addScript('assets/adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js');

//         $jsx = "
//             $(document).ready(function() {
//                 $('.datatable').DataTable({
//                     'order': [[ 0, 'desc' ]],
//                     'autoWidth': false,
//                     'columnDefs': [
//                         { 'targets': [1] }
//                     ]
//                 });
//             } );
//         ";
//         $this->_addScript($jsx, 'embed');

//         $this->_template_master_data['page_subtitle'] = '&nbsp;';
//         $this->_addContent($this->_data);
//         $this->_render();
//     }

//     public function add($error='')
//     {
//         $this->_data['error'] = $error;
//         $this->_data['error_msg'] = $this->session->flashdata('error');
//         $this->_data['categories'] = $this->db->get_where('category', array('is_delete'=>0, 'parent_id'=>0))->result();

//         $this->_template_master_data['page_subtitle'] = 'add';
//         $this->_addContent($this->_data);
//         $this->_render();
//     }

//     public function addprocess()
//     {
//         $data = [
//             'title' => trim($this->input->post('title')),
// 			'created_date' => date('Y-m-d H:i:s'),
//             'parent_id' => $this->input->post('parent_id')
//         ];

//         $this->load->library('form_validation'); 
//         $this->form_validation->set_message('required', '{field} can\'t be empty');
//         $this->form_validation->set_message('max_length', '{field} max {param} characters');
//         $this->form_validation->set_rules('title', 'Title', 'required');
		
//         if ($this->form_validation->run() == false) {
//             $this->session->set_flashdata('error', validation_errors());
//             redirect(ADMIN_URL."/{$this->router->class}/add/error");
//         }

//         $data['slug_url'] = $this->slug_url($data['title']);

//         if ($this->db->insert('category', $data)) {
//             $new_id = $this->db->insert_id();

//             $this->session->set_flashdata('success', 'Add data success');
//             redirect(ADMIN_URL."/{$this->router->class}/edit/{$new_id}/success");
//         } else {
//             $this->session->set_flashdata('error', 'Add data failed, please try again!');
//             redirect(ADMIN_URL."/{$this->router->class}/add/error");
//         }
//     }

//     protected function slug_url($word,$edit=false,$edit_id=0)
//     {
//         $url = url_title($word,"-",true);
//         $no = 1;
//         $subfix = "";
//         $get = false;

//         while(!$get){

//             if($edit){
//                 $res = $this->db->get_where('category',['slug_url' => $url.$subfix, 'id <>' => $edit_id])->num_rows();
//             }else{
//                 $res = $this->db->get_where('category',['slug_url' => $url.$subfix])->num_rows();
//             }

//             if( intval($res)<=0 ){
//                 $get = true;
//                 $url = $url.$subfix;
//             }

//             $no = $no + 1;
//             $subfix = "-".$no;
//         }

//         return $url;
//     }

//     public function edit($idx,$error='')
//     {
//         $idx = intval($idx);
//         if($idx<=0){
//             redirect(ADMIN_URL."/{$this->router->class}");
//         }

//         $data = $this->db->get_where('category',['id'=>$idx])->row();

//         if( empty($data->id)){
//             redirect(ADMIN_URL."/{$this->router->class}");
//         }

//         $this->_data['categories'] = $this->db->get_where('category', array('is_delete'=>0, 'parent_id'=>0))->result();

//         $this->_data['data'] = $data;
//         $this->_data['id'] = $idx;
//         $this->_data['error'] = $error;
//         $this->_data['error_msg'] = $this->session->flashdata('error');
//         $this->_data['success_msg'] = $this->session->flashdata('success');

//         $this->_template_master_data['page_subtitle'] = 'edit';
//         $this->_addContent($this->_data);
//         $this->_render();
//     }

//     public function editprocess($idx)
//     {
//         $idx = intval($idx);
//         if($idx<=0){
//             redirect(ADMIN_URL."/{$this->router->class}");
//         }

//         $data = $this->db->get_where('category',['id'=>$idx])->row();

//         if( empty($data->id)){
//             redirect(ADMIN_URL."/{$this->router->class}");
//         }

//         $data_new = [
//             'title' => trim($this->input->post('title')),
//             'parent_id' => $this->input->post('parent_id')
//         ];

//         $this->load->library('form_validation');
        
//         $this->form_validation->set_message('required', '{field} can\'t be empty');
//         $this->form_validation->set_message('max_length', '{field} max {param} characters');
//         $this->form_validation->set_rules('title', 'Title', 'required');

//         if ($this->form_validation->run() == false) {
//             $this->session->set_flashdata('error', validation_errors());
//             redirect(ADMIN_URL."/{$this->router->class}/edit/{$idx}/error");
//         }

//         $data_new['slug_url'] = $this->slug_url($data_new['title'],true,$idx);

//         if ($this->db->update('category', $data_new, array('id'=>$idx))) {
//             $this->session->set_flashdata('success', 'Edit data success');
//             redirect(ADMIN_URL."/{$this->router->class}/edit/{$idx}/success");
//         } else {
//             $this->session->set_flashdata('error', 'Edit data failed, please try again!');
//             redirect(ADMIN_URL."/{$this->router->class}/add/error");
//         }
//     }

//     public function delete($id)
//     {
//         $id = intval($id);
        
//         if($id<=0){
//             redirect(ADMIN_URL."/{$this->router->class}");
//         }

//         $res = $this->db->update('category', ['is_delete' => 1], ['id' => $id]);

//         if($res){
//             $this->session->set_flashdata('success', 'Delete data success');
//             redirect(ADMIN_URL."/{$this->router->class}/index/success");
//         }else{
//             $this->session->set_flashdata('error', 'Delete data failed');
//             redirect(ADMIN_URL."/{$this->router->class}/index/error");
//         }
//     }
// }