<?php foreach ($head as $val) { ?>
    <link href="<?= base_url().$val ?>" rel="stylesheet">
<?php } ?>

<div id="modal_bayar" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content" style="margin: 0 -15%; width: 130%;">
            <div class="modal-header">
                <h4 class="modal-title">Pembayaran Tera/Tera Ulang UTTP</h4>
                <!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> -->
            </div>

            <div class="modal-body" id="form-print">

                <table id="tbl_bayar" class="table table-striped table-hover" style="margin: auto; font-size: 10pt">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Jenis Alat</th>
                            <th>Kapasitas</th>
                            <th>Jumlah</th>
                            <th>Tarif</th>
                            <th>Total</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php 
                            $no=0; $tot_bayar=0; 
                            foreach ($timbang as $tb) { 
                                $no++;
                                $tot_tb = $tb['tarif'] * $tb['jml_timbang'];
                                $tot_bayar += $tot_tb;
                        ?>
                            <tr>
                                <td align="center"><?= $no ?></td>
                                <td><?= $tb['jenis_alat'] ?></td>
                                <td align="left"><?= $tb['kapasitas'] ?></td>
                                <td align="right"><?= $tb['jml_timbang'] ?></td>
                                <td align="right"><?= nominal($tb['tarif']) ?></td>
                                <td align="right"><?= nominal($tot_tb) ?></td>
                            </tr>
                        <?php } ?>

                        <?php 
                            foreach ($anak_timbang as $at) { 
                                $no++;
                                $tot_at = $at['tarif'] * $at['jml_anak_timbang'];
                                $tot_bayar += $tot_at;
                        ?>
                            <tr>
                                <td align="center"><?= $no ?></td>
                                <td><?= $at['parent'] ?></td>
                                <td><?= $at['child'] ?></td>
                                <td align="right"><?= $at['jml_anak_timbang'] ?></td>
                                <td align="right"><?= nominal($at['tarif']) ?></td>
                                <td align="right"><?= nominal($tot_at) ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>

                    <tfoot>
                        <tr style="font-weight: bold;">
                            <td colspan="5">Total Bayar (Rp)</td>
                            <td id="total_bayar" align="right"><?= nominal($tot_bayar) ?></td>
                        </tr>
                    </tfoot>
                </table>

            </div>

            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button> -->

                <button type="button" class="btn btn-danger waves-effect waves-light" onclick="printForm()"><i class="fa fa-print"></i> Print</button>
            </div>
        </div>
    </div>
</div>

<?php foreach ($foot as $val) { ?>    

    <script src="<?= base_url().$val ?>"></script>

<?php } ?>


<script type="text/javascript">

    function inputAngka(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode
        // alert(charCode);
        if (charCode > 31 && (charCode < 46 || charCode > 57))

        return false;
        return true;
    }

</script>


<script type="text/javascript">
    $('#modal_bayar').modal({
        backdrop: 'static',
        keyboard: false  // to prevent closing with Esc button (if you want this too)
    })

    $(document).ready(function() {
        $('#modal_bayar').modal('show');
    });
</script>