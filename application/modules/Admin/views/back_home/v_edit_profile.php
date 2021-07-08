<div class="page-wrapper">
  <div class="row page-titles">
    <div class="col-md-5 align-self-center">
      <h3 class="text-themecolor">Edit Profile</h3>
    </div>
    <div class="col-md-7 align-self-center">
      <ol class="breadcrumb">
        Edit Profile
      </ol>
    </div>
  </div>
  <div class="container-fluid">
    <?php echo $this->session->flashdata('alert'); ?>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <!-- <h4 class="card-title">Data Profile</h4> -->
            <form action="<?=base_url();?>Admin/save_edit_profile" method="post">
              <input type="hidden" name="id_profile" value="<?=$profile->id_profile;?>">
              <div class="form-group">
                <label for="title" class="control-label">Profile:</label>
                <textarea name="profile" class="form-control summernote" cols="30" rows="10"><?=$profile->profile;?></textarea>
              </div>
              <div class="form-group">
                <label for="title" class="control-label">Visi:</label>
                <textarea name="visi" class="form-control summernote" cols="30" rows="10"><?=$profile->visi;?></textarea>
              </div>
              <div class="form-group">
                <label for="title" class="control-label">Misi:</label>
                <textarea name="misi" class="form-control summernote" cols="30" rows="10"><?=$profile->misi;?></textarea>
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-6">
                    <a href="<?= base_url().'Admin/profile' ?>" class="btn btn-block btn-danger"><i class="fa fa-arrow-left"></i> Kembali</a>
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