<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH.'core/APP_Frontend.php';
class Aboutus extends APP_Frontend
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {

        $js = "
        $(document).ready(function() {
            analyticLog('about_us_open');
        });
        ";
        $this->_addScript($js,'embed');
        $this->_addContent($this->_data);
        $this->_render();
    }
}
