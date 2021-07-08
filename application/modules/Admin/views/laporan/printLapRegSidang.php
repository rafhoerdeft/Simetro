<?php 
	

	// Panggil class PHPExcel nya
	$excel = new PHPExcel();

	// Settingan awal fil excel
	$excel->getProperties()->setCreator('DISKOMINFO')
							->setLastModifiedBy('Erdeft')
							->setTitle("Register Sidang Tera ".$dataPasar.' '.$selectTglAwal.' Sampai '.$selectTglAkhir)
							->setSubject("Tera/Tera Ulang UTTP")
							->setDescription("Register Sidang Tera ".$dataPasar.' '.$selectTglAwal.' Sampai '.$selectTglAkhir)
							->setKeywords("Register Sidang Tera");

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
		)
		// ,
		// 'fill' => array(
  //           'type' => PHPExcel_Style_Fill::FILL_SOLID,
  //           'color' => array('rgb' => 'cfd0d1')
  //       )
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
			// 'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THICK), // Set border bottom dengan garis tipis
			'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		)
		// ,
		// 'fill' => array(
  //           'type' => PHPExcel_Style_Fill::FILL_SOLID,
  //           'color' => array('rgb' => 'cfd0d1')
  //       )
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
			// 'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
			'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
			'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THICK), // Set border bottom dengan garis tipis
			'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		)
		// ,
		// 'fill' => array(
  //           'type' => PHPExcel_Style_Fill::FILL_SOLID,
  //           'color' => array('rgb' => 'cfd0d1')
  //       )
	);

	$style_header4 = array(
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
		)
		// ,
		// 'fill' => array(
  //           'type' => PHPExcel_Style_Fill::FILL_SOLID,
  //           'color' => array('rgb' => 'cfd0d1')
  //       )
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
	$excel->getActiveSheet()->mergeCells('A1:AJ1');
	$excel->setActiveSheetIndex(0)->setCellValue('A1', "REGISTER SIDANG TERA");
	$excel->setActiveSheetIndex(0)->getStyle('A1')->getAlignment()->setWrapText(true);

	$excel->getActiveSheet()->mergeCells('A2:AJ2');
	$excel->setActiveSheetIndex(0)->setCellValue('A2', strtoupper($dataPasar));
	$excel->setActiveSheetIndex(0)->getStyle('A2')->getAlignment()->setWrapText(true);

	$excel->getActiveSheet()->mergeCells('A3:AJ3');
	$excel->setActiveSheetIndex(0)->setCellValue('A3', strtoupper(formatTanggalTtd($selectTglAwal))." - ".strtoupper(formatTanggalTtd($selectTglAkhir)));
	$excel->setActiveSheetIndex(0)->getStyle('A3')->getAlignment()->setWrapText(true);

	// Apply style 
	$excel->getActiveSheet()->getStyle('A1:AJ1')->applyFromArray($style_title1);
	$excel->getActiveSheet()->getStyle('A2:AJ2')->applyFromArray($style_title1);
	$excel->getActiveSheet()->getStyle('A3:AJ3')->applyFromArray($style_title1);

	$row_fst = 5;
	$row_scd = $row_fst + 1;
	$row_trd = $row_scd + 1;
	$row_frt = $row_trd + 1;

	// $first = date('d-m-Y',strtotime($tgl_awal));
	// $last = date('d-m-Y',strtotime($tgl_akhir));

	// $excel->getActiveSheet()->mergeCells('A3:K3');
	// $excel->setActiveSheetIndex(0)->setCellValue('A3', "Tanggal: ".$first." s/d ".$last);
	// $excel->setActiveSheetIndex(0)->getStyle('A3')->getAlignment()->setWrapText(true);
	

	// BARIS HEADER
	$excel->getActiveSheet()->mergeCells('A5:A7');
	$excel->setActiveSheetIndex(0)->setCellValue('A'.$row_fst, "NOMOR");
	$excel->setActiveSheetIndex(0)->getStyle('A'.$row_fst)->getAlignment()->setWrapText(true);
	$excel->getActiveSheet()->getStyle('A'.$row_fst)->getAlignment()->setTextRotation(90);

	$excel->getActiveSheet()->mergeCells('B5:B7');
	$excel->setActiveSheetIndex(0)->setCellValue('B'.$row_fst, "TANGGAL");
	$excel->setActiveSheetIndex(0)->getStyle('B'.$row_fst)->getAlignment()->setWrapText(true);

	$excel->getActiveSheet()->mergeCells('C5:C7');
	$excel->setActiveSheetIndex(0)->setCellValue('C'.$row_fst, "NAMA");
	$excel->setActiveSheetIndex(0)->getStyle('C'.$row_fst)->getAlignment()->setWrapText(true);

	$excel->getActiveSheet()->mergeCells('D5:D7');
	$excel->setActiveSheetIndex(0)->setCellValue('D'.$row_fst, "Ukuran Panjang Kap s/d 1 m");
	$excel->setActiveSheetIndex(0)->getStyle('D'.$row_fst)->getAlignment()->setWrapText(true);
	$excel->getActiveSheet()->getStyle('D'.$row_fst)->getAlignment()->setTextRotation(90);

	$excel->getActiveSheet()->mergeCells('E5:E7');
	$excel->setActiveSheetIndex(0)->setCellValue('E'.$row_fst, "Ukuran Panjang Kap > 1 m ≤ 2 m");
	$excel->setActiveSheetIndex(0)->getStyle('E'.$row_fst)->getAlignment()->setWrapText(true);
	$excel->getActiveSheet()->getStyle('E'.$row_fst)->getAlignment()->setTextRotation(90);

	// ===============================================================================================

	$excel->getActiveSheet()->mergeCells('F5:G5');
	$excel->setActiveSheetIndex(0)->setCellValue('F'.$row_fst, "TAKARAN");
	$excel->setActiveSheetIndex(0)->getStyle('F'.$row_fst)->getAlignment()->setWrapText(true);

	$excel->getActiveSheet()->mergeCells('F6:F7');
	$excel->setActiveSheetIndex(0)->setCellValue('F'.$row_scd, "Kap. s/d 2 L");
	$excel->setActiveSheetIndex(0)->getStyle('F'.$row_scd)->getAlignment()->setWrapText(true);
	$excel->getActiveSheet()->getStyle('F'.$row_scd)->getAlignment()->setTextRotation(90);

	$excel->getActiveSheet()->mergeCells('G6:G7');
	$excel->setActiveSheetIndex(0)->setCellValue('G'.$row_scd, "2 L < Tak ≤ 25 L");
	$excel->setActiveSheetIndex(0)->getStyle('G'.$row_scd)->getAlignment()->setWrapText(true);
	$excel->getActiveSheet()->getStyle('G'.$row_scd)->getAlignment()->setTextRotation(90);

	// ===============================================================================================

	$excel->getActiveSheet()->mergeCells('H5:L5');
	$excel->setActiveSheetIndex(0)->setCellValue('H'.$row_fst, "ANAK TIMBANGAN");
	$excel->setActiveSheetIndex(0)->getStyle('H'.$row_fst)->getAlignment()->setWrapText(true);

	$excel->getActiveSheet()->mergeCells('H6:J6');
	$excel->setActiveSheetIndex(0)->setCellValue('H'.$row_scd, "Kelas M2 dan M3");
	$excel->setActiveSheetIndex(0)->getStyle('H'.$row_scd)->getAlignment()->setWrapText(true);

	$excel->getActiveSheet()->mergeCells('K6:L6');
	$excel->setActiveSheetIndex(0)->setCellValue('K'.$row_scd, "Kelas F2 dan M1");
	$excel->setActiveSheetIndex(0)->getStyle('K'.$row_scd)->getAlignment()->setWrapText(true);

	// $excel->getActiveSheet()->mergeCells('H'.$row_trd);
	$excel->setActiveSheetIndex(0)->setCellValue('H'.$row_trd, "Kap. s/d 1 kg");
	$excel->setActiveSheetIndex(0)->getStyle('H'.$row_trd)->getAlignment()->setWrapText(true);
	$excel->getActiveSheet()->getStyle('H'.$row_trd)->getAlignment()->setTextRotation(90);

	// $excel->getActiveSheet()->mergeCells('I'.$row_trd);
	$excel->setActiveSheetIndex(0)->setCellValue('I'.$row_trd, "1 kg < at ≤ 5 kg");
	$excel->setActiveSheetIndex(0)->getStyle('I'.$row_trd)->getAlignment()->setWrapText(true);
	$excel->getActiveSheet()->getStyle('I'.$row_trd)->getAlignment()->setTextRotation(90);

	// $excel->getActiveSheet()->mergeCells('J'.$row_trd);
	$excel->setActiveSheetIndex(0)->setCellValue('J'.$row_trd, "5 kg < at ≤ 50 kg");
	$excel->setActiveSheetIndex(0)->getStyle('J'.$row_trd)->getAlignment()->setWrapText(true);
	$excel->getActiveSheet()->getStyle('J'.$row_trd)->getAlignment()->setTextRotation(90);

	// $excel->getActiveSheet()->mergeCells('K'.$row_trd);
	$excel->setActiveSheetIndex(0)->setCellValue('K'.$row_trd, "Kap. s/d 1 kg");
	$excel->setActiveSheetIndex(0)->getStyle('K'.$row_trd)->getAlignment()->setWrapText(true);
	$excel->getActiveSheet()->getStyle('K'.$row_trd)->getAlignment()->setTextRotation(90);

	// $excel->getActiveSheet()->mergeCells('L'.$row_trd);
	$excel->setActiveSheetIndex(0)->setCellValue('L'.$row_trd, "1 kg < at ≤ 5 kg");
	$excel->setActiveSheetIndex(0)->getStyle('L'.$row_trd)->getAlignment()->setWrapText(true);
	$excel->getActiveSheet()->getStyle('L'.$row_trd)->getAlignment()->setTextRotation(90);
	
	// ===========================================================================================

	$excel->getActiveSheet()->mergeCells('M5:AF5');
	$excel->setActiveSheetIndex(0)->setCellValue('M'.$row_fst, "TIMBANGAN");
	$excel->setActiveSheetIndex(0)->getStyle('M'.$row_fst)->getAlignment()->setWrapText(true);

	$excel->getActiveSheet()->mergeCells('M'.$row_scd.':M'.$row_trd);
	$excel->setActiveSheetIndex(0)->setCellValue('M'.$row_scd, "Neraca");
	$excel->setActiveSheetIndex(0)->getStyle('M'.$row_scd)->getAlignment()->setWrapText(true);
	$excel->getActiveSheet()->getStyle('M'.$row_scd)->getAlignment()->setTextRotation(90);

	$excel->getActiveSheet()->mergeCells('N6:O6');
	$excel->setActiveSheetIndex(0)->setCellValue('N'.$row_scd, "Dacin Logam");
	$excel->setActiveSheetIndex(0)->getStyle('N'.$row_scd)->getAlignment()->setWrapText(true);

	$excel->getActiveSheet()->mergeCells('P6:R6');
	$excel->setActiveSheetIndex(0)->setCellValue('P'.$row_scd, "Sentisimal");
	$excel->setActiveSheetIndex(0)->getStyle('P'.$row_scd)->getAlignment()->setWrapText(true);

	$excel->getActiveSheet()->mergeCells('S6:U6');
	$excel->setActiveSheetIndex(0)->setCellValue('S'.$row_scd, "Bobot Ingsut");
	$excel->setActiveSheetIndex(0)->getStyle('S'.$row_scd)->getAlignment()->setWrapText(true);

	// $excel->getActiveSheet()->mergeCells('N'.$row_trd);
	$excel->setActiveSheetIndex(0)->setCellValue('N'.$row_trd, "Kap. s/d 25 kg");
	$excel->setActiveSheetIndex(0)->getStyle('N'.$row_trd)->getAlignment()->setWrapText(true);
	$excel->getActiveSheet()->getStyle('N'.$row_trd)->getAlignment()->setTextRotation(90);

	// $excel->getActiveSheet()->mergeCells('O'.$row_trd);
	$excel->setActiveSheetIndex(0)->setCellValue('O'.$row_trd, "> 25 kg");
	$excel->setActiveSheetIndex(0)->getStyle('O'.$row_trd)->getAlignment()->setWrapText(true);
	$excel->getActiveSheet()->getStyle('O'.$row_trd)->getAlignment()->setTextRotation(90);

	// $excel->getActiveSheet()->mergeCells('P'.$row_trd);
	$excel->setActiveSheetIndex(0)->setCellValue('P'.$row_trd, "Kap. s/d 150 kg");
	$excel->setActiveSheetIndex(0)->getStyle('P'.$row_trd)->getAlignment()->setWrapText(true);
	$excel->getActiveSheet()->getStyle('P'.$row_trd)->getAlignment()->setTextRotation(90);

	// $excel->getActiveSheet()->mergeCells('Q'.$row_trd);
	$excel->setActiveSheetIndex(0)->setCellValue('Q'.$row_trd, "150 kg < sent ≤ 500 kg");
	$excel->setActiveSheetIndex(0)->getStyle('Q'.$row_trd)->getAlignment()->setWrapText(true);
	$excel->getActiveSheet()->getStyle('Q'.$row_trd)->getAlignment()->setTextRotation(90);

	// $excel->getActiveSheet()->mergeCells('R'.$row_trd);
	$excel->setActiveSheetIndex(0)->setCellValue('R'.$row_trd, "> 500 kg");
	$excel->setActiveSheetIndex(0)->getStyle('R'.$row_trd)->getAlignment()->setWrapText(true);
	$excel->getActiveSheet()->getStyle('R'.$row_trd)->getAlignment()->setTextRotation(90);

	// $excel->getActiveSheet()->mergeCells('S'.$row_trd);
	$excel->setActiveSheetIndex(0)->setCellValue('S'.$row_trd, "Kap. s/d 25 kg");
	$excel->setActiveSheetIndex(0)->getStyle('S'.$row_trd)->getAlignment()->setWrapText(true);
	$excel->getActiveSheet()->getStyle('S'.$row_trd)->getAlignment()->setTextRotation(90);

	// $excel->getActiveSheet()->mergeCells('T'.$row_trd);
	$excel->setActiveSheetIndex(0)->setCellValue('T'.$row_trd, "25 kg < BI ≤ 150 kg");
	$excel->setActiveSheetIndex(0)->getStyle('T'.$row_trd)->getAlignment()->setWrapText(true);
	$excel->getActiveSheet()->getStyle('T'.$row_trd)->getAlignment()->setTextRotation(90);

	// $excel->getActiveSheet()->mergeCells('U'.$row_trd);
	$excel->setActiveSheetIndex(0)->setCellValue('U'.$row_trd, "> 150 kg");
	$excel->setActiveSheetIndex(0)->getStyle('U'.$row_trd)->getAlignment()->setWrapText(true);
	$excel->getActiveSheet()->getStyle('U'.$row_trd)->getAlignment()->setTextRotation(90);

	$excel->getActiveSheet()->mergeCells('V'.$row_scd.':V'.$row_trd);
	$excel->setActiveSheetIndex(0)->setCellValue('V'.$row_scd, "Meja Beranger");
	$excel->setActiveSheetIndex(0)->getStyle('V'.$row_scd)->getAlignment()->setWrapText(true);
	$excel->getActiveSheet()->getStyle('V'.$row_scd)->getAlignment()->setTextRotation(90);

	$excel->getActiveSheet()->mergeCells('W6:X6');
	$excel->setActiveSheetIndex(0)->setCellValue('W'.$row_scd, "Pegas");
	$excel->setActiveSheetIndex(0)->getStyle('W'.$row_scd)->getAlignment()->setWrapText(true);

	$excel->getActiveSheet()->mergeCells('Y6:Z6');
	$excel->setActiveSheetIndex(0)->setCellValue('Y'.$row_scd, "Cepat");
	$excel->setActiveSheetIndex(0)->getStyle('Y'.$row_scd)->getAlignment()->setWrapText(true);

	$excel->getActiveSheet()->mergeCells('AA6:AF6');
	$excel->setActiveSheetIndex(0)->setCellValue('AA'.$row_scd, "Elektronik");
	$excel->setActiveSheetIndex(0)->getStyle('AA'.$row_scd)->getAlignment()->setWrapText(true);

	// $excel->getActiveSheet()->mergeCells('W'.$row_trd);
	$excel->setActiveSheetIndex(0)->setCellValue('W'.$row_trd, "Kap. s/d 25 kg");
	$excel->setActiveSheetIndex(0)->getStyle('W'.$row_trd)->getAlignment()->setWrapText(true);
	$excel->getActiveSheet()->getStyle('W'.$row_trd)->getAlignment()->setTextRotation(90);

	// $excel->getActiveSheet()->mergeCells('X'.$row_trd);
	$excel->setActiveSheetIndex(0)->setCellValue('X'.$row_trd, "> 25 kg");
	$excel->setActiveSheetIndex(0)->getStyle('X'.$row_trd)->getAlignment()->setWrapText(true);
	$excel->getActiveSheet()->getStyle('X'.$row_trd)->getAlignment()->setTextRotation(90);

	// $excel->getActiveSheet()->mergeCells('Y'.$row_trd);
	$excel->setActiveSheetIndex(0)->setCellValue('Y'.$row_trd, "Kap. s/d 500 kg");
	$excel->setActiveSheetIndex(0)->getStyle('Y'.$row_trd)->getAlignment()->setWrapText(true);
	$excel->getActiveSheet()->getStyle('Y'.$row_trd)->getAlignment()->setTextRotation(90);

	// $excel->getActiveSheet()->mergeCells('Z'.$row_trd);
	$excel->setActiveSheetIndex(0)->setCellValue('Z'.$row_trd, "> 500 kg");
	$excel->setActiveSheetIndex(0)->getStyle('Z'.$row_trd)->getAlignment()->setWrapText(true);
	$excel->getActiveSheet()->getStyle('Z'.$row_trd)->getAlignment()->setTextRotation(90);

	// $excel->getActiveSheet()->mergeCells('AA'.$row_trd);
	$excel->setActiveSheetIndex(0)->setCellValue('AA'.$row_trd, "Kap. s/d 25 kg");
	$excel->setActiveSheetIndex(0)->getStyle('AA'.$row_trd)->getAlignment()->setWrapText(true);
	$excel->getActiveSheet()->getStyle('AA'.$row_trd)->getAlignment()->setTextRotation(90);

	// $excel->getActiveSheet()->mergeCells('AB'.$row_trd);
	$excel->setActiveSheetIndex(0)->setCellValue('AB'.$row_trd, "25 kg < EI ≤ 150 kg");
	$excel->setActiveSheetIndex(0)->getStyle('AB'.$row_trd)->getAlignment()->setWrapText(true);
	$excel->getActiveSheet()->getStyle('AB'.$row_trd)->getAlignment()->setTextRotation(90);

	// $excel->getActiveSheet()->mergeCells('AC'.$row_trd);
	$excel->setActiveSheetIndex(0)->setCellValue('AC'.$row_trd, "150 kg < EI ≤ 500 kg");
	$excel->setActiveSheetIndex(0)->getStyle('AC'.$row_trd)->getAlignment()->setWrapText(true);
	$excel->getActiveSheet()->getStyle('AC'.$row_trd)->getAlignment()->setTextRotation(90);

	// $excel->getActiveSheet()->mergeCells('AD'.$row_trd);
	$excel->setActiveSheetIndex(0)->setCellValue('AD'.$row_trd, "500 kg < EI ≤ 1000 kg");
	$excel->setActiveSheetIndex(0)->getStyle('AD'.$row_trd)->getAlignment()->setWrapText(true);
	$excel->getActiveSheet()->getStyle('AD'.$row_trd)->getAlignment()->setTextRotation(90);

	// $excel->getActiveSheet()->mergeCells('AE'.$row_trd);
	$excel->setActiveSheetIndex(0)->setCellValue('AE'.$row_trd, "Kap. s/d 1 kg");
	$excel->setActiveSheetIndex(0)->getStyle('AE'.$row_trd)->getAlignment()->setWrapText(true);
	$excel->getActiveSheet()->getStyle('AE'.$row_trd)->getAlignment()->setTextRotation(90);

	// $excel->getActiveSheet()->mergeCells('AF'.$row_trd);
	$excel->setActiveSheetIndex(0)->setCellValue('AF'.$row_trd, "> 1 kg");
	$excel->setActiveSheetIndex(0)->getStyle('AF'.$row_trd)->getAlignment()->setWrapText(true);
	$excel->getActiveSheet()->getStyle('AF'.$row_trd)->getAlignment()->setTextRotation(90);

	// ================================================================================================

	$excel->getActiveSheet()->mergeCells('AG5:AH5');
	$excel->setActiveSheetIndex(0)->setCellValue('AG'.$row_fst, "SERBA-SERBI");
	$excel->setActiveSheetIndex(0)->getStyle('AG'.$row_fst)->getAlignment()->setWrapText(true);

	$excel->getActiveSheet()->mergeCells('AG'.$row_scd.':AG'.$row_trd);
	$excel->setActiveSheetIndex(0)->setCellValue('AG'.$row_scd, "Uraian");
	$excel->setActiveSheetIndex(0)->getStyle('AG'.$row_scd)->getAlignment()->setWrapText(true);

	$excel->getActiveSheet()->mergeCells('AH'.$row_scd.':AH'.$row_trd);
	$excel->setActiveSheetIndex(0)->setCellValue('AH'.$row_scd, "Jumlah Serba-Serbi");
	$excel->setActiveSheetIndex(0)->getStyle('AH'.$row_scd)->getAlignment()->setWrapText(true);

	// ================================================================================================

	$excel->getActiveSheet()->mergeCells('AI'.$row_fst.':AI'.$row_trd);
	$excel->setActiveSheetIndex(0)->setCellValue('AI'.$row_fst, "Jumlah Uang");
	$excel->setActiveSheetIndex(0)->getStyle('AI'.$row_fst)->getAlignment()->setWrapText(true);

	$excel->getActiveSheet()->mergeCells('AJ'.$row_fst.':AJ'.$row_trd);
	$excel->setActiveSheetIndex(0)->setCellValue('AJ'.$row_fst, "Keterangan");
	$excel->setActiveSheetIndex(0)->getStyle('AJ'.$row_fst)->getAlignment()->setWrapText(true);

	// ================================================================================================

	for ($i=0; $i < 36; $i++) { 
		$numb = $i + 1;
		$cols = PHPExcel_Cell::stringFromColumnIndex($i);

		$excel->setActiveSheetIndex(0)->setCellValue($cols.$row_frt, $numb);
		$excel->setActiveSheetIndex(0)->getStyle($cols.$row_frt)->getAlignment()->setWrapText(true);
	}	

	// ================================================================================================

	// Apply style 
	$excel->getActiveSheet()->getStyle('A'.$row_fst)->applyFromArray($style_header1);
	$excel->getActiveSheet()->getStyle('B'.$row_fst)->applyFromArray($style_header1);
	$excel->getActiveSheet()->getStyle('C'.$row_fst)->applyFromArray($style_header1);
	$excel->getActiveSheet()->getStyle('D'.$row_fst)->applyFromArray($style_header1);
	$excel->getActiveSheet()->getStyle('E'.$row_fst)->applyFromArray($style_header1);
	$excel->getActiveSheet()->getStyle('F'.$row_fst)->applyFromArray($style_header1);
	$excel->getActiveSheet()->getStyle('G'.$row_fst)->applyFromArray($style_header1);
	$excel->getActiveSheet()->getStyle('H'.$row_fst)->applyFromArray($style_header1);
	$excel->getActiveSheet()->getStyle('I'.$row_fst)->applyFromArray($style_header1);
	$excel->getActiveSheet()->getStyle('J'.$row_fst)->applyFromArray($style_header1);
	$excel->getActiveSheet()->getStyle('K'.$row_fst)->applyFromArray($style_header1);
	$excel->getActiveSheet()->getStyle('L'.$row_fst)->applyFromArray($style_header1);
	$excel->getActiveSheet()->getStyle('M'.$row_fst)->applyFromArray($style_header1);
	$excel->getActiveSheet()->getStyle('N'.$row_fst)->applyFromArray($style_header1);
	$excel->getActiveSheet()->getStyle('O'.$row_fst)->applyFromArray($style_header1);
	$excel->getActiveSheet()->getStyle('P'.$row_fst)->applyFromArray($style_header1);
	$excel->getActiveSheet()->getStyle('Q'.$row_fst)->applyFromArray($style_header1);
	$excel->getActiveSheet()->getStyle('R'.$row_fst)->applyFromArray($style_header1);
	$excel->getActiveSheet()->getStyle('S'.$row_fst)->applyFromArray($style_header1);
	$excel->getActiveSheet()->getStyle('T'.$row_fst)->applyFromArray($style_header1);
	$excel->getActiveSheet()->getStyle('U'.$row_fst)->applyFromArray($style_header1);
	$excel->getActiveSheet()->getStyle('V'.$row_fst)->applyFromArray($style_header1);
	$excel->getActiveSheet()->getStyle('W'.$row_fst)->applyFromArray($style_header1);
	$excel->getActiveSheet()->getStyle('X'.$row_fst)->applyFromArray($style_header1);
	$excel->getActiveSheet()->getStyle('Y'.$row_fst)->applyFromArray($style_header1);
	$excel->getActiveSheet()->getStyle('Z'.$row_fst)->applyFromArray($style_header1);
	$excel->getActiveSheet()->getStyle('AA'.$row_fst)->applyFromArray($style_header1);
	$excel->getActiveSheet()->getStyle('AB'.$row_fst)->applyFromArray($style_header1);
	$excel->getActiveSheet()->getStyle('AC'.$row_fst)->applyFromArray($style_header1);
	$excel->getActiveSheet()->getStyle('AD'.$row_fst)->applyFromArray($style_header1);
	$excel->getActiveSheet()->getStyle('AE'.$row_fst)->applyFromArray($style_header1);
	$excel->getActiveSheet()->getStyle('AF'.$row_fst)->applyFromArray($style_header1);
	$excel->getActiveSheet()->getStyle('AG'.$row_fst)->applyFromArray($style_header1);
	$excel->getActiveSheet()->getStyle('AH'.$row_fst)->applyFromArray($style_header1);
	$excel->getActiveSheet()->getStyle('AI'.$row_fst)->applyFromArray($style_header1);
	$excel->getActiveSheet()->getStyle('AJ'.$row_fst)->applyFromArray($style_header1);

	$excel->getActiveSheet()->getStyle('A'.$row_scd)->applyFromArray($style_header2);
	$excel->getActiveSheet()->getStyle('B'.$row_scd)->applyFromArray($style_header2);
	$excel->getActiveSheet()->getStyle('C'.$row_scd)->applyFromArray($style_header2);
	$excel->getActiveSheet()->getStyle('D'.$row_scd)->applyFromArray($style_header2);
	$excel->getActiveSheet()->getStyle('E'.$row_scd)->applyFromArray($style_header2);
	$excel->getActiveSheet()->getStyle('F'.$row_scd)->applyFromArray($style_header1);
	$excel->getActiveSheet()->getStyle('G'.$row_scd)->applyFromArray($style_header1);
	$excel->getActiveSheet()->getStyle('H'.$row_scd)->applyFromArray($style_header1);
	$excel->getActiveSheet()->getStyle('I'.$row_scd)->applyFromArray($style_header1);
	$excel->getActiveSheet()->getStyle('J'.$row_scd)->applyFromArray($style_header1);
	$excel->getActiveSheet()->getStyle('K'.$row_scd)->applyFromArray($style_header1);
	$excel->getActiveSheet()->getStyle('L'.$row_scd)->applyFromArray($style_header1);
	$excel->getActiveSheet()->getStyle('M'.$row_scd)->applyFromArray($style_header1);
	$excel->getActiveSheet()->getStyle('N'.$row_scd)->applyFromArray($style_header1);
	$excel->getActiveSheet()->getStyle('O'.$row_scd)->applyFromArray($style_header1);
	$excel->getActiveSheet()->getStyle('P'.$row_scd)->applyFromArray($style_header1);
	$excel->getActiveSheet()->getStyle('Q'.$row_scd)->applyFromArray($style_header1);
	$excel->getActiveSheet()->getStyle('R'.$row_scd)->applyFromArray($style_header1);
	$excel->getActiveSheet()->getStyle('S'.$row_scd)->applyFromArray($style_header1);
	$excel->getActiveSheet()->getStyle('T'.$row_scd)->applyFromArray($style_header1);
	$excel->getActiveSheet()->getStyle('U'.$row_scd)->applyFromArray($style_header1);
	$excel->getActiveSheet()->getStyle('V'.$row_scd)->applyFromArray($style_header1);
	$excel->getActiveSheet()->getStyle('W'.$row_scd)->applyFromArray($style_header1);
	$excel->getActiveSheet()->getStyle('X'.$row_scd)->applyFromArray($style_header1);
	$excel->getActiveSheet()->getStyle('Y'.$row_scd)->applyFromArray($style_header1);
	$excel->getActiveSheet()->getStyle('Z'.$row_scd)->applyFromArray($style_header1);
	$excel->getActiveSheet()->getStyle('AA'.$row_scd)->applyFromArray($style_header1);
	$excel->getActiveSheet()->getStyle('AB'.$row_scd)->applyFromArray($style_header1);
	$excel->getActiveSheet()->getStyle('AC'.$row_scd)->applyFromArray($style_header1);
	$excel->getActiveSheet()->getStyle('AD'.$row_scd)->applyFromArray($style_header1);
	$excel->getActiveSheet()->getStyle('AE'.$row_scd)->applyFromArray($style_header1);
	$excel->getActiveSheet()->getStyle('AF'.$row_scd)->applyFromArray($style_header1);
	$excel->getActiveSheet()->getStyle('AG'.$row_scd)->applyFromArray($style_header1);
	$excel->getActiveSheet()->getStyle('AH'.$row_scd)->applyFromArray($style_header1);
	$excel->getActiveSheet()->getStyle('AI'.$row_scd)->applyFromArray($style_header2);
	$excel->getActiveSheet()->getStyle('AJ'.$row_scd)->applyFromArray($style_header2);

	$excel->getActiveSheet()->getStyle('A'.$row_trd)->applyFromArray($style_header3);
	$excel->getActiveSheet()->getStyle('B'.$row_trd)->applyFromArray($style_header3);
	$excel->getActiveSheet()->getStyle('C'.$row_trd)->applyFromArray($style_header3);
	$excel->getActiveSheet()->getStyle('D'.$row_trd)->applyFromArray($style_header3);
	$excel->getActiveSheet()->getStyle('E'.$row_trd)->applyFromArray($style_header3);
	$excel->getActiveSheet()->getStyle('F'.$row_trd)->applyFromArray($style_header3);
	$excel->getActiveSheet()->getStyle('G'.$row_trd)->applyFromArray($style_header3);
	$excel->getActiveSheet()->getStyle('H'.$row_trd)->applyFromArray($style_header4);
	$excel->getActiveSheet()->getStyle('I'.$row_trd)->applyFromArray($style_header4);
	$excel->getActiveSheet()->getStyle('J'.$row_trd)->applyFromArray($style_header4);
	$excel->getActiveSheet()->getStyle('K'.$row_trd)->applyFromArray($style_header4);
	$excel->getActiveSheet()->getStyle('L'.$row_trd)->applyFromArray($style_header4);
	$excel->getActiveSheet()->getStyle('M'.$row_trd)->applyFromArray($style_header3);
	$excel->getActiveSheet()->getStyle('N'.$row_trd)->applyFromArray($style_header4);
	$excel->getActiveSheet()->getStyle('O'.$row_trd)->applyFromArray($style_header4);
	$excel->getActiveSheet()->getStyle('P'.$row_trd)->applyFromArray($style_header4);
	$excel->getActiveSheet()->getStyle('Q'.$row_trd)->applyFromArray($style_header4);
	$excel->getActiveSheet()->getStyle('R'.$row_trd)->applyFromArray($style_header4);
	$excel->getActiveSheet()->getStyle('S'.$row_trd)->applyFromArray($style_header4);
	$excel->getActiveSheet()->getStyle('T'.$row_trd)->applyFromArray($style_header4);
	$excel->getActiveSheet()->getStyle('U'.$row_trd)->applyFromArray($style_header4);
	$excel->getActiveSheet()->getStyle('V'.$row_trd)->applyFromArray($style_header3);
	$excel->getActiveSheet()->getStyle('W'.$row_trd)->applyFromArray($style_header4);
	$excel->getActiveSheet()->getStyle('X'.$row_trd)->applyFromArray($style_header4);
	$excel->getActiveSheet()->getStyle('Y'.$row_trd)->applyFromArray($style_header4);
	$excel->getActiveSheet()->getStyle('Z'.$row_trd)->applyFromArray($style_header4);
	$excel->getActiveSheet()->getStyle('AA'.$row_trd)->applyFromArray($style_header4);
	$excel->getActiveSheet()->getStyle('AB'.$row_trd)->applyFromArray($style_header4);
	$excel->getActiveSheet()->getStyle('AC'.$row_trd)->applyFromArray($style_header4);
	$excel->getActiveSheet()->getStyle('AD'.$row_trd)->applyFromArray($style_header4);
	$excel->getActiveSheet()->getStyle('AE'.$row_trd)->applyFromArray($style_header4);
	$excel->getActiveSheet()->getStyle('AF'.$row_trd)->applyFromArray($style_header4);
	$excel->getActiveSheet()->getStyle('AG'.$row_trd)->applyFromArray($style_header3);
	$excel->getActiveSheet()->getStyle('AH'.$row_trd)->applyFromArray($style_header3);
	$excel->getActiveSheet()->getStyle('AI'.$row_trd)->applyFromArray($style_header3);
	$excel->getActiveSheet()->getStyle('AJ'.$row_trd)->applyFromArray($style_header3);

	$excel->getActiveSheet()->getStyle('A'.$row_frt)->applyFromArray($style_header4);
	$excel->getActiveSheet()->getStyle('B'.$row_frt)->applyFromArray($style_header4);
	$excel->getActiveSheet()->getStyle('C'.$row_frt)->applyFromArray($style_header4);
	$excel->getActiveSheet()->getStyle('D'.$row_frt)->applyFromArray($style_header4);
	$excel->getActiveSheet()->getStyle('E'.$row_frt)->applyFromArray($style_header4);
	$excel->getActiveSheet()->getStyle('F'.$row_frt)->applyFromArray($style_header4);
	$excel->getActiveSheet()->getStyle('G'.$row_frt)->applyFromArray($style_header4);
	$excel->getActiveSheet()->getStyle('H'.$row_frt)->applyFromArray($style_header4);
	$excel->getActiveSheet()->getStyle('I'.$row_frt)->applyFromArray($style_header4);
	$excel->getActiveSheet()->getStyle('J'.$row_frt)->applyFromArray($style_header4);
	$excel->getActiveSheet()->getStyle('K'.$row_frt)->applyFromArray($style_header4);
	$excel->getActiveSheet()->getStyle('L'.$row_frt)->applyFromArray($style_header4);
	$excel->getActiveSheet()->getStyle('M'.$row_frt)->applyFromArray($style_header4);
	$excel->getActiveSheet()->getStyle('N'.$row_frt)->applyFromArray($style_header4);
	$excel->getActiveSheet()->getStyle('O'.$row_frt)->applyFromArray($style_header4);
	$excel->getActiveSheet()->getStyle('P'.$row_frt)->applyFromArray($style_header4);
	$excel->getActiveSheet()->getStyle('Q'.$row_frt)->applyFromArray($style_header4);
	$excel->getActiveSheet()->getStyle('R'.$row_frt)->applyFromArray($style_header4);
	$excel->getActiveSheet()->getStyle('S'.$row_frt)->applyFromArray($style_header4);
	$excel->getActiveSheet()->getStyle('T'.$row_frt)->applyFromArray($style_header4);
	$excel->getActiveSheet()->getStyle('U'.$row_frt)->applyFromArray($style_header4);
	$excel->getActiveSheet()->getStyle('V'.$row_frt)->applyFromArray($style_header4);
	$excel->getActiveSheet()->getStyle('W'.$row_frt)->applyFromArray($style_header4);
	$excel->getActiveSheet()->getStyle('X'.$row_frt)->applyFromArray($style_header4);
	$excel->getActiveSheet()->getStyle('Y'.$row_frt)->applyFromArray($style_header4);
	$excel->getActiveSheet()->getStyle('Z'.$row_frt)->applyFromArray($style_header4);
	$excel->getActiveSheet()->getStyle('AA'.$row_frt)->applyFromArray($style_header4);
	$excel->getActiveSheet()->getStyle('AB'.$row_frt)->applyFromArray($style_header4);
	$excel->getActiveSheet()->getStyle('AC'.$row_frt)->applyFromArray($style_header4);
	$excel->getActiveSheet()->getStyle('AD'.$row_frt)->applyFromArray($style_header4);
	$excel->getActiveSheet()->getStyle('AE'.$row_frt)->applyFromArray($style_header4);
	$excel->getActiveSheet()->getStyle('AF'.$row_frt)->applyFromArray($style_header4);
	$excel->getActiveSheet()->getStyle('AG'.$row_frt)->applyFromArray($style_header4);
	$excel->getActiveSheet()->getStyle('AH'.$row_frt)->applyFromArray($style_header4);
	$excel->getActiveSheet()->getStyle('AI'.$row_frt)->applyFromArray($style_header4);
	$excel->getActiveSheet()->getStyle('AJ'.$row_frt)->applyFromArray($style_header4);

	// Set Repeat Header
	$excel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(8,8);

	// Set width kolom
	$excel->getActiveSheet()->getColumnDimension('A')->setWidth(6.85);
	$excel->getActiveSheet()->getColumnDimension('B')->setWidth(13);
	$excel->getActiveSheet()->getColumnDimension('C')->setWidth(21);
	$excel->getActiveSheet()->getColumnDimension('D')->setWidth(8);
	$excel->getActiveSheet()->getColumnDimension('E')->setWidth(8);
	$excel->getActiveSheet()->getColumnDimension('F')->setWidth(8);
	$excel->getActiveSheet()->getColumnDimension('G')->setWidth(8);
	$excel->getActiveSheet()->getColumnDimension('H')->setWidth(8);
	$excel->getActiveSheet()->getColumnDimension('I')->setWidth(8);
	$excel->getActiveSheet()->getColumnDimension('J')->setWidth(8);
	$excel->getActiveSheet()->getColumnDimension('K')->setWidth(8);
	$excel->getActiveSheet()->getColumnDimension('L')->setWidth(8);
	$excel->getActiveSheet()->getColumnDimension('M')->setWidth(8);
	$excel->getActiveSheet()->getColumnDimension('N')->setWidth(8);
	$excel->getActiveSheet()->getColumnDimension('O')->setWidth(8);
	$excel->getActiveSheet()->getColumnDimension('P')->setWidth(8);
	$excel->getActiveSheet()->getColumnDimension('Q')->setWidth(8);
	$excel->getActiveSheet()->getColumnDimension('R')->setWidth(8);
	$excel->getActiveSheet()->getColumnDimension('S')->setWidth(8);
	$excel->getActiveSheet()->getColumnDimension('T')->setWidth(8);
	$excel->getActiveSheet()->getColumnDimension('U')->setWidth(8);
	$excel->getActiveSheet()->getColumnDimension('V')->setWidth(8);
	$excel->getActiveSheet()->getColumnDimension('W')->setWidth(8);
	$excel->getActiveSheet()->getColumnDimension('X')->setWidth(8);
	$excel->getActiveSheet()->getColumnDimension('Y')->setWidth(8);
	$excel->getActiveSheet()->getColumnDimension('Z')->setWidth(8);
	$excel->getActiveSheet()->getColumnDimension('AA')->setWidth(8);
	$excel->getActiveSheet()->getColumnDimension('AB')->setWidth(8);
	$excel->getActiveSheet()->getColumnDimension('AC')->setWidth(8);
	$excel->getActiveSheet()->getColumnDimension('AD')->setWidth(8);
	$excel->getActiveSheet()->getColumnDimension('AE')->setWidth(8);
	$excel->getActiveSheet()->getColumnDimension('AF')->setWidth(8);
	$excel->getActiveSheet()->getColumnDimension('AG')->setWidth(12.20);
	$excel->getActiveSheet()->getColumnDimension('AH')->setWidth(12.20);
	$excel->getActiveSheet()->getColumnDimension('AI')->setWidth(12.5);
	$excel->getActiveSheet()->getColumnDimension('AJ')->setWidth(12);

	$excel->getActiveSheet()->getRowDimension($row_fst)->setRowHeight(27.75);
	$excel->getActiveSheet()->getRowDimension($row_scd)->setRowHeight(27.75);
	$excel->getActiveSheet()->getRowDimension($row_trd)->setRowHeight(130);


	// BARIS BODY / ISI DATA
	$no = 0;
	$row = $row_frt + 1;

	$tot_up1 = 0;
	$tot_up2 = 0;
	$tot_tk1 = 0;
	$tot_tk2 = 0;
	$tot_at1 = 0;
	$tot_at2 = 0;
	$tot_at3 = 0;
	$tot_at4 = 0;
	$tot_at5 = 0;
	$tot_nc = 0;
	$tot_dc1 = 0;
	$tot_dc2 = 0;
	$tot_ss1 = 0;
	$tot_ss2 = 0;
	$tot_ss3 = 0;
	$tot_bi1 = 0;
	$tot_bi2 = 0;
	$tot_bi3 = 0;
	$tot_mb = 0;
	$tot_pg1 = 0;
	$tot_pg2 = 0;
	$tot_cp1 = 0;
	$tot_cp2 = 0;
	$tot_el1 = 0;
	$tot_el2 = 0;
	$tot_el3 = 0;
	$tot_el4 = 0;
	$tot_el5 = 0;
	$tot_el6 = 0;
	$tot_uang = 0;
		
	foreach ($dataRegSidang as $lap) {
		$no++;

		$uang = ($lap->up1 * $lap->tarif_up1) +
                ($lap->up2 * $lap->tarif_up2) +
                ($lap->tk1 * $lap->tarif_tk1) +
                ($lap->tk2 * $lap->tarif_tk2) +
                ($lap->at1 * $lap->tarif_at1) +
                ($lap->at2 * $lap->tarif_at2) +
                ($lap->at3 * $lap->tarif_at3) +
                ($lap->at4 * $lap->tarif_at4) +
                ($lap->at5 * $lap->tarif_at5) +
                ($lap->nc * $lap->tarif_nc) +
                ($lap->dc1 * $lap->tarif_dc1) +
                ($lap->dc2 * $lap->tarif_dc2) +
                ($lap->ss1 * $lap->tarif_ss1) +
                ($lap->ss2 * $lap->tarif_ss2) +
                ($lap->ss3 * $lap->tarif_ss3) +
                ($lap->bi1 * $lap->tarif_bi1) +
                ($lap->bi2 * $lap->tarif_bi2) +
                ($lap->bi3 * $lap->tarif_bi3) +
                ($lap->mb * $lap->tarif_mb) +
                ($lap->pg1 * $lap->tarif_pg1) +
                ($lap->pg2 * $lap->tarif_pg2) +
                ($lap->cp1 * $lap->tarif_cp1) +
                ($lap->cp2 * $lap->tarif_cp2) +
                ($lap->el1 * $lap->tarif_el1) +
                ($lap->el2 * $lap->tarif_el2) +
                ($lap->el3 * $lap->tarif_el3) +
                ($lap->el4 * $lap->tarif_el4) +
                ($lap->el5 * $lap->tarif_el5) +
                ($lap->el6 * $lap->tarif_el6);

        $tot_uang += $uang;
        $tot_up1 += $lap->up1;
		$tot_up2 += $lap->up2;
		$tot_tk1 += $lap->tk1;
		$tot_tk2 += $lap->tk2;
		$tot_at1 += $lap->at1;
		$tot_at2 += $lap->at2;
		$tot_at3 += $lap->at3;
		$tot_at4 += $lap->at4;
		$tot_at5 += $lap->at5;
		$tot_nc += $lap->nc;
		$tot_dc1 += $lap->dc1;
		$tot_dc2 += $lap->dc2;
		$tot_ss1 += $lap->ss1;
		$tot_ss2 += $lap->ss2;
		$tot_ss3 += $lap->ss3;
		$tot_bi1 += $lap->bi1;
		$tot_bi2 += $lap->bi2;
		$tot_bi3 += $lap->bi3;
		$tot_mb += $lap->mb;
		$tot_pg1 += $lap->pg1;
		$tot_pg2 += $lap->pg2;
		$tot_cp1 += $lap->cp1;
		$tot_cp2 += $lap->cp2;
		$tot_el1 += $lap->el1;
		$tot_el2 += $lap->el2;
		$tot_el3 += $lap->el3;
		$tot_el4 += $lap->el4;
		$tot_el5 += $lap->el5;
		$tot_el6 += $lap->el6;

		// if ($lap->nama_usaha != null || $lap->nama_usaha != '') {
  //           $usr = $lap->nama_user.'/'.$lap->nama_usaha;
  //       } else {
  //           $usr = $lap->nama_user;
  //       }
		$excel->setActiveSheetIndex(0)->setCellValue('A'.$row, $no);
		$excel->setActiveSheetIndex(0)->setCellValue('B'.$row, date($lap->tgl_daftar));
		$excel->setActiveSheetIndex(0)->setCellValue('C'.$row, $lap->nama_user);
		$excel->setActiveSheetIndex(0)->setCellValue('D'.$row, $lap->up1);
		$excel->setActiveSheetIndex(0)->setCellValue('E'.$row, $lap->up2);
		$excel->setActiveSheetIndex(0)->setCellValue('F'.$row, $lap->tk1);
		$excel->setActiveSheetIndex(0)->setCellValue('G'.$row, $lap->tk2);
		$excel->setActiveSheetIndex(0)->setCellValue('H'.$row, $lap->at1);
		$excel->setActiveSheetIndex(0)->setCellValue('I'.$row, $lap->at2);
		$excel->setActiveSheetIndex(0)->setCellValue('J'.$row, $lap->at3);
		$excel->setActiveSheetIndex(0)->setCellValue('K'.$row, $lap->at4);
		$excel->setActiveSheetIndex(0)->setCellValue('L'.$row, $lap->at5);
		$excel->setActiveSheetIndex(0)->setCellValue('M'.$row, $lap->nc);
		$excel->setActiveSheetIndex(0)->setCellValue('N'.$row, $lap->dc1);
		$excel->setActiveSheetIndex(0)->setCellValue('O'.$row, $lap->dc2);
		$excel->setActiveSheetIndex(0)->setCellValue('P'.$row, $lap->ss1);
		$excel->setActiveSheetIndex(0)->setCellValue('Q'.$row, $lap->ss2);
		$excel->setActiveSheetIndex(0)->setCellValue('R'.$row, $lap->ss3);
		$excel->setActiveSheetIndex(0)->setCellValue('S'.$row, $lap->bi1);
		$excel->setActiveSheetIndex(0)->setCellValue('T'.$row, $lap->bi2);
		$excel->setActiveSheetIndex(0)->setCellValue('U'.$row, $lap->bi3);
		$excel->setActiveSheetIndex(0)->setCellValue('V'.$row, $lap->mb);
		$excel->setActiveSheetIndex(0)->setCellValue('W'.$row, $lap->pg1);
		$excel->setActiveSheetIndex(0)->setCellValue('X'.$row, $lap->pg2);
		$excel->setActiveSheetIndex(0)->setCellValue('Y'.$row, $lap->cp1);
		$excel->setActiveSheetIndex(0)->setCellValue('Z'.$row, $lap->cp2);
		$excel->setActiveSheetIndex(0)->setCellValue('AA'.$row, $lap->el1);
		$excel->setActiveSheetIndex(0)->setCellValue('AB'.$row, $lap->el2);
		$excel->setActiveSheetIndex(0)->setCellValue('AC'.$row, $lap->el3);
		$excel->setActiveSheetIndex(0)->setCellValue('AD'.$row, $lap->el4);
		$excel->setActiveSheetIndex(0)->setCellValue('AE'.$row, $lap->el5);
		$excel->setActiveSheetIndex(0)->setCellValue('AF'.$row, $lap->el6);
		// $excel->setActiveSheetIndex(0)->setCellValue('AG'.$row, nominal($lap->bi3));
		// $excel->setActiveSheetIndex(0)->setCellValue('AH'.$row, nominal($lap->bi3));
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('AI'.$row, nominal($uang), PHPExcel_Cell_DataType::TYPE_STRING);

		// $excel->setActiveSheetIndex(0)->setCellValue('AJ'.$row, nominal($lap->bi3));


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
		$excel->getActiveSheet()->getStyle('P'.$row)->applyFromArray($style_body3);
		$excel->getActiveSheet()->getStyle('Q'.$row)->applyFromArray($style_body3);
		$excel->getActiveSheet()->getStyle('R'.$row)->applyFromArray($style_body3);
		$excel->getActiveSheet()->getStyle('S'.$row)->applyFromArray($style_body3);
		$excel->getActiveSheet()->getStyle('T'.$row)->applyFromArray($style_body3);
		$excel->getActiveSheet()->getStyle('U'.$row)->applyFromArray($style_body3);
		$excel->getActiveSheet()->getStyle('V'.$row)->applyFromArray($style_body3);
		$excel->getActiveSheet()->getStyle('W'.$row)->applyFromArray($style_body3);
		$excel->getActiveSheet()->getStyle('X'.$row)->applyFromArray($style_body3);
		$excel->getActiveSheet()->getStyle('Y'.$row)->applyFromArray($style_body3);
		$excel->getActiveSheet()->getStyle('Z'.$row)->applyFromArray($style_body3);
		$excel->getActiveSheet()->getStyle('AA'.$row)->applyFromArray($style_body3);
		$excel->getActiveSheet()->getStyle('AB'.$row)->applyFromArray($style_body3);
		$excel->getActiveSheet()->getStyle('AC'.$row)->applyFromArray($style_body3);
		$excel->getActiveSheet()->getStyle('AD'.$row)->applyFromArray($style_body3);
		$excel->getActiveSheet()->getStyle('AE'.$row)->applyFromArray($style_body3);
		$excel->getActiveSheet()->getStyle('AF'.$row)->applyFromArray($style_body3);
		$excel->getActiveSheet()->getStyle('AG'.$row)->applyFromArray($style_body3);
		$excel->getActiveSheet()->getStyle('AH'.$row)->applyFromArray($style_body3);
		$excel->getActiveSheet()->getStyle('AI'.$row)->applyFromArray($style_body3);
		$excel->getActiveSheet()->getStyle('AJ'.$row)->applyFromArray($style_body3);

		$excel->getActiveSheet()->getRowDimension($row)->setRowHeight(20);

		$row++;
	}


	$excel->getActiveSheet()->mergeCells('A'.$row.':C'.$row);
	$excel->setActiveSheetIndex(0)->setCellValue('A'.$row, "TOTAL");
	$excel->getActiveSheet()->getStyle('A'.$row.':C'.$row)->applyFromArray($style_foot1);


	// $excel->setActiveSheetIndex(0)->setCellValue('E'.$row, $tot_setor);

	$excel->setActiveSheetIndex(0)->setCellValueExplicit('D'.$row, nominal($tot_up1), PHPExcel_Cell_DataType::TYPE_STRING);
	$excel->getActiveSheet()->getStyle('D'.$row)->applyFromArray($style_foot2);

	$excel->setActiveSheetIndex(0)->setCellValueExplicit('E'.$row, nominal($tot_up2), PHPExcel_Cell_DataType::TYPE_STRING);
	$excel->getActiveSheet()->getStyle('E'.$row)->applyFromArray($style_foot2);

	$excel->setActiveSheetIndex(0)->setCellValueExplicit('F'.$row, nominal($tot_tk1), PHPExcel_Cell_DataType::TYPE_STRING);
	$excel->getActiveSheet()->getStyle('F'.$row)->applyFromArray($style_foot2);

	$excel->setActiveSheetIndex(0)->setCellValueExplicit('G'.$row, nominal($tot_tk2), PHPExcel_Cell_DataType::TYPE_STRING);
	$excel->getActiveSheet()->getStyle('G'.$row)->applyFromArray($style_foot2);

	$excel->setActiveSheetIndex(0)->setCellValueExplicit('H'.$row, nominal($tot_at1), PHPExcel_Cell_DataType::TYPE_STRING);
	$excel->getActiveSheet()->getStyle('H'.$row)->applyFromArray($style_foot2);

	$excel->setActiveSheetIndex(0)->setCellValueExplicit('I'.$row, nominal($tot_at2), PHPExcel_Cell_DataType::TYPE_STRING);
	$excel->getActiveSheet()->getStyle('I'.$row)->applyFromArray($style_foot2);

	$excel->setActiveSheetIndex(0)->setCellValueExplicit('J'.$row, nominal($tot_at3), PHPExcel_Cell_DataType::TYPE_STRING);
	$excel->getActiveSheet()->getStyle('J'.$row)->applyFromArray($style_foot2);

	$excel->setActiveSheetIndex(0)->setCellValueExplicit('K'.$row, nominal($tot_at4), PHPExcel_Cell_DataType::TYPE_STRING);
	$excel->getActiveSheet()->getStyle('K'.$row)->applyFromArray($style_foot2);

	$excel->setActiveSheetIndex(0)->setCellValueExplicit('L'.$row, nominal($tot_at5), PHPExcel_Cell_DataType::TYPE_STRING);
	$excel->getActiveSheet()->getStyle('L'.$row)->applyFromArray($style_foot2);

	$excel->setActiveSheetIndex(0)->setCellValueExplicit('M'.$row, nominal($tot_nc), PHPExcel_Cell_DataType::TYPE_STRING);
	$excel->getActiveSheet()->getStyle('M'.$row)->applyFromArray($style_foot2);

	$excel->setActiveSheetIndex(0)->setCellValueExplicit('N'.$row, nominal($tot_dc1), PHPExcel_Cell_DataType::TYPE_STRING);
	$excel->getActiveSheet()->getStyle('N'.$row)->applyFromArray($style_foot2);

	$excel->setActiveSheetIndex(0)->setCellValueExplicit('O'.$row, nominal($tot_dc2), PHPExcel_Cell_DataType::TYPE_STRING);
	$excel->getActiveSheet()->getStyle('O'.$row)->applyFromArray($style_foot2);

	$excel->setActiveSheetIndex(0)->setCellValueExplicit('P'.$row, nominal($tot_ss1), PHPExcel_Cell_DataType::TYPE_STRING);
	$excel->getActiveSheet()->getStyle('P'.$row)->applyFromArray($style_foot2);

	$excel->setActiveSheetIndex(0)->setCellValueExplicit('Q'.$row, nominal($tot_ss2), PHPExcel_Cell_DataType::TYPE_STRING);
	$excel->getActiveSheet()->getStyle('Q'.$row)->applyFromArray($style_foot2);

	$excel->setActiveSheetIndex(0)->setCellValueExplicit('R'.$row, nominal($tot_ss3), PHPExcel_Cell_DataType::TYPE_STRING);
	$excel->getActiveSheet()->getStyle('R'.$row)->applyFromArray($style_foot2);

	$excel->setActiveSheetIndex(0)->setCellValueExplicit('S'.$row, nominal($tot_bi1), PHPExcel_Cell_DataType::TYPE_STRING);
	$excel->getActiveSheet()->getStyle('S'.$row)->applyFromArray($style_foot2);

	$excel->setActiveSheetIndex(0)->setCellValueExplicit('T'.$row, nominal($tot_bi2), PHPExcel_Cell_DataType::TYPE_STRING);
	$excel->getActiveSheet()->getStyle('T'.$row)->applyFromArray($style_foot2);

	$excel->setActiveSheetIndex(0)->setCellValueExplicit('U'.$row, nominal($tot_bi3), PHPExcel_Cell_DataType::TYPE_STRING);
	$excel->getActiveSheet()->getStyle('U'.$row)->applyFromArray($style_foot2);

	$excel->setActiveSheetIndex(0)->setCellValueExplicit('V'.$row, nominal($tot_mb), PHPExcel_Cell_DataType::TYPE_STRING);
	$excel->getActiveSheet()->getStyle('V'.$row)->applyFromArray($style_foot2);

	$excel->setActiveSheetIndex(0)->setCellValueExplicit('W'.$row, nominal($tot_pg1), PHPExcel_Cell_DataType::TYPE_STRING);
	$excel->getActiveSheet()->getStyle('W'.$row)->applyFromArray($style_foot2);

	$excel->setActiveSheetIndex(0)->setCellValueExplicit('X'.$row, nominal($tot_pg2), PHPExcel_Cell_DataType::TYPE_STRING);
	$excel->getActiveSheet()->getStyle('X'.$row)->applyFromArray($style_foot2);

	$excel->setActiveSheetIndex(0)->setCellValueExplicit('Y'.$row, nominal($tot_cp1), PHPExcel_Cell_DataType::TYPE_STRING);
	$excel->getActiveSheet()->getStyle('Y'.$row)->applyFromArray($style_foot2);

	$excel->setActiveSheetIndex(0)->setCellValueExplicit('Z'.$row, nominal($tot_cp2), PHPExcel_Cell_DataType::TYPE_STRING);
	$excel->getActiveSheet()->getStyle('Z'.$row)->applyFromArray($style_foot2);

	$excel->setActiveSheetIndex(0)->setCellValueExplicit('AA'.$row, nominal($tot_el1), PHPExcel_Cell_DataType::TYPE_STRING);
	$excel->getActiveSheet()->getStyle('AA'.$row)->applyFromArray($style_foot2);

	$excel->setActiveSheetIndex(0)->setCellValueExplicit('AB'.$row, nominal($tot_el2), PHPExcel_Cell_DataType::TYPE_STRING);
	$excel->getActiveSheet()->getStyle('AB'.$row)->applyFromArray($style_foot2);

	$excel->setActiveSheetIndex(0)->setCellValueExplicit('AC'.$row, nominal($tot_el3), PHPExcel_Cell_DataType::TYPE_STRING);
	$excel->getActiveSheet()->getStyle('AC'.$row)->applyFromArray($style_foot2);

	$excel->setActiveSheetIndex(0)->setCellValueExplicit('AD'.$row, nominal($tot_el4), PHPExcel_Cell_DataType::TYPE_STRING);
	$excel->getActiveSheet()->getStyle('AD'.$row)->applyFromArray($style_foot2);

	$excel->setActiveSheetIndex(0)->setCellValueExplicit('AE'.$row, nominal($tot_el5), PHPExcel_Cell_DataType::TYPE_STRING);
	$excel->getActiveSheet()->getStyle('AE'.$row)->applyFromArray($style_foot2);

	$excel->setActiveSheetIndex(0)->setCellValueExplicit('AF'.$row, nominal($tot_el6), PHPExcel_Cell_DataType::TYPE_STRING);
	$excel->getActiveSheet()->getStyle('AF'.$row)->applyFromArray($style_foot2);

	// $excel->setActiveSheetIndex(0)->setCellValueExplicit('AG'.$row, nominal($tot_el6), PHPExcel_Cell_DataType::TYPE_STRING);
	$excel->getActiveSheet()->getStyle('AG'.$row)->applyFromArray($style_foot2);

	// $excel->setActiveSheetIndex(0)->setCellValueExplicit('AH'.$row, nominal($tot_el6), PHPExcel_Cell_DataType::TYPE_STRING);
	$excel->getActiveSheet()->getStyle('AH'.$row)->applyFromArray($style_foot2);

	$excel->setActiveSheetIndex(0)->setCellValueExplicit('AI'.$row, nominal($tot_uang), PHPExcel_Cell_DataType::TYPE_STRING);
	$excel->getActiveSheet()->getStyle('AI'.$row)->applyFromArray($style_foot2);

	// $excel->setActiveSheetIndex(0)->setCellValueExplicit('AJ'.$row, nominal($tot_el6), PHPExcel_Cell_DataType::TYPE_STRING);
	$excel->getActiveSheet()->getStyle('AJ'.$row)->applyFromArray($style_foot2);


	$excel->getActiveSheet()->getRowDimension($row)->setRowHeight(20);


	// $newRow1 = $row + 2;
	// $newRow2 = $newRow1 + 1;
	// $newRow3 = $newRow2 + 1;
	// $newRow4 = $newRow3 + 1;
	// $newRow5 = $newRow4 + 4;
	// $newRow6 = $newRow5 + 1;
	// $newRow7 = $newRow6 + 1;
	// $excel->getActiveSheet()->mergeCells('O'.$newRow1.':U'.$newRow1);
	// $excel->setActiveSheetIndex(0)->setCellValue('O'.$newRow1,"Kota Mungkid, ".formatTanggalTtd(date('d-m-Y')));
	// $excel->getActiveSheet()->getStyle('O'.$newRow1)->getFont()->setName('Calibri');
	// $excel->getActiveSheet()->getStyle('O'.$newRow1)->getFont()->setSize(12);
	// $excel->getActiveSheet()->getStyle('O'.$newRow1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	// $excel->getActiveSheet()->mergeCells('O'.$newRow2.':U'.$newRow2);
	// $excel->setActiveSheetIndex(0)->setCellValue('O'.$newRow2,"KEPALA DINAS PERDAGANGAN, KOPERASI");
	// $excel->getActiveSheet()->getStyle('O'.$newRow2)->getFont()->setName('Calibri');
	// $excel->getActiveSheet()->getStyle('O'.$newRow2)->getFont()->setSize(12);
	// $excel->getActiveSheet()->getStyle('O'.$newRow2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	// $excel->getActiveSheet()->mergeCells('O'.$newRow3.':U'.$newRow3);
	// $excel->setActiveSheetIndex(0)->setCellValue('O'.$newRow3,"USAHA KECIL DAN MENENGAH");
	// $excel->getActiveSheet()->getStyle('O'.$newRow3)->getFont()->setName('Calibri');
	// $excel->getActiveSheet()->getStyle('O'.$newRow3)->getFont()->setSize(12);
	// $excel->getActiveSheet()->getStyle('O'.$newRow3)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	// $excel->getActiveSheet()->mergeCells('O'.$newRow4.':U'.$newRow4);
	// $excel->setActiveSheetIndex(0)->setCellValue('O'.$newRow4,"KABUPATEN MAGELANG");
	// $excel->getActiveSheet()->getStyle('O'.$newRow4)->getFont()->setName('Calibri');
	// $excel->getActiveSheet()->getStyle('O'.$newRow4)->getFont()->setSize(12);
	// $excel->getActiveSheet()->getStyle('O'.$newRow4)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	// $excel->getActiveSheet()->mergeCells('O'.$newRow5.':U'.$newRow5);
	// $excel->setActiveSheetIndex(0)->setCellValue('O'.$newRow5, $kepalaDinas->nama_user);
	// $excel->getActiveSheet()->getStyle('O'.$newRow5)->getFont()->setName('Calibri');
	// $excel->getActiveSheet()->getStyle('O'.$newRow5)->getFont()->setSize(12);
	// $excel->getActiveSheet()->getStyle('O'.$newRow5)->getFont()->setBold(TRUE);
	// $excel->getActiveSheet()->getStyle('O'.$newRow5)->getFont()->setUnderline(TRUE);
	// $excel->getActiveSheet()->getStyle('O'.$newRow5)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	// $excel->getActiveSheet()->mergeCells('O'.$newRow6.':U'.$newRow6);
	// $excel->setActiveSheetIndex(0)->setCellValue('O'.$newRow6, $kepalaDinas->golongan);
	// $excel->getActiveSheet()->getStyle('O'.$newRow6)->getFont()->setName('Calibri');
	// $excel->getActiveSheet()->getStyle('O'.$newRow6)->getFont()->setSize(12);
	// $excel->getActiveSheet()->getStyle('O'.$newRow6)->getFont()->setBold(TRUE);
	// $excel->getActiveSheet()->getStyle('O'.$newRow6)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	// $excel->getActiveSheet()->mergeCells('O'.$newRow7.':U'.$newRow7);
	// $excel->setActiveSheetIndex(0)->setCellValue('O'.$newRow7,"NIP. ".$kepalaDinas->nip);
	// $excel->getActiveSheet()->getStyle('O'.$newRow7)->getFont()->setName('Calibri');
	// $excel->getActiveSheet()->getStyle('O'.$newRow7)->getFont()->setSize(12);
	// $excel->getActiveSheet()->getStyle('O'.$newRow7)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	// MENGETAHUI
	// $excel->getActiveSheet()->mergeCells('B'.$newRow1.':D'.$newRow1);
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
	$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
	$excel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A3);

	// Set Footer
	$excel->getActiveSheet()->getHeaderFooter()->setOddFooter('&R Halaman Ke-&P dari &N');
	$excel->getActiveSheet()->getHeaderFooter()->setEvenFooter('&R Halaman Ke-&P dari &N');

	// Set judul file excel nya
	$excel->getActiveSheet(0)->setTitle("Rekap Tera Ulang Kantor");
	$excel->setActiveSheetIndex(0);
	// Proses file excel
	// ob_end_clean();
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment; filename="Rekap Tera Ulang Kantor '.$selectTglAwal.' Sampai '.$selectTglAkhir.'.xlsx"'); // Set nama file excel nya
	header('Cache-Control: max-age=0');
	ob_end_clean();
	$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
	$write->save('php://output');

 ?>