<?php
class Migrate extends CI_Controller
{
    public function index($token = "", $version = "")
    {
        $this->load->helper("url");
        $this->load->config("web");
        $migrate_token = $this->config->item("app_migrate_token");

        if ($token!==$migrate_token) {
            redirect("");
            exit;
        }

        $this->load->library('migration');

        if (empty($version)) {
            if ($this->migration->current() === false) {
                    show_error($this->migration->error_string());
            } else {
                echo "Migrate success";
            }
        } else {
            if ($this->migration->version($version) === false) {
                    show_error($this->migration->error_string());
            } else {
                    echo "Migrate success";
            }
        }
    }
}
