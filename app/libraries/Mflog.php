<?php
class Mflog
{

    protected $CI = null;

    protected $session_name = "";

    private $data_separator = "[===%MFSEP&&MFSEP%===]";

    protected $log_path = "mflog/";

    public function __construct($param = ['session_name' => '', 'path' => ''])
    {
        $this->CI =& get_instance();
    
        $this->session_name = $param['session_name'];

        $this->log_path = empty($param['path']) ? $this->log_path : $param['path'];
    }

    public function log()
    {
        $raw_data = array(
            'url'       => current_url(),
            'request'   => $_REQUEST,
            'server'    => $_SERVER
        );

        $user = $this->CI->session->userdata($this->session_name);

        $this->CI->load->library('user_agent');
        
        $data = array(
            'uid'   =>  ( isset($user->uid) ? $user->uid : 0 ),
            'ip_address'=>  $this->CI->input->ip_address(),
            'controller'=>  $this->CI->router->class,
            'function'  =>  $this->CI->router->method,
            'referrer'  =>  ( $this->CI->agent->is_referral() ? $this->CI->agent->referrer() : '' ),
            'browser'   =>  $this->CI->agent->browser(),
            'version'   =>  $this->CI->agent->version(),
            'mobile'    =>  $this->CI->agent->mobile(),
            'raw_data'  =>  json_encode($raw_data),
            'created_date' => date('Y-m-d H:i:s'),
            'timestamp' => microtime(true)
        );

        // Cek session visitor (seperti GA)
        $session = $this->CI->session->userdata('visitorsession');
        if (empty($session)) {
            $session = md5($data['ip_address'].date('U').$data['browser'].$data['version']);
            $this->CI->session->set_userdata('visitorsession', $session);
            $this->CI->session->mark_as_temp('visitorsession', (60*30)); //30 menit
        } else {
            $this->CI->session->set_userdata('visitorsession', $session);
            $this->CI->session->mark_as_temp('visitorsession', (60*30)); //30 menit
        }
        $data['session'] = $session;

        $this->record($data);

        // $this->simple_log($data);
    }

    public function record($data)
    {
        $data = serialize($data) . $this->data_separator;

        if (!is_dir($this->log_path)) {
            $oldmask = umask(0);
            mkdir($this->log_path, 0775);
            umask($oldmask);
        }

        $filename = $this->filename();

        $myfile = fopen($this->log_path.$filename, "a+");
        fwrite($myfile, $data);
        fclose($myfile);

        //$this->compress_file( "../mflog/".$filename );
    }

    public function filename()
    {
        $filename = str_replace(["http://","https://","/"], ["","","_"], base_url());
        $filename .= date("dmY");
        return $filename;
    }

    public function compress_file($file)
    {
        $data = implode("", file($file));
        $gzdata = gzencode($data, 9);
        $fp = fopen($file.".gz", "w");
        fwrite($fp, $gzdata);
        fclose($fp);
    }

    /*public function compress_folder($foldername)
    {
    }*/

    public function import_to_db($filename)
    {
        if (empty($filename)) {
            return false;
        }

        $fh = fopen("logs/".$filename, 'r');
        while ($line = fgets($fh)) {
            $data = $line;
        }
        fclose($fh);

        if (empty($data)) {
            return false;
        }

        $config['hostname'] = '127.0.0.1';
        $config['username'] = 'root';
        $config['password'] = '';
        $config['database'] = 'muniyo';
        $config['dbdriver'] = 'mysqli';
        $config['dbprefix'] = 'yo_';
        $config['pconnect'] = false;
        $config['db_debug'] = true;
        $config['cache_on'] = false;
        $config['cachedir'] = '';
        $config['char_set'] = 'utf8';
        $config['dbcollat'] = 'utf8_general_ci';
        $DB = $this->CI->load->database($config, true);

        $data = explode($this->data_separator, $data);

        foreach ($data as $v) {
            $v = unserialize($v);
            $DB->insert("logs", $v);
        }
        
        return true;
    }

    public function simple_log($data)
    {
        $new_data = [
            'session'   =>  $data['session'],
            'uid'   =>  $data['uid'],
            'ip_address'=>  $data['ip_address'],
            'controller'=>  $data['controller'],
            'function'  =>  $data['function'],
            'created_date' => $data['created_date']
        ];

        $this->CI->db->insert('simple_log',$new_data);
    }
}
