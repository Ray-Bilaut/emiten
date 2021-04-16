<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH.'core/APP_Core.php';
class APP_Frontend extends APP_Core {

	protected $_template_folder = 'frontend';

	private $_logthis = true;

    private $bilingual = false;

    protected $language = 'en';

    function __construct()
    {
        parent::__construct(array(
        	'folder' => $this->_template_folder,
        	'log' => $this->_logthis
        ));

        if($this->bilingual){
            
            $this->language = $this->uri->segment(1)=='id' ? 'id' : 'en';
            $this->_template_master_data['lang'] = $this->language;
            $this->_data['lang'] = $this->language;
            $this->lang->load('app', $this->language );
            define('APP_LANG', $this->language);

        }

        //meta
        $this->_template_master_data['meta_title'] = $this->config->item('app_meta_title');
        $this->_template_master_data['meta_desc'] = $this->config->item('app_meta_description');
        $this->_template_master_data['meta_keyword'] = $this->config->item('app_meta_keywords');
        $this->_template_master_data['meta_image'] = base_url('assets/images/logo.png');

        //navigation menu
        $this->_template_master_data['menus'] = $this->db->get_where('category', ['is_pinned' => 1])->result();

        if(ENVIRONMENT!='development'){
            $this->_FOLDER .= '-min';
        }

        $this->_data['stocks'] = $this->stock->getIndices();
    }

    protected function _set_og($url,$data)
    {
            $this->_template_master_data['meta_og'] = "
                <meta property='og:url' content='".$url."' />
                <meta property='og:type' content='website' />
                <meta property='fb:app_id' content='".$data['facebook']['app_id']."' /> 
                <meta property='og:title' content='".$data['facebook']['title']."' />
                <meta property='og:description' content='".$data['facebook']['description']."' />
                <meta property='og:image' content='".$data['facebook']['image']."' />
                <meta property='og:image:width' content='1200'/>
                <meta property='og:image:height' content='630'/>
            ";
            $this->_template_master_data['meta_og'] .= "
                <meta name='twitter:card' content='summary_large_image'>
                <meta name='twitter:site' content='". $data['twitter']['account'] ."'>
                <meta name='twitter:creator' content='".$data['twitter']['account']."'>
                <meta name='twitter:title' content='".$data['twitter']['title']."'>
                <meta name='twitter:description' content='".$data['twitter']['description']."'>
                <meta name='twitter:image' content='".$data['twitter']['image']."'>
            ";
    }

    protected function metatag_page($page)
    {
        $res = $this->db->get_where('metatag',['page' => $page])->row();
        $title = empty($res->title) ? '' : $res->title;
        $desc = empty($res->desc) ? '' : $res->desc;
        $this->metatag($title,$desc);
    }

    protected function metatag_detail_page($title='',$description='',$keyword='',$image='')
    {
        $desc = empty($description) ? '' : (strlen(strip_tags($description)) > 148 ? (substr(strip_tags($description), 0, 147).'...') : strip_tags($description));
        $this->metatag($title,$desc,$keyword,$image);
    }

    protected function metatag($title='',$desc='',$keyword='',$image='')
    {
        $title = empty($title) ? $this->config->item('app_meta_title') : $title;
        $desc = empty($desc) ? $this->config->item('app_meta_desc') : $desc;
        $keyword = empty($keyword) ? $this->config->item('app_meta_keyword') : $keyword;
        $image = empty($image) ? base_url('assets/images/logo.png') : $image;

        $metatag = "<title>{$title}</title>";
        $metatag .= "<meta name='description' content='{$desc}'>";
        $metatag .= "<meta name='keyword' content='{$keyword}'>";
        $metatag .= "<meta name='image' content='{$image}'>";
        $this->_template_master_data['metatag'] = $metatag;
    }
}