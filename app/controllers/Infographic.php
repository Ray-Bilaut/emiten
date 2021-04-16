<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH.'core/APP_Frontend.php';
class Infographic extends APP_Frontend
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library("pagination");
    }

    public function index()
    {
        $config = array();
        $config["base_url"] = base_url() . "infographic";
        $config["total_rows"] = $this->expert->getExpertCount()->total;
        $config["per_page"] = 12;
        $config["uri_segment"] = 2;

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;

        $this->_data["links"] = $this->pagination->create_links();
        $this->_data['infographics'] = $this->infographic->getInfographicWithLimit($config["per_page"], $page);
        $this->_data['topAds'] = $this->ads->getInfographicListTopAds();
        $this->_data['bottomAds'] = $this->ads->getInfographicListBottomAds();
        $this->_data['latestPodcast'] = $this->podcast->getLatestPodcast();
        $this->_data['latestPodcastTags'] = $this->podcast->getLatestPodcastTag();

        $data['recommendations'] = $this->news->getRecommendation();
        $this->_data['list_recommendation'] = $this->_addTemplate($data, 'list_recommendation_detail');
        $this->_data['mobile_list_recommendation'] = $this->_addTemplate($data, 'mobile_list_recommendation');

        $js = "
        var attr = {};
        $(document).ready(function() {
            analyticLog('see_all_infographic_open', attr);
        });
        ";
        $this->_addScript($js,'embed');
        $this->_addContent($this->_data);
        $this->_render();
    }

    public function detail($slug = '')
    {
        $infographic = $this->infographic->getDetailBySlug($slug);

        if($infographic == FALSE){
            redirect('/404');
            exit;
        }

        $this->_data['news'] = $infographic;
        $this->_data['tags'] = $this->infographic->getTagBySlug($slug);
        $this->_data['relatedNews'] = $this->news->getRelatedNews($slug, 'infographic');
        $this->_data['topAds'] = $this->ads->getNewsDetailTopAds();
        $this->_data['bottomAds'] = $this->ads->getNewsDetailBottomAds();
        $this->_data['likes'] = $this->news->getLikesCount($slug, 'infographic_id', 'infographic');
        $this->_data['comments'] = $this->news->getCommentBySlug($slug, 'infographic_id', 'infographic');
        $tagsString = $this->infographic->getTagsString($slug);
        $this->metatag_detail_page($infographic->title, $infographic->description, $tagsString, $infographic->thumb_url);

        $data['recommendations'] = $this->news->getRecommendation();
        $this->_data['list_recommendation'] = $this->_addTemplate($data, 'list_recommendation_detail');
        $this->_data['mobile_list_recommendation'] = $this->_addTemplate($data, 'mobile_list_recommendation');

        $js = "
        var attr = {};
        attr.infographic_title = '".$infographic->title."';
        $(document).ready(function() {
            analyticLog('infographic_detail_open', attr);
        });
        ";
        $this->_addScript($js,'embed');
        $this->_addContent($this->_data);
        $this->_render();
    }
}
