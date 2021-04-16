<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class APP_Core extends CI_Controller {

	protected $_FOLDER = '';

	protected $_tmp;

	protected $_tmp_object = array(
		'styles' => '',
		'scripts' => '',
		'content' => '',
        'content_fullwidth' => '',
        'sidebar' => ''
	);

    var $_template_master_data = array();

    var $_template_master_name = 'master';

    protected $_isLog = false;

    protected $_session_name = '';

    protected $_user; //pastikan $this->_user->id untuk id user guna keperluan log

    protected $_data;

    protected $_FCM_SERVER_KEY = "";

    protected $_FCM_SEND_URL = "https://fcm.googleapis.com/fcm/send";

    function __construct($param=array())
    {
        parent::__construct();

        /* load helper/library/model */
        $this->load->helper('url');
        $this->load->helper('text');
        $this->load->database();
        $this->load->library('session');

        /* Load App config*/
        $this->config->load('app');
        $this->config->load('web');
        
        $this->_session_name = $this->config->item('app_session_name');

        /* META TAG */
        $meta_title = $this->config->item('app_meta_title');
        if( isset($meta_title) && $meta_title!='' ){
            $this->_template_master_data['meta_title'] = "<title>".$meta_title."</title>";   
        }
        $meta_description = $this->config->item('app_meta_description');
        if( isset($meta_description) && $meta_description!='' ){
            $this->_template_master_data['meta_description'] = '<meta name="description" content="'.$meta_description.'">';
        }
        $meta_keywords = $this->config->item('app_meta_keywords');
        if( isset($meta_keywords) && $meta_keywords!='' ){
            $this->_template_master_data['meta_keywords'] = '<meta name="keywords" content="'.$meta_keywords.'">';
        }
        
        /* GOOGLE ANALYTIC */
        $google_analytic = $this->config->item('app_google_analytic');
        if( isset($google_analytic) && $google_analytic!='' ){
            $this->_template_master_data['google_analytic'] = "<script>".$google_analytic."</script>";   
        }

        $this->_FOLDER = isset($param['folder']) ? $param['folder'] : '' ;

        $this->_isLog = isset($param['log']) ? $param['log'] : FALSE;

        $this->_tmp = (object) $this->_tmp_object;

        $this->_template_master_data['login'] = false;
        $this->_data['login'] = false;
        if($this->_check_session()){
            $this->_template_master_data['login'] = true;
            $this->_data['login'] = true;
        }

        if( $this->_isLog )
        {
            $this->_log();
        }

        if(ENVIRONMENT!='development'){
            $this->_FCM_SERVER_KEY = 'AAAAxPp3B5w:APA91bFcSTm8pSQSSv49x7uDUofl0NsWbxVDPhYRoUnVPW7icl78T8nxSY29YBIjUQ5ZERmDZYTj45PUjuSr3QOxFkloGXz4okJeEZQYKwdSiNzs2o-AcRSiEwVFBrNBtC4PGst3H1Dr';
        } else {
            $this->_FCM_SERVER_KEY = 'AAAASC_tUlQ:APA91bFxpbsVx300Jzt96x67R4lAC9UHzyqr1h1Y7AVwlF0OcJRU7oFMqJt-o45CH5oHRXaJfe5nzw6XNXJmLUjJtZ0RbNJOGrsfXK6qIPsfkIF_crgiIIjMlVxMG5nxenlLvSFVxmY5';
        }

        //HTTP CACHING
        $this->output->set_header("Cache-Control: no-cache, must-revalidate");
        $this->output->set_header("Cache-Control: post-check=0, pre-check=0, public, max-age=". (60*60*8) );

        $this->apisdk->set_credential([
            'app-production' => true
        ]);
    }

    /*
     *  _render view
     *
     *  - tambah param master untuk kasih option pake master template atau tidak (25/09/2014)
     * 
     */
    protected function _render($master=true)
    {
        if($master)
        {
        	$data = array();
            
            foreach($this->_tmp as $label => $value){
        		$data[$label] = $value;
        	}

            foreach ($this->_template_master_data as $key => $value) {
                $data[$key] = $value;
            }

        	$this->load->view($this->_FOLDER .'/'. $this->_template_master_name,$data);
        }
        else
        {
            echo $this->_tmp->content;
        }
    }

    protected function _addContent($data=array(),$tmp=false,$container='content')
    {
        if(!$tmp)
        {
            $template = strtolower($this->router->class.'_'.$this->router->method);
    	}
        else
        {
            $template = $tmp;
        }
        $this->_tmp->$container = $this->load->view($this->_FOLDER.'/'.$template,$data,TRUE);
    }

    protected function _addTemplate($data=array(),$template)
    {
        return $this->load->view($this->_FOLDER.'/layout/'.$template,$data,TRUE);     
    }

    function _addStyle($data,$type='inline')
    {
    	if($type=='embed'){
    		$html = '
    			<style type="text/css">
    			'.$data.'
    			</style>
 			'; 
        }elseif($type=='outer'){
            $html = '<link rel="stylesheet" type="text/css" href="'.$data.'" />';
    	}else{
    		$html = '<link rel="stylesheet" type="text/css" href="'.base_url().$data.'" />';
    	}

    	$this->_tmp->styles .= $html;
    }

    function _addScript($data,$type='inline')
    {
    	if($type=='embed'){
    		$html = '
    			<script type="text/javascript">
    			'.$data.'
    			</script>
 			';
        }elseif($type=='outer'){
            $html = '<script src="'.$data.'"></script>'; 
    	}else{
    		$html = '<script src="'.base_url().$data.'"></script>';
    	}

    	$this->_tmp->scripts .= $html;
    }

    protected function _log()
    {
        $this->load->library('mflog',['session_name' => $this->_session_name, 'path' => $this->config->item('app_mflog_path')]);
        $this->mflog->log();
    }

    protected function _set_session($data)
    {
        $this->session->set_userdata($this->_session_name, $data);
    }

    protected function _unset_session()
    {
        $this->session->sess_destroy();
    }

    protected function _check_session()
    {
        $this->_user = $this->session->userdata($this->_session_name);

        if(isset($this->_user->id)){

            $this->_user->data = $this->db->get_where('user',['id' => $this->_user->id])->row();
            $this->_template_master_data['user'] = $this->_user->data;
            $this->_data['user'] = $this->_user->data;

            return TRUE;
        }else{
            return FALSE;
        }
    }

    protected function _is_login()
    {
        if(isset($this->_user->id) ){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    protected function _error($msg)
    {
        if(!is_dir('logs')){
            $oldmask = umask(0);
            mkdir('logs', 0755);
            umask($oldmask);
        }
        error_log(date('d-m-Y H:i:s') . " " . $msg . "\n", 3, "logs/error_".date('dmY').".log");
    }
}