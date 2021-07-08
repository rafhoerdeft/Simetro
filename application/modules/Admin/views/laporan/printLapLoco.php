<?php 
	

	// Panggil class PHPExcel nya
	$excel = new PHPExcel();

	// Settingan awal fil excel
	$excel->getProperties()->setCreator('DISKOMINFO')
							->setLastModifiedBy('Erdeft')
							->setTitle("Rekap Tera Ulang Loco ".$selectTglAwal.' Sampai '.$selectTglAkhir)
							->setSubject("Tera/Tera Ulang UTTP")
							->setDescription("Rekap Tera Ulang Loco ".$selectTglAwal.' Sampai '.$selectTglAkhir)
							->setKeywords("Rekap Tera Ulang Loco");

	// Buat sebuah variabel untuk menampung pengaturan style dari header tabel
	$style_title1 = array(
		'font' => array(
			'name'  => 'Arial',
	      	'bold' => TRUE,
	      	'size' => (14)
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
	      	'size' => (10)
		),
		'alignment' => array(
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
			'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		),
		'borders' => array(
			'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
			'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
			// 'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
			'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		),
		'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'cfd0d1')
        )
	);
	$style_header2 = array(
		'font' => array(
			'name'  => 'Arial',
	      	'bold' => TRUE,
	      	'size' => (10)
		),
		'alignment' => array(
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
			'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		),
		'borders' => array(
			// 'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
			'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
			'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THICK), // Set border bottom dengan garis tipis
			'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		),
		'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'cfd0d1')
        )
	);

	$style_header3 = array(
		'font' => array(
			'name'  => 'Arial',
	      	'bold' => TRUE,
	      	'size' => (10)
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
		),
		'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'cfd0d1')
        )
	);

	$style_foot1 = array(
		'font' => array(
			'name'  => 'Arial',
	      	'bold' => TRUE,
	      	'size' => (10)
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
	      	'size' => (10)
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
		),
		'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'cfd0d1')
        )
	);

	$style_body1 = array(
		'font' => array(
			'name'  => 'Arial',
	      	'bold' => FALSE,
	      	'size' => (10)
		),
		'alignment' => array(
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
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
  //           'color' => array('rgb' => 'ffffff')
  //       )
	);

	$style_body2 = array(
		'font' => array(
			'name'  => 'Arial',
	      	'bold' => FALSE,
	      	'size' => (10)
		),
		'alignment' => array(
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, // Set text jadi ditengah secara horizontal (center)
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
  //           'color' => array('rgb' => 'ffffff')
  //       )
	);

	$style_body3 = array(
		'font' => array(
			'name'  => 'Arial',
	      	'bold' => FALSE,
	      	'size' => (10)
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
  //           'color' => array('rgb' => 'ffffff')
  //       )
	);

	$style_body4 = array(
		'font' => array(
			'name'  => 'Arial',
	      	'bold' => TRUE,
	      	'size' => (10)
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
		),
		'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'cfd0d1')
        )
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
	$excel->getActiveSheet()->mergeCells('A1:O1');
	$excel->setActiveSheetIndex(0)->setCellValue('A1', "REKAP DATA TERA ULANG LUAR KANTOR (LOCO)");
	$excel->setActiveSheetIndex(0)->getStyle('A1')->getAlignment()->setWrapText(true);

	$excel->getActiveSheet()->mergeCells('A2:O2');
	$excel->setActiveSheetIndex(0)->setCellValue('A2', strtoupper(formatTanggalTtd($selectTglAwal))." - ".strtoupper(formatTanggalTtd($selectTglAkhir)));
	$excel->setActiveSheetIndex(0)->getStyle('A2')->getAlignment()->setWrapText(true);

	// Apply style 
	$excel->getActiveSheet()->getStyle('A1:O1')->applyFromArray($style_title1);
	$excel->getActiveSheet()->getStyle('A2:O2')->applyFromArray($style_title1);

	$row_first = 4;
	$row_bot = $row_first + 1;

	// $first = date('d-m-Y',strtotime($tgl_awal));
	// $last = date('d-m-Y',strtotime($tgl_akhir));

	// $excel->getActiveSheet()->mergeCells('A3:K3');
	// $excel->setActiveSheetIndex(0)->setCellValue('A3', "Tanggal: ".$first." s/d ".$last);
	// $excel->setActiveSheetIndex(0)->getStyle('A3')->getAlignment()->setWrapText(true);
	

	// BARIS HEADER
	$excel->getActiveSheet()->mergeCells('A4:A5');
	$excel->setActiveSheetIndex(0)->setCellValue('A'.$row_first, "NO");
	$excel->setActiveSheetIndex(0)->getStyle('A'.$row_first)->getAlignment()->setWrapText(true);

	$excel->getActiveSheet()->mergeCells('B4:B5');
	$excel->setActiveSheetIndex(0)->setCellValue('B'.$row_first, "NAMA WTU");
	$excel->setActiveSheetIndex(0)->getStyle('B'.$row_first)->getAlignment()->setWrapText(true);

	$excel->getActiveSheet()->mergeCells('C4:C5');
	$excel->setActiveSheetIndex(0)->setCellValue('C'.$row_first, "TANGGAL TERA");
	$excel->setActiveSheetIndex(0)->getStyle('C'.$row_first)->getAlignment()->setWrapText(true);

	$excel->getActiveSheet()->mergeCells('D4:O4');
	$excel->setActiveSheetIndex(0)->setCellValue('D'.$row_first, "JUMLAH UTTP");
	$excel->setActiveSheetIndex(0)->getStyle('D'.$row_first)->getAlignment()->setWrapText(true);


	$excel->setActiveSheetIndex(0)->setCellValue('D'.$row_bot, "PU BBM");
	$excel->setActiveSheetIndex(0)->getStyle('D'.$row_bot)->getAlignment()->setWrapText(true);

	$excel->setActiveSheetIndex(0)->setCellValue('E'.$row_bot, "BEJANA UKUR");
	$excel->setActiveSheetIndex(0)->getStyle('E'.$row_bot)->getAlignment()->setWrapText(true);

	$excel->setActiveSheetIndex(0)->setCellValue('F'.$row_bot, "TUTSIDA");
	$excel->setActiveSheetIndex(0)->getStyle('F'.$row_bot)->getAlignment()->setWrapText(true);

	$excel->setActiveSheetIndex(0)->setCellValue('G'.$row_bot, "ATB");
	$excel->setActiveSheetIndex(0)->getStyle('G'.$row_bot)->getAlignment()->setWrapText(true);

	$excel->setActiveSheetIndex(0)->setCellValue('H'.$row_bot, "TM");
	$excel->setActiveSheetIndex(0)->getStyle('H'.$row_bot)->getAlignment()->setWrapText(true);

	$excel->setActiveSheetIndex(0)->setCellValue('I'.$row_bot, "TS");
	$excel->setActiveSheetIndex(0)->getStyle('I'.$row_bot)->getAlignment()->setWrapText(true);

	$excel->setActiveSheetIndex(0)->setCellValue('J'.$row_bot, "TE");
	$excel->setActiveSheetIndex(0)->getStyle('J'.$row_bot)->getAlignment()->setWrapText(true);

	$excel->setActiveSheetIndex(0)->setCellValue('K'.$row_bot, "TE > 500kg");
	$excel->setActiveSheetIndex(0)->getStyle('K'.$row_bot)->getAlignment()->setWrapText(true);

	$excel->setActiveSheetIndex(0)->setCellValue('L'.$row_bot, "TE KELAS I");
	$excel->setActiveSheetIndex(0)->getStyle('L'.$row_bot)->getAlignment()->setWrapText(true);

	$excel->setActiveSheetIndex(0)->setCellValue('M'.$row_bot, "JEMBATAN S.D 50 TON");
	$excel->setActiveSheetIndex(0)->getStyle('M'.$row_bot)->getAlignment()->setWrapText(true);

	$excel->setActiveSheetIndex(0)->setCellValue('N'.$row_bot, "TONGKAT DUGA");
	$excel->setActiveSheetIndex(0)->getStyle('N'.$row_bot)->getAlignment()->setWrapText(true);

	$excel->setActiveSheetIndex(0)->setCellValue('O'.$row_bot, "FILLING MACHINE");
	$excel->setActiveSheetIndex(0)->getStyle('O'.$row_bot)->getAlignment()->setWrapText(true);



	// Apply style 
	$excel->getActiveSheet()->getStyle('A'.$row_first)->applyFromArray($style_header1);
	$excel->getActiveSheet()->getStyle('B'.$row_first)->applyFromArray($style_header1);
	$excel->getActiveSheet()->getStyle('C'.$row_first)->applyFromArray($style_header1);
	$excel->getActiveSheet()->getStyle('D'.$row_first)->applyFromArray($style_header1);
	$excel->getActiveSheet()->getStyle('E'.$row_first)->applyFromArray($style_header1);
	$excel->getActiveSheet()->getStyle('F'.$row_first)->applyFromArray($style_header1);
	$excel->getActiveSheet()->getStyle('G'.$row_first)->applyFromArray($style_header1);
	$excel->getActiveSheet()->getStyle('H'.$row_first)->applyFromArray($style_header1);
	$excel->getActiveSheet()->getStyle('I'.$row_first)->applyFromArray($style_header1);
	$excel->getActiveSheet()->getStyle('J'.$row_first)->applyFromArray($style_header1);
	$excel->getActiveSheet()->getStyle('K'.$row_first)->applyFromArray($style_header1);
	$excel->getActiveSheet()->getStyle('L'.$row_first)->applyFromArray($style_header1);
	$excel->getActiveSheet()->getStyle('M'.$row_first)->applyFromArray($style_header1);
	$excel->getActiveSheet()->getStyle('N'.$row_first)->applyFromArray($style_header1);
	$excel->getActiveSheet()->getStyle('O'.$row_first)->applyFromArray($style_header1);

	$excel->getActiveSheet()->getStyle('A'.$row_bot)->applyFromArray($style_header2);
	$excel->getActiveSheet()->getStyle('B'.$row_bot)->applyFromArray($style_header2);
	$excel->getActiveSheet()->getStyle('C'.$row_bot)->applyFromArray($style_header2);
	$excel->getActiveSheet()->getStyle('D'.$row_bot)->applyFromArray($style_header3);
	$excel->getActiveSheet()->getStyle('E'.$row_bot)->applyFromArray($style_header3);
	$excel->getActiveSheet()->getStyle('F'.$row_bot)->applyFromArray($style_header3);
	$excel->getActiveSheet()->getStyle('G'.$row_bot)->applyFromArray($style_header3);
	$excel->getActiveSheet()->getStyle('H'.$row_bot)->applyFromArray($style_header3);
	$excel->getActiveSheet()->getStyle('I'.$row_bot)->applyFromArray($style_header3);
	$excel->getActiveSheet()->getStyle('J'.$row_bot)->applyFromArray($style_header3);
	$excel->getActiveSheet()->getStyle('K'.$row_bot)->applyFromArray($style_header3);
	$excel->getActiveSheet()->getStyle('L'.$row_bot)->applyFromArray($style_header3);
	$excel->getActiveSheet()->getStyle('M'.$row_bot)->applyFromArray($style_header3);
	$excel->getActiveSheet()->getStyle('N'.$row_bot)->applyFromArray($style_header3);
	$excel->getActiveSheet()->getStyle('O'.$row_bot)->applyFromArray($style_header3);

	// Set Repeat Header
	$excel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1,5);

	// Set width kolom
	$excel->getActiveSheet()->getColumnDimension('A')->setWidth(4.85);
	$excel->getActiveSheet()->getColumnDimension('B')->setWidth(32.5);
	$excel->getActiveSheet()->getColumnDimension('C')->setWidth(12.5);
	$excel->getActiveSheet()->getColumnDimension('D')->setWidth(9.5);
	$excel->getActiveSheet()->getColumnDimension('E')->setWidth(9.5);
	$excel->getActiveSheet()->getColumnDimension('F')->setWidth(9.5);
	$excel->getActiveSheet()->getColumnDimension('G')->setWidth(9.5);
	$excel->getActiveSheet()->getColumnDimension('H')->setWidth(9.5);
	$excel->getActiveSheet()->getColumnDimension('I')->setWidth(9.5);
	$excel->getActiveSheet()->getColumnDimension('J')->setWidth(9.5);
	$excel->getActiveSheet()->getColumnDimension('K')->setWidth(9.5);
	$excel->getActiveSheet()->getColumnDimension('L')->setWidth(9.5);
	$excel->getActiveSheet()->getColumnDimension('M')->setWidth(9.5);
	$excel->getActiveSheet()->getColumnDimension('N')->setWidth(9.5);
	$excel->getActiveSheet()->getColumnDimension('O')->setWidth(9.5);

	$excel->getActiveSheet()->getRowDimension($row_first)->setRowHeight(20);
	$excel->getActiveSheet()->getRowDimension($row_bot)->setRowHeight(42.75);

	// $excel->getActiveSheet()->getRowDimension($row_first)->setRowHeight(36.5);


	// BARIS BODY / ISI DATA
	$no = 0;
	$row = $row_bot + 1;
	$tot_wtu = 0;
	$tot_BBM = 0;
	$tot_BU = 0;
	$tot_Tutsida = 0;
	$tot_ATB = 0;
	$tot_TM = 0;
	$tot_TS = 0;
	$tot_TE1 = 0;
	$tot_TE2 = 0;
	$tot_TE3 = 0;
	$tot_Jb = 0;
	$tot_TD = 0;
	$tot_FM = 0;
	$tot_tensi = 0;
	
	foreach ($dataLapLoco as $lap) {
		$no++;
		if ($lap['nama_usaha'] != null || $lap['nama_usaha'] != '') {
            $usr = $lap['nama_user'].'/'.$lap['nama_usaha'];
        } else {
            $usr = $lap['nama_user'];
        }
		
		$excel->setActiveSheetIndex(0)->setCellValue('A'.$row, $no);
		$excel->setActiveSheetIndex(0)->setCellValue('B'.$row, $usr);
		$excel->setActiveSheetIndex(0)->setCellValue('C'.$row, $lap['tgl_daftar']);
		$excel->setActiveSheetIndex(0)->setCellValue('D'.$row, nominal($lap['BBM']));
		$excel->setActiveSheetIndex(0)->setCellValue('E'.$row, nominal($lap['BU']));
		$excel->setActiveSheetIndex(0)->setCellValue('F'.$row, nominal($lap['Tutsida']));
		$excel->setActiveSheetIndex(0)->setCellValue('G'.$row, nominal($lap['ATB']));
		$excel->setActiveSheetIndex(0)->setCellValue('H'.$row, nominal($lap['TM']));
		$excel->setActiveSheetIndex(0)->setCellValue('I'.$row, nominal($lap['TS']));
		$excel->setActiveSheetIndex(0)->setCellValue('J'.$row, nominal($lap['TE1']));
		$excel->setActiveSheetIndex(0)->setCellValue('K'.$row, nominal($lap['TE2']));
		$excel->setActiveSheetIndex(0)->setCellValue('L'.$row, nominal($lap['TE3']));
		$excel->setActiveSheetIndex(0)->setCellValue('M'.$row, nominal($lap['Jb']));
		$excel->setActiveSheetIndex(0)->setCellValue('N'.$row, nominal($lap['TD']));
		$excel->setActiveSheetIndex(0)->setCellValue('O'.$row, nominal($lap['FM']));

		// $tot_wtu += $lap['jml_wtu'];
		$tot_BBM += $lap['BBM'];
		$tot_BU += $lap['BU'];
		$tot_Tutsida += $lap['Tutsida'];
		$tot_ATB += $lap['ATB'];
		$tot_TM += $lap['TM'];
		$tot_TS += $lap['TS'];
		$tot_TE1 += $lap['TE1'];
		$tot_TE2 += $lap['TE2'];
		$tot_TE3 += $lap['TE3'];
		$tot_Jb += $lap['Jb'];
		$tot_TD += $lap['TD'];
		$tot_FM += $lap['FM'];

    	$excel->getActiveSheet()->getStyle('A'.$row)->applyFromArray($style_body1);
		$excel->getActiveSheet()->getStyle('B'.$row)->applyFromArray($style_body2);
		$excel->getActiveSheet()->getStyle('C'.$row)->applyFromArray($style_body1);
		$excel->getActiveSheet()->getStyle('D'.$row)->applyFromArray($style_body3);
		$excel->getActiveSheet()->getStyle('E'.$row)->applyFromArray($style_body3);
		$excel->getActiveSheet()->getStyle('F'.$row)->applyFromArray($style_body3);
		$excel->getActiveSheet()->getStyle('G'.$row)->applyFromArray($style_body3);
		$excel->getActiveSheet()->getStyle('H'.$row)->applyFromArray($style_body3);
		$excel->getActiveSheet()->getStyle('I'.$row)->applyFromArray($style_body3);
		$excel->getActiveSheet()->getStyle('J'.$row)->applyFromArray($style_body3);
		$excel->getActiveSheet()->getStyle('K'.$row)->applyFromArray($style_body3);
		$excel->getActiveSheet()->getStyle('L'.$row)->applyFromArray($style_body3);
		$excel->getActiveSheet()->getStyle('M'.$row)->applyFromArray($style_body3);
		$excel->getActiveSheet()->getStyle('N'.$row)->applyFromArray($style_body3);
		$excel->getActiveSheet()->getStyle('O'.$row)->applyFromArray($style_body3);

		$excel->getActiveSheet()->getRowDimension($row)->setRowHeight(20);

		$row++;
	}


	$excel->getActiveSheet()->mergeCells('A'.$row.':C'.$row);
	$excel->setActiveSheetIndex(0)->setCellValue('A'.$row, "TOTAL");
	$excel->getActiveSheet()->getStyle('A'.$row.':C'.$row)->applyFromArray($style_foot1);

	// $excel->setActiveSheetIndex(0)->setCellValue('E'.$row, $tot_setor);

	$excel->setActiveSheetIndex(0)->setCellValueExplicit('D'.$row, nominal($tot_BBM), PHPExcel_Cell_DataType::TYPE_STRING);
	$excel->getActiveSheet()->getStyle('D'.$row)->applyFromArray($style_foot2);

	$excel->setActiveSheetIndex(0)->setCellValueExplicit('E'.$row, nominal($tot_BU), PHPExcel_Cell_DataType::TYPE_STRING);
	$excel->getActiveSheet()->getStyle('E'.$row)->applyFromArray($style_foot2);

	$excel->setActiveSheetIndex(0)->setCellValueExplicit('F'.$row, nominal($tot_Tutsida), PHPExcel_Cell_DataType::TYPE_STRING);
	$excel->getActiveSheet()->getStyle('F'.$row)->applyFromArray($style_foot2);

	$excel->setActiveSheetIndex(0)->setCellValueExplicit('G'.$row, nominal($tot_ATB), PHPExcel_Cell_DataType::TYPE_STRING);
	$excel->getActiveSheet()->getStyle('G'.$row)->applyFromArray($style_foot2);

	$excel->setActiveSheetIndex(0)->setCellValueExplicit('H'.$row, nominal($tot_TM), PHPExcel_Cell_DataType::TYPE_STRING);
	$excel->getActiveSheet()->getStyle('H'.$row)->applyFromArray($style_foot2);

	$excel->setActiveSheetIndex(0)->setCellValueExplicit('I'.$row, nominal($tot_TS), PHPExcel_Cell_DataType::TYPE_STRING);
	$excel->getActiveSheet()->getStyle('I'.$row)->applyFromArray($style_foot2);

	$excel->setActiveSheetIndex(0)->setCellValueExplicit('J'.$row, nominal($tot_TE1), PHPExcel_Cell_DataType::TYPE_STRING);
	$excel->getActiveSheet()->getStyle('J'.$row)->applyFromArray($style_foot2);

	$excel->setActiveSheetIndex(0)->setCellValueExplicit('K'.$row, nominal($tot_TE2), PHPExcel_Cell_DataType::TYPE_STRING);
	$excel->getActiveSheet()->getStyle('K'.$row)->applyFromArray($style_foot2);

	$excel->setActiveSheetIndex(0)->setCellValueExplicit('L'.$row, nominal($tot_TE3), PHPExcel_Cell_DataType::TYPE_STRING);
	$excel->getActiveSheet()->getStyle('L'.$row)->applyFromArray($style_foot2);

	$excel->setActiveSheetIndex(0)->setCellValueExplicit('M'.$row, nominal($tot_Jb), PHPExcel_Cell_DataType::TYPE_STRING);
	$excel->getActiveSheet()->getStyle('M'.$row)->applyFromArray($style_foot2);

	$excel->setActiveSheetIndex(0)->setCellValueExplicit('N'.$row, nominal($tot_TD), PHPExcel_Cell_DataType::TYPE_STRING);
	$excel->getActiveSheet()->getStyle('N'.$row)->applyFromArray($style_foot2);

	$excel->setActiveSheetIndex(0)->setCellValueExplicit('O'.$row, nominal($tot_FM), PHPExcel_Cell_DataType::TYPE_STRING);
	$excel->getActiveSheet()->getStyle('O'.$row)->applyFromArray($style_foot2);

	$excel->getActiveSheet()->getRowDimension($row)->setRowHeight(20);


	$newRow1 = $row + 2;
	$newRow2 = $newRow1 + 1;
	$newRow3 = $newRow2 + 1;
	$newRow4 = $newRow3 + 1;
	$newRow5 = $newRow4 + 4;
	$newRow6 = $newRow5 + 1;
	$newRow7 = $newRow6 + 1;
	$excel->getActiveSheet()->mergeCells('K'.$newRow1.':O'.$newRow1);
	$excel->setActiveSheetIndex(0)->setCellValue('K'.$newRow1,"Kota Mungkid, ".formatTanggalTtd(date('d-m-Y')));
	$excel->getActiveSheet()->getStyle('K'.$newRow1)->getFont()->setName('Calibri');
	$excel->getActiveSheet()->getStyle('K'.$newRow1)->getFont()->setSize(12);
	$excel->getActiveSheet()->getStyle('K'.$newRow1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	$excel->getActiveSheet()->mergeCells('K'.$newRow2.':O'.$newRow2);
	$excel->setActiveSheetIndex(0)->setCellValue('K'.$newRow2,"KEPALA DINAS PERDAGANGAN, KOPERASI");
	$excel->getActiveSheet()->getStyle('K'.$newRow2)->getFont()->setName('Calibri');
	$excel->getActiveSheet()->getStyle('K'.$newRow2)->getFont()->setSize(12);
	$excel->getActiveSheet()->getStyle('K'.$newRow2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	$excel->getActiveSheet()->mergeCells('K'.$newRow3.':O'.$newRow3);
	$excel->setActiveSheetIndex(0)->setCellValue('K'.$newRow3,"USAHA KECIL DAN MENENGAH");
	$excel->getActiveSheet()->getStyle('K'.$newRow3)->getFont()->setName('Calibri');
	$excel->getActiveSheet()->getStyle('K'.$newRow3)->getFont()->setSize(12);
	$excel->getActiveSheet()->getStyle('K'.$newRow3)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	$excel->getActiveSheet()->mergeCells('K'.$newRow4.':O'.$newRow4);
	$excel->setActiveSheetIndex(0)->setCellValue('K'.$newRow4,"KABUPATEN MAGELANG");
	$excel->getActiveSheet()->getStyle('K'.$newRow4)->getFont()->setName('Calibri');
	$excel->getActiveSheet()->getStyle('K'.$newRow4)->getFont()->setSize(12);
	$excel->getActiveSheet()->getStyle('K'.$newRow4)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	$excel->getActiveSheet()->mergeCells('K'.$newRow5.':O'.$newRow5);
	$excel->setActiveSheetIndex(0)->setCellValue('K'.$newRow5, $kepalaDinas->nama_user);
	$excel->getActiveSheet()->getStyle('K'.$newRow5)->getFont()->setName('Calibri');
	$excel->getActiveSheet()->getStyle('K'.$newRow5)->getFont()->setSize(12);
	$excel->getActiveSheet()->getStyle('K'.$newRow5)->getFont()->setBold(TRUE);
	$excel->getActiveSheet()->getStyle('K'.$newRow5)->getFont()->setUnderline(TRUE);
	$excel->getActiveSheet()->getStyle('K'.$newRow5)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	$excel->getActiveSheet()->mergeCells('K'.$newRow6.':O'.$newRow6);
	$excel->setActiveSheetIndex(0)->setCellValue('K'.$newRow6, $kepalaDinas->golongan);
	$excel->getActiveSheet()->getStyle('K'.$newRow6)->getFont()->setName('Calibri');
	$excel->getActiveSheet()->getStyle('K'.$newRow6)->getFont()->setSize(12);
	$excel->getActiveSheet()->getStyle('K'.$newRow6)->getFont()->setBold(TRUE);
	$excel->getActiveSheet()->getStyle('K'.$newRow6)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	$excel->getActiveSheet()->mergeCells('K'.$newRow7.':O'.$newRow7);
	$excel->setActiveSheetIndex(0)->setCellValue('K'.$newRow7,"NIP. ".$kepalaDinas->nip);
	$excel->getActiveSheet()->getStyle('K'.$newRow7)->getFont()->setName('Calibri');
	$excel->getActiveSheet()->getStyle('K'.$newRow7)->getFont()->setSize(12);
	$excel->getActiveSheet()->getStyle('K'.$newRow7)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

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
	$excel->getActiveSheet(0)->setTitle("Rekap Tera Ulang Loco");
	$excel->setActiveSheetIndex(0);
	// Proses file excel
	// ob_end_clean();
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment; filename="Rekap Tera Ulang Loco '.$selectTglAwal.' Sampai '.$selectTglAkhir.'.xlsx"'); // Set nama file excel nya
	header('Cache-Control: max-age=0');
	ob_end_clean();
	$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
	$write->save('php://output');

 ?>