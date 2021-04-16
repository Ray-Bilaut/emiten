<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH.'core/APP_Frontend.php';
class Profile extends APP_Frontend
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if(!isset($this->_user->id) ){
            redirect('/404');
        }

        $js = "
        var attr = {};
        $(document).ready(function() {
            analyticLog('profile_open', attr);
        });
        ";
        $this->_addScript($js,'embed');
        $this->_addContent($this->_data);
        $this->_render();
    }
}
