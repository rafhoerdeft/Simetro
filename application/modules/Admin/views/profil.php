        <div style="z-index: 20; top: 40%; left: 47%; position: fixed; display:none;" id="loading-show">
            <img src="<?= base_url().'assets/loading/loading3.gif' ?>" width="100">
        </div>  

        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="row page-titles">
                <div class="col-md-8 align-self-center">
                    <h3 class="text-themecolor">Data Profil User</h3>
                </div>
                <div class="col-md-4">
                </div>
                

                <!-- <div>
                    <button class="right-side-toggle waves-effect waves-light btn-inverse btn btn-circle btn-sm pull-right m-l-10"><i class="ti-settings text-white"></i></button>
                </div> -->
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">

                <?= $this->session->flashdata('alert') ?>

                <div class="row">
                    <div id="loading" class="col-md-12" style="margin-bottom: -25px; margin-top: -50px; text-align: center; display:none;">
                        <img src="<?= base_url().'assets/loading/loading1.gif' ?>" width="100" >
                    </div>
                </div>


                <div class="card">
                    <div class="card-body p-b-20">
                        <form id="simpanProfil" method="POST" action="<?= base_url().'Admin/simpanProfil' ?>">
                            <div class="modal-body">

                                <div class="form-group">
                                    <label for="nama_user" class="control-label">Nama User :</label>
                                    <div class="controls">
                                        <input required type="text" class="form-control" name="nama_user" id="nama_user" placeholder="Isi nama Anda" value="<?= $dataUser->nama_user ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="jk_user" class="control-label">Jenis Kelamin :</label>
                                    <div class="controls">
                                        <select required id="jk_user" name="jk_user" class="form-control">
                                            <option selected value="" disabled style="color: #d6d6d6">Pilih jenis kelamin</option>
                                            <option id="Laki-Laki" value="Laki-Laki" <?= ($dataUser->jk_user=='Laki-Laki'?'selected':'') ?> >Laki-Laki</option>
                                            <option id="Perempuan" value="Perempuan" <?= ($dataUser->jk_user=='Perempuan'?'selected':'') ?> >Perempuan</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- <div class="form-group">
                                    <label for="username" class="control-label">Username :</label>
                                    <div class="controls">
                                        <input required data-validation-required-message="Username harus diisi" type="text" class="form-control" name="username" id="username" placeholder="Isi username untuk login">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="password" class="control-label">Password :</label>
                                    <div class="controls">
                                        <input required data-validation-required-message="Nama user harus diisi" type="text" class="form-control" name="password" id="password" placeholder="Isi password untuk login">
                                    </div>
                                </div> -->

                                <div class="form-group">
                                    <label for="no_hp" class="control-label">Nomor HP :</label><br>
                                    <div class="controls">
                                        <input required type="text" placeholder="Ex: 085743xxxxxx" onkeypress="return inputAngka(event);" class="form-control" name="no_hp" id="no_hp" value="<?= $dataUser->no_hp ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="alamat_user" class="control-label">Alamat :</label>
                                    <div class="controls">
                                        <textarea required class="form-control" id="alamat_user" name="alamat_user" placeholder="Alamat tempat tinggal Anda"><?= $dataUser->alamat_user ?></textarea>
                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <!-- <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button> -->
                                <button type="submit" class="btn btn-info waves-effect waves-light" id="simpan_jalan"><i class="fa fa-save"></i> Simpan</button>
                            </div>
                        </form>

                    </div>
                </div>

            </div>



