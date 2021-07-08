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
                    <h3 class="text-themecolor">Terima Pengajuan</h3>
                </div>

                <div class="col-md-6 align-self-center">
                    <ol class="breadcrumb">
                        <!-- <label>Jenis Perlengkapan</label> -->
                        <li class="breadcrumb-item"><a href="<?= base_url().'Petugas/pengajuanMasuk' ?>" class="text-danger">Pengajuan Masuk</a></li>
                        <li class="breadcrumb-item active">Terima Pengajuan</li>
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

                        <!-- <form method="POST" action="<?//= base_url().'Petugas/terimaPengajuanMasuk' ?>"> -->
                            <div class="modal-body">

                                <div class="form-group">
                                    <label for="no_order" class="control-label">Nomor Order :</label>
                                    <span class="text-danger"><b><?= $dataPendaftaran->no_order ?></b></span>
                                    <input type="hidden" class="form-control" name="id_daftar" id="id_daftar" value="<?= $dataPendaftaran->id_daftar ?>">
                                </div>

                                <div class="form-group">
                                    <label for="layanan_order" class="control-label">Layanan :</label>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <input name="layanan" value="tera ulang" type="radio" id="tera_ulang" class="with-gap radio-col-red" <?= $dataPendaftaran->layanan=='tera ulang'?'checked':'disabled' ?> />
                                            <label for="tera_ulang">Tera Ulang</label>
                                        </div>

                                        <div class="col-md-4">
                                            <input name="layanan" value="tera" type="radio" id="tera" class="with-gap radio-col-indigo" <?= $dataPendaftaran->layanan=='tera'?'checked':'disabled' ?> />
                                            <label for="tera">Tera</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="layanan_order" class="control-label">Tempat Tera :</label>
                                    <div class="row">
                                        <?php $colors = array('orange','red','blue','green','black'); ?>
                                        <?php $x=0; foreach ($tempat_tera as $tmp) {?>
                                            <div class="col-md-4">
                                                <input name="tempat" value="<?= $tmp->id_tempat_tera ?>" type="radio" id="<?= str_replace(' ', '_', $tmp->tempat_tera) ?>" class="with-gap radio-col-<?= $colors[$x] ?>" data-grup="<?= $tmp->grup ?>" <?= $dataPendaftaran->id_tempat_tera==$tmp->id_tempat_tera?'checked':'disabled' ?> />
                                                <label for="<?= str_replace(' ', '_', $tmp->tempat_tera) ?>"><?= $tmp->tempat_tera ?></label>
                                            </div>
                                        <?php $x++;} ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="user" class="control-label">Pemilik Usaha :</label>
                                    <label class="text-danger"><?= $dataUser->nama_user.($dataUser->alamat_user!=null || $dataUser->alamat_user != ''?' - '.$dataUser->alamat_user:'') ?></label>
                                </div>

                                <div class="form-group">
                                    <label for="id_usaha" class="control-label">Usaha :</label>
                                    <?php foreach ($dataUsaha as $usaha) { 
                                        if ($dataPendaftaran->id_usaha==$usaha->id_usaha) { ?>
                                            <label class="text-danger">
                                                <?= $usaha->jenis_usaha.($usaha->nama_usaha != null && $usaha->nama_usaha != ''?' - '.$usaha->nama_usaha:'') ?>
                                            </label>
                                    <?php }} ?>
                                </div>

                                <style type="text/css">
                                   #tbl_tarif tbody tr:nth-child(even) {
                                        background-color: #f2f2f2
                                    }

                                    #list_tarif_pilih tbody tr:nth-child(even) {
                                        background-color: #f2f2f2
                                    }
                                </style>

                                <div id="tbl_list_tarif">
                                    <hr>
                                    <table id="list_tarif_pilih" border="1" width="100%" style="border-color: white; font-size: 10pt" cellpadding="5px">
                                        <thead align="center" class="bg-megna  text-white" style="border-color: white">
                                            <tr style="height: 40px">
                                                <th width="30%">UTTP</th>
                                                <th width="5%">Kapasitas</th>
                                                <th width="30%">Spesifikasi UTTP</th>
                                                <th width="5%">Satuan</th>
                                                <th width="5%">Jumlah</th>
                                                <!-- <th width="10%">Tarif (Rp)</th> -->
                                                <!-- <th width="10%">Total (Rp)</th> -->
                                                <th width="10%">Tarif</th>
                                                <th width="10%">Total Tarif</th>
                                                <th width="5%">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $tot_all  = 0;
                                                $ind = 0;
                                                $trf_uttp = 0;
                                                $id_tarifx = '';
                                                $id_listx = '';
                                                $jml_list  = count($listUttp);
                                                foreach ($listUttp as $list) { 
                                                    $tot_tarif = $list->tarif * $list->jumlah_uttp;
                                                    $tot_all += $tot_tarif;
                                                    $ind++;
                                                    if ($jml_list == $ind) {
                                                        $id_tarifx .= $list->id_tarifx;
                                                        $id_listx .= $list->id_list;
                                                    } else  {
                                                        $id_tarifx .= $list->id_tarifx.'-';
                                                        $id_listx .= $list->id_list.'-';
                                                    }
                                                    
                                            ?>
                                                    <tr style="height: 40px">
                                                        <input type="hidden" name="id_uttp[]" id="current_id_uttp_<?= $ind ?>" value="<?= $list->id_uttp ?>">
                                                        <input type="hidden" name="id_tarif[]" id="current_id_tarif_<?= $ind ?>" value="<?= $list->id_tarif ?>">
                                                        <input type="hidden" name="jumlah_uttp[]" id="current_jumlah_uttp_<?= $ind ?>" value="<?= $list->jumlah_uttp ?>">
                                                        <td><?= $list->jenis_alat ?></td>
                                                        <td align="center"><?= $list->kapasitas ?></td>
                                                        <td align="center"><?= ($list->jenis_tarif != '' || $list->jenis_tarif != null?'<span style="text-align: left; float: left">'.$list->jenis_tarif.'</span>':'-') ?></td>
                                                        <td align="center"><?= ($list->satuan != '' || $list->satuan != null?$list->satuan:'-') ?></td>
                                                        <td align="center"><?= $list->jumlah_uttp ?></td>
                                                        <!-- <td align="right"><?//= number_format($list->tarif,0,".",".") ?></td> -->
                                                        <!-- <td align="right"><?//= number_format($tot_tarif,0,".",".") ?></td> -->
                                                        <td align="center">
                                                            <?php if ($list->tarif != '' || $list->tarif != null) { $trf_uttp++;?>
                                                                <span style="text-align: right;"><?= number_format($list->tarif,0,".",".") ?></span>
                                                            <?php } else { ?>
                                                                <span>-</span>
                                                            <?php } ?>
                                                        </td>
                                                        <td align="right">
                                                            <?=  number_format($tot_tarif,0,".",".") ?>
                                                        </td>
                                                        <td>
                                                            <button style="width: 35px" onclick="setTarif(<?= $list->id_jenis_alat ?>, <?= $list->id_uttp ?>, <?= $list->id_list ?>, this)" type="button" class="btn btn-sm btn-danger" data-alat="<?= $list->jenis_alat ?>" title="Atur Tarif"><i class="fa fa-gear"></i></button>
                                                        </td>
                                                    </tr>
                                            <?php } ?>
                                            <input type="hidden" name="jml_current_list" id="jml_current_list" value="<?= $ind ?>">
                                        </tbody>
                                        <tfoot>
                                            <tr class="bg-megna text-white" style="border-color: white; height: 40px">
                                                <td align="center" colspan="6" style="font-weight: bold">Total Bayar</td>
                                                <td align="right"  style="font-weight: bold"><?= number_format($tot_all,0,".",".") ?></td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                                <!-- <div id="data_uttp">
                                    <input type="hidden" name="select_id_uttp" id="select_id_uttp">

                                </div> -->

                                <div id="total_tarif" class="m-t-30">

                                </div>

                            </div>

                            <hr class="m-l-20 m-r-20">

                            <!-- <div class="row p-20">
                                <div class="col-md-6"></div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-6"> </div>
                                        <div class="col-md-6" style="text-align: right;">
                                            <button type="button" onclick="cekTarif()" class="btn bg-megna btn-block waves-effect waves-light text-white float-right">
                                                <i class="fa">(Rp)</i> 
                                                Cek Total Bayar
                                            </button>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div> -->

                            <div class="row p-20 float-right d-block d-sm-block d-md-none d-lg-none">
                                <div class="col-md-6">
                                    <a href="<?= base_url('Petugas/pengajuanMasuk') ?>" class="btn btn-danger waves-effect m-r-5"><i class="fa fa-arrow-left"></i></a>
                                    <!-- <button type="reset" onclick="resetAll()" class="btn btn-warning waves-effect m-r-5"><i class="fa fa-undo"></i></button> -->
                                    <button type="button" onclick="terimaPengajuan(<?= $dataPendaftaran->id_daftar ?>, <?= $trf_uttp ?>, <?= $ind ?>, this)" data-tarif="<?= $id_tarifx ?>" data-list="<?= $id_listx ?>" class="btn btn-info waves-effect waves-light" id="simpan_jalan"><i class="fa fa-check"></i></button>
                                </div>
                            </div>

                            <div class="row p-20">                             

                                <input type="hidden" id="jml_group_uttp" name="jml_group_uttp" value="0">

                                <div class="col-md-6 m-b-5">
                                    <!-- <button type="button" onclick="addUttp()" class="btn btn-warning waves-effect waves-light"><i class="fa fa-plus"></i> <span class="d-none d-sm-none d-md-block d-lg-block float-right m-l-5">Tambah Tera UTTP</span></button> -->
                                </div>

                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-4 m-b-5" style="text-align: right;">
                                            
                                        </div>
                                        <div class="col-md-4 m-b-5" style="text-align: right;">
                                            <a href="<?= base_url('Petugas/pengajuanMasuk') ?>" class="btn btn-danger waves-effect waves-light btn-block d-none d-sm-none d-md-block d-lg-block"><i class="fa fa-arrow-left"></i> Kembali</a>
                                        </div>
                                        
                                        <div class="col-md-4 m-b-5" style="text-align: right;">
                                            <button type="button" onclick="terimaPengajuan(<?= $dataPendaftaran->id_daftar ?>, <?= $trf_uttp ?>, <?= $ind ?>, this)" data-tarif="<?= $id_tarifx ?>" data-list="<?= $id_listx ?>" class="btn btn-info waves-effect waves-light btn-block d-none d-sm-none d-md-block d-lg-block" id="simpan_jalan"><i class="fa fa-check"></i> Terima</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                
                        <!-- </form> -->

                    </div>
                </div>

            </div>

            <!-- Modal Set Tarif -->
            <div id="modal-set" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Atur Tarif UTTP <span id="nama_uttp"></span></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <form id="setTarifUttp" method="POST" action="<?= base_url().'Petugas/setTarifUttp' ?>">
                            <div class="modal-body">

                                <input type="hidden" name="id_daftar" id="id_daftar" value="<?= $dataPendaftaran->id_daftar ?>">
                                <input type="hidden" name="id_uttp" id="id_uttp">
                                <input type="hidden" name="id_list" id="id_list">

                                <div id="data_uttp">
                                    <!-- <input type="hidden" name="select_id_uttp" id="select_id_uttp"> -->
                                    <div id="uttp-1">

                                        <div class="row">
                                            <div class="col-md-12" id="retribusi-1"></div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12" id="retribusi-2"></div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12" id="retribusi-3"></div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12" id="retribusi-4"></div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12" id="listTarif"></div>
                                        </div>

                                        <div id="input_id_tera"></div>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-info waves-effect waves-light" id="save">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->


        <!-- Fungsi Dialog -->
        <script type="text/javascript">
            //These codes takes from http://t4t5.github.io/sweetalert/
            function showBasicMessage() {
                swal("Here's a message!");
            }

            function showWithTitleMessage() {
                swal("Here's a message!", "It's pretty, isn't it?");
            }

            function validasiMessage(text){
                swal({
                    title: "Dilarang!",
                    text: text,
                    type: "error",
                    timer: 1000,
                    showConfirmButton: false
                });
            }

            function showSuccessMessage(input) {
                swal({
                    title: input+"!",
                    text: "Data Berhasil "+input+"!",
                    type: "success",
                    timer: 1000,
                    showConfirmButton: false
                });
            }

            function showFailedMessage(input) {
                swal({
                    title: "Gagal!",
                    text: input,
                    type: "error",
                    timer: 1000,
                    showConfirmButton: false
                });
            }

            function showCancelMessage() {
                swal({
                    title: "Are you sure?",
                    text: "You will not be able to recover this imaginary file!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "No, cancel plx!",
                    closeOnConfirm: false,
                    closeOnCancel: false
                }, function (isConfirm) {
                    if (isConfirm) {
                        swal("Deleted!", "Your imaginary file has been deleted.", "success");
                    } else {
                        swal("Cancelled", "Your imaginary file is safe :)", "error");
                    }
                });
            }
        </script>

        <script type="text/javascript">
            function resetAll(argument) {
                // removeAllUttp(0);
                // $('#group_tot_bayar').remove();
                location.reload();
            }

            function setTarif(id_jenis_alat='', id_uttp='', id_list='', data) {

                var nama_uttp = $(data).attr('data-alat');
                    
                $("#loading-show").fadeIn("slow");

                $.post("<?= base_url().'Petugas/getDataTarif' ?>", {id_jenis_alat:id_jenis_alat}, function(result){
                    $("#loading-show").fadeIn("slow").delay(20).slideUp('slow');

                    var dt = JSON.parse(result);
                    console.log(dt.data);

                    if (dt.response) {

                        $('#modal-set #uttp-1 #listTarif #list_tarif_1').remove();
                        $('#modal-set #uttp-1 #input_id_tera input').remove();
                        for (var i = 1; i < 5; i++) {
                            $('#modal-set #uttp-1 #retribusi-'+i+' #group_tarif_'+i).remove();
                        }

                        var selectTarif =   '<div class="form-group" id="group_tarif_1">'+
                                                '<label for="tarif_1" class="control-label">Tarif Retribusi Layanan Tera UTTP :</label>'+
                                                '<select required id="tarif_1" name="tarif_1[]" class="form-control" onchange="changeTarif(this)">'+
                                                    '<option selected value="" disabled style="color: #d6d6d6">Pilih jenis UTTP</option>'+
                                                '</select>'+
                                            '</div>';

                        $('#modal-set #uttp-1 #retribusi-1').html(selectTarif);

                        var opt = '';
                        for (var i = 0; i < dt.data.length; i++) {
                            opt += '<option data-parentId="'+dt.data[i].parent_id+'" data-childId="'+dt.data[i].child_id+'" value="'+dt.data[i].id_tarif+'">'+dt.data[i].jenis_tarif+'</option>';
                        }

                        $('#modal-set #uttp-1 #retribusi-1 #tarif_1').append(opt);

                        $('#modal-set #id_uttp').val(id_uttp);
                        $('#modal-set #id_list').val(id_list);
                        $('#modal-set #nama_uttp').html('('+nama_uttp+')');
                        $('#modal-set').modal('show');
                        // $('#group_tot_bayar').remove();
                        // $('#'+uttp_group+' #retribusi-1 #tarif').selectpicker('refresh');
                    }
                });

            }

            function changeTarif(data) {
                var uttp_group = $(data).parent().parent().parent().parent().attr('id');
                var id_group = uttp_group.split("-");
                var retrif = $(data).parent().parent().attr('id');
                var id_retrif = retrif.split("-");

                // alert(id_group);
                var tarif = $('#'+uttp_group+' #tarif_'+id_retrif[1]).val();
                if (tarif != '') {
                    // alert(parseInt(id_retrif[1])+1);
                    var child_id = $('#'+uttp_group+' #tarif_'+id_retrif[1]+' option:selected').attr('data-childId');
                    var parent_id = $('#'+uttp_group+' #tarif_'+id_retrif[1]+' option:selected').attr('data-parentId');
                    var id_tarif = $('#'+uttp_group+' #tarif_'+id_retrif[1]+' option:selected').attr('value');

                    subTarif(id_tarif, parent_id, child_id, uttp_group, parseInt(id_group[1]), parseInt(id_retrif[1]));
                }
            }

            function subTarif(id_tarif='', parent_id='', child_id='', uttp_group='', id_group='', id_retrif='') {
                var new_id_retrif = id_retrif+1;
                $("#loading-show").fadeIn("slow");

                $.post("<?= base_url().'Petugas/getListTarif' ?>", {id_tarif:id_tarif, parent_id:parent_id, child_id:child_id}, function(result){
                    $("#loading-show").fadeIn("slow").delay(20).slideUp('slow');

                    var dt = JSON.parse(result);
                    // console.log(dt.data);


                    if (dt.response) {
                        $('#group_tot_bayar').remove();
                        $('#'+uttp_group+' #listTarif #list_tarif_'+id_group).remove();
                        $('#'+uttp_group+' #input_id_tera input').remove();
                        for (var i = new_id_retrif; i < 5; i++) {
                            $('#'+uttp_group+' #retribusi-'+i+' #group_tarif_'+i).remove();
                        }

                        if (child_id == '0') {

                            var nama_jenis_tarif = dt.data[0].jenis_tarif;
                            var accord = '<div id="list_tarif_'+id_group+'" class="accordion m-b-30" role="tablist" aria-multiselectable="true">'+
                                            '<div class="card">'+
                                                '<a data-toggle="collapse" data-parent="#list_tarif_'+id_group+'" href="#select_tarif_'+id_group+'" aria-expanded="true" aria-controls="collapseOne">'+
                                                    '<div class="card-header bg-info" role="tab" id="headingOne">'+
                                                        '<h5 class="mb-0 text-white">'+
                                                             'Tarif '+nama_jenis_tarif+
                                                        '</h5>'+
                                                    '</div>'+
                                                '</a>'+
                                                '<div id="select_tarif_'+id_group+'" class="collapse show" role="tabpanel" aria-labelledby="headingOne">'+
                                                    '<div class="card-body" id="content_tarif">'+
                                                        'Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et.'+
                                                    '</div>'+
                                                '</div>'+
                                            '</div>'+
                                        '</div>';

                            $('#'+uttp_group+' #listTarif').html(accord);

                            var tbl_tarif = '<table id="tbl_tarif" border="1" width="100%" style="border-color: white; font-size: 10pt" cellpadding="5px">'+
                                                '<thead align="center" class="bg-megna  text-white" style="border-color: white">'+
                                                    '<tr>'+
                                                        '<th rowspan="3">Spesifikasi UTTP</th>'+
                                                        '<th rowspan="3">Satuan</th>'+
                                                        '<th colspan="4">Tarif</th>'+
                                                    '</tr>'+
                                                    '<tr>'+
                                                        '<th colspan="2">Tera</th>'+
                                                        '<th colspan="2">Tera Ulang</th>'+
                                                    '</tr>'+
                                                    '<tr>'+
                                                        '<th>Kantor (Rp)</th>'+
                                                        '<th>Tempat Pakai (Rp)</th>'+
                                                        '<th>Kantor (Rp)</th>'+
                                                        '<th>Tempat Pakai (Rp)</th>'+
                                                    '</tr>'+
                                                '</thead>'+
                                                '<tbody>'+
                                                    
                                                '</tbody>'+
                                            '</table>';

                            $('#'+uttp_group+' #listTarif #list_tarif_'+id_group+' #content_tarif').html(tbl_tarif);

                            var tera_kantor = dt.data[0].tera_kantor.toString();
                            var tera_tempat_pakai = dt.data[0].tera_tempat_pakai.toString();
                            var tera_ulang_kantor = dt.data[0].tera_ulang_kantor.toString();
                            var tera_ulang_tempat_pakai = dt.data[0].tera_ulang_tempat_pakai.toString();
                            var pilihTarif = '<tr style="height: 45px">'+
                                                '<td>'+dt.data[0].jenis_tarif+'</td>'+
                                                '<td align="center" width="10%">'+dt.data[0].satuan+'</td>'+
                                                '<td align="right" width="12%">'+formatRupiah(tera_kantor, 'Rp.')+'</td>'+
                                                '<td align="right" width="12%">'+formatRupiah(tera_tempat_pakai, 'Rp.')+'</td>'+
                                                '<td align="right" width="12%">'+formatRupiah(tera_ulang_kantor, 'Rp.')+'</td>'+
                                                '<td align="right" width="12%">'+formatRupiah(tera_ulang_tempat_pakai, 'Rp.')+'</td>'+
                                            '</tr>';

                            $('#'+uttp_group+' #listTarif #list_tarif_'+id_group+' #content_tarif #tbl_tarif tbody').html(pilihTarif);

                            $('#'+uttp_group+' #input_id_tera').html('<input type="hidden" id="id_tarif_'+id_group+'" name="id_tarif[]" value="'+dt.data[0].id_tarif+'">');

                        } else {

                            var selectTarif =   '<div class="form-group" id="group_tarif_'+new_id_retrif+'">'+
                                                    '<label for="tarif_'+new_id_retrif+'" class="control-label">Sub Tarif '+id_retrif+' :</label>'+
                                                    '<select required id="tarif_'+new_id_retrif+'" name="tarif_'+new_id_retrif+'[]" class="form-control" onchange="changeTarif(this)">'+
                                                        '<option selected value="" disabled style="color: #d6d6d6">Pilih jenis layanan UTTP</option>'+
                                                    '</select>'+
                                                '</div>';

                            $('#'+uttp_group+' #retribusi-'+new_id_retrif).html(selectTarif);

                            var opt = '';
                            for (var i = 0; i < dt.data.length; i++) {
                                opt += '<option data-parentId="'+dt.data[i].parent_id+'" data-childId="'+dt.data[i].child_id+'" value="'+dt.data[i].id_tarif+'">'+dt.data[i].jenis_tarif+'</option>';
                            }

                            $('#'+uttp_group+' #retribusi-'+new_id_retrif+' #tarif_'+new_id_retrif).append(opt);
                        }
                    }
                });
            }

            function addUttp(argument) {
                var count = $('#jml_group_uttp').val();
                var nextCount = parseInt(count) + 1;
                var id_usaha = $('#modal-set #setTarifUttp #id_usaha').val();
                // alert(count);

                var id_uttp_first = $('#uttp-'+count+' #id_uttp').val();
                var cur_jml = $('#list_tarif_pilih #jml_current_list').val();

                if (cur_jml === undefined) {
                    if (id_uttp_first === undefined) {
                        id_uttp_xxx = 0;
                    } else {
                         id_uttp_xxx = id_uttp_first;
                    }
                } else {
                    id_uttp_xxx = cur_jml;
                }


                if (id_uttp_xxx != null) {

                    //SET ID UTTP yang sudah dipilih
                    var uttp_id = '';
                    if (id_uttp_xxx != 0) {

                        var ono = 0;
                        if (id_uttp_first !== undefined) {
                            for (var i = 1; i <= count; i++) {
                                var idUttp = $('#uttp-'+i+' #id_uttp').val();
                                if (i == count) {
                                    uttp_id += idUttp;
                                } else {
                                    uttp_id += idUttp+',';
                                }
                            }
                            ono++;
                        }

                        if (cur_jml !== undefined) {
                            var long = $("#list_tarif_pilih").find("input[name='id_uttp[]']").length;
                            $("#list_tarif_pilih").find("input[name='id_uttp[]']").each(function (i) {
                                var z = i + 1;
                                var current_id_uttp = $(this).val();
                                // console.log('TRY', z);
                                if (ono > 0) {
                                    uttp_id += ','+current_id_uttp;
                                } else {
                                    if (z == long) {
                                        uttp_id += current_id_uttp;
                                    } else {
                                        uttp_id += current_id_uttp+',';
                                    }
                                }
                            });
                        }

                        $('#select_id_uttp').val(uttp_id);
                    } else {
                        $('#select_id_uttp').val(0);
                    }

                    // alert($('#select_id_uttp').val());

                    var select_id_uttp = $('#select_id_uttp').val();
                    if (select_id_uttp == '') {
                        select_id_uttp = 0;
                    }

                    $("#loading-show").fadeIn("slow");

                    $.post("<?= base_url().'Petugas/getDataUttp' ?>", {select_id_uttp:select_id_uttp, id_usaha:id_usaha}, function(result){
                        $("#loading-show").fadeIn("slow").delay(20).slideUp('slow');

                        var dt = JSON.parse(result);
                        // console.log(dt.response);


                        if (dt.response) {
                            //SET JML GROUP YG SUDAH DITAMBAHKAN
                            $('#jml_group_uttp').val(nextCount);

                            var groupUttp = '<div id="uttp-'+nextCount+'">'+
                                                // '<div class="row">'+
                                                //     '<div class="col-md-6"></div>'+
                                                //     '<div class="col-md-6">'+
                                                //         '<button onclick="removeUttp(this)" type="button" class="btn btn-danger btn-sm waves-effect waves-light float-right" style="margin-bottom: -10px; width: 30px" title="Hapus">X</button>'+
                                                //     '</div>'+
                                                // '</div>'+
                                                '<hr>'+
                                                '<div class="row">'+
                                                    '<div class="form-group col-md-8">'+
                                                        '<label for="id_uttp" class="control-label">Pilih UTTP/Alat :</label>'+
                                                        '<select required id="id_uttp" name="id_uttp[]" class="form-control" onchange="changeUttp(this)">'+
                                                            '<option selected value="" disabled style="color: #d6d6d6">Pilih UTTP/Alat yang akan ditera</option>'+
                                                        '</select>'+
                                                    '</div>'+

                                                    '<div class="form-group col-md-4">'+
                                                        '<label for="jumlah_uttp" class="control-label">Jumlah :</label>'+
                                                        '<input required type="text" class="form-control" name="jumlah_uttp[]" id="jumlah_uttp" placeholder="Isi jumlah UTTP" onkeypress="return inputAngka(event);">'+
                                                    '</div>'+
                                                '</div>'+

                                                '<div class="row">'+
                                                    '<div class="col-md-12" id="retribusi-1"></div>'+
                                                '</div>'+

                                                '<div class="row">'+
                                                    '<div class="col-md-12" id="retribusi-2"></div>'+
                                                '</div>'+

                                                '<div class="row">'+
                                                    '<div class="col-md-12" id="retribusi-3"></div>'+
                                                '</div>'+

                                                '<div class="row">'+
                                                    '<div class="col-md-12" id="retribusi-4"></div>'+
                                                '</div>'+

                                                '<div class="row">'+
                                                    '<div class="col-md-12" id="listTarif"></div>'+
                                                '</div>'+

                                                '<div id="input_id_tera"></div>'+
                                            '</div>';

                            $('#modal-set #setTarifUttp .modal-body #data_uttp').append(groupUttp);

                            // if (count != 0) {
                            //     let exit = '<div class="row">'+
                            //                     '<div class="col-md-6"></div>'+
                            //                     '<div class="col-md-6">'+
                            //                         '<button onclick="removeUttp(this)" type="button" class="btn btn-danger btn-sm waves-effect waves-light float-right" style="margin-bottom: -10px; width: 30px" title="Hapus">X</button>'+
                            //                     '</div>'+
                            //                 '</div>';

                            //     $('#modal-set #setTarifUttp .modal-body #data_uttp #uttp-'+nextCount).prepend(exit);

                            // }

                            var opt = '';
                            for (var i = 0; i < dt.data.length; i++) {
                                opt += '<option data="'+dt.data[i].id_jenis_alat+'" value="'+dt.data[i].id_uttp+'">'+dt.data[i].jenis_alat+'</option>';
                            }

                            $('#uttp-'+nextCount+' #id_uttp').append(opt);
                            $('#group_tot_bayar').remove();
                        } else {
                            alert('Data UTTP sudah dipilih semua!');
                        }

                    });
                } else {
                    alert('Pilih dahulu UTTP sebelumnya jika ingin menambahkan tera UTTP lain');
                }
                
            }

            function removeAllUttp(id_first=0) {
                var count = $('#jml_group_uttp').val();
                for (var i = id_first; i <= count; i++) {
                    if (i > id_first) {
                        $('#uttp-'+i).remove();
                        var xx = $('#jml_group_uttp').val();
                        $('#jml_group_uttp').val(parseInt(xx)-1);
                    }
                }
            }

            function removeUttp(data) {
                var count = $('#jml_group_uttp').val();
                $('#jml_group_uttp').val(parseInt(count)-1);

                $(data).parent().parent().parent().remove();
                $('#group_tot_bayar').remove();
            }

            function cekTarif(argument) {
                var count = $('#jml_group_uttp').val();
                var layanan = $("#modal-set #setTarifUttp input[type='radio'][name='layanan']:checked").val();
                var tempat = $("#modal-set #setTarifUttp input[type='radio'][name='tempat']:checked").attr('data-grup');
                var usaha = $('#id_usaha').val();
                var cur_jml = $('#list_tarif_pilih #jml_current_list').val();

                if (usaha != null) {

                    var id_tarif = '';
                    var counter_tarif = 0;
                    if (count != 0) {
                        for (var i = 1; i <= count; i++) {
                            var idTarif = $('#id_tarif_'+i).val();
                            if (idTarif === undefined) {
                                alert('UTTP dan tarif ke-'+i+' belum dipilih!');
                            } else {
                                counter_tarif++;
                                if (i == count) {
                                    id_tarif += idTarif;
                                } else {
                                    id_tarif += idTarif+',';
                                }
                            }
                        }
                    }

                    var long_trf = $("#list_tarif_pilih").find("input[name='id_tarif[]']").length;
                    $("#list_tarif_pilih").find("input[name='id_tarif[]']").each(function (i) {
                        var v = i + 1;
                        var current_id_trf = $(this).val();
                        // console.log('TRY', v);
                        if (counter_tarif > 0) {
                            id_tarif += ','+current_id_trf;
                        } else {
                            if (v == long_trf) {
                                id_tarif += current_id_trf;
                            } else {
                                id_tarif += current_id_trf+',';
                            }
                        }
                    });


                    if (counter_tarif == count) {
                        var uttp_id = '';
                        var ono1 = 0;
                        if (count != 0) {
                            for (var i = 1; i <= count; i++) {
                                var idUttp = $('#uttp-'+i+' #id_uttp').val();
                                if (i == count) {
                                    uttp_id += idUttp;
                                } else {
                                    uttp_id += idUttp+',';
                                }
                                ono1++;
                            }
                        }

                        var jml_uttp = '';
                        var counter_jml = 0;
                        for (var i = 1; i <= count; i++) {
                            var jmlUttp = $('#uttp-'+i+' #jumlah_uttp').val();

                            if (jmlUttp !== '') {
                                counter_jml++;
                                if (i == count) {
                                    jml_uttp += jmlUttp;
                                } else {
                                    jml_uttp += jmlUttp+',';
                                }
                            } else {
                                alert('Jumlah UTTP ke-'+i+' belum diisi!');
                            }
                           
                        }

                        if (cur_jml !== undefined) {
                            var long = $("#list_tarif_pilih").find("input[name='id_uttp[]']").length;
                            $("#list_tarif_pilih").find("input[name='id_uttp[]']").each(function (i) {
                                var z = i + 1;
                                var current_id_uttp = $(this).val();
                                // console.log('TRY', z);
                                if (ono1 > 0) {
                                    uttp_id += ','+current_id_uttp;
                                } else {
                                    if (z == long) {
                                        uttp_id += current_id_uttp;
                                    } else {
                                        uttp_id += current_id_uttp+',';
                                    }
                                }
                            });

                            var long_jumlah = $("#list_tarif_pilih").find("input[name='jumlah_uttp[]']").length;
                            $("#list_tarif_pilih").find("input[name='jumlah_uttp[]']").each(function (i) {
                                var y = i + 1;
                                var current_jml_uttp = $(this).val();
                                // console.log('TRY', y);
                                if (counter_jml > 0) {
                                    jml_uttp += ','+current_jml_uttp;
                                } else {
                                    if (y == long_jumlah) {
                                        jml_uttp += current_jml_uttp;
                                    } else {
                                        jml_uttp += current_jml_uttp+',';
                                    }
                                }
                            });
                        }


                        if (counter_jml == count) {

                            $("#loading-show").fadeIn("slow");

                            $.post("<?= base_url().'Petugas/cekTarif' ?>", {id_tarif:id_tarif, uttp_id:uttp_id, jml_uttp:jml_uttp, layanan:layanan, tempat:tempat}, function(result){
                                $("#loading-show").fadeIn("slow").delay(20).slideUp('slow');

                                var dt = JSON.parse(result);
                                // console.log(dt.data);

                                if (dt.response) {
                                    var tbl_total = '<div id="group_tot_bayar">'+  
                                                        '<hr>'+
                                                        '<h4>Total Bayar</h4>'+
                                                        '<table id="tbl_tarif" border="1" width="100%" style="border-color: white; font-size: 10pt" cellpadding="5px">'+
                                                            '<thead align="center" class="bg-megna  text-white" style="border-color: white">'+
                                                                '<tr style="height: 40px">'+
                                                                    '<th width="20%">UTTP</th>'+
                                                                    '<th width="25%">Spesifikasi UTTP</th>'+
                                                                    '<th width="5%">Satuan</th>'+
                                                                    '<th width="10%">Layanan</th>'+
                                                                    '<th width="10%">Tempat</th>'+
                                                                    '<th width="5%">Jumlah</th>'+
                                                                    '<th width="10%">Tarif (Rp)</th>'+
                                                                    '<th width="10%">Total (Rp)</th>'+
                                                                '</tr>'+
                                                            '</thead>'+
                                                            '<tbody></tbody>'+
                                                            '<tfoot></tfoot>'+
                                                        '</table>'+
                                                    '</div>';

                                    $('#modal-set #setTarifUttp #total_tarif').html(tbl_total);

                                    var list_total = '';
                                    var total_all_tarif = 0;
                                    for (var i = 0; i < dt.data.length; i++) {
                                        var trf = dt.data[i].tarif.toString();
                                        var tot_trf = dt.data[i].tot_tarif.toString();
                                        list_total += '<tr style="height: 40px">'+
                                                            '<td>'+dt.data[i].jenis_alat+'</td>'+
                                                            '<td>'+dt.data[i].jenis_tarif+'</td>'+
                                                            '<td align="center">'+dt.data[i].satuan+'</td>'+
                                                            '<td align="center">'+dt.data[i].layanan+'</td>'+
                                                            '<td align="center">'+dt.data[i].tempat+'</td>'+
                                                            '<td align="center">'+dt.data[i].jumlah+'</td>'+
                                                            '<td align="right">'+formatRupiah(trf, 'Rp.')+'</td>'+
                                                            '<td align="right">'+formatRupiah(tot_trf, 'Rp.')+'</td>'+
                                                        '</tr>';
                                        total_all_tarif += dt.data[i].tot_tarif;
                                    }

                                    var tot_byr = total_all_tarif.toString();

                                    var total_bayar =   '<tr class="bg-megna text-white" style="border-color: white; height: 40px">'+
                                                            '<td align="center" colspan="7" style="font-weight: bold">Total Bayar</td>'+
                                                            '<td align="right"  style="font-weight: bold">'+formatRupiah(tot_byr, 'Rp.')+'</td>'+
                                                        '</tr>';

                                    $('#total_tarif #tbl_tarif tbody').html(list_total);

                                    $('#total_tarif #tbl_tarif tfoot').html(total_bayar);
                                }

                            });

                            // alert(id_tarif);
                        }
                        
                    }
                } else {
                    alert('Pilih usaha Anda terlebih dahulu!');
                }
                
            }

            function batalSimpan(argument) {
                swal({
                    title: "Batalkan?",
                    text: "Anda ingin membatalkan ubah data pengajuan?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Ya, Batalkan!",
                    closeOnConfirm: false
                }, function () {
                    location = "<?= base_url().'Petugas/dataTera' ?>";
                });
            }

            function removeCurrentList(data) {
                var cur_jml = $('#list_tarif_pilih #jml_current_list').val();

                if (cur_jml > 1) {
                    $(data).parent().parent().remove();
                    $('#list_tarif_pilih #jml_current_list').val(parseInt(cur_jml)-1);
                } else {
                    $(data).parent().parent().parent().parent().parent().remove();
                    // removeAllUttp(1);
                    // $('#group_tot_bayar').remove();
                    // $('#modal-set #setTarifUttp').trigger('reset');
                }
                
            }

            function terimaPengajuan(id='', count='', count_all='', data) {
                var id_tarif = $(data).attr('data-tarif');
                var id_list = $(data).attr('data-list');
                // alert(count);
                if (count == count_all) {
                    swal({
                        title: "Terima Pengajuan",
                        text: "Terima pengajuan tera ini?",
                        type: "info",
                        showCancelButton: true,
                        confirmButtonColor: "#38a80c",
                        confirmButtonText: "Ya, Terima!",
                        closeOnConfirm: false
                    }, function () {
                        window.location.href = "<?=base_url().'Petugas/terimaPengajuanMasuk/' ?>"+id+'/'+id_tarif+'/'+id_list;
                    });
                } else {
                    alert('Atur tarif semua UTTP dahulu!');
                }
                
                // window.location.href = "<?//=base_url().'Petugas/showTerimaPengajuan/' ?>"+id;
            }

            // $('#modal-set #setTarifUttp').on('submit', function(e){
            //     e.preventDefault();
            //     alert('id');
            // });
        </script>

        <script type="text/javascript">
            // rupiah2.value = formatRupiah(this.value, 'Rp. ');
            /* Fungsi formatRupiah */
            function formatRupiah(angka, prefix){
                var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split           = number_string.split(','),
                sisa            = split[0].length % 3,
                rupiah          = split[0].substr(0, sisa),
                ribuan          = split[0].substr(sisa).match(/\d{3}/gi);
     
                // tambahkan titik jika yang di input sudah menjadi angka ribuan
                if(ribuan){
                    separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }
     
                rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                return prefix == undefined ? rupiah : (rupiah ? rupiah : '');
            }
        </script>


        <!-- SIMPAN USER =========================================== -->
        <script type="text/javascript">
            function showModalAdd(argument) {
                $('#modal-simpan #tambahDataUser').trigger("reset");
                $('#modal-simpan').modal('show');
            }
        </script>
        <!-- ======================================================= -->
