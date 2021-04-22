<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'core/APP_Frontend.php';
class Category extends APP_Frontend
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library("pagination");
        $this->load->model("category_model");
    }

    public function index($slug = '')
    {
        $category = $this->category_model->getCategoryBySlug($slug);

        if ($category == FALSE) {
            redirect('/404');
            exit;
        }

        $config = array();
        $config["base_url"] = base_url() . "category/" . $slug;
        $config["total_rows"] = $this->news->getCategoryNewsCount($slug)->total;
        $config["per_page"] = 9;
        $config["uri_segment"] = 3;

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $this->_data["links"] = $this->pagination->create_links();
        $this->_data['news'] = $this->news->getCategoryNewsWithLimit($slug, $config["per_page"], $page);
        $this->_data['title'] = $category->title;
        $this->_data['relatedPodcasts'] = $this->podcast->getRelatedPodcastByCategory($slug);
        $this->_data['topAds'] = $this->ads->getNewsListTopAds();
        $this->_data['bottomAds'] = $this->ads->getNewsListBottomAds();
        $this->_data['latestPodcast'] = $this->podcast->getLatestPodcast();
        $this->_data['latestPodcastTags'] = $this->podcast->getLatestPodcastTag();
        $this->_data['subscribe_bottom'] = $this->_addTemplate(null, 'subscribe_bottom');
        $data['recommendations'] = $this->news->getRecommendation();
        $this->_data['list_recommendation'] = $this->_addTemplate($data, 'list_recommendation_detail');
        $this->_data['mobile_list_recommendation'] = $this->_addTemplate($data, 'mobile_list_recommendation');

        $js = "
        var attr = {};
        attr.category_title = '" . $category->title . "';
        $(document).ready(function() {
            analyticLog('category_open', attr);
        });
        ";
        $this->_addScript($js, 'embed');
        $this->_addContent($this->_data);
        $this->_render();
    }
}
