<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH.'core/APP_Frontend.php';
class Search extends APP_Frontend
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library("pagination");
    }

    public function index($kword='') {
        $keyword = rawurldecode($kword);
       
        $config = array();
        $config["base_url"] = base_url() . "search/" . $kword;
        $config["total_rows"] = $this->search->getCountNewsByKeyword($keyword);
        $config["per_page"] = 9;
        $config["uri_segment"] = 3;

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $this->_data["links"] = $this->pagination->create_links();
        $this->_data['news'] = $this->search->getNewsByKeyword($keyword, $config["per_page"], $page);
        $this->_data['topAds'] = $this->ads->getNewsListTopAds();
        $this->_data['bottomAds'] = $this->ads->getNewsListBottomAds();
        $this->_data['latestPodcast'] = $this->podcast->getLatestPodcast();
        $this->_data['latestPodcastTags'] = $this->podcast->getLatestPodcastTag();

        $data['recommendations'] = $this->news->getRecommendation();
        $this->_data['list_recommendation'] = $this->_addTemplate($data, 'list_recommendation_detail');
        $this->_data['mobile_list_recommendation'] = $this->_addTemplate($data, 'mobile_list_recommendation');

        $js = "
        var attr = {};
        attr.keyword = '".$kword."';
        $(document).ready(function() {
            analyticLog('search_open', attr);
        });
        ";
        $this->_addScript($js,'embed');
        $this->_data['keyword'] = $keyword;
        $this->_addContent($this->_data);
        $this->_render();
    }
}