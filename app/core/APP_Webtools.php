<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH.'core/APP_Core.php';
class APP_Webtools extends APP_Core {

	private $_template_folder = 'webtools';

	private $_logthis = true;

    private $_admin_url = 'webtools';

    function __construct()
    {
        parent::__construct(array(
        	'folder' => $this->_template_folder,
        	'log' => $this->_logthis
        ));

        define('ADMIN_URL', $this->_admin_url);

        //HTTP CACHING
        $this->output->set_header("Cache-Control: no-cache, must-revalidate, no-store");
        $this->output->set_header("Cache-Control: post-check=0, pre-check=0, public, max-age=0");

        $this->_check_session();

        if(!$this->_check_access()){
            admin_redirect('','refresh');
        }

        $this->_template_master_data['user'] = $this->_user;
    }

    /*
     *	OVERRIDE BEBERAPA METHOD KHUSUS UNTUK ADMIN
     */
    protected function _log()
    {
        $raw_data = array(
            'url'       => current_url(),
            'request'   => $_REQUEST,
            'server'    => $_SERVER
        );

        $user = $this->session->userdata($this->_session_name.md5('4dm1nw3bt00ls'));
        if(isset($user->id)){
            $uid = $user->id;
        }else{
            $uid = 0;
        }

        $this->load->library('user_agent');
        
        /*
            Dapatkan referrer url
         */
        $referrer_url = '';
        if($this->agent->is_referral())
        {
            $referrer_url = $this->agent->referrer();
        }

        /*
            Dapatkan REFID (BANNER ADS ID)
         */
        $refid = '';
        if($this->input->get('ref'))
        {
            $refid = $this->input->get('ref');
        }

        $raw_data_hash = json_encode($raw_data);

        $data = array(
            'user_id'   =>  $uid,
            'ip_address'=>  $this->input->ip_address(),
            'controller'=>  $this->router->class,
            'function'  =>  $this->router->method,
            'referrer'  =>  $referrer_url,
            'browser'   =>  $this->agent->browser(),
            'version'   =>  $this->agent->version(),
            'mobile'    =>  $this->agent->mobile(),
            'refid'     => $refid,
            'raw_data'  =>  $raw_data_hash,
            'created_date' => date('Y-m-d H:i:s')
        );

        /* 
         * KALO MO SAVE KE DATABASE PAKE INI
         */
        $this->db->insert('admin_logs',$data);
        
       
        /* 
         * KALO MO SAVE KE FILE PAKE INI
         */
        /*
        $csv = '';
        $first = true;
        foreach ($data as $k => $v) {
            if(!$first){
                $csv .= "\t";
            }
            $csv .= $v;
            if($first){
                $first = false;
            }
        }
        $csv .= "\n";
        $csv_handler = fopen('./assets/lox/'.date('dmY').'.csv','a+');
        fwrite($csv_handler,$csv);
        fclose($csv_handler);
        */
    }

    protected function _check_session()
    {
        $return = false;
        $this->_user = $this->session->userdata($this->_session_name.md5('4dm1nw3bt00ls'));
        if(isset($this->_user->id)){
            $this->db->where('id',intval($this->_user->id));
            $this->db->where('username',$this->_user->username);
            $this->db->where('password',$this->_user->password);
            $u = $this->db->get('admin')->row();
            if(isset($u->id) && intval($u->id)>0){
                $return = intval($u->id);
            }
        }

        if(!$return){
            $this->_unset_session();
            redirect($this->_admin_url.'/auth/logout');
        }

        return $return;
    }

    /*
     * Mehtod untuk webtools
     */
    protected function _check_access()
    {
        //jika superadmin atau admin dilewati, karena bebas akses semua
        if($this->_user->group==1 || $this->_user->group==2 ){ return true; }

        $controller = $this->router->class;
        $method = $this->router->method;

        $qry = "
            SELECT 
                *
            FROM 
                {$this->db->dbprefix('admin_access')}
            WHERE 
                `controller`='{$controller}'
                AND `groups` LIKE '%{$this->_user->group}%'
                AND (
                    `method`='{$method}' OR `method`='*'
                )
            LIMIT 
                1
        ";

        $ac = $this->db->query($qry)->row();

        //jika tidak ditemukan akses, maka jangan dikasih
        if( empty($ac->id) ){ return false; }

        return true;
    }

    public function add_tinymce()
    {
        $this->_addScript('assets/js/tinymce/tinymce.min.js');
        
        $jsr = "
            $(document).ready(function() {
            
                tinymce.init({
                    selector: '.textmce',
                    height: 700,
                    menubar: false,
                    plugins: [
                        'advlist lists wordcount code link autolink responsivefilemanager image media filemanager'
                    ],
                    image_advtab: true,
                    relative_urls: false,
                    toolbar: 'undo redo | formatselect fontselect fontsizeselect | alignleft aligncenter alignright alignjustify | bold italic underline | bullist numlist outdent indent blockquote link unlink image | removeformat code',

                    external_filemanager_path: '".site_url('filemanager')."/',
                    filemanager_title: 'Image Manager',
                    external_plugins: { 
                        'responsivefilemanager' : 'plugins/responsivefilemanager/plugin.min.js',
                        'filemanager': '../../../filemanager/plugin.min.js'
                    },
                    filemanager_access_key: '1HoQkNWgG393m8GPNBSeaRvFWbzmYjJjmFku0X0jAaFOlXWnXcKCqtp8KoeOcuQ5',
                });

            });
        ";
        
        $this->_addScript($jsr, 'embed');
    }
}