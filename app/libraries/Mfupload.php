<?php
class Mfupload
{

    protected $CI = null;

    public function __construct($param = [])
    {
        $this->CI =& get_instance();
    }

    // public function image($field,$upload_path,$mandatory=true,$label='')
    // {
    //     $label = empty($label) ? $field : $label;

    //     if( $mandatory && empty($_FILES[$field]['tmp_name'])){
    //         return (object) ['status' => 400, 'message' => 'Empty '.$label];
    //     }

    //     if( !empty($_FILES[$field]['tmp_name']) ){
    //             $extension = @strtolower(end(explode('.',$_FILES[$field]['name'])));
    //             $image_name = date('U').'.'.$extension;
    //             $config = [];
    //             $config['upload_path'] = $upload_path;
    //             $config['allowed_types'] = 'jpeg|jpg|png';
    //             $config['max_size'] = '2048';
    //             $config['file_name']    = $image_name;
    //             $this->CI->load->library('upload', $config);
    //             $this->CI->upload->initialize($config);

    //             if(!is_dir($upload_path)){
    //                 $oldmask = umask(0);
    //                 mkdir($upload_path, 0775);
    //                 umask($oldmask);
    //             }

    //             if (!$this->CI->upload->do_upload($field)){
    //                 return (object) ['status' => 400, 'message' => $label.' must be JPG or PNG and maximum 2 MB'];
    //             }

    //             return (object) ['status' => 200, 'image' => $image_name];
    //     }

    //     if(!$mandatory){
    //         return (object) ['status' => 201, 'image' => ''];
    //     }
    // }

    public function image($field,$upload_path,$mandatory=true,$prefix_filename='')
    {
        if( $mandatory && empty($_FILES[$field]['tmp_name'])){
            return (object) ['status' => 400, 'message' => 'Empty file'];
        }

        if( !empty($_FILES[$field]['tmp_name']) ){
                $extension = @strtolower(end(explode('.',$_FILES[$field]['name'])));
                $image_name = $prefix_filename.date('U').'.'.$extension;
                $config = [];
                $config['upload_path'] = $upload_path;
                $config['allowed_types'] = 'jpeg|jpg|png';
                $config['max_size'] = '2048';
                $config['file_name']    = $image_name;
                $this->CI->load->library('upload', $config);
                $this->CI->upload->initialize($config);

                if(!is_dir($upload_path)){
                    $oldmask = umask(0);
                    mkdir($upload_path, 0775);
                    umask($oldmask);
                }

                if (!$this->CI->upload->do_upload($field)){
                    return (object) ['status' => 400, 'message' => 'Image must be JPG or PNG and maximum 2 MB'];
                }

                return (object) ['status' => 200, 'image' => $image_name];
        }

        if(!$mandatory){
            return (object) ['status' => 201, 'image' => ''];
        }
    }

    public function pdf($field,$upload_path,$mandatory=true,$label='',$prefix='')
    {
        $label = empty($label) ? $field : $label;

        if( $mandatory && empty($_FILES[$field]['tmp_name'])){
            return (object) ['status' => 400, 'message' => 'Empty '.$label];
        }

        if( !empty($_FILES[$field]['tmp_name']) ){
                $extension = @strtolower(end(explode('.',$_FILES[$field]['name'])));
                $image_name = $prefix.date('U').'.'.$extension;
                $config = [];
                $config['upload_path'] = $upload_path;
                $config['allowed_types'] = 'pdf';
                $config['max_size'] = '5120';
                $config['file_name']    = $image_name;
                $this->CI->load->library('upload', $config);
                $this->CI->upload->initialize($config);

                if(!is_dir($upload_path)){
                    $oldmask = umask(0);
                    mkdir($upload_path, 0775);
                    umask($oldmask);
                }

                if (!$this->CI->upload->do_upload($field)){
                    return (object) ['status' => 400, 'message' => $label.' must be PDF and maximum 2 MB'];
                }

                return (object) ['status' => 200, 'pdf' => $image_name];
        }

        if(!$mandatory){
            return (object) ['status' => 201, 'pdf' => ''];
        }
    }

    public function resize($src,$dest,$width,$height,$ratio=false)
    {
        $config = [];
        $config['image_library']='gd2';
        $config['source_image']=$src;
        $config['create_thumb']= FALSE;
        $config['maintain_ratio']= $ratio;
        // $config['quality']= '50%';
        $config['width']= $width;
        $config['height']= $height;
        $config['new_image']= $dest;
        $this->CI->load->library('image_lib', $config);
        $this->CI->image_lib->resize();
    }

    public function audio($field,$upload_path,$mandatory=true,$prefix_filename='')
    {
        if( $mandatory && empty($_FILES[$field]['tmp_name'])){
            return (object) ['status' => 400, 'message' => 'Empty file'];
        }

        if( !empty($_FILES[$field]['tmp_name']) ){
                $extension = @strtolower(end(explode('.',$_FILES[$field]['name'])));
                $audio_name = $prefix_filename.date('U').'.'.$extension;
                $config = [];
                $config['upload_path'] = $upload_path;
                $config['allowed_types'] = 'mp2|mp3|mpga';
                $config['max_size'] = '10240';
                $config['file_name']    = $audio_name;
                $this->CI->load->library('upload', $config);
                $this->CI->upload->initialize($config);

                if(!is_dir($upload_path)){
                    $oldmask = umask(0);
                    mkdir($upload_path, 0775);
                    umask($oldmask);
                }

                if (!$this->CI->upload->do_upload($field)){
                    return (object) ['status' => 400, 'message' => 'Audio must be mp3 and maximum 10 MB'];
                }

                return (object) ['status' => 200, 'audio' => $audio_name];
        }

        if(!$mandatory){
            return (object) ['status' => 201, 'audio' => ''];
        }
    }
}
