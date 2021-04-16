<?php

if( !function_exists('admin_redirect') ){
    function admin_redirect($str=''){
    	redirect(ADMIN_URL.'/'.$str);
    }
}

if ( ! function_exists('array_to_csv'))
{
    function array_to_csv($array, $download = "")
    {
        if ($download != "")
        {    
            header('Content-Type: application/csv');
            header('Content-Disposition: attachement; filename="' . $download . '"');
        }        

        ob_start();
        $f = fopen('php://output', 'w') or show_error("Can't open php://output");
        $n = 0;        
        foreach ($array as $line)
        {
            $n++;
            if ( ! fputcsv($f, $line))
            {
                show_error("Can't write line $n: $line");
            }
        }
        fclose($f) or show_error("Can't close php://output");
        $str = ob_get_contents();
        ob_end_clean();

        if ($download == "")
        {
            return $str;    
        }
        else
        {    
            echo $str;
        }        
    }
}

if ( ! function_exists('aph_keyword_url'))
{
    function aph_keyword_url($word)
    {
        $word = preg_replace('/[^a-zA-Z0-9 ]/', '', $word);
        $word = str_replace(' ', '-', strtolower($word));
        return $word;
    }
}

if ( ! function_exists('aph_site_url'))
{
    function aph_site_url($url)
    {
        if(APP_LANG=='id'){
            return site_url('id/'.$url);
        }else{
            return site_url($url);
        }
    }
}

if( !function_exists('aph_thumb') ){
    function aph_thumb($thumb) {
        if( is_file($thumb) ){
            return base_url($thumb);
        }
        return base_url('assets/images/default_thumb.jpg');
    }
}
if( !function_exists('aph_image') ){
    function aph_image($thumb) {
        if( is_file($thumb) ){
            return base_url($thumb);
        }
        return base_url('assets/images/default_image.jpg');
    }
}

if( !function_exists('aph_period') ){
    function aph_period($start_date,$end_date) {
        $start_year = date('Y', strtotime($start_date));
        $end_year = date('Y', strtotime($end_date));

        if ($start_year==$end_year) {
            return date('j M', strtotime($start_date)) ." - ". date('j M Y', strtotime($end_date));
        } else {
            return date('j M Y', strtotime($start_date)) ." - ". date('j M Y', strtotime($end_date));
        }
    }
}

if ( ! function_exists('aph_id_url'))
{
    function aph_id_url()
    {
        $uri = uri_string();
        if(mb_strlen($uri)<=2){
            return substr($uri, 2);
        }else{
            return substr($uri, 3);
        }
    }
}