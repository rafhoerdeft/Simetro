<div class="page-wrapper">
  <div class="row page-titles">
    <div class="col-md-5 align-self-center">
      <h3 class="text-themecolor">Image Carousel</h3>
    </div>
    <div class="col-md-7 align-self-center">
      <ol class="breadcrumb">
        Image Carousel
      </ol>
    </div>
  </div>
  <div class="container-fluid">
    <?php echo $this->session->flashdata('alert'); ?>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">
              Data Carousel
              <button data-toggle="modal" data-target="#modal_add_carousel" class="btn btn-primary fa fa-plus-circle float-right"></button>
            </h4>
            <div class="table-responsive m-t-40">
              <table id="myTablees" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Option</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $no = 1; foreach($carousels->result() as $carousel) { ?>
                    <tr>
                      <td><?=$no++;?>.</td>
                      <td>
                        <a href="#!" id="modalmadol" data-toggle="modal" data-target="#modal_show_carousel" data-id_image_carousel="<?=$carousel->id_image_carousel;?>" data-image="<?=$carousel->image;?>" data-title="<?=$carousel->title;?>">
                          <img src="<?=base_url('assets/frontend/carousel_image/'.$carousel->image);?>" alt="image" style="max-width:60px;max-height:60px">
                        </a>
                      </td>
                      <td><?=$carousel->title;?></td>
                      <td>
                        <a href="#" id="mek" data-id_image_carousel="<?=$carousel->id_image_carousel;?>" data-image="<?=$carousel->image;?>" data-title="<?=$carousel->title;?>" data-toggle="modal" data-target="#modal_edit_carousel" class="btn btn-sm btn-warning fa fa-edit"></a>
                        <a href="<?=base_url();?>Back_home/delete_carousel/<?=$carousel->id_image_carousel;?>/<?=$carousel->image;?>" class="btn btn-sm btn-danger fa fa-trash" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')"></a>
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script
  src="https://code.jquery.com/jquery-3.4.1.slim.min.js">
</script>
<div class="modal fade" id="modal_show_carousel" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><span id="nama_modal"></span></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <!-- <div class="modal-body" id="body_med"> -->
        <div class="text-center" id="image_showings"></div>
      <!-- </div> -->
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<script>
  $(document).on('click', "#modalmadol", function() {
    var title = $(this).data('title');
    var carousel = $(this).data('image');
    $('#nama_modal').html(title);
    $('#image_showings').html('<img class="img img-responsive" width="250" src="<?= base_url(); ?>assets/frontend/carousel_image/' + carousel+'" />');
  });
</script>

<!-- add carousel -->
<div class="modal fade" id="modal_add_carousel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel1">Add Image Carousel</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <form action="<?=base_url();?>Back_home/save_add_carousel" method="post" enctype="multipart/form-data">
        <div class="modal-body">
          <div class="form-group">
            <label for="title" class="control-label">Title:</label>
            <input type="text" name="title" class="form-control" placeholder="Ex: SiMETRO Kab. Magelang" required>
          </div>
          <div class="form-group">
            <label for="image" class="control-label">Image:</label>
            <input type="file" name="image" class="dropify" data-allowed-file-extensions="jpg png jpeg" data-height="120" required/>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- edit carousel -->
<div class="modal fade" id="modal_edit_carousel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel1">Edit carousel</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <form id="form_edit_carousel">
        <div class="modal-body" id="body_mek">
          <input type="hidden" name="id_image_carousel" id="mek_id_image_carousel">
          <div class="form-group">
            <label for="title" class="control-label">Title:</label>
            <input type="text" name="title" class="form-control" id="mek_title" placeholder="Ex: SiMETRO Kab. Magelang" required>
          </div>
          <div class="form-group">
            <label for="image" class="control-label">Image:</label>
            <input type="hidden" name="old_image" id="mek_old_image">
            <input type="file" name="image" id="mek_image" data-allowed-file-extensions="jpg png jpeg" class="dropify_modal" data-height="120" />
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  $(document).on('click', "#mek", function() {
    var id_image_carousel = $(this).data('id_image_carousel');
    var title = $(this).data('title');
    var image = $(this).data('image');
    $('#body_mek #mek_id_image_carousel').val(id_image_carousel);
    $('#body_mek #mek_title').val(title);
    $('#body_mek #mek_old_image').val(image);
    $('#body_mek #mek_old_foto').val(image);
    $('#body_mek #mek_image').attr('data-default-file', '<?= base_url("assets/frontend/carousel_image/"); ?>' + image);
    $('#body_mek .dropify-render img').attr('src', '<?= base_url("assets/frontend/carousel_image/"); ?>' + image);
    $('#body_mek .dropify_modal').dropify({
      messages: {
        'default': '<center>Seret gambar di sini.</center>',
        'error': 'Ooops, something wrong happended.'
      }
    });
  });

  $(document).ready(function(e) {
    $('#form_edit_carousel').on('submit', (function(e) {
      e.preventDefault();
      $.ajax({
        url: '<?= base_url(); ?>Back_home/save_edit_carousel',
        type: 'POST',
        data: new FormData(this),
        contentType: false,
        processData: false,
        success: function(msg) {
          $('.table').html(msg);
        }
      });
    }));
  });
</script>