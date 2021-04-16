<?php
class Ads_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function getHomeAds() {
        $rows = $this->db->query('
        SELECT *
        FROM '.$this->db->dbprefix('ads').' a
        WHERE a.is_active = 1 AND a.is_delete = 0 AND position_id=1 ORDER BY modified_date DESC')->result();
        
        $rows = $this->prepare($rows,[]);
        return end($rows);
    }

    public function getNewsListTopAds() {
        $rows = $this->db->query('
        SELECT *
        FROM '.$this->db->dbprefix('ads').' a
        WHERE a.is_active = 1 AND a.is_delete = 0 AND position_id=2 ORDER BY modified_date DESC')->result();
        
        $rows = $this->prepare($rows,[]);
        return end($rows);
    }

    public function getNewsListBottomAds() {
        $rows = $this->db->query('
        SELECT *
        FROM '.$this->db->dbprefix('ads').' a
        WHERE a.is_active = 1 AND a.is_delete = 0 AND position_id=3 ORDER BY modified_date DESC')->result();
        
        $rows = $this->prepare($rows,[]);
        return end($rows);
    }

    public function getNewsDetailTopAds() {
        $rows = $this->db->query('
        SELECT *
        FROM '.$this->db->dbprefix('ads').' a
        WHERE a.is_active = 1 AND a.is_delete = 0 AND position_id=4 ORDER BY modified_date DESC')->result();
        
        $rows = $this->prepare($rows,[]);
        return end($rows);
    }

    public function getNewsDetailBottomAds() {
        $rows = $this->db->query('
        SELECT *
        FROM '.$this->db->dbprefix('ads').' a
        WHERE a.is_active = 1 AND a.is_delete = 0 AND position_id=5 ORDER BY modified_date DESC')->result();
        
        $rows = $this->prepare($rows,[]);
        return end($rows);
    }

    public function getExpertListTopAds() {
        $rows = $this->db->query('
        SELECT *
        FROM '.$this->db->dbprefix('ads').' a
        WHERE a.is_active = 1 AND a.is_delete = 0 AND position_id=6 ORDER BY modified_date DESC')->result();
        
        $rows = $this->prepare($rows,[]);
        return end($rows);
    }

    public function getExpertListBottomAds() {
        $rows = $this->db->query('
        SELECT *
        FROM '.$this->db->dbprefix('ads').' a
        WHERE a.is_active = 1 AND a.is_delete = 0 AND position_id=7 ORDER BY modified_date DESC')->result();
        
        $rows = $this->prepare($rows,[]);
        return end($rows);
    }

    public function getInfographicListTopAds() {
        $rows = $this->db->query('
        SELECT *
        FROM '.$this->db->dbprefix('ads').' a
        WHERE a.is_active = 1 AND a.is_delete = 0 AND position_id=8 ORDER BY modified_date DESC')->result();
        
        $rows = $this->prepare($rows,[]);
        return end($rows);
    }

    public function getInfographicListBottomAds() {
        $rows = $this->db->query('
        SELECT *
        FROM '.$this->db->dbprefix('ads').' a
        WHERE a.is_active = 1 AND a.is_delete = 0 AND position_id=9 ORDER BY modified_date DESC')->result();
        
        $rows = $this->prepare($rows,[]);
        return end($rows);
    }

    private function prepare($rows = [], $options = []) {
        foreach ($rows as $ads) {
        $ads->image_url = base_url('uploads/ads/'.$ads->image);
        
        }

        return $rows;
    }
}