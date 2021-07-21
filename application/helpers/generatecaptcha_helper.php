<?php

function acak_huruf(){
    $word='0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $string='';
        for ($i=0;$i<4;$i++){
            $pos=rand(0,strlen($word)-1);
            $string.=$word[$pos];
        }
    return $string;
}

if (!function_exists('generate_captcha')) {
    function generate_captcha($width = 150, $height = 30, $font_size = 16) {
        $CI = & get_instance();
        $CI->load->helper('captcha');
        // $word = acak_huruf();
        $vals = array(
            'img_path' 		=>'./captcha/',
            'font_path'		=> FCPATH . 'system/fonts/texb.ttf',
            // 'word'			=> $word,
            'font_size' 	=> $font_size,
            'img_url' 		=> base_url().'captcha/',
            'img_width' 	=> $width,
            'img_height' 	=> $height,
            'expiration' 	=> 7200,
            'pool'          => '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ',
            'word_length'   => 4,
            'colors'		=> array(
                                'background' => array(255, 255, 255),
                                'border' => array(195, 54, 81),
                                'text' => array(195, 54, 81),
                                'grid' => array(245, 216, 221)
                            )
        );
        $captcha = create_captcha($vals);
        
        // Unset previous captcha and set new captcha word
        $CI->session->unset_userdata('captchaCode');
        $CI->session->set_userdata('captchaCode', $captcha['word']);

        return $captcha;
        
        //echo $captcha['image'];
        //echo $captcha['word'];
    }
}