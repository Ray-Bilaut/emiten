<?php
class Expert_model extends CI_Model {

	function __construct() {
		parent::__construct();
  }

  public function getExpertWithLimit($limit, $start) {
    $rows = $this->db->query('
      SELECT a.name, a.bio, a.slug_url, a.image
      FROM '.$this->db->dbprefix('admin').' a
      WHERE a.is_active = 1 AND a.is_delete = 0 AND a.group = 4 AND a.top_order = 0 LIMIT '.$start.','.$limit)->result();
      
    $rows = $this->prepare($rows,[]);
    return $rows;
  }

  public function getTopExpert() {
    $rows = $this->db->query('
      SELECT a.name, a.bio, a.slug_url, a.image
      FROM '.$this->db->dbprefix('admin').' a
      WHERE a.is_active = 1 AND a.is_delete = 0 AND a.group = 4 AND a.top_order <> 0')->result();
      
    $rows = $this->prepare($rows,[]);
    return $rows;
  }

  public function getExpertBySlug($slug) {
    $rows = $this->db->query('
      SELECT a.name, a.bio, a.slug_url, a.image
      FROM '.$this->db->dbprefix('admin').' a
      WHERE a.slug_url = "'.$slug.'"')->result();

    if(count($rows) == 0) {
      return FALSE;
    }
    
    $rows = $this->prepare($rows,[]);
    return end($rows);
  }

  public function getExpertCount() {
    $count = $this->db->query('SELECT COUNT(a.id) AS total FROM '.$this->db->dbprefix('admin').' a WHERE a.is_active = 1 AND a.is_delete = 0 AND a.group = 4')->row();

    return $count;
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
    foreach ($rows as $expert) {
      $expert->image_url = base_url('uploads/expert/'.$expert->image);
    }

    return $rows;
  }
}