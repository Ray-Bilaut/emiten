<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH.'core/APP_Frontend.php';
class Transfer extends APP_Frontend
{

    public function __construct()
    {
        parent::__construct();
    }

    // public function migrate_term($type = 'category') {
    //     $get = $this->db->query("SELECT t.term_id, t.name, t.slug, x.taxonomy, x.description FROM {$this->db->dbprefix('wp_terms')} t LEFT JOIN {$this->db->dbprefix('wp_term_taxonomy')} x ON t.term_id = x.term_id WHERE x.taxonomy = ?", [$type])->result_array();

    //     //migrate category
    //     if($type == 'category') {
    //         foreach($get as $term) {
    //             $ins = $this->db->insert("category", [
    //                 "title" => $term['name'],
    //                 "slug_url" => $term['slug'],
    //                 "is_active" => 1,
    //                 "is_delete" => 0,
    //                 "parent_id" => 0,
    //                 "created_date" => date('Y-m-d H:i:s')
    //             ]);

    //             if(isset($ins) or $ins != false) {
    //                 $insertId = $this->db->insert_id();
    //                 $set = $this->db->update("wp_terms", ["new_id" => $insertId], ["term_id" => $term["term_id"]]);

    //                 if(isset($set) or $set != false) {
    //                     echo $term['term_id']." => ".$insertId."<br>";
    //                 }
    //             }
    //         }
            
    //     //migrate tag
    //     } else {
    //         foreach($get as $term) {
    //             $check = $this->db->get_where("tag", ["title" => $term['name']])->row();

    //             if(isset($check->id)) {
    //                 continue;
    //             } else {
    //                 $ins = $this->db->insert("tag", [
    //                     "title" => $term['name'],
    //                     "slug_url" => $term['slug'],
    //                     "created_date" => date('Y-m-d H:i:s')
    //                 ]);

    //                 if(isset($ins) or $ins != false) {
    //                     $insertId = $this->db->insert_id();
    //                     $set = $this->db->update("wp_terms", ["new_id" => $insertId], ["term_id" => $term["term_id"]]);

    //                     if(isset($set) or $set != false) {
    //                         echo $term['term_id']." => ".$insertId."<br>";
    //                     }
    //                 }
    //             }
    //         }
    //     }
    // }

    // private function cleantext($text) {
    //     return str_replace(["[caption","]<img","[/caption]", "[embed]", "[/embed]", "[video", "mp4=", "][/video]", "watch?v="],["<div class='caption' ","><img","</div>", "<iframe src=\"", "\"></iframe>", "<video", "src=", "></video>", "embed/"], $text);
    // }

    // public function import() {
    //     set_time_limit(0);

    //     $limit = 5000;
    //     $query = $this->db->query("SELECT * FROM `em_wp_posts` WHERE `post_status` = 'publish' AND `post_type` = 'post' AND `is_imported` = 0 LIMIT 0, ?", [$limit])->result_array();

    //     foreach($query as $item) {
    //         $content = $this->cleantext($item['post_content']);
    //         $image = "";
    //         $category_id = 0;
    //         $tags = [];

    //         $terms = $this->db->query("SELECT s.new_id, t.taxonomy FROM em_wp_term_relationships r, em_wp_terms s, em_wp_term_taxonomy t WHERE r.term_taxonomy_id = t.term_taxonomy_id AND t.term_id = s.term_id AND r.object_id = ?", [$item['ID']])->result_array();
    //         foreach($terms as $term) {
    //             if($category_id == 0 and $term['taxonomy'] == 'category') {
    //                 $category_id = $term['new_id'];
    //             } 
    //             if($term['taxonomy'] == 'post_tag') {
    //                 $tags[] = $term['new_id'];
    //             }
    //         }

    //         $images = $this->db->query("SELECT p.* FROM em_wp_postmeta m LEFT JOIN em_wp_posts p ON m.meta_value = p.ID WHERE m.post_id = ? AND m.meta_key = '_thumbnail_id' ORDER BY m.meta_id DESC LIMIT 0, 1", [$item['ID']])->row();

    //         if(isset($images->guid)) {
    //             $exp = explode("wp-content/uploads/", $images->guid);
    //             if(count($exp) > 0) {
    //                 $image = end($exp);
    //             }
    //         }

    //         $datas = [
    //             'title' => $item['post_title'],
    //             'description' => $content,
    //             'slug_url' => $item['post_name'],
    //             'thumb' => $image,
    //             'image' => $image,
    //             'image_mobile' => $image,
    //             'category_id' => $category_id,
    //             'author_id' => $item['post_author'],
    //             'expert_id' => 0,
    //             'is_highlight' => 0,
    //             'is_trending' => 0,
    //             'is_recommendation' => 0,
    //             'is_active' => 1,
    //             'is_delete' => 0,
    //             // 'view_count' => 0,
    //             'publish_date' => $item['post_date'],
    //             'created_date' => $item['post_date']
    //         ];

    //         if($this->db->insert('news', $datas)) {
    //             $insId = $this->db->insert_id();
    //             foreach($tags as $tag) {
    //                 $this->db->insert("tag_relation", [
    //                     "news_id" => $insId,
    //                     "infographic_id" => 0,
    //                     "podcast_id" => 0,
    //                     "tag_id" => $tag
    //                 ]);
    //             }

    //             $this->db->update("wp_posts",["is_imported"=>1],["ID"=>$item['ID']]);

    //             echo "Post imported ID ".$item['ID']." => ".$insId."<br>";
    //         } else {
    //             echo "<b>Failed to import ID ".$item['ID']."</b><br>";
    //         }
    //     }

    // }

    public function fix_tags() {
        $rows = $this->db->query('
            SELECT t.*
            FROM '.$this->db->dbprefix('tag').' t
            WHERE t.slug_url = ""')->result();


        // var_dump($rows);
        var_dump("<br><br><br>");
        $now = date('Y-m-d H:i:s');

        foreach ($rows as $theTag) {
            $tag = $theTag->title;
            
            if (strlen($tag) > 0) {
                if ($theTag->slug_url == "") {
                    $slug_url_tag = $this->slug_url_tag($tag);
                    if ($this->db->update('tag', ['slug_url' => $slug_url_tag], ['id' => $theTag->id])) {
                        var_dump("success update", $slug_url_tag);
                    } else {
                        var_dump("failed update", $slug_url_tag);
                    }
                } 
            }
        }
    }

    protected function slug_url_tag($word,$edit=false,$edit_id=0)
    {
        $url = url_title($word,"-",true);
        $no = 1;
        $subfix = "";
        $get = false;

        while(!$get){

            if($edit){
                $res = $this->db->get_where('tag',['slug_url' => $url.$subfix, 'id <>' => $edit_id])->num_rows();
            }else{
                $res = $this->db->get_where('tag',['slug_url' => $url.$subfix])->num_rows();
            }

            if( intval($res)<=0 ){
                $get = true;
                $url = $url.$subfix;
            }

            $no = $no + 1;
            $subfix = "-".$no;
        }

        return $url;
    }
}
