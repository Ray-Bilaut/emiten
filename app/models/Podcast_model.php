<?php
class Podcast_model extends CI_Model {

	function __construct() {
		parent::__construct();
  }

  public function getDetailBySlug($slug) {
    $now = date('Y-m-d H:i:s');
    $rows = $this->db->query('
      SELECT n.*, c.title AS category, a.name AS author
      FROM '.$this->db->dbprefix('podcast').' n 
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
      JOIN '.$this->db->dbprefix('podcast').' n
      ON tr.podcast_id=n.id
      WHERE n.slug_url = "'.$slug.'"')->result();

    return $rows;
  }

  public function getPodcastWithLimit($limit, $start) {
    $now = date('Y-m-d H:i:s');
    $rows = $this->db->query('SELECT n.* FROM '.$this->db->dbprefix('podcast').' n WHERE n.is_active = 1 AND n.is_delete = 0 AND n.publish_date <= "'.$now.'" ORDER BY n.publish_date DESC LIMIT '.$start.','.$limit)->result();
    
    $rows = $this->prepare($rows,[]);
    return $rows;
  }

  public function getPodcastCount() {
    $count = $this->db->query('SELECT COUNT(p.id) AS total FROM '.$this->db->dbprefix('podcast').' p WHERE p.is_active = 1 AND p.is_delete = 0')->row();

    return $count;
  }

  //Dont separate next two function
  public function getAllPodcast() {
    $now = date('Y-m-d H:i:s');
    $rows = $this->db->query('SELECT p.*
      FROM '.$this->db->dbprefix('podcast').' p
      WHERE p.is_active = 1 AND p.is_delete = 0 AND p.publish_date <= "'.$now.'"
      ORDER BY p.publish_date DESC LIMIT 0,10')->result();

    $rows = $this->prepare($rows,[]);
    return $rows;
  }
  public function getAllPodcastTag() {
    $now = date('Y-m-d H:i:s');
    $rows = $this->db->query('SELECT p.id AS podcast_id, t.title AS tag_title, t.slug_url AS tag_url
      FROM '.$this->db->dbprefix('tag').' t
      JOIN '.$this->db->dbprefix('tag_relation').' tr
      ON t.id = tr.tag_id
      JOIN 
      (
        SELECT id
        FROM '.$this->db->dbprefix('podcast').'
        WHERE is_active = 1 AND is_delete = 0 AND publish_date <= "'.$now.'"
        ORDER BY publish_date DESC LIMIT 0,10
      ) p
      ON p.id = tr.podcast_id
      WHERE tr.podcast_id <> 0')->result();

    // $rows = $this->prepare($rows,[]);
    return $rows;
  }
  //Dont separate previous two function

  //Dont separate next two function
  public function getLatestPodcast() {
    $now = date('Y-m-d H:i:s');
    $rows = $this->db->query('SELECT p.*
      FROM '.$this->db->dbprefix('podcast').' p
      WHERE p.is_active = 1 AND p.is_delete = 0 AND p.publish_date <= "'.$now.'"
      ORDER BY p.publish_date DESC LIMIT 0,1')->result();

    $rows = $this->prepare($rows,[]);
    return end($rows);
  }
  public function getLatestPodcastTag() {
    $now = date('Y-m-d H:i:s');
    $rows = $this->db->query('SELECT p.id AS podcast_id, t.title AS tag_title, t.slug_url AS tag_url
      FROM '.$this->db->dbprefix('tag').' t
      JOIN '.$this->db->dbprefix('tag_relation').' tr
      ON t.id = tr.tag_id
      JOIN 
      (
        SELECT id
        FROM '.$this->db->dbprefix('podcast').'
        WHERE is_active = 1 AND is_delete = 0 AND publish_date <= "'.$now.'"
        ORDER BY publish_date DESC LIMIT 0,1
      ) p
      ON p.id = tr.podcast_id
      WHERE tr.podcast_id <> 0')->result();

    // $rows = $this->prepare($rows,[]);
    return $rows;
  }
  //Dont separate previous two function

  public function getPodcastById($idx) {
    $now = date('Y-m-d H:i:s');
    $rows = $this->db->query('
      SELECT n.*
      FROM '.$this->db->dbprefix('podcast').' n
      WHERE n.is_active = 1 AND n.is_delete = 0 AND n.id = "'.$idx.'" AND n.publish_date <= "'.$now.'"')->result();
    
    if(count($rows) == 0) {
      return FALSE;
    }

    $rows = $this->prepare($rows,[]);
    return end($rows);
  }

  public function getAudioPodcast() {
    $now = date('Y-m-d H:i:s');
    $rows = $this->db->query('SELECT * FROM '.$this->db->dbprefix('podcast').' WHERE is_active = 1 AND is_delete = 0 AND type = 0 AND publish_date <= "'.$now.'" ORDER BY publish_date DESC LIMIT 0,10')->result();

    $rows = $this->prepare($rows,[]);
    return $rows;
  }

  public function getRelatedPodcastByTag($slug) {
    $now = date('Y-m-d H:i:s');
    $rows = $this->db->query('
      SELECT p.*
      FROM '.$this->db->dbprefix('podcast').' p
      JOIN '.$this->db->dbprefix('tag_relation').' tr
      ON p.id=tr.podcast_id
      WHERE p.is_active = 1 AND p.is_delete = 0 AND p.publish_date <= "'.$now.'" AND tr.tag_id = (
        SELECT id FROM '.$this->db->dbprefix('tag').' WHERE slug_url = "'.$slug.'"
      ) ORDER BY p.publish_date DESC LIMIT 0,4')->result();

    $rows = $this->prepare($rows,[]);
    return $rows;
  }

  public function getRelatedPodcastByCategory($slug) {
    $now = date('Y-m-d H:i:s');
    $rows = $this->db->query('
      SELECT p.*
      FROM '.$this->db->dbprefix('podcast').' p
      WHERE p.is_active = 1 AND p.is_delete = 0 AND publish_date <= "'.$now.'" AND category_id = (
        SELECT id FROM '.$this->db->dbprefix('category').' WHERE slug_url = "'.$slug.'"
      ) ORDER BY p.publish_date DESC LIMIT 0,4')->result();
    
    $rows = $this->prepare($rows,[]);
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
    foreach ($rows as $podcast) {
      $podcast->pretty_time = $this->getDateTime($podcast->publish_date);
      $podcast->image_url = base_url('uploads/podcast_image/'.$podcast->image);
      $podcast->image_mobile_url = base_url('uploads/podcast_image/'.$podcast->image_mobile);
      $podcast->thumb_url = base_url('uploads/podcast_image/'.$podcast->thumb);
      $podcast->detail_url = base_url('podcast/'.$podcast->slug_url);
      $podcast->short_desc = strlen($podcast->description) > 200 ? substr($podcast->description,0,200)."..." : $podcast->description;
      $podcast->datetime = (new DateTime($podcast->publish_date))->format('d/m/Y, H:i').' WIB';

      //get total paragraph
      $pattern = "/<p.*<\/p>/m";
      $podcast->paragraph_count = preg_match_all($pattern,$podcast->description);
    }

    return $rows;
  }
}