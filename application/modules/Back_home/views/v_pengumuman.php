<div class="page-wrapper">
  <div class="row page-titles">
    <div class="col-md-5 align-self-center">
      <h3 class="text-themecolor">Pengumuman</h3>
    </div>
    <div class="col-md-7 align-self-center">
      <ol class="breadcrumb">
        Pengumuman
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
              Data Pengumuman
              <a href="#" data-toggle="modal" data-target="#modal_add_pengumuman" class="btn btn-primary fa fa-plus-circle float-right"></a>
            </h4>
            <div class="table-responsive m-t-40">
              <table id="myTablees" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Tanggal</th>
                    <th>Pengumuman</th>
                    <th>Option</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $no = 1; foreach($pengumumans->result() as $pengumuman) { ?>
                    <tr>
                      <td><?=$no++;?>.</td>
                      <td><?= date('d-m-Y', strtotime($pengumuman->tanggal))?></td> 
                      <td>
                        <button id="modal_isi_pengumuman" data-toggle="modal" data-target="#modal_show_isi_pengumuman" data-tanggal="<?=date('d M Y', strtotime($pengumuman->tanggal));?>" data-isi_pengumuman='<?=$pengumuman->pengumuman;?>' class="btn btn-sm btn-info">Lihat Pengumuman</button>
                      </td>
                      <td>
                        <a href="#" id="mek" data-id_pengumuman="<?=$pengumuman->id_pengumuman;?>" data-tanggal="<?= date('d-m-Y', strtotime($pengumuman->tanggal));?>" data-pengumuman="<?=$pengumuman->pengumuman;?>" data-toggle="modal" data-target="#modal_edit_pengumuman" class="btn btn-sm btn-warning fa fa-edit"></a>
                        <a href="<?=base_url();?>Back_home/delete_pengumuman/<?=$pengumuman->id_pengumuman;?>" class="btn btn-sm btn-danger fa fa-trash" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')"></a>
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

<!-- add pengumuman -->
<div class="modal fade" id="modal_add_pengumuman" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel1">Tanbah Pengumuman</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <form action="<?=base_url();?>Back_home/save_add_pengumuman" method="post" enctype="multipart/form-data">
        <div class="modal-body">
          <div class="form-group">
            <label for="tanggal" class="control-label">Tanggal:</label>
            <input type="text" name="tanggal" class="form-control mdate" placeholder="<?=date('d-m-Y');?>" value="<?=date('d-m-Y');?>" required>
          </div>
          <div class="form-group">
            <label for="pengumuman" class="control-label">Pengumuman:</label>
            <textarea name="pengumuman" class="form-control summernote" cols="30" rows="30" required></textarea>
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

<!-- edit pengumuman -->
<div class="modal fade" id="modal_edit_pengumuman" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel1">Edit Pengumuman</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <form id="form_edit_pengumuman">
        <div class="modal-body" id="body_mek">
          <input type="hidden" name="id_pengumuman" id="mek_id_pengumuman">
          <div class="form-group">
            <label for="tanggal" class="control-label">Tanggal:</label>
            <input type="text" name="tanggal" class="form-control mek_tanggal mdate" required>
          </div>
          <div class="form-group">
            <label for="pengumuman" class="control-label">Pengumuman:</label>
            <textarea name="pengumuman" id="mek_pengumuman" class="form-control summernote" cols="30" rows="30" required></textarea>
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
    $('#form_edit_pengumuman').trigger('reset');
    var id_pengumuman = $(this).data('id_pengumuman');
    var tanggal = $(this).data('tanggal');
    var pengumuman = $(this).data('pengumuman');
    $('#body_mek #mek_id_pengumuman').val(id_pengumuman);
    $('#body_mek .mek_tanggal').bootstrapMaterialDatePicker('setDate', tanggal);
    $('#body_mek #mek_pengumuman').summernote('code', pengumuman);
  });

  $(document).ready(function(e) {
    $('#form_edit_pengumuman').on('submit', (function(e) {
      e.preventDefault();
      $.ajax({
        url: '<?= base_url(); ?>Back_home/save_edit_pengumuman',
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


<div class="modal fade bs-example-modal-lg" id="modal_show_isi_pengumuman" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><span id="tgl_pengumuman"></span></h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      </div>
      <div class="modal-body">
        <div id="isi_pengumuman"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<script>
  $(document).on('click', "#modal_isi_pengumuman", function() {
    var tanggal = $(this).data('tanggal');
    var isi_pengumuman = $(this).data('isi_pengumuman');
    $('#tgl_pengumuman').html(tanggal);
    $('#isi_pengumuman').html(isi_pengumuman);
  });
</script>