<div class="page-wrapper">
  <div class="row page-titles">
    <div class="col-md-5 align-self-center">
      <h3 class="text-themecolor">Berita</h3>
    </div>
    <div class="col-md-7 align-self-center">
      <ol class="breadcrumb">
        Berita
      </ol>
    </div>
  </div>
  <div class="container-fluid">
    <?php echo $this->session->flashdata('alert'); ?>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <h4 class="card-judul">
              Data berita
              <a href="<?=base_url();?>Back_home/add_berita" class="btn btn-primary fa fa-plus-circle float-right"></a>
            </h4>
            <div class="table-responsive m-t-40">
              <table id="myTablees" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Judul</th>
                    <th>Tanggal</th>
                    <th>Berita</th>
                    <th>Option</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $no = 1; foreach($beritas->result() as $berita) { ?>
                    <tr>
                      <td><?=$no++;?>.</td>
                      <td>
                        <a href="#!" id="modalmadol" data-toggle="modal" data-target="#modal_show_berita" data-id_berita="<?=$berita->id_berita;?>" data-image="<?=$berita->image;?>" data-judul="<?=ucwords($berita->judul);?>">
                          <img src="<?=base_url('assets/frontend/berita_image/'.$berita->image);?>" alt="image" style="max-width:60px;max-height:60px">
                        </a>
                      </td>
                      <td><?=ucwords($berita->judul);?></td>
                      <td><?=$berita->tanggal;?></td>
                      <td>
                        <button id="modal_isi_berita" data-toggle="modal" data-target="#modal_show_isi_berita" data-judul="<?=$berita->judul;?>" data-isi_berita='<?=$berita->berita;?>' class="btn btn-sm btn-info">Lihat Berita</button>
                      </td>
                      <td>
                        <a href="<?=base_url('Back_home/edit_berita/'.$berita->id_berita);?>" class="btn btn-sm btn-warning fa fa-edit"></a>
                        <a href="<?=base_url();?>Back_home/delete_berita/<?=$berita->id_berita;?>/<?=$berita->image;?>" class="btn btn-sm btn-danger fa fa-trash" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')"></a>
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
<div class="modal fade" id="modal_show_berita" role="dialog">
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
    var title = $(this).data('judul');
    var berita = $(this).data('image');
    $('#nama_modal').html(title);
    $('#image_showings').html('<img class="img img-responsive" width="250" src="<?= base_url(); ?>assets/frontend/berita_image/' + berita+'" />');
  });
</script>

<div class="modal fade bs-example-modal-lg" id="modal_show_isi_berita" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><span id="judul_isi_berita"></span></h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      </div>
      <div class="modal-body">
        <div id="isi_berita"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<script>
  $(document).on('click', "#modal_isi_berita", function() {
    var judul_berita = $(this).data('judul');
    var isi_berita = $(this).data('isi_berita');
    $('#judul_isi_berita').html(judul_berita);
    $('#isi_berita').html(isi_berita);
  });
</script>