<?php
class Infographic_model extends CI_Model {

	function __construct() {
		parent::__construct();
  }

  public function getInfographicById($idx) {
    $now = date('Y-m-d H:i:s');
    $rows = $this->db->query('
      SELECT n.*
      FROM '.$this->db->dbprefix('infographic').' n
      WHERE n.is_active = 1 AND n.is_delete = 0 AND n.id = "'.$idx.'" AND n.publish_date <= "'.$now.'"')->result();
    
    if(count($rows) == 0) {
      return FALSE;
    }

    $rows = $this->prepare($rows,[]);
    return end($rows);
  }

  public function getHomeInfographics() {
    $now = date('Y-m-d H:i:s');
    $rows = $this->db->query('SELECT p.*
      FROM '.$this->db->dbprefix('infographic').' p
      WHERE p.is_active = 1 AND p.is_delete = 0 AND p.publish_date <= "'.$now.'"
      ORDER BY p.publish_date DESC LIMIT 0,10')->result();

    $rows = $this->prepare($rows,[]);
    return $rows;
  }

  public function getInfographicWithLimit($limit, $start) {
    $now = date('Y-m-d H:i:s');
    $rows = $this->db->query('
      SELECT i.*
      FROM '.$this->db->dbprefix('infographic').' i
      WHERE i.is_active = 1 AND i.is_delete = 0 AND i.publish_date <= "'.$now.'"
      ORDER BY i.publish_date DESC LIMIT '.$start.','.$limit)->result();
      
    $rows = $this->prepare($rows,[]);
    return $rows;
  }

   public function getDetailBySlug($slug) {
    $now = date('Y-m-d H:i:s');
    $rows = $this->db->query('
      SELECT n.*, c.title AS category, a.name AS author
      FROM '.$this->db->dbprefix('infographic').' n 
      JOIN '.$this->db->dbprefix('category').' c 
      ON n.category_id=c.id 
      JOIN '.$this->db->dbprefix('admin').' a 
      ON n.author_id=a.id
      WHERE n.is_active = 1 AND n.is_delete = 0 AND n.slug_url = "'.$slug.'" AND publish_date <= "'.$now.'"')->result();
    
    if(count($rows) == 0) {
      return FALSE;
    }

    $rows = $this->prepare($rows,[]);
    return end($rows);
  }

  public function getTagBySlug($slug) {
    $rows = $this->db->query('
      SELECT t.*
      FROM '.$this->db->dbprefix('tag').' t
      JOIN '.$this->db->dbprefix('tag_relation').' tr
      ON t.id=tr.tag_id
      JOIN '.$this->db->dbprefix('infographic').' n
      ON tr.infographic_id=n.id
      WHERE n.slug_url = "'.$slug.'"')->result();

    return $rows;
  }

  function getTagsString($slug) {
    $slugs = $this->getTagBySlug($slug);
    
    $count = count($slugs) > 10 ? 10 : count($slugs);

    $theSlugs = array();
    for ($i=0; $i < $count; $i++) {
      array_push($theSlugs, $slugs[$i]->title);
    }

    return join(",", $theSlugs);
  }

  function getDateTime($datetime) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    if ($diff->d < 2 && $diff->w < 1 && $diff->y < 1 && $diff->m < 1) {
        // var_dump($diff);exit;
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

  private function prepare($rows = [], $options = []) {
    foreach ($rows as $infographic) {
      $infographic->pretty_time = $this->getDateTime($infographic->publish_date);
      $infographic->image_url = base_url('uploads/infographic/'.$infographic->image);
      $infographic->image_mobile_url = base_url('uploads/infographic/'.$infographic->image_mobile);
      $infographic->thumb_url = base_url('uploads/infographic/'.$infographic->thumb);
      $infographic->detail_url = base_url('infographic/'.$infographic->slug_url);
      $infographic->datetime = (new DateTime($infographic->publish_date))->format('d/m/Y, H:i').' WIB';

      //get total paragraph
      $pattern = "/<p.*<\/p>/m";
      $infographic->paragraph_count = preg_match_all($pattern,$infographic->description);
    }

    return $rows;
  }
}