<?php 
	

	// Panggil class PHPExcel nya
	$excel = new PHPExcel();

	// Settingan awal fil excel
	$excel->getProperties()->setCreator('DISKOMINFO')
							->setLastModifiedBy('Erdeft')
							->setTitle("Cetak Laporan Setor Bulan ".$dataBulan[$selectBulan].' Tahun '.$selectTahun)
							->setSubject("Tera/Tera Ulang UTTP")
							->setDescription("Laporan Setor Bulanan")
							->setKeywords("Laporan Setor Bulanan");

	// Buat sebuah variabel untuk menampung pengaturan style dari header tabel
	$style_title1 = array(
		'font' => array(
			'name'  => 'Arial',
	      	'bold' => TRUE,
	      	'size' => (11)
		),
		'alignment' => array(
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
			'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		)
		// 'fill' => array(
  //           'type' => PHPExcel_Style_Fill::FILL_SOLID,
  //           'color' => array('rgb' => 'ffffff')
  //       )
	);

	// $style_title2 = array(
	// 	'font' => array(
	// 		'name'  => 'Times New Roman',
	//       	'bold' => FALSE,
	//       	'size' => (10)
	// 	),
	// 	'alignment' => array(
	// 		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
	// 		'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
	// 	),
	// 	'fill' => array(
 //            'type' => PHPExcel_Style_Fill::FILL_SOLID,
 //            'color' => array('rgb' => 'ffffff')
 //        )
	// );

	$style_header1 = array(
		'font' => array(
			'name'  => 'Arial',
	      	'bold' => TRUE,
	      	'size' => (11)
		),
		'alignment' => array(
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
			'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		),
		'borders' => array(
			'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
			// 'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
			'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THICK), // Set border bottom dengan garis tipis
			'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		)
		// 'fill' => array(
  //           'type' => PHPExcel_Style_Fill::FILL_SOLID,
  //           'color' => array('rgb' => '91cef2')
  //       )
	);
	$style_header2 = array(
		'font' => array(
			'name'  => 'Arial',
	      	'bold' => TRUE,
	      	'size' => (11)
		),
		'alignment' => array(
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
			'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		),
		'borders' => array(
			'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
			'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
			'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THICK), // Set border bottom dengan garis tipis
			'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		)
		// 'fill' => array(
  //           'type' => PHPExcel_Style_Fill::FILL_SOLID,
  //           'color' => array('rgb' => '91cef2')
  //       )
	);

	$style_foot1 = array(
		'font' => array(
			'name'  => 'Arial',
	      	'bold' => TRUE,
	      	'size' => (11)
		),
		'alignment' => array(
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
			'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		),
		'borders' => array(
			'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
			// 'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
			'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
			'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		)
		// 'fill' => array(
  //           'type' => PHPExcel_Style_Fill::FILL_SOLID,
  //           'color' => array('rgb' => '91cef2')
  //       )
	);

	$style_foot2 = array(
		'font' => array(
			'name'  => 'Arial',
	      	'bold' => TRUE,
	      	'size' => (11)
		),
		'alignment' => array(
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, // Set text jadi ditengah secara horizontal (center)
			'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		),
		'borders' => array(
			'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
			'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
			'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
			'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		)
		// 'fill' => array(
  //           'type' => PHPExcel_Style_Fill::FILL_SOLID,
  //           'color' => array('rgb' => '91cef2')
  //       )
	);

	$style_body1 = array(
		'font' => array(
			'name'  => 'Calibri',
	      	'bold' => FALSE,
	      	'size' => (12)
		),
		'alignment' => array(
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
			'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		),
		'borders' => array(
			// 'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
			'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
			'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
			'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		)
		// 'fill' => array(
  //           'type' => PHPExcel_Style_Fill::FILL_SOLID,
  //           'color' => array('rgb' => 'ffffff')
  //       )
	);

	$style_body2 = array(
		'font' => array(
			'name'  => 'Calibri',
	      	'bold' => FALSE,
	      	'size' => (12)
		),
		'alignment' => array(
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
			'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		),
		'borders' => array(
			// 'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
			'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
			// 'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
			'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		)
		// 'fill' => array(
  //           'type' => PHPExcel_Style_Fill::FILL_SOLID,
  //           'color' => array('rgb' => 'ffffff')
  //       )
	);

	$style_body3 = array(
		'font' => array(
			'name'  => 'Calibri',
	      	'bold' => FALSE,
	      	'size' => (12)
		),
		'alignment' => array(
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, // Set text jadi ditengah secara horizontal (center)
			'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		),
		'borders' => array(
			// 'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
			'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
			'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
			'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		)
		// 'fill' => array(
  //           'type' => PHPExcel_Style_Fill::FILL_SOLID,
  //           'color' => array('rgb' => 'ffffff')
  //       )
	);

	$style_body4 = array(
		'font' => array(
			'name'  => 'Calibri',
	      	'bold' => FALSE,
	      	'size' => (12)
		),
		'alignment' => array(
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, // Set text jadi ditengah secara horizontal (center)
			'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		),
		'borders' => array(
			// 'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
			'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
			// 'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
			'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		)
		// 'fill' => array(
  //           'type' => PHPExcel_Style_Fill::FILL_SOLID,
  //           'color' => array('rgb' => 'ffffff')
  //       )
	);

	$style_body5 = array(
		'font' => array(
			'name'  => 'Calibri',
	      	'bold' => FALSE,
	      	'size' => (12)
		),
		'alignment' => array(
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, // Set text jadi ditengah secara horizontal (center)
			'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		),
		'borders' => array(
			// 'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
			'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
			'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
			'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		)
		// 'fill' => array(
  //           'type' => PHPExcel_Style_Fill::FILL_SOLID,
  //           'color' => array('rgb' => 'ffffff')
  //       )
	);

	$style_body6 = array(
		'font' => array(
			'name'  => 'Calibri',
	      	'bold' => FALSE,
	      	'size' => (12)
		),
		'alignment' => array(
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, // Set text jadi ditengah secara horizontal (center)
			'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		),
		'borders' => array(
			// 'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
			'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
			// 'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
			'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		)
		// 'fill' => array(
  //           'type' => PHPExcel_Style_Fill::FILL_SOLID,
  //           'color' => array('rgb' => 'ffffff')
  //       )
	);



	// $objDrawing = new PHPExcel_Worksheet_Drawing();
	// $objDrawing->setName('Aset');
	// $objDrawing->setDescription('Kode Aset');
	// $objDrawing->setPath('assets/images/print logo.png');
	// $excel->getActiveSheet()->mergeCells('A1:B3');
	// $objDrawing->setCoordinates('A1');                      
	// //setOffsetX works properly
	// $objDrawing->setOffsetX(12.5); 
	// // $objDrawing->setOffsetY(5);                
	// //set width, height
	// $objDrawing->setWidth(70); 
	// $objDrawing->setHeight(70); 
	// $objDrawing->setWorksheet($excel->getActiveSheet());
	
	// TITLE
	$excel->getActiveSheet()->mergeCells('A1:E1');
	$excel->setActiveSheetIndex(0)->setCellValue('A1', "DAFTAR PENYETORAN UANG RETRIBUSI TERA/TERA ULANG");
	$excel->setActiveSheetIndex(0)->getStyle('A1')->getAlignment()->setWrapText(true);

	$excel->getActiveSheet()->mergeCells('A2:E2');
	$excel->setActiveSheetIndex(0)->setCellValue('A2', "BULAN ".strtoupper($dataBulan[$selectBulan])." TAHUN ".$selectTahun);
	$excel->setActiveSheetIndex(0)->getStyle('A2')->getAlignment()->setWrapText(true);

	// Apply style 
	$excel->getActiveSheet()->getStyle('A1:E1')->applyFromArray($style_title1);
	$excel->getActiveSheet()->getStyle('A2:E2')->applyFromArray($style_title1);

	$row_first = 4;

	if ($selectPasar != '') {
		$row_first = 5;
		if ($selectPasar > 0) {
			$nama_pasar = '';
			foreach ($dataPasar as $psr) {
				if ($psr->id_pasar == $selectPasar) {
					$nama_pasar = $psr->nama_pasar;
				}
			}
			$excel->getActiveSheet()->mergeCells('A3:E3');
			$excel->setActiveSheetIndex(0)->setCellValue('A3', strtoupper($nama_pasar));
			$excel->setActiveSheetIndex(0)->getStyle('A3')->getAlignment()->setWrapText(true);
			$excel->getActiveSheet()->getStyle('A3:E3')->applyFromArray($style_title1);
		} else {
			$row_first = 4;
		}
	}

	// $first = date('d-m-Y',strtotime($tgl_awal));
	// $last = date('d-m-Y',strtotime($tgl_akhir));

	// $excel->getActiveSheet()->mergeCells('A3:K3');
	// $excel->setActiveSheetIndex(0)->setCellValue('A3', "Tanggal: ".$first." s/d ".$last);
	// $excel->setActiveSheetIndex(0)->getStyle('A3')->getAlignment()->setWrapText(true);
	

	// BARIS HEADER
	$excel->setActiveSheetIndex(0)->setCellValue('A'.$row_first, "NO");
	$excel->setActiveSheetIndex(0)->getStyle('A'.$row_first)->getAlignment()->setWrapText(true);

	$excel->setActiveSheetIndex(0)->setCellValue('B'.$row_first, "TANGGAL");
	$excel->setActiveSheetIndex(0)->getStyle('B'.$row_first)->getAlignment()->setWrapText(true);

	$excel->setActiveSheetIndex(0)->setCellValue('C'.$row_first, "RINCIAN SETORAN");
	$excel->setActiveSheetIndex(0)->getStyle('C'.$row_first)->getAlignment()->setWrapText(true);

	$excel->setActiveSheetIndex(0)->setCellValue('D'.$row_first, "JUMLAH (Rp)");
	$excel->setActiveSheetIndex(0)->getStyle('D'.$row_first)->getAlignment()->setWrapText(true);

	$excel->setActiveSheetIndex(0)->setCellValue('E'.$row_first, "SUB TOTAL (Rp)");
	$excel->setActiveSheetIndex(0)->getStyle('E'.$row_first)->getAlignment()->setWrapText(true);

	// Apply style 
	$excel->getActiveSheet()->getStyle('A'.$row_first)->applyFromArray($style_header1);
	$excel->getActiveSheet()->getStyle('B'.$row_first)->applyFromArray($style_header1);
	$excel->getActiveSheet()->getStyle('C'.$row_first)->applyFromArray($style_header1);
	$excel->getActiveSheet()->getStyle('D'.$row_first)->applyFromArray($style_header1);
	$excel->getActiveSheet()->getStyle('E'.$row_first)->applyFromArray($style_header2);

	// Set Repeat Header
	$excel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1,4);

	// Set width kolom
	$excel->getActiveSheet()->getColumnDimension('A')->setWidth(4.85);
	$excel->getActiveSheet()->getColumnDimension('B')->setWidth(19);
	$excel->getActiveSheet()->getColumnDimension('C')->setWidth(48.10);
	$excel->getActiveSheet()->getColumnDimension('D')->setWidth(19.5);
	$excel->getActiveSheet()->getColumnDimension('E')->setWidth(19.5);

	$excel->getActiveSheet()->getRowDimension($row_first)->setRowHeight(36.5);


	// BARIS BODY / ISI DATA
    $xx = 0;
	$no = 0;
	$row = $row_first + 1;
	$tot_tarif_show = 0;
	$jml_all_data = count($dataSetor);
	$tot_setor = 0;
	foreach ($dataSetor as $setor) { 
		$no++;
		// $tgl_masuk = date('d-m-Y', strtotime($setor->tgl_masuk));
		$excel->setActiveSheetIndex(0)->setCellValue('A'.$row, $no);

		$tgl = date('d', strtotime($setor->tgl_bayar));
		$bln = $dataBulan[date('m', strtotime($setor->tgl_bayar))];
		$thn = date('Y', strtotime($setor->tgl_bayar));

		$excel->setActiveSheetIndex(0)->setCellValue('B'.$row, $tgl.' '.$bln.' '.$thn);

		// Apply style
		$excel->getActiveSheet()->getStyle('A'.$row)->applyFromArray($style_body2);
		$excel->getActiveSheet()->getStyle('B'.$row)->applyFromArray($style_body2);
		// $excel->getActiveSheet()->getStyle('C'.$row)->applyFromArray($style_body4);
		$excel->getActiveSheet()->getStyle('D'.$row)->applyFromArray($style_body6);
		$excel->getActiveSheet()->getStyle('E'.$row)->applyFromArray($style_body6);

		$tot_tarif = 0;
		$jml_list = 0;
		$row_rincian = $row;
		$row_sblm = $row_rincian - 1;


        foreach ($dataOrder as $order) {
            if ($order->tgl_bayar == $setor->tgl_bayar) {

            	$name = '';
            	if ($order->nama_usaha!=null && $order->nama_usaha!='') {
            		$name = $order->nama_user.' / '.$order->nama_usaha;
            	} else {
            		$name = $order->nama_user;
            	}

                $excel->setActiveSheetIndex(0)->setCellValue('C'.$row_rincian, $name);

            	$excel->getActiveSheet()->getStyle('A'.$row_rincian)->applyFromArray($style_body2);
				$excel->getActiveSheet()->getStyle('B'.$row_rincian)->applyFromArray($style_body2);
				$excel->getActiveSheet()->getStyle('C'.$row_rincian)->applyFromArray($style_body4);
				$excel->getActiveSheet()->getStyle('D'.$row_rincian)->applyFromArray($style_body6);
				$excel->getActiveSheet()->getStyle('E'.$row_rincian)->applyFromArray($style_body6);
                

                foreach ($dataBayar as $byr) {
                    if ($byr['id_daftar'] == $order->id_daftar) {

                    	$row_rincian++;
                    	$xx++;

                    	$excel->setActiveSheetIndex(0)->setCellValue('C'.$row_rincian, '- '.$byr['uttp'].' - '.$byr['jenis_tarif'].' x '.$byr['jml_uttp']);
                    	$excel->getActiveSheet()->getStyle('C')->getAlignment()->setWrapText(true);

                    	$excel->setActiveSheetIndex(0)->setCellValueExplicit('D'.$row_rincian, nominal($byr['tarif']*$byr['jml_uttp']), PHPExcel_Cell_DataType::TYPE_STRING);

                        $tot_tarif += $byr['tarif'] * $byr['jml_uttp'];

                        // Apply style
                        $excel->getActiveSheet()->getStyle('A'.$row_rincian)->applyFromArray($style_body2);
						$excel->getActiveSheet()->getStyle('B'.$row_rincian)->applyFromArray($style_body2);
						$excel->getActiveSheet()->getStyle('C'.$row_rincian)->applyFromArray($style_body4);
						$excel->getActiveSheet()->getStyle('D'.$row_rincian)->applyFromArray($style_body6);
						$excel->getActiveSheet()->getStyle('E'.$row_rincian)->applyFromArray($style_body6);
                    }
                }

	    		$excel->setActiveSheetIndex(0)->setCellValueExplicit('E'.$row_rincian, nominal($tot_tarif), PHPExcel_Cell_DataType::TYPE_STRING);

	        	// Apply style
				$excel->getActiveSheet()->getStyle('A'.$row_rincian)->applyFromArray($style_body1);
				$excel->getActiveSheet()->getStyle('B'.$row_rincian)->applyFromArray($style_body1);
				$excel->getActiveSheet()->getStyle('C'.$row_rincian)->applyFromArray($style_body3);
				$excel->getActiveSheet()->getStyle('D'.$row_rincian)->applyFromArray($style_body5);
				$excel->getActiveSheet()->getStyle('E'.$row_rincian)->applyFromArray($style_body5);

                $row_rincian++;
                $tot_setor += $tot_tarif;

            }
            $jml_list++;
        } 

        $tot_tarif_show = $tot_tarif;

		$row = $row_rincian;
	}

	$excel->getActiveSheet()->mergeCells('A'.$row.':D'.$row);
	$excel->setActiveSheetIndex(0)->setCellValue('A'.$row, "JUMLAH TOTAL SETORAN");
	$excel->getActiveSheet()->getStyle('A'.$row.':D'.$row)->applyFromArray($style_foot1);

	// $excel->setActiveSheetIndex(0)->setCellValue('E'.$row, $tot_setor);
	$excel->setActiveSheetIndex(0)->setCellValueExplicit('E'.$row, nominal($tot_setor), PHPExcel_Cell_DataType::TYPE_STRING);
	$excel->getActiveSheet()->getStyle('E'.$row)->applyFromArray($style_foot2);

	$excel->getActiveSheet()->getRowDimension($row)->setRowHeight(20);

	$nama_bulan = array(
		'01'=>'Januari', 
		'02'=>'Februari', 
		'03'=>'Maret', 
		'04'=>'April', 
		'05'=>'Mei', 
		'06'=>'Juni', 
		'07'=>'Juli', 
		'08'=>'Agustus', 
		'09'=>'September', 
		'10'=>'Oktober', 
		'11'=>'November', 
		'12'=>'Desember'
	);

	$tgl_print = date('d');
	$bulan = date('m');
	foreach ($nama_bulan as $setor => $value) {
		if ($setor==$bulan) {
			$bln_print = $value;
		}
	}
	$thn_print = date('Y');

	$newRow1 = $row + 2;
	$newRow2 = $newRow1 + 1;
	$newRow3 = $newRow2 + 1;
	$newRow4 = $newRow3 + 1;
	$newRow5 = $newRow4 + 4;
	$newRow6 = $newRow5 + 1;
	$newRow7 = $newRow6 + 1;
	$excel->getActiveSheet()->mergeCells('D'.$newRow1.':E'.$newRow1);
	$excel->setActiveSheetIndex(0)->setCellValue('D'.$newRow1,"Kota Mungkid, ".$tgl_print.' '.$bln_print.' '.$thn_print);
	$excel->getActiveSheet()->getStyle('D'.$newRow1)->getFont()->setName('Calibri');
	$excel->getActiveSheet()->getStyle('D'.$newRow1)->getFont()->setSize(12);
	$excel->getActiveSheet()->getStyle('D'.$newRow1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	$excel->getActiveSheet()->mergeCells('D'.$newRow2.':E'.$newRow2);
	$excel->setActiveSheetIndex(0)->setCellValue('D'.$newRow2,"KEPALA DINAS PERDAGANGAN, KOPERASI");
	$excel->getActiveSheet()->getStyle('D'.$newRow2)->getFont()->setName('Calibri');
	$excel->getActiveSheet()->getStyle('D'.$newRow2)->getFont()->setSize(12);
	$excel->getActiveSheet()->getStyle('D'.$newRow2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	$excel->getActiveSheet()->mergeCells('D'.$newRow3.':E'.$newRow3);
	$excel->setActiveSheetIndex(0)->setCellValue('D'.$newRow3,"USAHA KECIL DAN MENENGAH");
	$excel->getActiveSheet()->getStyle('D'.$newRow3)->getFont()->setName('Calibri');
	$excel->getActiveSheet()->getStyle('D'.$newRow3)->getFont()->setSize(12);
	$excel->getActiveSheet()->getStyle('D'.$newRow3)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	$excel->getActiveSheet()->mergeCells('D'.$newRow4.':E'.$newRow4);
	$excel->setActiveSheetIndex(0)->setCellValue('D'.$newRow4,"KABUPATEN MAGELANG");
	$excel->getActiveSheet()->getStyle('D'.$newRow4)->getFont()->setName('Calibri');
	$excel->getActiveSheet()->getStyle('D'.$newRow4)->getFont()->setSize(12);
	$excel->getActiveSheet()->getStyle('D'.$newRow4)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	$excel->getActiveSheet()->mergeCells('D'.$newRow5.':E'.$newRow5);
	$excel->setActiveSheetIndex(0)->setCellValue('D'.$newRow5, $kepalaDinas->nama_user);
	$excel->getActiveSheet()->getStyle('D'.$newRow5)->getFont()->setName('Calibri');
	$excel->getActiveSheet()->getStyle('D'.$newRow5)->getFont()->setSize(12);
	$excel->getActiveSheet()->getStyle('D'.$newRow5)->getFont()->setBold(TRUE);
	$excel->getActiveSheet()->getStyle('D'.$newRow5)->getFont()->setUnderline(TRUE);
	$excel->getActiveSheet()->getStyle('D'.$newRow5)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	$excel->getActiveSheet()->mergeCells('D'.$newRow6.':E'.$newRow6);
	$excel->setActiveSheetIndex(0)->setCellValue('D'.$newRow6, $kepalaDinas->golongan);
	$excel->getActiveSheet()->getStyle('D'.$newRow6)->getFont()->setName('Calibri');
	$excel->getActiveSheet()->getStyle('D'.$newRow6)->getFont()->setSize(12);
	$excel->getActiveSheet()->getStyle('D'.$newRow6)->getFont()->setBold(TRUE);
	$excel->getActiveSheet()->getStyle('D'.$newRow6)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	$excel->getActiveSheet()->mergeCells('D'.$newRow7.':E'.$newRow7);
	$excel->setActiveSheetIndex(0)->setCellValue('D'.$newRow7,"NIP. ".$kepalaDinas->nip);
	$excel->getActiveSheet()->getStyle('D'.$newRow7)->getFont()->setName('Calibri');
	$excel->getActiveSheet()->getStyle('D'.$newRow7)->getFont()->setSize(12);
	$excel->getActiveSheet()->getStyle('D'.$newRow7)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	// // MENGETAHUI
	// 	$excel->getActiveSheet()->mergeCells('B'.$newRow1.':D'.$newRow1);
	// $excel->setActiveSheetIndex(0)->setCellValue('B'.$newRow1,"MENGETAHUI,");
	// $excel->getActiveSheet()->getStyle('B'.$newRow1)->getFont()->setName('Times New Roman');
	// $excel->getActiveSheet()->getStyle('B'.$newRow1)->getFont()->setSize(12);
	// $excel->getActiveSheet()->getStyle('B'.$newRow1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	// $excel->getActiveSheet()->mergeCells('B'.$newRow2.':D'.$newRow2);
	// $excel->setActiveSheetIndex(0)->setCellValue('B'.$newRow2,"KASIE PELAYANAN INFORMASI PUBLIK");
	// $excel->getActiveSheet()->getStyle('B'.$newRow2)->getFont()->setName('Times New Roman');
	// $excel->getActiveSheet()->getStyle('B'.$newRow2)->getFont()->setSize(12);
	// $excel->getActiveSheet()->getStyle('B'.$newRow2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


	// $excel->getActiveSheet()->mergeCells('B'.$newRow3.':D'.$newRow3);
	// $excel->setActiveSheetIndex(0)->setCellValue('B'.$newRow3,"KASTOLANI,S.Sos");
	// $excel->getActiveSheet()->getStyle('B'.$newRow3)->getFont()->setName('Times New Roman');
	// $excel->getActiveSheet()->getStyle('B'.$newRow3)->getFont()->setSize(12);
	// $excel->getActiveSheet()->getStyle('B'.$newRow3)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	// $excel->getActiveSheet()->mergeCells('B'.$newRow4.':D'.$newRow4);
	// $excel->setActiveSheetIndex(0)->setCellValue('B'.$newRow4,"NIP. 1966087 1986081001");
	// $excel->getActiveSheet()->getStyle('B'.$newRow4)->getFont()->setName('Times New Roman');
	// $excel->getActiveSheet()->getStyle('B'.$newRow4)->getFont()->setSize(12);
	// $excel->getActiveSheet()->getStyle('B'.$newRow4)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	
	

	// Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
	// $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
	// Set orientasi kertas jadi PORTRAIT
	$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
	$excel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

	// Set Footer
	$excel->getActiveSheet()->getHeaderFooter()->setOddFooter('&R Halaman Ke-&P dari &N');
	$excel->getActiveSheet()->getHeaderFooter()->setEvenFooter('&R Halaman Ke-&P dari &N');

	// Set judul file excel nya
	$excel->getActiveSheet(0)->setTitle("Lap Setor ".$dataBulan[$selectBulan].' '.$selectTahun);
	$excel->setActiveSheetIndex(0);
	// Proses file excel
	// ob_end_clean();
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment; filename="Lap Setor '.$dataBulan[$selectBulan].' '.$selectTahun.'.xlsx"'); // Set nama file excel nya
	header('Cache-Control: max-age=0');
	ob_end_clean();
	$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
	$write->save('php://output');

 ?>