<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH.'core/APP_Frontend.php';
class News extends APP_Frontend
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library("pagination");
    }

    public function index($slug = '') {

        $news = $this->news->getDetailBySlug($slug);

		if($news == FALSE) {
			redirect('/404');
    		exit;
        }
        
        $config = array();
        $config["base_url"] = base_url() . "news/" . $slug;
        $config["total_rows"] = $news->paragraph_count;
        $config["per_page"] = $news->paragraph_per_page;
        $config["uri_segment"] = 3;
        
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $this->_data["links"] = $this->pagination->create_links();

        $news->sliced_desc = $this->news->getDescriptionBySlugWithLimit($slug, $config["per_page"], $page, $config["total_rows"]);
        $this->_data['news'] = $news;
        $this->_data['tags'] = $this->news->getTagBySlug($slug);
        $this->_data['relatedNews'] = $this->news->getRelatedNews($slug);
        $this->_data['topAds'] = $this->ads->getNewsDetailTopAds();
        $this->_data['bottomAds'] = $this->ads->getNewsDetailBottomAds();
        $this->_data['likes'] = $this->news->getLikesCount($slug);
        $this->_data['comments'] = $this->news->getCommentBySlug($slug);
        $tagsString = $this->news->getTagsString($slug);
        $this->metatag_detail_page($news->title, $news->description, $tagsString, $news->thumb_url);

        $data['recommendations'] = $this->news->getRecommendation();
        $this->_data['list_recommendation'] = $this->_addTemplate($data, 'list_recommendation_detail');
        $this->_data['mobile_list_recommendation'] = $this->_addTemplate($data, 'mobile_list_recommendation');

        $js = "
        var attr = {};
        attr.news_title = '".$news->title."';
        $(document).ready(function() {
            analyticLog('news_detail_open', attr);
        });
        ";
        $this->_addScript($js,'embed');
		$this->_addContent($this->_data);
        $this->_render();
	}

}
