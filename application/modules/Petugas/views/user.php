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
                <div class="col-md-6 align-self-center">
                    <h3 class="text-themecolor">Data User Pemilik Usaha</h3>
                </div>

                <div class="col-md-6 align-self-center">
                    <ol class="breadcrumb">
                        <!-- <label>Jenis Perlengkapan</label> -->
                        <li class="breadcrumb-item active">Data User</li>
                    </ol>
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
                        <button type="button" onclick="showModalAdd()" class="btn waves-effect waves-light btn-primary float-right"><i class="fa fa-plus"></i> Tambah User</button>
                        <br><br>
                        <hr>

                        <style type="text/css">
                            .dataTable > thead > tr > th[class*="sort"]:after{
                                content: "" !important;
                            }
                        </style>

                        <div class="table-responsive">
                            <table class="table-bordered table-striped table-hover" cellpadding="7px" width="100%">
                                <thead align="center" class="bg-megna text-white">
                                    <tr style="font-size: 11pt">
                                        <th width="5%"><b>#</b></th>
                                        <th width="20%"><b>Nama User</b></th>
                                        <th width="15%"><b>Jenis Kelamin</b></th>
                                        <th width="15%"><b>Username</b></th>
                                        <th width="15%"><b>No. HP</b></th>
                                        <th width="20%"><b>Alamat</b></th>
                                        <th width="10%"><b>Aksi</b></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $no = 0;
                                        foreach ($data_user as $usr) { 
                                            $no++;
                                    ?>
                                            <tr style="font-size: 11pt">
                                                <td align="center"><?= $numbers + $no ?></td>
                                                <td><?= $usr->nama_user ?></td>
                                                <td><?= $usr->jk_user ?></td>
                                                <td><?= $usr->username ?></td>
                                                <td><?= $usr->no_hp ?></td>
                                                <td><?= $usr->alamat_user ?></td>
                                                <td>

                                                    <div class="d-none d-sm-none d-md-block d-lg-block">
                                                        <button style="width: 35px" type="button" 
                                                            data-id="<?= $usr->id_user ?>" 
                                                            data-nama="<?= $usr->nama_user ?>" 
                                                            data-jk="<?= $usr->jk_user ?>" 
                                                            data-username="<?= $usr->username ?>" 
                                                            data-noHp="<?= $usr->no_hp ?>" 
                                                            data-almt="<?= $usr->alamat_user ?>" 
                                                            onclick="showModalEdit(this)" class="btn btn-sm waves-effect waves-light btn-info m-b-5" title="Edit Data"><i class="fa fa-pencil-square-o"></i></button>

                                                        <a href="<?= base_url().'Petugas/dataUsaha/'.encode($usr->id_user).'/'.encode($this->uri->segment(3)) ?>" style="width: 35px" class="btn btn-sm waves-effect waves-light btn-inverse m-b-5" title="Tambah Usaha"><i class="fa fa-plus"></i></a>

                                                        <button style="width: 35px" type="button" onclick="showConfirmMessage('<?= $usr->id_user ?>')" class="btn btn-sm waves-effect waves-light btn-danger m-b-5" style="width: 40px" title="Hapus Data"><i class="fa fa-trash-o"></i></button>
                                                    </div>

                                                    <div class="d-block d-sm-block d-md-none d-lg-none">
                                                        <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="fa fa-cog"></i>
                                                        </button>

                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item" href="javascript:void(0)" 
                                                                data-id="<?= $usr->id_user ?>" 
                                                                data-nama="<?= $usr->nama_user ?>" 
                                                                data-jk="<?= $usr->jk_user ?>" 
                                                                data-username="<?= $usr->username ?>" 
                                                                data-noHp="<?= $usr->no_hp ?>" 
                                                                data-almt="<?= $usr->alamat_user ?>"
                                                                onclick="showModalEdit(this)"><i class="fa fa-pencil-square-o"></i> Edit Data User</a>
                                                            <a class="dropdown-item" href="<?= base_url().'Petugas/dataUsaha/'.encode($usr->id_user).'/'.encode($this->uri->segment(3)) ?>"><i class="fa fa-plus"></i> Tambah Usaha</a>
                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="showConfirmMessage('<?= $usr->id_user ?>')"><i class="fa fa-trash-o"></i> Hapus Data User</a>
                                                            <!-- <div class="dropdown-divider"></div>
                                                            <a class="dropdown-item" href="#">Separated link</a> -->
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>

                        <br>
                        <div class="row">
                            <div style="text-decoration: none; margin: auto;">
                                <?= $pages ?>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            <!-- Modal Simpan -->
            <div id="modal-simpan" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Tambah Data User</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <form id="tambahDataUser" method="POST" action="<?= base_url().'Petugas/tambahDataUser' ?>">
                            <div class="modal-body">

                                <input type="hidden" name="id_role" id="id_role" value="<?= $id_role ?>">

                                <div class="form-group">
                                    <label for="nama_user" class="control-label">Nama User :</label>
                                    <div class="controls">
                                        <input required type="text" class="form-control" name="nama_user" id="nama_user" placeholder="Isi nama user" autocomplete="off">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="jk_user" class="control-label">Jenis Kelamin :</label>
                                    <div class="controls">
                                        <select id="jk_user" name="jk_user" class="form-control" required>
                                            <option value="" disabled selected>Pilih jenis kelamin</option>
                                            <option id="Laki-Laki" value="Laki-Laki">Laki-Laki</option>
                                            <option id="Perempuan" value="Perempuan">Perempuan</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="username" class="control-label">Username :</label>
                                    <div class="controls">
                                        <input required type="text" class="form-control" name="username" id="username" placeholder="Isi username untuk login" autocomplete="off">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="password" class="control-label">Password :</label>
                                    <div class="controls">
                                        <input required type="text" class="form-control" name="password" id="password" placeholder="Isi password untuk login" autocomplete="off">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="no_hp" class="control-label">Nomor HP :</label><br>
                                    <div class="controls">
                                        <input required type="text"  onkeypress="return inputAngka(event);" class="form-control" name="no_hp" id="no_hp" autocomplete="off">
                                    </div>
                                </div>

                                <!-- <div class="form-group">
                                    <label for="role" class="control-label">Role :</label>
                                    <div class="controls">
                                        <select id="role" name="id_role" class="form-control">
                                            <?php foreach ($data_role as $role) { ?>
                                                <option id="<?= $role->id_role ?>" value="<?=$role->id_role ?>"><?=$role->role ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div> -->

                                <div class="form-group">
                                    <label for="alamat_user" class="control-label">Alamat :</label>
                                    <textarea required class="form-control" name="alamat_user" id="alamat_user" autocomplete="off"></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-info waves-effect waves-light" id="simpan_user"><i class="fa fa-save"></i> Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal Edit -->
            <div id="modal-edit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabels" aria-hidden="true" style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Update Data User</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <form id="updateDataUser" method="POST" action="<?= base_url().'Petugas/updateDataUser/'.$this->uri->segment(3) ?>">
                            <div class="modal-body">

                                <input type="hidden" name="id_user" id="id_user">
                                <input type="hidden" name="id_role" id="id_role" value="<?= $id_role ?>">

                                <div class="form-group">
                                    <label for="nama_user" class="control-label">Nama User :</label>
                                    <div class="controls">
                                        <input required type="text" class="form-control" name="nama_user" id="nama_user" placeholder="Isi nama user" autocomplete="off">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="jk_user" class="control-label">Jenis Kelamin :</label>
                                    <div class="controls">
                                        <select id="jk_user" name="jk_user" class="form-control" required>
                                            <option value="" disabled selected>Pilih jenis kelamin</option>
                                            <option id="Laki-Laki" value="Laki-Laki">Laki-Laki</option>
                                            <option id="Perempuan" value="Perempuan">Perempuan</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="username" class="control-label">Username :</label>
                                    <div class="controls">
                                        <input required type="text" class="form-control" name="username" id="username" placeholder="Isi username untuk login" autocomplete="off">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="password" class="control-label">Password :</label>
                                    <div class="controls">
                                        <input type="text" class="form-control" name="password" id="password" placeholder="Isi password jika ingin ubah password" autocomplete="off">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="no_hp" class="control-label">Nomor HP :</label><br>
                                    <div class="controls">
                                        <input required type="text"  onkeypress="return inputAngka(event);" class="form-control" name="no_hp" id="no_hp" autocomplete="off">
                                    </div>
                                </div>

                                <!-- <div class="form-group">
                                    <label for="role" class="control-label">Role :</label>
                                    <div class="controls">
                                        <select id="role" name="id_role" class="form-control">
                                            <?php foreach ($data_role as $role) { ?>
                                                <option id="<?= $role->id_role ?>" value="<?=$role->id_role ?>"><?=$role->role ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div> -->

                                <div class="form-group">
                                    <label for="alamat_user" class="control-label">Alamat :</label>
                                    <textarea required class="form-control" name="alamat_user" id="alamat_user" autocomplete="off"></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-info waves-effect waves-light" id="simpan_user"><i class="fa fa-save"></i> Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->


        <!-- SIMPAN USER =========================================== -->
        <script type="text/javascript">
            function showModalAdd(argument) {
                $('#modal-simpan #tambahDataUser').trigger("reset");
                $('#modal-simpan').modal('show');
            }
        </script>
        <!-- ======================================================= -->

        <!-- UPDATE USER =========================================== -->
        <script type="text/javascript">

            function showModalEdit(data) {
                var id_user = $(data).attr('data-id');
                var nama_user = $(data).attr('data-nama');
                var jk_user = $(data).attr('data-jk');
                var username = $(data).attr('data-username');
                var no_hp = $(data).attr('data-noHp');
                var alamat = $(data).attr('data-almt');
                // var role = $(data).attr('data-role');

                $('#modal-edit #id_user').val(id_user);
                $('#modal-edit #nama_user').val(nama_user);
                $('#modal-edit #jk_user').val(jk_user).prop('selected',true);
                $('#modal-edit #username').val(username);
                $('#modal-edit #no_hp').val(no_hp);
                $('#modal-edit #alamat_user').val(alamat);
                // $('#modal-edit #role').val(role).prop('selected',true);
                $('#modal-edit').modal('show');
            }

        </script>
        <!-- ======================================================= -->

        <!-- HAPUS USER ================================= -->
        <script type="text/javascript">
            function showConfirmMessage(id) {
                swal({
                    title: "Anda yakin data akan dihapus?",
                    text: "Data tidak akan dapat di kembalikan lagi!!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Ya, Hapus!",
                    closeOnConfirm: false
                }, function () {
                    window.location.href = "<?=base_url().'Petugas/deleteDataUser/' ?>"+id;
                });
            }
        </script>
            