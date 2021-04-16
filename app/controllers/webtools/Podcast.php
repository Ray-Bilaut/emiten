<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'core/APP_Webtools.php';
class Podcast extends APP_Webtools {

	public function __construct()
	{
        parent::__construct();
        $this->_template_master_data['page_title'] = 'Podcast';
        $this->load->model("notif_model");
	}

    public function index($error='')
    {
        $this->_data['error'] = $error;
        $this->_data['error_msg'] = $this->session->flashdata('error');
        $this->_data['success_msg'] = $this->session->flashdata('success');

        $podcastQry = "SELECT 
                    p.*, a.name
                FROM
                    {$this->db->dbprefix('podcast')} p
                JOIN
                    {$this->db->dbprefix('admin')} a
                ON
                p.author_id=a.id
                WHERE 
                    p.is_delete=0
				";
        $this->_data['list'] = $this->db->query($podcastQry)->result();
        // $this->_data['list'] = $this->db->get_where('Podcast', array('is_delete'=>0))->result();
        $this->_data['categories'] = $this->db->get_where('category', array('is_delete'=>0))->result();

        $this->_addScript('assets/adminlte/bower_components/moment/min/moment.min.js');
        $this->_addStyle('assets/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css');
        $this->_addScript('assets/adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js');
        $this->_addScript('assets/adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js');
        $this->_addScript('assets/adminlte/plugins/datatables/datetime-moment.js');

        $jsx = "
            $.fn.dataTable.moment('DD MMM YYYY - HH:mm');
            $(document).ready(function() {
                $('.datatable').DataTable({
                    'order': [[ 7, 'desc' ]],
                    'autoWidth': false,
                    'scrollY': 400,
                    'scrollX': 400,
                    'scroller': true
                });
            } );
        ";
        $this->_addScript($jsx, 'embed');

        $this->_template_master_data['page_subtitle'] = '&nbsp;';
        $this->_addContent($this->_data);
        $this->_render();
    }

    public function add($error='')
    {
        $this->_data['error'] = $error;
        $this->_data['error_msg'] = $this->session->flashdata('error');
        $this->_data['categories'] = $this->db->get_where('category', array('is_delete'=>0, 'parent_id'=>0))->result();

        $this->_template_master_data['page_subtitle'] = 'add';
        $this->_addContent($this->_data);
        $this->_render();
    }

    public function addprocess()
    {
        $this->load->library('form_validation'); 
        $this->form_validation->set_message('required', '{field} can\'t be empty');
        $this->form_validation->set_message('max_length', '{field} max {param} characters');
        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('description', 'Description', 'required');
        $this->form_validation->set_rules('publish_date', 'Publish Date', 'required');
		
        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('error', validation_errors());
            redirect(ADMIN_URL."/{$this->router->class}/add/error");
        }

        $title = trim($this->input->post('title'));
        $description = trim($this->input->post('description'));
        $publishDate = trim($this->input->post('publish_date',true));
        $time = trim($this->input->post('publish_time',true));
        $datetime = $publishDate." ".$time.":00";
        $publishDateTime = date('Y-m-d H:i:s',strtotime($datetime));

        $tags = trim($this->input->post('tags'));
        $arrayTags = explode(',', strtolower($tags));

        $now = date('Y-m-d H:i:s');

        $data = [
            'title' => $title,
            'description' => $description,
            'category_id' => intval($this->input->post('category_id')),
            'is_active' => intval($this->input->post('is_active')),
            'type' => intval($this->input->post('type')),
			'publish_date' => $publishDateTime,
			'created_date' => $now
        ];

        $this->load->library('mfupload');

        if ($data['type'] == 0) {
            $data['file_name'] = trim($this->input->post('audio'));
        } else {
            $data['file_name'] = trim($this->input->post('youtube_id'));
        }

        $img = $this->mfupload->image('image','./uploads/podcast_image/',true,'image_');
        if( $img->status==400 ){
            $this->session->set_flashdata('error', $img->message);
            redirect(ADMIN_URL."/{$this->router->class}/add/error");
        }else{
            $data['image'] = empty($img->image) ? '' : $img->image;
        }

        $isThumbSame = false;
        $isImageMobileSame = false;

        if (!empty($_FILES['image']['name']) && !empty($_FILES['thumb']['name']) && !empty($_FILES['image_mobile']['name'])) {
            $imageTempName = $_FILES['image']['name'];
            $thumbTempName = $_FILES['thumb']['name'];
            $imageMobileTempName = $_FILES['image_mobile']['name'];
            if ($imageTempName == $thumbTempName) {
                $isThumbSame = true;
            }
            if ($imageTempName == $imageMobileTempName) {
                $isImageMobileSame = true;
            }
        }

        if ($isThumbSame) {
            $data['thumb'] = $data['image'];
        } else {
            $img = $this->mfupload->image('thumb','./uploads/podcast_image/',true,'thumb_');
            if( $img->status==400 ){
                $this->session->set_flashdata('error', $img->message);
                redirect(ADMIN_URL."/{$this->router->class}/add/error");
            }else{
                $data['thumb'] = empty($img->image) ? '' : $img->image;
            }
        }

