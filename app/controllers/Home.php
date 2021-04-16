<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH.'core/APP_Frontend.php';
class Home extends APP_Frontend
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        
        $this->_data['highlights'] = $this->news->getHighlight();
        $this->_data['updates'] = $this->news->getAllNews();
        $this->_data['emitenNews'] = $this->news->getEmitenNews();
        $this->_data['trends'] = $this->news->getTrendingNews();
        $this->_data['podcastHome'] = $this->podcast->getAllPodcast();
        $this->_data['podcastTagHome'] = $this->podcast->getAllPodcastTag();
        $this->_data['homeAds'] = $this->ads->getHomeAds();
        $this->_data['infographics'] = $this->infographic->getHomeInfographics();
        $this->_data['topValue'] = $this->stock->getSharesByTotalValue();
        $this->_data['topVolume'] = $this->stock->getSharesByTotalVolume();
        $this->_data['topFrequency'] = $this->stock->getSharesByTotalFrequency();
        $this->_data['topChange'] = $this->stock->getSharesByChange();
        $this->_data['subscribe_bottom'] = $this->_addTemplate(null, 'subscribe_bottom');

        $data['recommendations'] = $this->news->getRecommendation();
        $this->_data['list_recommendation'] = $this->_addTemplate($data, 'list_recommendation');
        $this->_data['mobile_list_recommendation'] = $this->_addTemplate($data, 'mobile_list_recommendation');

        // $total_infographic = count( $this->_data['infographics']);
        // $count_infographic = $total_infographic > 4 ? 4 : $total_infographic;

        $total_podcast = count( $this->_data['podcastHome']);
        $count_podcast = $total_podcast > 3 ? 3 : $total_podcast;

        $js = "
        $(document).ready(function() {
            $('.slide-highlight').slick({
                infinite: true,
                arrows: false,
                slidesToShow: 1,
                dots: true,  
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 3000
            });

            $('.podcast-home').slick({
                infinite: true,
                arrows: false,
                slidesToShow: 3,
                dots: true,  
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 3000,
                responsive: [
                    {
                        breakpoint: 768,
                        settings: {
                          slidesToShow: 2
                        }
                    }
                ]
            });

            $('.list-infografis-home').slick({
                infinite: true,
                arrows: false,
                slidesToShow: 4,
                dots: true,  
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 3000,
                responsive: [
                    {
                        breakpoint: 768,
                        settings: {
                          slidesToShow: 2
                        }
                    }
                ]
            });

            analyticLog('home_open');
        });
        ";
        $this->_addScript($js,'embed');
        // $this->_addScript("assets/js/analytic-home.js");

        $this->_addContent($this->_data);
        $this->_render();
    }

    public function updates()
    {
        $this->load->library("pagination");

        $config = array();
        $config["base_url"] = base_url() . "home/updates/";
        $config["total_rows"] = $this->news->getAllNewsCount()->total;
        $config["per_page"] = 9;
        $config["uri_segment"] = 3;

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $this->_data["links"] = $this->pagination->create_links();
        $this->_data['news'] = $this->news->getAllNewsWithLimit($config["per_page"], $page);
        $this->_data['title'] = "Updates";
        $this->_data['relatedPodcasts'] = array();
        $this->_data['topAds'] = $this->ads->getNewsListTopAds();
        $this->_data['bottomAds'] = $this->ads->getNewsListBottomAds();
        $this->_data['latestPodcast'] = $this->podcast->getLatestPodcast();
        $this->_data['latestPodcastTags'] = $this->podcast->getLatestPodcastTag();

        $data['recommendations'] = $this->news->getRecommendation();
        $this->_data['list_recommendation'] = $this->_addTemplate($data, 'list_recommendation_detail');
        $this->_data['mobile_list_recommendation'] = $this->_addTemplate($data, 'mobile_list_recommendation');

        $js = "
        $(document).ready(function() {
            analyticLog('see_all_updates_open');
        });
        ";
        $this->_addScript($js,'embed');
        $this->_addContent($this->_data);
        $this->_render();
    }

    public function trending()
    {
        $this->load->library("pagination");

        $config = array();
        $config["base_url"] = base_url() . "home/trending/";
        $config["total_rows"] = $this->news->getAllTrendingCount()->total;
        $config["per_page"] = 9;
        $config["uri_segment"] = 3;

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $this->_data["links"] = $this->pagination->create_links();
        $this->_data['news'] = $this->news->getAllTrendingWithLimit($config["per_page"], $page);
        $this->_data['title'] = "Updates";
        $this->_data['relatedPodcasts'] = array();
        $this->_data['topAds'] = $this->ads->getNewsListTopAds();
        $this->_data['bottomAds'] = $this->ads->getNewsListBottomAds();
        $this->_data['latestPodcast'] = $this->podcast->getLatestPodcast();
        $this->_data['latestPodcastTags'] = $this->podcast->getLatestPodcastTag();

        $data['recommendations'] = $this->news->getRecommendation();
        $this->_data['list_recommendation'] = $this->_addTemplate($data, 'list_recommendation_detail');
        $this->_data['mobile_list_recommendation'] = $this->_addTemplate($data, 'mobile_list_recommendation');

        $js = "
        $(document).ready(function() {
            analyticLog('see_all_trending_open');
        });
        ";
        $this->_addScript($js,'embed');
        $this->_addContent($this->_data);
        $this->_render();
    }
}
