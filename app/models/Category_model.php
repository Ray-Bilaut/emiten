<?php
class Category_model extends CI_Model {

  function __construct() {
    parent::__construct();
  }

  public function getCategoryBySlug($slug) {
    $rows = $this->db->query('
      SELECT c.title, c.slug_url
      FROM '.$this->db->dbprefix('category').' c
      WHERE c.slug_url = "'.$slug.'"')->result();

    if(count($rows) == 0) {
      return FALSE;
    }
    
    return end($rows);
  }
}