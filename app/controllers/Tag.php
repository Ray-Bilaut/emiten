<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH.'core/APP_Frontend.php';
class Tag extends APP_Frontend
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library("pagination");
        $this->load->model("tag_model");
    }

    public function index($slug = '')
    {
        $tag = $this->tag_model->getTagBySlug($slug);
        
        if($tag == FALSE) {
			redirect('/404');
    		exit;
        }

        $config = array();
        $config["base_url"] = base_url() . "tag/" . $slug;
        $config["total_rows"] = $this->news->getTagNewsCount($slug)->total;
        $config["per_page"] = 9;
        $config["uri_segment"] = 3;

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $this->_data["links"] = $this->pagination->create_links();
        $this->_data['news'] = $this->news->getTagNewsWithLimit($slug, $config["per_page"], $page);
        $this->_data['title'] = $tag->title;
        $this->_data['relatedPodcasts'] = $this->podcast->getRelatedPodcastByTag($slug);
        $this->_data['topAds'] = $this->ads->getNewsListTopAds();
        $this->_data['bottomAds'] = $this->ads->getNewsListBottomAds();
        $this->_data['latestPodcast'] = $this->podcast->getLatestPodcast();
        $this->_data['latestPodcastTags'] = $this->podcast->getLatestPodcastTag();

        $data['recommendations'] = $this->news->getRecommendation();
        $this->_data['list_recommendation'] = $this->_addTemplate($data, 'list_recommendation_detail');
        $this->_data['mobile_list_recommendation'] = $this->_addTemplate($data, 'mobile_list_recommendation');

        $js = "
        var attr = {};
        attr.tag_title = '".$tag->title."';
        $(document).ready(function() {
            analyticLog('tag_open', attr);
        });
        ";
        $this->_addScript($js,'embed');
        $this->_addContent($this->_data);
        $this->_render();
    }
}
