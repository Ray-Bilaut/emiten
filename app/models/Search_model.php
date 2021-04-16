<?php

class Search_model extends CI_Model {

	function __construct() {
		parent::__construct();
    }

    public function getNewsByKeyword($keyword, $limit, $start){

        $now = date('Y-m-d H:i:s');
        $rows = $this->db->query('
        (SELECT "'.$this->db->dbprefix('news').'" as table_name, id as item_id, slug_url as item_slug_url, title as item_title, 
            description as item_description, thumb as item_thumb, image as item_image, image_mobile as item_image_mobile, publish_date as item_publish_date 
        FROM '.$this->db->dbprefix('news').'
        WHERE (is_active = 1 AND is_delete = 0 AND publish_date <= "'.$now.'" AND (title LIKE "%'.$keyword.'%" OR description LIKE "%'.$keyword.'%"))
        union
        SELECT "'.$this->db->dbprefix('podcast').'" as table_name, id as item_id, slug_url as item_slug_url, title as item_title, 
            description as item_description, thumb as item_thumb, image as item_image, image_mobile as item_image_mobile, publish_date as item_publish_date 
        FROM '.$this->db->dbprefix('podcast').'
        WHERE (is_active = 1 AND is_delete = 0 AND publish_date <= "'.$now.'" AND (title LIKE "%'.$keyword.'%" OR description LIKE "%'.$keyword.'%"))
        union
        SELECT "'.$this->db->dbprefix('infographic').'" as table_name, id as item_id, slug_url as item_slug_url, title as item_title, 
            description as item_description, thumb as item_thumb, image as item_image, image_mobile as item_image_mobile, publish_date as item_publish_date 
        FROM '.$this->db->dbprefix('infographic').'
        WHERE (is_active = 1 AND is_delete = 0 AND publish_date <= "'.$now.'" AND (title LIKE "%'.$keyword.'%" OR description LIKE "%'.$keyword.'%")) )
        ORDER BY item_publish_date DESC LIMIT '.$start.','.$limit)->result();
        
        $rows = $this->prepare($rows,[]);
        return $rows;
    }

    public function getCountNewsByKeyword($keyword){
        $now = date('Y-m-d H:i:s');
        
        $rows = $this->db->query('
            (SELECT "'.$this->db->dbprefix('news').'" as table_name, id as item_id, slug_url as item_slug_url, title as item_title, 
                description as item_description, thumb as item_thumb, image as item_image, image_mobile as item_image_mobile, publish_date as item_publish_date 
            FROM '.$this->db->dbprefix('news').'
            WHERE (is_active = 1 AND is_delete = 0 AND publish_date <= "'.$now.'" AND (title LIKE "%'.$keyword.'%" OR description LIKE "%'.$keyword.'%"))
            union
            SELECT "'.$this->db->dbprefix('podcast').'" as table_name, id as item_id, slug_url as item_slug_url, title as item_title, 
                description as item_description, thumb as item_thumb, image as item_image, image_mobile as item_image_mobile, publish_date as item_publish_date 
            FROM '.$this->db->dbprefix('podcast').'
            WHERE (is_active = 1 AND is_delete = 0 AND publish_date <= "'.$now.'" AND (title LIKE "%'.$keyword.'%" OR description LIKE "%'.$keyword.'%"))
            union
            SELECT "'.$this->db->dbprefix('infographic').'" as table_name, id as item_id, slug_url as item_slug_url, title as item_title, 
                description as item_description, thumb as item_thumb, image as item_image, image_mobile as item_image_mobile, publish_date as item_publish_date 
            FROM '.$this->db->dbprefix('infographic').'
            WHERE (is_active = 1 AND is_delete = 0 AND publish_date <= "'.$now.'" AND (title LIKE "%'.$keyword.'%" OR description LIKE "%'.$keyword.'%")) )
            ')->result();
        
        
        return count($rows);
    }

    private function prepare($rows = [], $options = []) {
        foreach ($rows as $news) {
            $type = '';
            $imageDirectory = '';
            switch ($news->table_name) {
                case $this->db->dbprefix('podcast'):
                    $type = 'podcast';
                    $imageDirectory = 'podcast_image';
                    break;
                case $this->db->dbprefix('infographic'):
                    $type = 'infographic';
                    $imageDirectory = 'infographic';
                    break;
                default:
                    $type = 'news';
                    $imageDirectory = 'news';
                    break;
            }
            $news->pretty_time = $this->getDateTime($news->item_publish_date);
            $dir = $imageDirectory."/";
            $strDir = explode("/", $news->item_image);
            if (count($strDir) > 2) {
                $dir = "";
            }
            $news->image_url = empty($news->item_image) ? base_url('assets/images/logo.png') : base_url('uploads/'.$dir.$news->item_image);
            $news->image_mobile_url = empty($news->item_image_mobile) ? base_url('assets/images/logo.png') : base_url('uploads/'.$dir.$news->item_image_mobile);
            $news->thumb_url = empty($news->item_thumb) ? base_url('assets/images/logo.png') : base_url('uploads/'.$dir.$news->item_thumb);
            $news->detail_url = base_url(''.$type.'/'.$news->item_slug_url);
            $news->datetime = (new DateTime($news->item_publish_date))->format('d/m/Y, H:i').' WIB';

            //get total paragraph
            $pattern = "/<p.*<\/p>/m";
            $news->paragraph_count = preg_match_all($pattern,$news->item_description);
        }

        return $rows;
    }

    function getDateTime($datetime) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        if ($diff->d < 2 && $diff->w < 1 && $diff->y < 1 && $diff->m < 1) {
            return $this->timeElapsedString($datetime);
        }
        return (new DateTime($datetime))->format('d/m/Y, H:i').' WIB';
    }

    function timeElapsedString($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);
    
        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;
    
        $string = array(
            'y' => 'tahun',
            'm' => 'bulan',
            'w' => 'minggu',
            'd' => 'hari',
            'h' => 'jam',
            'i' => 'menit',
            's' => 'detik',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? '' : '');
            } else {
                unset($string[$k]);
            }
        }
    
        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' yang lalu' : 'baru saja';
      }
}