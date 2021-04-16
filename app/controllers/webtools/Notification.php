<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH.'core/APP_Webtools.php';
class Notification extends APP_Webtools
{

    public function __construct()
    {
        parent::__construct();
        $this->_template_master_data['page_title'] = 'Notification';
    }

    public function index($error='')
    {
        $this->_data['error'] = $error;
        $this->_data['error_msg'] = $this->session->flashdata('error');
        $this->_data['success_msg'] = $this->session->flashdata('success');

        $this->db->select("*");
        $this->db->from('user_push_queue');
        $this->db->order_by('id', 'desc');
        $this->_data['list'] =  $this->db->get()->result();

        $this->_addScript('assets/adminlte/bower_components/moment/min/moment.min.js');
        $this->_addStyle('assets/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css');
        $this->_addScript('assets/adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js');
        $this->_addScript('assets/adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js');
        $this->_addScript('assets/adminlte/plugins/datatables/datetime-moment.js');

        $jsx = "
            $.fn.dataTable.moment('DD MMM YYYY - HH:mm');
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
        $this->_addStyle('assets/adminlte/plugins/daterangepicker/daterangepicker.css');
        $this->_addScript('assets/adminlte/plugins/moment/moment.min.js');
        $this->_addScript('assets/adminlte/plugins/daterangepicker/daterangepicker.js');
        $this->_addScript("$(document).ready(function() {"
            . "$('.datepick').daterangepicker({"
            . "singleDatePicker: true,"
            . "showDropdowns: true,"
            . "timePicker: true,"
            . "locale: {
                format: 'DD/MM/YYYY HH:mm:ss'
              }"
            . "});"
            . "} );",
        'embed');
    
        $this->_addContent($this->_data);
        $this->_render();
    }

    public function addprocess() {

        $this->load->library('form_validation');                
        $this->form_validation->set_rules('title', 'Title', 'trim|required');
        $this->form_validation->set_rules('message', 'Message', 'trim|required');
        $this->form_validation->set_rules('publish_date', 'Publish Date', 'trim|required');
        $this->form_validation->set_rules('url', 'Click Url', 'trim|required');

        if ($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata('error', validation_errors());
            redirect(ADMIN_URL."/{$this->router->class}/add/error");
        }

        $title = $this->input->post('title',true);
        $message = $this->input->post('message',true);
        $clickUrl = $this->input->post('url');
        $publishDate = $this->input->post('publish_date',true);
        $scheduledDatetime = DateTime::createFromFormat('d/m/Y H:i:s', $publishDate);
        
        $data = array(
                'title' => $title,
                'message' => $message,
                'url' => $clickUrl,
                'user_id' => 0,
                'is_read' => 1,
                'referal_type' => 'broadcast',
                'referal_id' => 0,
                'scheduled_datetime' => $scheduledDatetime->format('Y-m-d H:i:s'),
                'created_date' => date('Y-m-d H:i:s'),
            );

        if( $this->db->insert('user_push_queue',$data) ){
            $this->session->set_flashdata('success', "Notification successfully added.");
            redirect(ADMIN_URL."/{$this->router->class}/index/success");
        }else{
            $this->session->set_flashdata('error', 'Add Notification failed, please try again!');
            redirect(ADMIN_URL."/{$this->router->class}/add/error");
        }
    }
}
