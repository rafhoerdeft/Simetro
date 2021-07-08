<?php

defined('BASEPATH') or exit('No direct script access allowed');



class Back_home extends CI_Controller

{



  function __construct()

  {

    parent::__construct();

    $this->load->model('MasterData');

    $this->load->library('session');

    $this->load->helper('alert');

    $this->load->helper('encrypt');

    $this->load->helper('uang');

    $this->load->helper('terbilang');

    $this->load->helper('tanggal');

    // $this->sms = $this->load->database('sms', TRUE);



    // if ($this->session->userdata('role') != 'Admin') {

    //   redirect('Auth');

    // }



    date_default_timezone_set('Asia/Jakarta');



    $this->id_user = $this->session->userdata('id_user');



    $this->head = array(

      "assets/assets/plugins/bootstrap/css/bootstrap.min.css",

      "assets/assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css",

      "assets/assets/plugins/clockpicker/dist/jquery-clockpicker.min.css",

      // "assets/assets/plugins/morrisjs/morris.css",

      "assets/assets/plugins/dropify/dist/css/dropify.min.css",

      "assets/main/css/style.css",

      "assets/main/css/colors/yellow.css",

    );





    $this->foot = array(

      "assets/assets/plugins/jquery/jquery.min.js",

      "assets/assets/plugins/bootstrap/js/popper.min.js",

      "assets/assets/plugins/bootstrap/js/bootstrap.min.js",

      "assets/main/js/jquery.slimscroll.js",

      "assets/main/js/waves.js",

      "assets/main/js/sidebarmenu.js",

      "assets/assets/plugins/sticky-kit-master/dist/sticky-kit.min.js",

      "assets/main/js/custom.min.js",

      "assets/assets/plugins/moment/moment.js",

      "assets/assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js",

      "assets/assets/plugins/clockpicker/dist/jquery-clockpicker.min.js",

      "assets/main/js/validation.js",

      "assets/assets/plugins/datatables/jquery.dataTables.min.js",

      "assets/assets/plugins/dropify/dist/js/dropify.min.js",

      "assets/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js",

      // "assets/assets/plugins/sparkline/jquery.sparkline.min.js",

      // "assets/assets/plugins/raphael/raphael-min.js",

      // "assets/assets/plugins/morrisjs/morris.min.js",

      "assets/assets/plugins/styleswitcher/jQuery.style.switcher.js"

    );

  }



