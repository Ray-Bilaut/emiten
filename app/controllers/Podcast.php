<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH.'core/APP_Frontend.php';
class Podcast extends APP_Frontend
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library("pagination");
    }

    public function index()
    {
        $config = array();
        $config["base_url"] = base_url() . "podcast";
        $config["total_rows"] = $this->podcast->getPodcastCount()->total;
        $config["per_page"] = 9;
        $config["uri_segment"] = 2;

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;

        $this->_data["links"] = $this->pagination->create_links();
        $this->_data['podcastList'] = $this->podcast->getPodcastWithLimit($config["per_page"], $page);
        $this->_data['podcastTagList'] = $this->podcast->getAllPodcastTag();
        $this->_data['topAds'] = $this->ads->getExpertListTopAds();
        $this->_data['bottomAds'] = $this->ads->getExpertListBottomAds();

        $data['recommendations'] = $this->news->getRecommendation();
        $this->_data['list_recommendation'] = $this->_addTemplate($data, 'list_recommendation_detail');
        $this->_data['mobile_list_recommendation'] = $this->_addTemplate($data, 'mobile_list_recommendation');

        $js = "
        var attr = {};
        $(document).ready(function() {
            analyticLog('stolk_podcast_open', attr);
        });
        ";
        $this->_addScript($js,'embed');
        $this->_addContent($this->_data);
        $this->_render();
    }

    public function detail($slug = '') {

        $podcast = $this->podcast->getDetailBySlug($slug);

		if($podcast == FALSE) {
			redirect('/404');
    		exit;
        }
        
        $this->_data['news'] = $podcast;
        $this->_data['tags'] = $this->podcast->getTagBySlug($slug);
        $this->_data['relatedNews'] = $this->news->getRelatedNews($slug, 'podcast');
        $this->_data['topAds'] = $this->ads->getNewsDetailTopAds();
        $this->_data['bottomAds'] = $this->ads->getNewsDetailBottomAds();
        $this->_data['likes'] = $this->news->getLikesCount($slug, 'podcast_id', 'podcast');
        $this->_data['comments'] = $this->news->getCommentBySlug($slug, 'podcast_id', 'podcast');
        $tagsString = $this->podcast->getTagsString($slug);
        $this->metatag_detail_page($podcast->title, $podcast->description, $tagsString, $podcast->thumb_url);

        $data['recommendations'] = $this->news->getRecommendation();
        $this->_data['list_recommendation'] = $this->_addTemplate($data, 'list_recommendation_detail');
        $this->_data['mobile_list_recommendation'] = $this->_addTemplate($data, 'mobile_list_recommendation');

        $js = "
        var attr = {};
        attr.podcast_title = '".$podcast->title."';
        $(document).ready(function() {
            analyticLog('podcast_detail_open', attr);
        });
        ";
        $this->_addScript($js,'embed');
		$this->_addContent($this->_data);
        $this->_render();
	}
}
