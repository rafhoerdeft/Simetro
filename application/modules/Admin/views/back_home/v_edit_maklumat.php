<div class="page-wrapper">
  <div class="row page-titles">
    <div class="col-md-5 align-self-center">
      <h3 class="text-themecolor">Edit Maklumat</h3>
    </div>
    <div class="col-md-7 align-self-center">
      <ol class="breadcrumb">
        Edit Maklumat
      </ol>
    </div>
  </div>
  <div class="container-fluid">
    <?php echo $this->session->flashdata('alert'); ?>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <!-- <h4 class="card-title">Data maklumat</h4> -->
            <form action="<?=base_url();?>Admin/save_edit_maklumat" method="post">
              <input type="hidden" name="id_maklumat" value="<?=$maklumat->id_maklumat;?>">
              <div class="form-group">
                <label for="title" class="control-label">maklumat:</label>
                <textarea name="maklumat" class="form-control summernote" cols="30" rows="10"><?=$maklumat->maklumat;?></textarea>
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-6">
                    <a href="<?= base_url().'Admin/maklumat' ?>" class="btn btn-block btn-danger"><i class="fa fa-arrow-left"></i> Kembali</a>
                  </div>
                  <div class="col-md-6">
                    <button type="submit" class="btn btn-block btn-primary"><i class="fa fa-save"></i> Simpan</button>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>