  public function index() {

    $script = [

      "$('#myTablees').DataTable();",

      "$(document).ready(function() {

        $('.dropify').dropify({

    

          messages: {

            'default': '<center>Seret gambar di sini.</center>',

            'error': 'Ooops, something wrong happended.'

          }

        });

      });",

    ];

    $head['head'] = $this->head;

    $foot = [

			'foot'    => $this->foot,

			'script'  => $script,

    ];

    $nav['menu'] = 'carousel';



    $data = [

      'carousels' => $this->MasterData->getData('carousel_image'),

    ];



    $this->load->view('head', $head);

    $this->load->view('Back_home/navigation', $nav);

    $this->load->view('Back_home/v_image_carousel', $data);

    $this->load->view('foot', $foot);

  }



  public function save_add_carousel() {

    $post = $this->input->post();

    $title  = $post['title'];

    if (!empty($_FILES['image']['name'])) {

      $upload = $this->_do_upload(null, 'carousel_image');

      $image = $upload;

    }



    $query = $this->MasterData->inputData([

      'title' => $title,

      'image' => $image,

    ], 'carousel_image');



    if ($query) {

      $sess['alert'] = alert_success('Data berhasil ditambahkan.');

      $this->session->set_flashdata($sess);

      ?>

        <script>

          window.location = "<?= base_url('Back_home'); ?>";

        </script>

      <?php

          } else {

            $sess['alert'] = alert_failed('Tambah data gagal.');

            $this->session->set_flashdata($sess);

            ?>

        <script>

          window.location = "<?= base_url('Back_home'); ?>";

        </script>

      <?php

    }

  }



  public function save_edit_carousel() {

    $post = $this->input->post();

    $id_image_carousel = $post['id_image_carousel'];

    $title = $post['title'];



    if (!empty($_FILES['image']['name'])) {

      $upload = $this->_do_upload(null, 'carousel_image');

      $filename = $post['old_image'];

      unlink(FCPATH . "assets/frontend/carousel_image/$filename");

      $image = $upload;

    }

    else

    {

      $image = $post['old_image'];

    }



    $query = $this->MasterData->editData(

      [

        'id_image_carousel'=>$id_image_carousel

      ], 

      [

        'title' => $title,

        'image' => $image

      ], 

      'carousel_image'

    );

    if ($query) {

      $sess['alert'] = alert_success('Data berhasil diupdate.');

      $this->session->set_flashdata($sess);

      ?>

        <script>

          window.location = "<?= base_url('Back_home'); ?>";

        </script>

      <?php

          } else {

            $sess['alert'] = alert_failed('Update data gagal.');

            $this->session->set_flashdata($sess);

            ?>

        <script>

          window.location = "<?= base_url('Back_home'); ?>";

        </script>

      <?php

    }

  }



  public function delete_carousel($id_image_carousel, $image) {

    $query = $this->MasterData->deleteData(['id_image_carousel'=>$id_image_carousel], 'carousel_image');

    if ($query) {

      unlink(FCPATH . "assets/frontend/carousel_image/$image");

      $sess['alert'] = alert_success('Data berhasil dihapus.');

      $this->session->set_flashdata($sess);

      ?>

        <script>

          window.location = "<?= base_url('Back_home'); ?>";

        </script>

      <?php

          } else {

            $sess['alert'] = alert_failed('Hapus data gagal.');

            $this->session->set_flashdata($sess);

            ?>

        <script>

          window.location = "<?= base_url('Back_home'); ?>";

        </script>

      <?php

    }

  }



  private function _do_upload($url=null, $path=null) {

    $config['upload_path']     = './assets/frontend/'.$path;

    $config['allowed_types']   = 'jpeg|jpg|png';

    // $config['max_size']        = 2048;

    $config['file_name']       = round(microtime(true) * 1000);



    $this->load->library('upload', $config);

    if (!$this->upload->do_upload('image')) {

      $sess['alert'] = alert_failed('Update data gagal.');

      $this->session->set_flashdata($sess);

      ?>

        <script>

          window.location = "<?= base_url('Back_home/'.$url); ?>";

        </script>

      <?php

    }

    return $this->upload->data('file_name');

  }



  public function profile() {

    $css_link = [

      "http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.css",

    ];



    $js_link = [

      "http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.js",

    ];



    $script = [

      "$('#myTablees').DataTable();",

    ];

    $head = [

      'head'  => $this->head,

      'css_link' => $css_link,

    ];

      

    $foot = [

			'foot'    => $this->foot,

      'script'  => $script,

      'js_link' => $js_link,

    ];

    $nav['menu'] = 'profile';



    $data = [

      'profiles' => $this->MasterData->getData('profile')->row(),

    ];



    $this->load->view('head', $head);

    $this->load->view('Back_home/navigation', $nav);

    $this->load->view('Back_home/v_profile', $data);

    $this->load->view('foot', $foot);

  }



  public function edit_profile($id_profile) {

    $css_link = [

      "http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.css",

    ];



    $js_link = [

      "http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.js",

    ];



    $script = [

      "$(document).ready(function() {

          $('.summernote').summernote();

      });"

    ];



    $head = [

      'head'  => $this->head,

      'css_link' => $css_link,

    ];

      

    $foot = [

			'foot'    => $this->foot,

      'js_link' => $js_link,

      'script'  => $script,

    ];



    $nav['menu'] = 'profile';



    $data = [

      'profile' => $this->MasterData->getDataWhere('profile', ['id_profile'=>$id_profile])->row(),

    ];



    $this->load->view('head', $head);

    $this->load->view('Back_home/navigation', $nav);

    $this->load->view('Back_home/v_edit_profile', $data);

    $this->load->view('foot', $foot);

  }



  public function save_edit_profile() {

    $post = $this->input->post();

    $id_profile = $post['id_profile'];

    $profile  = $post['profile'];

    $visi     = $post['visi'];

    $misi     = $post['misi'];



    $query = $this->MasterData->editData(

      ['id_profile'=>$id_profile],

      [

        'profile' => $profile,

        'visi'    => $visi,

        'misi'    => $misi,

      ], 'profile'

    );



    if ($query) {

      $sess['alert'] = alert_success('Data berhasil diedit.');

      $this->session->set_flashdata($sess);

      ?>

        <script>

          window.location = "<?= base_url('Back_home/profile'); ?>";

        </script>

      <?php

          } else {

            $sess['alert'] = alert_failed('Update data gagal.');

            $this->session->set_flashdata($sess);

            ?>

        <script>

          window.location = "<?= base_url('Back_home/profile'); ?>";

        </script>

      <?php

    }

  }



  public function berita() {

    $script = [

      "$('#myTablees').DataTable();",

      "$(document).ready(function() {

        $('.dropify').dropify({

    

          messages: {

            'default': '<center>Seret gambar di sini.</center>',

            'error': 'Ooops, something wrong happended.'

          }

        });

      });",

    ];

    $head['head'] = $this->head;

    $foot = [

			'foot'    => $this->foot,

			'script'  => $script,

    ];

    $nav['menu'] = 'berita';



    $data = [

      'beritas' => $this->MasterData->getSelectDataOrder('*','berita','id_berita','DESC'),

    ];



    $this->load->view('head', $head);

    $this->load->view('Back_home/navigation', $nav);

    $this->load->view('Back_home/v_berita', $data);

    $this->load->view('foot', $foot);

  }



  public function add_berita() {

    $css_link = [

      "http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.css",

    ];



    $js_link = [

      "http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.js",

    ];



    $script = [

      "$(document).ready(function() {

          $('.summernote').summernote({

            height: 150,

          });

      });",

      "$('#mdate').bootstrapMaterialDatePicker({ weekStart: 0, time: false });",

      "$(document).ready(function() {

        $('.dropify').dropify({

    

          messages: {

            'default': '<center>Seret gambar di sini.</center>',

            'error': 'Ooops, something wrong happended.'

          }

        });

      });",

    ];



    $head = [

      'head'  => $this->head,

      'css_link' => $css_link,

    ];

      

    $foot = [

			'foot'    => $this->foot,

      'js_link' => $js_link,

      'script'  => $script,

    ];



    $nav['menu'] = 'berita';



    $data = [

      'berita' => 'berita',

    ];



    $this->load->view('head', $head);

    $this->load->view('Back_home/navigation', $nav);

    $this->load->view('Back_home/v_add_berita', $data);

    $this->load->view('foot', $foot);

  }



  public function edit_berita($id_berita) {

    $css_link = [

      "http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.css",

    ];



    $js_link = [

      "http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.js",

    ];



    $script = [

      "$(document).ready(function() {

          $('.summernote').summernote({

            height: 200,

          });

      });",

      "$('#mdate').bootstrapMaterialDatePicker({ weekStart: 0, time: false });",

      "$(document).ready(function() {

        $('.dropify').dropify({

    

          messages: {

            'default': '<center>Seret gambar di sini.</center>',

            'error': 'Ooops, something wrong happended.'

          }

        });

      });",

    ];



    $head = [

      'head'  => $this->head,

      'css_link' => $css_link,

    ];

      

    $foot = [

			'foot'    => $this->foot,

      'js_link' => $js_link,

      'script'  => $script,

    ];



    $nav['menu'] = 'berita';



    $data = [

      'berita' => $this->MasterData->getDataWhere('berita', ['id_berita'=>$id_berita])->row(),

    ];



    $this->load->view('head', $head);

    $this->load->view('Back_home/navigation', $nav);

    $this->load->view('Back_home/v_edit_berita', $data);

    $this->load->view('foot', $foot);

  }



  public function save_add_berita() {

    $post = $this->input->post();

    $judul    = $post['judul'];

    $tanggal  = $post['tanggal'];

    $berita   = $post['berita'];

    

    if (!empty($_FILES['image']['name'])) {

      $upload = $this->_do_upload('add_berita', 'berita_image');

      $image = $upload;

    }



    $query = $this->MasterData->inputData([

      'judul'   => $judul,

      'tanggal' => $tanggal,

      'berita'  => $berita,

      'image'   => $image,

    ], 'berita');



    if ($query) {

      $sess['alert'] = alert_success('Data berhasil ditambahkan.');

      $this->session->set_flashdata($sess);

      ?>

        <script>

          window.location = "<?= base_url('Back_home/berita'); ?>";

        </script>

      <?php

          } else {

            $sess['alert'] = alert_failed('Tambah data gagal.');

            $this->session->set_flashdata($sess);

            ?>

        <script>

          window.location = "<?= base_url('Back_home/berita'); ?>";

        </script>

      <?php

    }

  }



  public function save_edit_berita() {

    $post = $this->input->post();

    $id_berita= $post['id_berita'];

    $judul    = $post['judul'];

    $tanggal  = $post['tanggal'];

    $berita   = $post['berita'];



    if (!empty($_FILES['image']['name'])) {

      $upload = $this->_do_upload('berita', 'berita_image');

      $filename = $post['old_image'];

      unlink(FCPATH . "assets/frontend/berita_image/$filename");

      $image = $upload;

    }

    else

    {

      $image = $post['old_image'];

    }



    $query = $this->MasterData->editData(

      [

        'id_berita'=>$id_berita

      ], 

      [

        'judul'   => $judul,

        'tanggal' => $tanggal,

        'berita'  => $berita,

        'image'   => $image,

      ], 

      'berita'

    );

    if ($query) {

      $sess['alert'] = alert_success('Data berhasil diupdate.');

      $this->session->set_flashdata($sess);

      ?>

        <script>

          window.location = "<?= base_url('Back_home/berita'); ?>";

        </script>

      <?php

          } else {

            $sess['alert'] = alert_failed('Update data gagal.');

            $this->session->set_flashdata($sess);

            ?>

        <script>

          window.location = "<?= base_url('Back_home/berita'); ?>";

        </script>

      <?php

    }

  }



  public function delete_berita($id_berita, $image) {

    $query = $this->MasterData->deleteData(['id_berita'=>$id_berita], 'berita');

    if ($query) {

      unlink(FCPATH . "assets/frontend/berita_image/$image");

      $sess['alert'] = alert_success('Data berhasil dihapus.');

      $this->session->set_flashdata($sess);

      ?>

        <script>

          window.location = "<?= base_url('Back_home/berita'); ?>";

        </script>

      <?php

          } else {

            $sess['alert'] = alert_failed('Hapus data gagal.');

            $this->session->set_flashdata($sess);

            ?>

        <script>

          window.location = "<?= base_url('Back_home/berita'); ?>";

        </script>

      <?php

    }

  }



  public function pengumuman() {

    $css_link = [

      "http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.css",

    ];



    $js_link = [

      "http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.js",

    ];



    $script = [

      "$(document).ready(function() {

          $('.summernote').summernote({

            height: 200,

            placeholder: 'Isi pengumuman...',

          });

      });",

      "$('.mdate').bootstrapMaterialDatePicker({ format: 'DD-mm-YYYY', weekStart: 0, time: false });",

      "$(document).ready(function() {

        $('.dropify').dropify({

    

          messages: {

            'default': '<center>Seret gambar di sini.</center>',

            'error': 'Ooops, something wrong happended.'

          }

        });

      });",

    ];



    $head = [

      'head'  => $this->head,

      'css_link' => $css_link,

    ];

      

    $foot = [

			'foot'    => $this->foot,

      'js_link' => $js_link,

      'script'  => $script,

    ];

    $nav['menu'] = 'pengumuman';



    $data = [

      'pengumumans' => $this->MasterData->getSelectDataOrder('*', 'pengumuman', 'tanggal', 'desc'),

    ];



    $this->load->view('head', $head);

    $this->load->view('Back_home/navigation', $nav);

    $this->load->view('Back_home/v_pengumuman', $data);

    $this->load->view('foot', $foot);

  }



  public function save_add_pengumuman() {

    $post = $this->input->post();

    $tanggal  = date('Y-m-d', strtotime($post['tanggal']));

    $pengumuman = $post['pengumuman'];

    

    $query = $this->MasterData->inputData([

      'tanggal'   => $tanggal,

      'pengumuman' => $pengumuman,

    ], 'pengumuman');



    if ($query) {

      $sess['alert'] = alert_success('Data berhasil ditambahkan.');

      $this->session->set_flashdata($sess);

      ?>

        <script>

          window.location = "<?= base_url('Back_home/pengumuman'); ?>";

        </script>

      <?php

          } else {

            $sess['alert'] = alert_failed('Tambah data gagal.');

            $this->session->set_flashdata($sess);

            ?>

        <script>

          window.location = "<?= base_url('Back_home/pengumuman'); ?>";

        </script>

      <?php

    }



  }



  public function save_edit_pengumuman() {

    $post = $this->input->post();

    $id_pengumuman  = $post['id_pengumuman'];

    $tanggal        = $post['tanggal'];

    $pengumuman     = $post['pengumuman'];

    

    $query = $this->MasterData->editData(

      [

        'id_pengumuman'=>$id_pengumuman

      ], 

      [

        'tanggal'     => $tanggal,

        'pengumuman'  => $pengumuman,

      ], 'pengumuman'

    );



    if ($query) {

      $sess['alert'] = alert_success('Data berhasil diedit.');

      $this->session->set_flashdata($sess);

      ?>

        <script>

          window.location = "<?= base_url('Back_home/pengumuman'); ?>";

        </script>

      <?php

          } else {

            $sess['alert'] = alert_failed('Edit data gagal.');

            $this->session->set_flashdata($sess);

            ?>

        <script>

          window.location = "<?= base_url('Back_home/pengumuman'); ?>";

        </script>

      <?php

    }



  }



  public function delete_pengumuman($id_pengumuman) {

    $query = $this->MasterData->deleteData(['id_pengumuman'=>$id_pengumuman], 'pengumuman');

    if ($query) {

      $sess['alert'] = alert_success('Data berhasil dihapus.');

      $this->session->set_flashdata($sess);

      ?>

        <script>

          window.location = "<?= base_url('Back_home/pengumuman'); ?>";

        </script>

      <?php

          } else {

            $sess['alert'] = alert_failed('Hapus data gagal.');

            $this->session->set_flashdata($sess);

            ?>

        <script>

          window.location = "<?= base_url('Back_home/pengumuman'); ?>";

        </script>

      <?php

    }

  }



  public function maklumat() {

    $css_link = [

      "http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.css",

    ];



    $js_link = [

      "http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.js",

    ];



    $script = [

      "$('#myTablees').DataTable();",

    ];

    $head = [

      'head'  => $this->head,

      'css_link' => $css_link,

    ];

      

    $foot = [

			'foot'    => $this->foot,

      'script'  => $script,

      'js_link' => $js_link,

    ];

    $nav['menu'] = 'maklumat';



    $data = [

      'maklumats' => $this->MasterData->getData('maklumat')->row(),

    ];



    $this->load->view('head', $head);

    $this->load->view('Back_home/navigation', $nav);

    $this->load->view('Back_home/v_maklumat', $data);

    $this->load->view('foot', $foot);

  }



  public function edit_maklumat($id_maklumat) {

    $css_link = [

      "http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.css",

    ];



    $js_link = [

      "http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.js",

    ];



    $script = [

      "$(document).ready(function() {

          $('.summernote').summernote();

      });"

    ];



    $head = [

      'head'  => $this->head,

      'css_link' => $css_link,

    ];

      

    $foot = [

			'foot'    => $this->foot,

      'js_link' => $js_link,

      'script'  => $script,

    ];



    $nav['menu'] = 'maklumat';



    $data = [

      'maklumat' => $this->MasterData->getDataWhere('maklumat', ['id_maklumat'=>$id_maklumat])->row(),

    ];



    $this->load->view('head', $head);

    $this->load->view('Back_home/navigation', $nav);

    $this->load->view('Back_home/v_edit_maklumat', $data);

    $this->load->view('foot', $foot);

  }



  public function save_edit_maklumat() {

    $post = $this->input->post();

    $id_maklumat = $post['id_maklumat'];

    $maklumat  = $post['maklumat'];



    $query = $this->MasterData->editData(

      ['id_maklumat'=>$id_maklumat],

      [

        'maklumat' => $maklumat,

      ], 'maklumat'

    );



    if ($query) {

      $sess['alert'] = alert_success('Data berhasil diedit.');

      $this->session->set_flashdata($sess);

      ?>

        <script>

          window.location = "<?= base_url('Back_home/maklumat'); ?>";

        </script>

      <?php

          } else {

            $sess['alert'] = alert_failed('Update data gagal.');

            $this->session->set_flashdata($sess);

            ?>

        <script>

          window.location = "<?= base_url('Back_home/maklumat'); ?>";

        </script>

      <?php

    }

  }







}

