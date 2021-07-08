<?php

	$pdf = new FPDF('P','mm','A4');
    // membuat halaman baru
    $pdf->AddPage();


    $files = array();
    $no_order = '';
    foreach ($photo as $key) {
        $no_order = $key->no_order;
        if ($key->file_surat != '-' && $key->file_surat != null && $key->file_surat != 'null') {
           $file_photo = explode(',', $key->file_surat);

            foreach ($file_photo as $x) {
                if ($x != '') {
                    $files[] = $x;
                }
            }
        }
    }

    

    $col = 20;
    $count = count($files);
    $x = 0;
    foreach ($files as $index => $val) {
        $x++;
        
        $location = base_url('assets/path_file/'.$val);

        // $pdf->SetX($pdf->GetX());

        // $pdf->Image($location,$col,$pdf->GetY() + 10,190,120);

        list($x1, $y1) = getimagesize($location);
        $x2 = $pdf->GetX();
        $y2 = $pdf->GetY();
        // if(($x1 / $x2) < ($y1 / $y2)) {
        //     $y2 = 0;
        // } else {
        //     $x2 = 0;
        // }
        $pdf->Cell(0, 0, "", 0, 1, 'C',$pdf->Image($location,0,0,210,295));

        if ($x < $count) {
            $pdf->AddPage();           
        }

    }




    $pdf->Output('D', 'Surat_Permohonan_No_Order_'.$no_order.'.pdf');
?>