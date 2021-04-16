<?php
use Snipe\BanBuilder\CensorWords;

class News_model extends CI_Model {

	function __construct() {
		parent::__construct();
    $this->load->helper('file');
  }

  public function getDescriptionBySlugWithLimit($slug, $limits, $start, $totalRow) {
    $limit = $limits != 0 ? $limits : 1;
    $totalPage = ceil($totalRow/$limit);
    $rows = $this->db->query('
      SELECT n.description
      FROM '.$this->db->dbprefix('news').' n
      WHERE n.slug_url = "'.$slug.'" ')->row();

    $rows->description = $this->clearDescription($rows->description);

    $originalDesc = preg_split("/<\/p>/m", $rows->description);

    $paragraph = preg_split("/<\/p>/m", $rows->description);
    $paragraph = array_slice($paragraph, $start, $limit);
    $text = '';
    foreach ($paragraph as $par) {
      $pos = strpos($par, '<p');
      if ($pos === false) {
        
      } else {
        $par = $par.'</p>';
      }
      $text = $text.$par;
    }

    // if ($start == 0 && $totalPage > 1) {
    //   if (strpos($originalDesc[0], '<div')) {
    //     $text = $text.'</div>';
    //   } else {
    //     // $text = $text.'</p>';
    //   }
    // } else if ($totalPage > 1 && ($totalRow - $start) <= ($totalRow - $limit)){
    //   if (strpos($originalDesc[0].$text, '<div')) {
    //     $text = $originalDesc[0].$text;
    //   }
    //   if (($limit * $totalPage - $start) != $limit) {
    //     if (strpos($originalDesc[0], '<div')) {
    //       $text = $text.'</div>';
    //     } else {
    //       // $text = $text.'</p>';
    //     }
    //   }
    // }


    return $text;
  }

  public function getRelatedNews($slug, $identifier='news') {
    $now = date('Y-m-d H:i:s');
    $rows = $this->db->query('
      SELECT n.*
      FROM '.$this->db->dbprefix('news').' n
      WHERE n.is_active = 1 AND n.is_delete = 0 AND publish_date <= "'.$now.'" AND category_id = (
        SELECT category_id FROM '.$this->db->dbprefix($identifier).' WHERE slug_url = "'.$slug.'"
      ) AND slug_url <> "'.$slug.'" ORDER BY publish_date DESC LIMIT 0,5')->result();

    $rows = $this->prepare($rows,[]);
    return $rows;
  }
  
  public function getDetailBySlug($slug) {
    $now = date('Y-m-d H:i:s');
    $rows = $this->db->query('
      SELECT n.*, c.title AS category, a.name AS author
      FROM '.$this->db->dbprefix('news').' n 
      JOIN '.$this->db->dbprefix('category').' c 
      ON n.category_id=c.id 
      JOIN '.$this->db->dbprefix('admin').' a 
      ON IF(n.expert_id=0, n.author_id=a.id, n.expert_id=a.id)
      WHERE n.is_active = 1 AND n.is_delete = 0 AND n.slug_url = "'.$slug.'" AND publish_date <= "'.$now.'"')->result();
    
    if(count($rows) == 0) {
      return FALSE;
    }

    $rows = $this->prepare($rows,[]);
    return end($rows);
  }

  public function getNewsById($idx) {
    $now = date('Y-m-d H:i:s');
    $rows = $this->db->query('
      SELECT n.*
      FROM '.$this->db->dbprefix('news').' n
      WHERE n.is_active = 1 AND n.is_delete = 0 AND n.id = "'.$idx.'" AND n.publish_date <= "'.$now.'"')->result();
    
    if(count($rows) == 0) {
      return FALSE;
    }

    $rows = $this->prepare($rows,[]);
    return end($rows);
  }

  public function comment($identifier, $idx, $uid, $comment) {
    $now = date('Y-m-d H:i:s');
    return $this->db->insert('comment', [$identifier => $idx, 'user_id' => $uid, 'created_date' => $now, 'comment' => $comment]);
  }

  public function getCommentBySlug($slug, $identifier = 'news_id', $type = 'news') {
    $rows = $this->db->query('
      SELECT c.*, u.name
      FROM '.$this->db->dbprefix('comment').' c
      LEFT JOIN '.$this->db->dbprefix($type).' n
      ON c.'.$identifier.'=n.id
      LEFT JOIN '.$this->db->dbprefix('user').' u
      ON c.user_id=u.id
      WHERE n.slug_url = "'.$slug.'"
      ORDER BY created_date DESC')->result();

    foreach ($rows as $r) {
      $r->pretty_time = $this->getDateTime($r->created_date);
      $r->comment = $this->censor($r->comment);
    }

    return $rows;
  }

  public function getTagBySlug($slug) {
    $rows = $this->db->query('
      SELECT t.*
      FROM '.$this->db->dbprefix('tag').' t
      JOIN '.$this->db->dbprefix('tag_relation').' tr
      ON t.id=tr.tag_id
      JOIN '.$this->db->dbprefix('news').' n
      ON tr.news_id=n.id
      WHERE n.slug_url = "'.$slug.'"')->result();

    return $rows;
  }

  public function getPodcastTagBySlug($slug) {
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

  public function getRecommendation() {
    $now = date('Y-m-d H:i:s');
    $rows = $this->db->query('
      SELECT n.*
      FROM '.$this->db->dbprefix('news').' n
      WHERE n.is_active = 1 AND n.is_delete = 0 AND n.is_recommendation=1 AND n.publish_date <= "'.$now.'" ORDER BY n.publish_date DESC LIMIT 0,5')->result();

    $rows = $this->prepare($rows,[]);
    return $rows;
  }

  public function getTrendingNews() {
    $now = date('Y-m-d H:i:s');
    $rows = $this->db->query('SELECT * FROM '.$this->db->dbprefix('news').' WHERE is_active = 1 AND is_delete = 0 AND is_trending = 1 AND publish_date <= "'.$now.'" ORDER BY publish_date DESC LIMIT 0,5')->result();
    
    $rows = $this->prepare($rows,[]);
    return $rows;
  }

  public function getAllNews() {
    $now = date('Y-m-d H:i:s');
    $rows = $this->db->query('SELECT * FROM '.$this->db->dbprefix('news').' WHERE is_active = 1 AND is_delete = 0 AND publish_date <= "'.$now.'" ORDER BY publish_date DESC LIMIT 0,5')->result();
    
    $rows = $this->prepare($rows,[]);
    return $rows;
  }

  public function getEmitenNews() {
    $now = date('Y-m-d H:i:s');
    $rows = $this->db->query('SELECT * FROM '.$this->db->dbprefix('news').' WHERE is_active = 1 AND is_delete = 0 AND category_id = 2 AND publish_date <= "'.$now.'" ORDER BY publish_date DESC LIMIT 0,5')->result();
    
    $rows = $this->prepare($rows,[]);
    return $rows;
  }

  public function getHighlight() {
    $now = date('Y-m-d H:i:s');
    $rows = $this->db->query('SELECT * FROM '.$this->db->dbprefix('news').' WHERE is_active = 1 AND is_delete = 0 AND is_highlight = 1 AND publish_date <= "'.$now.'" ORDER BY publish_date DESC LIMIT 0,5')->result();
    
    $rows = $this->prepare($rows,[]);
    return $rows;
  }

  public function getCategoryNewsWithLimit($slug, $limit, $start) {
    $now = date('Y-m-d H:i:s');
    $rows = $this->db->query('SELECT n.* FROM '.$this->db->dbprefix('news').' n JOIN '.$this->db->dbprefix('category').' c ON n.category_id=c.id WHERE n.is_active = 1 AND n.is_delete = 0 AND c.slug_url = "'.$slug.'" AND n.publish_date <= "'.$now.'" ORDER BY n.publish_date DESC LIMIT '.$start.','.$limit)->result();
    
    $rows = $this->prepare($rows,[]);
    return $rows;
  }

  public function getAllNewsWithLimit($limit, $start) {
    $now = date('Y-m-d H:i:s');
    $rows = $this->db->query('SELECT n.* FROM '.$this->db->dbprefix('news').' n WHERE n.is_active = 1 AND n.is_delete = 0 AND n.publish_date <= "'.$now.'" ORDER BY n.publish_date DESC LIMIT '.$start.','.$limit)->result();
    
    $rows = $this->prepare($rows,[]);
    return $rows;
  }

  public function getAllTrendingWithLimit($limit, $start) {
    $now = date('Y-m-d H:i:s');
    $rows = $this->db->query('SELECT n.* FROM '.$this->db->dbprefix('news').' n WHERE n.is_active = 1 AND n.is_delete = 0 AND n.is_trending = 1 AND n.publish_date <= "'.$now.'" ORDER BY n.publish_date DESC LIMIT '.$start.','.$limit)->result();
    
    $rows = $this->prepare($rows,[]);
    return $rows;
  }

  public function getExpertNewsWithLimit($slug, $limit, $start) {
    $now = date('Y-m-d H:i:s');
    $rows = $this->db->query('SELECT n.* FROM '.$this->db->dbprefix('news').' n JOIN '.$this->db->dbprefix('admin').' a ON n.expert_id=a.id WHERE n.is_active = 1 AND n.is_delete = 0 AND a.slug_url = "'.$slug.'" AND n.publish_date <= "'.$now.'" ORDER BY n.publish_date DESC LIMIT '.$start.','.$limit)->result();
    
    $rows = $this->prepare($rows,[]);
    return $rows;
  }

  public function getTagNewsWithLimit($slug, $limit, $start) {
    $now = date('Y-m-d H:i:s');
    $rows = $this->db->query('
      SELECT n.*
      FROM '.$this->db->dbprefix('news').' n
      JOIN '.$this->db->dbprefix('tag_relation').' tr
      ON n.id=tr.news_id
      WHERE n.is_active = 1 AND n.is_delete = 0 AND n.publish_date <= "'.$now.'" AND tr.tag_id = (
        SELECT id FROM '.$this->db->dbprefix('tag').' WHERE slug_url = "'.$slug.'"
      ) LIMIT '.$start.','.$limit)->result();
      
    $rows = $this->prepare($rows,[]);
    return $rows;
  }

  public function getCategoryNewsCount($slug) {
    $now = date('Y-m-d H:i:s');
    $count = $this->db->query('SELECT COUNT(n.id) AS total FROM '.$this->db->dbprefix('news').' n JOIN '.$this->db->dbprefix('category').' c ON n.category_id=c.id WHERE n.is_active = 1 AND n.is_delete = 0 AND c.slug_url = "'.$slug.'" AND publish_date <= "'.$now.'" ORDER BY publish_date DESC')->row();

    return $count;
  }

  public function getAllNewsCount() {
    $now = date('Y-m-d H:i:s');
    $count = $this->db->query('SELECT COUNT(n.id) AS total FROM '.$this->db->dbprefix('news').' n WHERE n.is_active = 1 AND n.is_delete = 0 AND publish_date <= "'.$now.'" ORDER BY publish_date DESC')->row();

    return $count;
  }

  public function getAllTrendingCount() {
    $now = date('Y-m-d H:i:s');
    $count = $this->db->query('SELECT COUNT(n.id) AS total FROM '.$this->db->dbprefix('news').' n WHERE n.is_active = 1 AND n.is_delete = 0 AND n.is_trending = 1 AND publish_date <= "'.$now.'" ORDER BY publish_date DESC')->row();

    return $count;
  }
  
  public function getLikesCount($slug, $identifier = 'news_id', $type = 'news') {
    $count = $this->db->query('SELECT COUNT(l.id) AS total FROM '.$this->db->dbprefix('like').' l LEFT JOIN '.$this->db->dbprefix($type).' n ON l.'.$identifier.'=n.id WHERE n.slug_url = "'.$slug.'"')->row();

    return $count;
  }

  public function like($identifier, $idx, $uid, $type) {
    $row = $this->db->query('
      SELECT l.id as id, n.slug_url as slug
      FROM '.$this->db->dbprefix('like').' l
      JOIN '.$this->db->dbprefix($type).' n
      WHERE '.$identifier.'="'.$idx.'" AND user_id="'.$uid.'"')->row();

    $item = $this->db->get_where($type,['id'=>$idx])->row();

    if(empty($row)) {
      $now = date('Y-m-d H:i:s');
      if ($this->db->insert('like', [$identifier => $idx, 'user_id' => $uid, 'created_date' => $now]) != FALSE) {
        
        return ($this->getLikesCount($item->slug_url, $identifier, $type))->total;
      }
      return FALSE;
    } else {
      if ($this->db->delete('like', ['id' => $row->id]) != FALSE) {
        
        return ($this->getLikesCount($item->slug_url, $identifier, $type))->total;
      }
      return FALSE;
    }
  }

  public function getTagNewsCount($slug) {
    $now = date('Y-m-d H:i:s');
    $count = $this->db->query('
      SELECT COUNT(n.id) AS total
      FROM '.$this->db->dbprefix('news').' n
      JOIN '.$this->db->dbprefix('tag_relation').' tr
      ON n.id=tr.news_id
      WHERE n.is_active = 1 AND n.is_delete = 0 AND n.publish_date <= "'.$now.'" AND tr.tag_id = (
        SELECT id FROM '.$this->db->dbprefix('tag').' WHERE slug_url = "'.$slug.'"
      )')->row();

    return $count;
  }

  public function getExpertNewsCount($slug) {
    $now = date('Y-m-d H:i:s');
    $count = $this->db->query('
      SELECT COUNT(n.id) AS total
      FROM '.$this->db->dbprefix('news').' n
      JOIN '.$this->db->dbprefix('admin').' a
      ON n.expert_id=a.id
      WHERE n.is_active = 1 AND n.is_delete = 0 AND n.publish_date <= "'.$now.'" AND a.id = (
        SELECT id FROM '.$this->db->dbprefix('admin').' WHERE slug_url = "'.$slug.'"
      )')->row();

    return $count;
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
    foreach ($rows as $news) {
      $news->pretty_time = $this->getDateTime($news->publish_date);
      $dir = "news/";
      $strDir = explode("/", $news->image);
      if (count($strDir) > 2) {
        $dir = "";
      }
      $news->image_url = empty($news->image) ? base_url('assets/images/logo.png') : base_url('uploads/'.$dir.$news->image);
      $news->image_mobile_url = empty($news->image_mobile) ? base_url('assets/images/logo.png') : base_url('uploads/'.$dir.$news->image_mobile);
      $news->thumb_url = empty($news->thumb) ? base_url('assets/images/logo.png') : base_url('uploads/'.$dir.$news->thumb);
      $news->detail_url = base_url('news/'.$news->slug_url);
      $news->datetime = (new DateTime($news->publish_date))->format('d/m/Y, H:i').' WIB';
      $news->description = $this->clearDescription($news->description);

      //get total paragraph
      // $fakeParagraphCount = preg_match_all("/<p[^>]*>&nbsp;<\/p>/m",$news->description);
      // $news->paragraph_count = preg_match_all($pattern,$news->description) - $fakeParagraphCount;
      $news->paragraph_count = preg_match_all("/<p.*<\/p>/m",$news->description);
      $news->paragraph_per_page = 7;
    }

    return $rows;
  }

  private function clearDescription($text) {
    $text = preg_replace('/(<[^>]+) style=".*?"/i', '$1', $text);
    $text = preg_replace('/(<[^>]+) dir=".*?"/i', '$1', $text);
    $text = preg_replace("/<\/?div[^>]*\>/i", "", $text);
    $text = preg_replace("/<\/?span[^>]*\>/i", "", $text);
    $text = preg_replace("/<p[^>]*>&nbsp;<\/p>/m", "<br>", $text);
    $text = preg_replace("/<p[^>]*><\/p>/m", "<br>", $text);

    return $text;
  }

  private function censor($text='') {
    $existing = $this->db->query("select word from {$this->db->dbprefix('badword')}")->result();
    $words = array();
    foreach ($existing as $exist) {
      array_push($words, "'".$exist->word."'");
    }
    
    $str = implode(",", $words);
    $data = ""
    ."<?php\n"
    ."array_push("
    ."\$badwords,"
    ."{$str}"
    .");";

    if (!write_file('./assets/dict/dict.php', $data)){
      // echo 'Unable to write the file';
    } else {
      // echo 'File written!';
    }

    $censor = new CensorWords;
    $badwords = array();
    $censor->setDictionary('./assets/dict/dict.php');

    $text = $censor->censorString($text);

    return $text['clean'];
  }
}