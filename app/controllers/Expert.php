<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH.'core/APP_Frontend.php';
class Expert extends APP_Frontend
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library("pagination");
    }

    public function index()
    {
        $config = array();
        $config["base_url"] = base_url() . "expert";
        $config["total_rows"] = $this->expert->getExpertCount()->total;
        $config["per_page"] = 12;
        $config["uri_segment"] = 2;

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;

        $this->_data["links"] = $this->pagination->create_links();
        $this->_data['experts'] = $this->expert->getExpertWithLimit($config["per_page"], $page);
        $this->_data['topExperts'] = $page == 0 ? $this->expert->getTopExpert() : array();
        $this->_data['topAds'] = $this->ads->getExpertListTopAds();
        $this->_data['bottomAds'] = $this->ads->getExpertListBottomAds();
        $this->_data['latestPodcast'] = $this->podcast->getLatestPodcast();
        $this->_data['latestPodcastTags'] = $this->podcast->getLatestPodcastTag();

        $data['recommendations'] = $this->news->getRecommendation();
        $this->_data['list_recommendation'] = $this->_addTemplate($data, 'list_recommendation_detail');
        $this->_data['mobile_list_recommendation'] = $this->_addTemplate($data, 'mobile_list_recommendation');

        $js = "
        $(document).ready(function() {
            analyticLog('expert_views_open');
        });
        ";
        $this->_addScript($js,'embed');
        $this->_addContent($this->_data);
        $this->_render();
    }

    public function detail($slug = '')
    {
        $expert = $this->expert->getExpertBySlug($slug);

        if($expert == FALSE) {
			redirect('/404');
    		exit;
        }

        $config = array();
        $config["base_url"] = base_url() . "expert/" . $slug;
        $config["total_rows"] = $this->news->getExpertNewsCount($slug)->total;
        $config["per_page"] = 9;
        $config["uri_segment"] = 3;

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $this->_data["links"] = $this->pagination->create_links();
        $this->_data['news'] = $this->news->getExpertNewsWithLimit($slug, $config["per_page"], $page);
        $this->_data['expert'] = $expert;
        $this->_data['topAds'] = $this->ads->getExpertListTopAds();
        $this->_data['bottomAds'] = $this->ads->getExpertListBottomAds();
        $this->_data['latestPodcast'] = $this->podcast->getLatestPodcast();
        $this->_data['latestPodcastTags'] = $this->podcast->getLatestPodcastTag();

        $data['recommendations'] = $this->news->getRecommendation();
        $this->_data['list_recommendation'] = $this->_addTemplate($data, 'list_recommendation_detail');
        $this->_data['mobile_list_recommendation'] = $this->_addTemplate($data, 'mobile_list_recommendation');

        $js = "
        var attr = {};
        attr.expert_name = '".$expert->name."';
        $(document).ready(function() {
            analyticLog('expert_detail_open', attr);
        });
        ";
        $this->_addScript($js,'embed');
        $this->_addContent($this->_data);
        $this->_render();
    }
}
