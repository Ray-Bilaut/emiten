<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH.'core/APP_Frontend.php';
class Errors extends APP_Frontend
{

    public function __construct()
    {
        parent::__construct();
    }

    // public function index()
    // {

    //     $this->_addContent($this->_data);
    //     $this->_render();
    // }

    public function notfound()
    {
        $js = "
        $(document).ready(function() {
            analyticLog('error_not_found_open');
        });
        ";
        $this->_addScript($js,'embed');
        $this->_addContent($this->_data);
        $this->_render();
    }
}