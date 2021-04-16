<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'core/APP_Webtools.php';
class Badword extends APP_Webtools {

	public function __construct()
	{
        parent::__construct();
        $this->_template_master_data['page_title'] = 'Badword';
	}

    public function index($error='')
    {
        $this->_data['error'] = $error;
        $this->_data['error_msg'] = $this->session->flashdata('error');
        $this->_data['success_msg'] = $this->session->flashdata('success');

        $this->_data['list'] = $this->db->get('badword')->result();

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

    public function add($error='')
    {
        $this->_data['error'] = $error;
        $this->_data['error_msg'] = $this->session->flashdata('error');

        $this->_template_master_data['page_subtitle'] = 'add';
        $this->_addContent($this->_data);
        $this->_render();
    }

    public function addprocess()
    {
        // $this->load->library('form_validation'); 
        // $this->form_validation->set_message('required', '{field} can\'t be empty');
        // $this->form_validation->set_rules('word', 'word', 'required');
		
        // if ($this->form_validation->run() == false) {
        //     $this->session->set_flashdata('error', validation_errors());
        //     redirect(ADMIN_URL."/{$this->router->class}/add/error");
        // }

        $words = $this->input->post('word');

        $existing = $this->db->query("select word from {$this->db->dbprefix('badword')}")->result_array();

        $data = [];

        foreach ($words as $word) {
            if (!in_array(array('word'=>$word), $existing) && trim($word) != "") {
                $insert = array(
                    'word' => trim($word)
                );
                array_push($data, $insert);
            }
        }

        if (count($data) > 0) {
            if($this->db->insert_batch('badword', $data)) {
                $this->session->set_flashdata('success', 'Add data success');
                redirect(ADMIN_URL."/{$this->router->class}/index");
            } else {
                $this->session->set_flashdata('error', 'Add data failed, please try again!');
                redirect(ADMIN_URL."/{$this->router->class}/add/error");
            }
        } else {
            $this->session->set_flashdata('success', 'Add data success');
            redirect(ADMIN_URL."/{$this->router->class}/index");
        }
    }

    public function delete($id)
    {
        $id = intval($id);
        
        if($id<=0){
            redirect(ADMIN_URL."/{$this->router->class}");
        }

        $res = $this->db->delete('badword', ['id' => $id]);

        if($res){
            $this->session->set_flashdata('success', 'Delete data success');
            redirect(ADMIN_URL."/{$this->router->class}/index/success");
        }else{
            $this->session->set_flashdata('error', 'Delete data failed');
            redirect(ADMIN_URL."/{$this->router->class}/index/error");
        }
    }
}