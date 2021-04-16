<?php
class Tag_model extends CI_Model {

  function __construct() {
    parent::__construct();
  }

  public function getTagBySlug($slug) {
    $rows = $this->db->query('
      SELECT t.title, t.slug_url
      FROM '.$this->db->dbprefix('tag').' t
      WHERE t.slug_url = "'.$slug.'"')->result();

    if(count($rows) == 0) {
      return FALSE;
    }
    
    return end($rows);
  }
}