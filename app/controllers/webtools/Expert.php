<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'core/APP_Webtools.php';
class Expert extends APP_Webtools {

	public function __construct()
	{
        parent::__construct();
        $this->_template_master_data['page_title'] = 'Expert';
	}

    public function index($error='')
    {
        $this->_data['error'] = $error;
        $this->_data['error_msg'] = $this->session->flashdata('error');
        $this->_data['success_msg'] = $this->session->flashdata('success');

        $this->db->select("id, name, top_order, is_active", FALSE);
        $this->db->from('admin');
        $this->db->where(['group' => 4]);
        $this->_data['list'] = $this->db->get()->result();

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

    public function change_order($idx=0,$order=0) {
        $this->db->select("*", FALSE);
        $this->db->from('admin');
        $this->db->where(['id' => $idx]);
        $expert = $this->db->get()->row();

        if (empty($expert)) {
            echo json_encode(['code'=>400]);
        }

        $this->db->select("*", FALSE);
        $this->db->from('admin');
        $this->db->where(['top_order' => $order]);
        $prev = $this->db->get()->row();

        if ($this->db->update('admin',['top_order'=>$order],['id'=>$idx])) {
            if (!empty($prev)) {
                $this->db->update('admin',['top_order'=>$expert->top_order],['id'=>$prev->id]);
            }
            echo json_encode(['code'=>200]);
        } else {
            echo json_encode(['code'=>400]);
        }
    }
}