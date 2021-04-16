<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'core/APP_Webtools.php';
class Trending extends APP_Webtools {

	public function __construct()
	{
        parent::__construct();
        $this->_template_master_data['page_title'] = 'Trending';
	}

    public function index($error='')
    {
        $this->_data['error'] = $error;
        $this->_data['error_msg'] = $this->session->flashdata('error');
        $this->_data['success_msg'] = $this->session->flashdata('success');

        $this->_data['list'] = $this->db->get_where('news', array('is_delete'=>0, 'is_trending'=> 1))->result();
        $this->_data['categories'] = $this->db->get_where('category', array('is_delete'=>0))->result();
        $this->_data['authors'] = $this->db->get_where('admin')->result();
        // $this->_data['experts'] = $this->db->get_where('expert')->result();

        $this->_addScript('assets/adminlte/bower_components/moment/min/moment.min.js');
        $this->_addStyle('assets/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css');
        $this->_addScript('assets/adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js');
        $this->_addScript('assets/adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js');
        $this->_addScript('assets/adminlte/plugins/datatables/datetime-moment.js');

        $jsx = "
            $.fn.dataTable.moment('DD MMM YYYY - HH:mm');
            $(document).ready(function() {
                $('.datatable').DataTable({
                    'order': [[ 6, 'desc' ]],
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

    public function remove($idx)
    {
        $idx = intval($idx);
        
        if($idx<=0){
            redirect(ADMIN_URL."/{$this->router->class}");
        }

        $res = $this->db->update('news', ['is_trending' => 0], ['id' => $idx]);

        if($res){
            $this->session->set_flashdata('success', 'Remove data success');
            redirect(ADMIN_URL."/{$this->router->class}/index/success");
        }else{
            $this->session->set_flashdata('error', 'Remove data failed');
            redirect(ADMIN_URL."/{$this->router->class}/index/error");
        }
    }
}