        if ($isImageMobileSame) {
            $data['image_mobile'] = $data['image'];
        } else {
            $img = $this->mfupload->image('image_mobile','./uploads/podcast_image/',true,'mobile_');
            if( $img->status==400 ){
                $this->session->set_flashdata('error', $img->message);
                redirect(ADMIN_URL."/{$this->router->class}/add/error");
            }else{
                $data['image_mobile'] = empty($img->image) ? '' : $img->image;
            }
        }

        $data['slug_url'] = $this->slug_url($data['title']);
        $data['author_id'] = $this->_template_master_data['user']->id;

        if ($this->db->insert('podcast', $data)) {
            $new_id = $this->db->insert_id();

            $this->notif_model->set_push_queue([
                'user_id' => 0,
                'referal_type' => 'podcast',
                'referal_id' => $new_id,
                'title' => $title,
                'url' => 'podcast/'.$data['slug_url'],
                'message' => substr(strip_tags($description), 0, 50).'...'
            ], $publishDateTime);

            foreach ($arrayTags as $theTag) {
                $tag = trim($theTag);
                $selectedTag = $this->db->get_where('tag', array('title'=>$tag))->result();
                if (strlen($tag) > 0) {
                    if (count($selectedTag) < 1) {
                        $slug_url_tag = $this->slug_url_tag($tag);
                        if ($this->db->insert('tag', ['title' => $tag, 'created_date' => $now, 'slug_url' => $slug_url_tag])) {
                            $new_tag_id = $this->db->insert_id();
                            $this->db->insert('tag_relation', [
                                'podcast_id' => $new_id,
                                'tag_id' => $new_tag_id
                            ]);
                        }
                    } else {
                        $this->db->insert('tag_relation', [
                            'podcast_id' => $new_id,
                            'tag_id' => $selectedTag[0]->id
                        ]);
                    }
                }
            }

            $this->session->set_flashdata('success', 'Add data success');
            redirect(ADMIN_URL."/{$this->router->class}/edit/{$new_id}/success");
        } else {
            $this->session->set_flashdata('error', 'Add data failed, please try again!');
            redirect(ADMIN_URL."/{$this->router->class}/add/error");
        }
    }

    protected function slug_url($word,$edit=false,$edit_id=0)
    {
        $url = url_title($word,"-",true);
        $no = 1;
        $subfix = "";
        $get = false;

        while(!$get){

            if($edit){
                $res = $this->db->get_where('podcast',['slug_url' => $url.$subfix, 'id <>' => $edit_id])->num_rows();
            }else{
                $res = $this->db->get_where('podcast',['slug_url' => $url.$subfix])->num_rows();
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

    public function edit($idx,$error='')
    {
        $idx = intval($idx);
        if($idx<=0){
            redirect(ADMIN_URL."/{$this->router->class}");
        }

        $data = $this->db->get_where('podcast',['id'=>$idx])->row();

        if( empty($data->id)){
            redirect(ADMIN_URL."/{$this->router->class}");
        }

        $this->_data['data'] = $data;
        $this->_data['id'] = $idx;
        $this->_data['error'] = $error;
        $this->_data['error_msg'] = $this->session->flashdata('error');
        $this->_data['success_msg'] = $this->session->flashdata('success');

        $this->_data['categories'] = $this->db->get_where('category', array('is_delete'=>0, 'parent_id'=>0))->result();

        $tagsQry = "SELECT 
					*
				FROM 
					{$this->db->dbprefix('tag')} t
                JOIN 
                    {$this->db->dbprefix('tag_relation')} tr
                ON
                    t.id=tr.tag_id
				WHERE 
					tr.podcast_id=$idx
				";
        $arrayTags = $this->db->query($tagsQry)->result();
        $tags = '';
        for ($i=0; $i < count($arrayTags); $i++) {
            $tags = $tags.$arrayTags[$i]->title;
            $tags = $tags.($i == count($arrayTags)-1 ? '' : ', ');
        }
        $this->_data['tags'] = $tags;
        
        $this->_template_master_data['page_subtitle'] = 'edit';
        $this->_addContent($this->_data);
        $this->_render();
    }

    public function editprocess($idx)
    {
        $idx = intval($idx);
        if($idx<=0){
            redirect(ADMIN_URL."/{$this->router->class}");
        }

        $data = $this->db->get_where('podcast',['id'=>$idx])->row();

        if( empty($data->id)){
            redirect(ADMIN_URL."/{$this->router->class}");
        }

        $this->load->library('form_validation');
        
        $this->form_validation->set_message('required', '{field} can\'t be empty');
        $this->form_validation->set_message('max_length', '{field} max {param} characters');
        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('description', 'Description', 'required');
        $this->form_validation->set_rules('publish_date', 'Publish Date', 'required');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('error', validation_errors());
            redirect(ADMIN_URL."/{$this->router->class}/edit/{$idx}/error");
        }

        $publishDate = trim($this->input->post('publish_date',true));

        $time = trim($this->input->post('publish_time',true));
        $datetime = $publishDate." ".$time.":00";
        $publishDateTime = date('Y-m-d H:i:s',strtotime($datetime));

        $tags = trim($this->input->post('tags'));
        $arrayTags = explode(',', strtolower($tags));
        
        $now = date('Y-m-d H:i:s');

        $data_new = [
            'title' => trim($this->input->post('title')),
            'description' => trim($this->input->post('description')),
            'publish_date' => $publishDateTime,
            'type' => intval($this->input->post('type')),
            'category_id' => intval($this->input->post('category_id')),
			'is_active' => intval($this->input->post('is_active'))
        ];

        $this->load->library('mfupload');

        if ($data_new['type'] == 0) {
            $data_new['file_name'] = trim($this->input->post('audio'));
        } else {
            $data_new['file_name'] = trim($this->input->post('youtube_id'));
        }

        $img = $this->mfupload->image('image', './uploads/podcast_image/', false, 'image_');
        if ($img->status==400) {
            $this->session->set_flashdata('error', $img->message);
            redirect(ADMIN_URL."/{$this->router->class}/edit/{$idx}/error");
        } elseif ($img->status==200) {
            $data_new['image'] = empty($img->image) ? '' : $img->image;
        }

        $isThumbSame = false;
        $isImageMobileSame = false;

        if (!empty($_FILES['image']['name']) && !empty($_FILES['thumb']['name']) && !empty($_FILES['image_mobile']['name'])) {
            $imageTempName = $_FILES['image']['name'];
            $thumbTempName = $_FILES['thumb']['name'];
            $imageMobileTempName = $_FILES['image_mobile']['name'];
            if ($imageTempName == $thumbTempName) {
                $isThumbSame = true;
            }
            if ($imageTempName == $imageMobileTempName) {
                $isImageMobileSame = true;
            }
        }

        if ($isThumbSame) {
            $data_new['thumb'] = $data_new['image'];
        } else {
            $img = $this->mfupload->image('thumb', './uploads/podcast_image/', false, 'thumb_');
            if ($img->status==400) {
                $this->session->set_flashdata('error', $img->message);
                redirect(ADMIN_URL."/{$this->router->class}/edit/{$idx}/error");
            } elseif ($img->status==200) {
                $data_new['thumb'] = empty($img->image) ? '' : $img->image;
            }
        }

        if ($isImageMobileSame) {
            $data_new['image_mobile'] = $data_new['image'];
        } else {
            $img = $this->mfupload->image('image_mobile', './uploads/podcast_image/', false, 'mobile_');
            if ($img->status==400) {
                $this->session->set_flashdata('error', $img->message);
                redirect(ADMIN_URL."/{$this->router->class}/edit/{$idx}/error");
            } elseif ($img->status==200) {
                $data_new['image_mobile'] = empty($img->image) ? '' : $img->image;
            }
        }

        $data_new['slug_url'] = $this->slug_url($data_new['title'],true,$idx);

        if ($this->db->update('podcast', $data_new, array('id'=>$idx))) {
            $this->db->delete('tag_relation', ['podcast_id' => $idx]);

            foreach ($arrayTags as $theTag) {
                $tag = trim($theTag);
                $selectedTag = $this->db->get_where('tag', array('title'=>$tag))->result();
                if (strlen($tag) > 0) {
                    if (count($selectedTag) < 1) {
                        $slug_url_tag = $this->slug_url_tag($tag);
                        if ($this->db->insert('tag', ['title' => $tag, 'created_date' => $now, 'slug_url' => $slug_url_tag])) {
                            $new_tag_id = $this->db->insert_id();
                            $this->db->insert('tag_relation', [
                                'podcast_id' => $idx,
                                'tag_id' => $new_tag_id
                            ]);
                        }
                    } else {
                        $this->db->insert('tag_relation', [
                            'podcast_id' => $idx,
                            'tag_id' => $selectedTag[0]->id
                        ]);
                    }
                }
            }

            $this->session->set_flashdata('success', 'Edit data success');
            redirect(ADMIN_URL."/{$this->router->class}/edit/{$idx}/success");
        } else {
            $this->session->set_flashdata('error', 'Edit data failed, please try again!');
            redirect(ADMIN_URL."/{$this->router->class}/add/error");
        }
    }

    public function delete($id)
    {
        $id = intval($id);
        
        if($id<=0){
            redirect(ADMIN_URL."/{$this->router->class}");
        }

        $res = $this->db->update('podcast', ['is_delete' => 1], ['id' => $id]);

        if($res){
            $this->session->set_flashdata('success', 'Delete data success');
            redirect(ADMIN_URL."/{$this->router->class}/index/success");
        }else{
            $this->session->set_flashdata('error', 'Delete data failed');
            redirect(ADMIN_URL."/{$this->router->class}/index/error");
        }
    }
}