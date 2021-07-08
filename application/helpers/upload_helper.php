<?php
if (!function_exists('upload_files')) {
    function upload_files($name_post = '', $size_file = 1024, $overwrite = false, $allow = '*', $path_file = '')
    {
        $CI = &get_instance();

        // $_FILES[$name_post]['name']     = $file_post['name'];
        // $_FILES[$name_post]['type']     = $file_post['type'];
        // $_FILES[$name_post]['tmp_name'] = $file_post['tmp_name'];
        // $_FILES[$name_post]['error']    = $file_post['error'];
        // $_FILES[$name_post]['size']     = $file_post['size'];

        $config['upload_path']      = FCPATH . $path_file;
        $config['allowed_types']    = $allow;
        $config['overwrite']        = $overwrite;
        $config['max_size']         = $size_file;
        $config['file_name']        = 'files_' . round(microtime(true) * 1000);
        $CI->load->library('upload', $config);
        if (!$CI->upload->do_upload($name_post)) {
            $res = array(
                'respons' => false,
                'data'    => $CI->upload->display_errors()
            );
        } else {
            $data_file = $CI->upload->data();
            $name_file = $data_file['file_name'];
            $res = array(
                'respons' => true,
                'data'    => $name_file
            );
        }
        return $res;
    }
}

if (!function_exists('upload_photo')) {
    function upload_photo($name_post = '', $size_file = 1024, $overwrite = false, $path_file = '', $width = '', $height = 250, $thumb = TRUE, $new_path = '')
    {
        $CI = &get_instance();

        $upload = upload_files($name_post, $size_file, $overwrite, 'jpg|jpeg|png|gif|jpg2|bmp', $path_file);
        if ($upload['respons']) {
            $file_name = $upload['data'];

            $config['image_library']    = 'gd2';
            $config['source_image']     = FCPATH . $path_file . '/' . $file_name;
            $config['new_image']        = $new_path;
            $config['create_thumb']     = $thumb;
            $config['maintain_ratio']   = TRUE;
            $config['width']            = $width;
            $config['height']           = $height;
            // $config['quality']          = 50;

            $CI->load->library('image_lib', $config);
            if (!$CI->image_lib->resize()) {
                $res = array(
                    'respons' => false,
                    'data'    => $CI->image_lib->display_errors()
                );
            } else {
                //===== Make Watermark in Picture =======
                $conf['source_image']       = FCPATH . $path_file . '/' . $file_name;
                $conf['new_image']          = FCPATH . $path_file . '/watermark/';
                $conf['wm_text']            = 'Copyright ' . date('Y') . ' - Rafho Erdeft';
                $conf['wm_type']            = 'text';
                $conf['wm_font_path']       = FCPATH . 'system/fonts/texb.ttf';
                $conf['wm_font_size']       = '16';
                $conf['wm_font_color']      = 'ffffffa6';
                // $conf['wm_shadow_color']    = 'fff000';
                $conf['wm_vrt_alignment']   = 'bottom';
                $conf['wm_hor_alignment']   = 'right';
                $conf['wm_padding']         = '-10';

                $CI->image_lib->initialize($conf);
                $CI->image_lib->watermark();
                // ======================================

                $res = array(
                    'respons' => true,
                    'data'    => $file_name
                );
            }
        } else {
            $res = array(
                'respons' => false,
                'data'    => $upload['data']
            );
        }
        return $res;
    }
}

if (!function_exists('upload_crop_photo')) {
    function upload_crop_photo($name_post = '', $size_file = 1024, $overwrite = false, $path_file = '', $width = 0, $height = 0, $x, $y)
    {
        $CI = &get_instance();

        $upload = upload_files($name_post, $size_file, $overwrite, 'jpg|jpeg|png|gif|jpg2|bmp', $path_file);
        if ($upload['respons']) {
            $file_name = $upload['data'];

            $config['image_library']    = 'gd2';
            $config['source_image']     = FCPATH . $path_file . '/' . $file_name;
            $config['new_image']        = FCPATH . $path_file . '/crop/';
            $config['create_thumb']     = FALSE;
            // $config['maintain_ratio']   = TRUE;
            $config['width']            = $width;
            $config['height']           = $height;
            $config['x_axis']           = $x;
            $config['y_axis']           = $y;

            $CI->load->library('image_lib', $config);
            $CI->image_lib->initialize($config);
            if (!$CI->image_lib->crop()) {
                $res = array(
                    'respons' => false,
                    'data'    => $CI->image_lib->display_errors()
                );
            } else {
                //===== Make Watermark in Picture =======
                $conf['source_image']       = FCPATH . $path_file . '/crop/' . $file_name;
                // $conf['new_image']          = FCPATH . $path_file . '/watermark/';
                $conf['wm_text']            = 'Copyright ' . date('Y') . ' - Rafho Erdeft';
                $conf['wm_type']            = 'text';
                $conf['wm_font_path']       = FCPATH . 'system/fonts/texb.ttf';
                $conf['wm_font_size']       = '16';
                $conf['wm_font_color']      = 'ffffffa6';
                // $conf['wm_shadow_color']    = 'fff000';
                $conf['wm_vrt_alignment']   = 'bottom';
                $conf['wm_hor_alignment']   = 'right';
                $conf['wm_padding']         = '-10';

                $CI->image_lib->initialize($conf);
                $CI->image_lib->watermark();
                // ======================================

                $res = array(
                    'respons' => true,
                    'data'    => $file_name
                );
            }
        } else {
            $res = array(
                'respons' => false,
                'data'    => $upload['data']
            );
        }
        return $res;
    }
}

function get_extension($filename)
{
    $ext = explode('.', strtolower($filename));
    $ext = '.' . end($ext);
    return $ext;
}
