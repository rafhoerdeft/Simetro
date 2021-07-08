<?php 

	// Panggil class PHPExcel nya
	$excel = new PHPExcel();



	// Settingan awal fil excel
	$excel->getProperties()->setCreator('DISKOMINFO')
							->setLastModifiedBy('Erdeft')
							->setTitle("Daftar Sidang Tera ".$tgl_sidang)
							->setSubject("Tera/Tera Ulang UTTP")
							->setDescription("Daftar Sidang Tera ".$tgl_sidang)
							->setKeywords("Daftar Sidang Tera");



	// Buat sebuah variabel untuk menampung pengaturan style dari header tabel

	$style_title1 = array(

		'font' => array(
			'name'  => 'Arial Narrow',
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

			'name'  => 'Arial Narrow',

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

			// 'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis

			'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis

		),

		// 'fill' => array(

  //           'type' => PHPExcel_Style_Fill::FILL_SOLID,

  //           'color' => array('rgb' => 'cfd0d1')

  //       )

	);

	$style_header2 = array(

		'font' => array(

			'name'  => 'Arial Narrow',

	      	'bold' => TRUE,

	      	'size' => (11)

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

		// 'fill' => array(

  //           'type' => PHPExcel_Style_Fill::FILL_SOLID,

  //           'color' => array('rgb' => 'cfd0d1')

  //       )

	);



	$style_header3 = array(

		'font' => array(

			'name'  => 'Arial Narrow',

	      	'bold' => TRUE,

	      	'size' => (8)

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

		// 'fill' => array(

  //           'type' => PHPExcel_Style_Fill::FILL_SOLID,

  //           'color' => array('rgb' => 'cfd0d1')

  //       )

	);



	$style_foot1 = array(

		'font' => array(

			'name'  => 'Arial Narrow',

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
			'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_DOUBLE), // Set border bottom dengan garis tipis
			'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		)

		// 'fill' => array(
  //           'type' => PHPExcel_Style_Fill::FILL_SOLID,
  //           'color' => array('rgb' => '91cef2')
  //       )

	);



	$style_foot2 = array(

		'font' => array(
			'name'  => 'Arial Narrow',
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
			'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_DOUBLE), // Set border bottom dengan garis tipis
			'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		),

		// 'fill' => array(
  //           'type' => PHPExcel_Style_Fill::FILL_SOLID,
  //           'color' => array('rgb' => 'cfd0d1')
  //       )

	);

	$style_body_top = array(

		'font' => array(

			'name'  => 'Arial',
	      	'bold' => FALSE,
	      	'size' => (8)
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

			'name'  => 'Arial Narrow',

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

		// 'fill' => array(

  //           'type' => PHPExcel_Style_Fill::FILL_SOLID,

  //           'color' => array('rgb' => 'cfd0d1')

  //       )

	);



	$style_ket1 = array(

		'font' => array(
			'name'  => 'Calibri',
	      	'bold' => TRUE,
	      	'size' => (16),
	      	'underline' => TRUE,
	      	'italic'	=> TRUE
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
	);



	$style_ket2 = array(

		'font' => array(
			'name'  => 'Calibri',
	      	'bold' => TRUE,
	      	'size' => (10),
	      	'underline' => FALSE,
	      	'italic'	=> TRUE
		),

		'alignment' => array(
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, // Set text jadi ditengah secara horizontal (center)
			'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		),

		'borders' => array(
			// 'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
			// 'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
			// 'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
			'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		)
	);

	$style_ket3 = array(

		'font' => array(
			'name'  => 'Calibri',
	      	'bold' => TRUE,
	      	'size' => (10),
	      	'underline' => FALSE,
	      	'italic'	=> TRUE
		),

		'alignment' => array(
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, // Set text jadi ditengah secara horizontal (center)
			'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		),

		'borders' => array(
			// 'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
			'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
			// 'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
			// 'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		)
	);

	$style_ket4 = array(

		'font' => array(
			'name'  => 'Calibri',
	      	'bold' => FALSE,
	      	'size' => (13),
	      	'underline' => FALSE,
	      	'italic'	=> FALSE
		),

		'alignment' => array(
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, // Set text jadi ditengah secara horizontal (center)
			'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		),

		'borders' => array(
			'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
			// 'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
			'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
			'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		)
	);

	$style_ket5 = array(

		'font' => array(
			'name'  => 'Calibri',
	      	'bold' => FALSE,
	      	'size' => (13),
	      	'underline' => FALSE,
	      	'italic'	=> FALSE
		),

		'alignment' => array(
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, // Set text jadi ditengah secara horizontal (center)
			'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		),

		'borders' => array(
			'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
			'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
			'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
			// 'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		)
	);

	$style_ket6 = array(

		'font' => array(
			'name'  => 'Calibri',
	      	'bold' => TRUE,
	      	'size' => (13),
	      	'underline' => FALSE,
	      	'italic'	=> FALSE
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
	);

	$style_ket7 = array(

		'font' => array(
			'name'  => 'Calibri',
	      	'bold' => TRUE,
	      	'size' => (13),
	      	'underline' => FALSE,
	      	'italic'	=> FALSE
		),

		'alignment' => array(
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, // Set text jadi ditengah secara horizontal (center)
			'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		),

		'borders' => array(
			'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
			'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
			'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
			// 'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		)
	);

	$style_ket8 = array(

		'font' => array(
			'name'  => 'Calibri',
	      	'bold' => TRUE,
	      	'size' => (11),
	      	'underline' => FALSE,
	      	'italic'	=> FALSE
		),

		'alignment' => array(
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, // Set text jadi ditengah secara horizontal (center)
			'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		),

		'borders' => array(
			// 'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
			// 'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
			// 'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
			'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		)
	);

	$style_ket9 = array(

		'font' => array(
			'name'  => 'Calibri',
	      	'bold' => TRUE,
	      	'size' => (11),
	      	'underline' => FALSE,
	      	'italic'	=> FALSE
		),

		'alignment' => array(
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, // Set text jadi ditengah secara horizontal (center)
			'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		),

		'borders' => array(
			// 'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
			'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
			// 'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
			// 'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		)
	);

	$style_ket10 = array(

		'font' => array(
			'name'  => 'Calibri',
	      	'bold' => TRUE,
	      	'size' => (11),
	      	'underline' => FALSE,
	      	'italic'	=> FALSE
		),

		'alignment' => array(
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, // Set text jadi ditengah secara horizontal (center)
			'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		),

		'borders' => array(
			// 'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
			// 'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
			'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
			'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		)
	);

	$style_ket11 = array(

		'font' => array(
			'name'  => 'Calibri',
	      	'bold' => TRUE,
	      	'size' => (11),
	      	'underline' => FALSE,
	      	'italic'	=> FALSE
		),

		'alignment' => array(
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, // Set text jadi ditengah secara horizontal (center)
			'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		),

		'borders' => array(
			// 'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
			'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
			'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
			// 'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		)
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
	$excel->setActiveSheetIndex(0)->setCellValue('A1', "PENDAFTARAN UTTP DI PASAR LOS/KIOS");
	$excel->getActiveSheet()->getStyle('A1')->getFont()->setUnderline(TRUE);
	$excel->setActiveSheetIndex(0)->getStyle('A1')->getAlignment()->setWrapText(true);

	$excel->getActiveSheet()->mergeCells('A2:O2');
	$excel->setActiveSheetIndex(0)->setCellValue('A2', "DI KABUPATEN MAGELANG TAHUN ".date('Y', strtotime($tgl_sidang)));
	$excel->setActiveSheetIndex(0)->getStyle('A2')->getAlignment()->setWrapText(true);

	$excel->getActiveSheet()->mergeCells('A4:B4');
	$excel->setActiveSheetIndex(0)->setCellValue('A4', "Nama Pasar/Pertokoan");
	$excel->getActiveSheet()->getStyle('A4')->getFont()->setName('Arial');
	$excel->getActiveSheet()->getStyle('A4')->getFont()->setSize('11');
	$excel->setActiveSheetIndex(0)->getStyle('A4')->getAlignment()->setWrapText(true);

	$excel->setActiveSheetIndex(0)->setCellValue('C4', " : ".$nama_pasar);
	$excel->getActiveSheet()->getStyle('C4')->getFont()->setName('Arial');
	$excel->getActiveSheet()->getStyle('C4')->getFont()->setSize('11');
	$excel->getActiveSheet()->getStyle('C4')->getFont()->setBold(TRUE);
	$excel->setActiveSheetIndex(0)->getStyle('C4')->getAlignment()->setWrapText(true);

	$excel->getActiveSheet()->mergeCells('A5:B5');
	$excel->setActiveSheetIndex(0)->setCellValue('A5', "Hari/Tanggal");
	$excel->getActiveSheet()->getStyle('A5')->getFont()->setName('Arial');
	$excel->getActiveSheet()->getStyle('A5')->getFont()->setSize('11');
	$excel->setActiveSheetIndex(0)->getStyle('A5')->getAlignment()->setWrapText(true);

	$excel->setActiveSheetIndex(0)->setCellValue('C5', " : ".formatTanggal($tgl_sidang));
	$excel->getActiveSheet()->getStyle('C5')->getFont()->setName('Arial');
	$excel->getActiveSheet()->getStyle('C5')->getFont()->setSize('11');
	$excel->getActiveSheet()->getStyle('C5')->getFont()->setBold(TRUE);
	$excel->setActiveSheetIndex(0)->getStyle('C5')->getAlignment()->setWrapText(true);


	// Apply style 
	$excel->getActiveSheet()->getStyle('A1:Q1')->applyFromArray($style_title1);
	$excel->getActiveSheet()->getStyle('A2:Q2')->applyFromArray($style_title1);


	$row_first = 7;
	$row_bot = $row_first + 1;

	// BARIS HEADER
	$excel->getActiveSheet()->mergeCells('A'.$row_first.':A'.$row_bot);
	$excel->setActiveSheetIndex(0)->setCellValue('A'.$row_first, "No");
	$excel->setActiveSheetIndex(0)->getStyle('A'.$row_first)->getAlignment()->setWrapText(true);

	$excel->getActiveSheet()->mergeCells('B'.$row_first.':B'.$row_bot);
	$excel->setActiveSheetIndex(0)->setCellValue('B'.$row_first, "Nama Pemilik / Pengguna UTTP");
	$excel->setActiveSheetIndex(0)->getStyle('B'.$row_first)->getAlignment()->setWrapText(true);

	$excel->getActiveSheet()->mergeCells('C'.$row_first.':C'.$row_bot);
	$excel->setActiveSheetIndex(0)->setCellValue('C'.$row_first, "Alamat");
	$excel->setActiveSheetIndex(0)->getStyle('C'.$row_first)->getAlignment()->setWrapText(true);



	$excel->getActiveSheet()->mergeCells('D'.$row_first.':H'.$row_first);
	$excel->setActiveSheetIndex(0)->setCellValue('D'.$row_first, "Data Teknis UTTP");
	$excel->setActiveSheetIndex(0)->getStyle('D'.$row_first)->getAlignment()->setWrapText(true);

	$excel->setActiveSheetIndex(0)->setCellValue('D'.$row_bot, "Jenis");
	$excel->setActiveSheetIndex(0)->getStyle('D'.$row_bot)->getAlignment()->setWrapText(true);

	$excel->setActiveSheetIndex(0)->setCellValue('E'.$row_bot, "Kapasitas");
	$excel->setActiveSheetIndex(0)->getStyle('E'.$row_bot)->getAlignment()->setWrapText(true);

	$excel->setActiveSheetIndex(0)->setCellValue('F'.$row_bot, "Jumlah Timbangan");
	$excel->setActiveSheetIndex(0)->getStyle('F'.$row_bot)->getAlignment()->setWrapText(true);

	$excel->setActiveSheetIndex(0)->setCellValue('G'.$row_bot, "Jumlah Anak Timbangan");
	$excel->setActiveSheetIndex(0)->getStyle('G'.$row_bot)->getAlignment()->setWrapText(true);

	$excel->setActiveSheetIndex(0)->setCellValue('H'.$row_bot, "Jumlah Timbangan + Anak Timbangan");
	$excel->setActiveSheetIndex(0)->getStyle('H'.$row_bot)->getAlignment()->setWrapText(true);

	// ==========================================================================

	$excel->getActiveSheet()->mergeCells('I'.$row_first.':J'.$row_first);
	$excel->setActiveSheetIndex(0)->setCellValue('I'.$row_first, "Tanda Tera");
	$excel->setActiveSheetIndex(0)->getStyle('I'.$row_first)->getAlignment()->setWrapText(true);

	$excel->setActiveSheetIndex(0)->setCellValue('I'.$row_bot, "Berlaku");
	$excel->setActiveSheetIndex(0)->getStyle('I'.$row_bot)->getAlignment()->setWrapText(true);

	$excel->setActiveSheetIndex(0)->setCellValue('J'.$row_bot, "Tidak Berlaku");
	$excel->setActiveSheetIndex(0)->getStyle('J'.$row_bot)->getAlignment()->setWrapText(true);

	// ========================================================================

	$excel->getActiveSheet()->mergeCells('K'.$row_first.':L'.$row_first);
	$excel->setActiveSheetIndex(0)->setCellValue('K'.$row_first, "Kondisi");
	$excel->setActiveSheetIndex(0)->getStyle('K'.$row_first)->getAlignment()->setWrapText(true);

	$excel->setActiveSheetIndex(0)->setCellValue('K'.$row_bot, "Baik");
	$excel->setActiveSheetIndex(0)->getStyle('K'.$row_bot)->getAlignment()->setWrapText(true);

	$excel->setActiveSheetIndex(0)->setCellValue('L'.$row_bot, "Rusak");
	$excel->setActiveSheetIndex(0)->getStyle('L'.$row_bot)->getAlignment()->setWrapText(true);

	// ==========================================================================

	$excel->getActiveSheet()->mergeCells('M'.$row_first.':N'.$row_first);
	$excel->setActiveSheetIndex(0)->setCellValue('M'.$row_first, "Tindakan");
	$excel->setActiveSheetIndex(0)->getStyle('M'.$row_first)->getAlignment()->setWrapText(true);

	$excel->setActiveSheetIndex(0)->setCellValue('M'.$row_bot, "Ditera");
	$excel->setActiveSheetIndex(0)->getStyle('M'.$row_bot)->getAlignment()->setWrapText(true);

	$excel->setActiveSheetIndex(0)->setCellValue('N'.$row_bot, "Diganti");
	$excel->setActiveSheetIndex(0)->getStyle('N'.$row_bot)->getAlignment()->setWrapText(true);

	// =========================================================================

	$excel->getActiveSheet()->mergeCells('O'.$row_first.':O'.$row_bot);
	$excel->setActiveSheetIndex(0)->setCellValue('O'.$row_first, "Tarif (Rp)");
	$excel->setActiveSheetIndex(0)->getStyle('O'.$row_first)->getAlignment()->setWrapText(true);



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
	$excel->getActiveSheet()->getStyle('O'.$row_bot)->applyFromArray($style_header2);


	// Set width kolom
	$excel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
	$excel->getActiveSheet()->getColumnDimension('B')->setWidth(22.5);
	$excel->getActiveSheet()->getColumnDimension('C')->setWidth(22.5);
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
	$excel->getActiveSheet()->getColumnDimension('O')->setWidth(11.5);

	// Set Height Row
	$excel->getActiveSheet()->getRowDimension($row_first)->setRowHeight(20);
	$excel->getActiveSheet()->getRowDimension($row_bot)->setRowHeight(54.75);

	$row = $row_bot + 1;

	$excel->setActiveSheetIndex(0)->setCellValue('A'.$row, '1');
	$excel->getActiveSheet()->getStyle('A'.$row)->applyFromArray($style_body_top);
	$excel->setActiveSheetIndex(0)->setCellValue('B'.$row, '2');
	$excel->getActiveSheet()->getStyle('B'.$row)->applyFromArray($style_body_top);
	$excel->setActiveSheetIndex(0)->setCellValue('C'.$row, '3');
	$excel->getActiveSheet()->getStyle('C'.$row)->applyFromArray($style_body_top);
	$excel->setActiveSheetIndex(0)->setCellValue('D'.$row, '4');
	$excel->getActiveSheet()->getStyle('D'.$row)->applyFromArray($style_body_top);
	$excel->setActiveSheetIndex(0)->setCellValue('E'.$row, '5');
	$excel->getActiveSheet()->getStyle('E'.$row)->applyFromArray($style_body_top);
	$excel->setActiveSheetIndex(0)->setCellValue('F'.$row, '6');
	$excel->getActiveSheet()->getStyle('F'.$row)->applyFromArray($style_body_top);
	$excel->setActiveSheetIndex(0)->setCellValue('G'.$row, '7');
	$excel->getActiveSheet()->getStyle('G'.$row)->applyFromArray($style_body_top);
	$excel->setActiveSheetIndex(0)->setCellValue('H'.$row, '8');
	$excel->getActiveSheet()->getStyle('H'.$row)->applyFromArray($style_body_top);
	$excel->setActiveSheetIndex(0)->setCellValue('I'.$row, '9');
	$excel->getActiveSheet()->getStyle('I'.$row)->applyFromArray($style_body_top);
	$excel->setActiveSheetIndex(0)->setCellValue('J'.$row, '10');
	$excel->getActiveSheet()->getStyle('J'.$row)->applyFromArray($style_body_top);
	$excel->setActiveSheetIndex(0)->setCellValue('K'.$row, '11');
	$excel->getActiveSheet()->getStyle('K'.$row)->applyFromArray($style_body_top);
	$excel->setActiveSheetIndex(0)->setCellValue('L'.$row, '12');
	$excel->getActiveSheet()->getStyle('L'.$row)->applyFromArray($style_body_top);
	$excel->setActiveSheetIndex(0)->setCellValue('M'.$row, '13');
	$excel->getActiveSheet()->getStyle('M'.$row)->applyFromArray($style_body_top);
	$excel->setActiveSheetIndex(0)->setCellValue('N'.$row, '14');
	$excel->getActiveSheet()->getStyle('N'.$row)->applyFromArray($style_body_top);
	$excel->setActiveSheetIndex(0)->setCellValue('O'.$row, '15');
	$excel->getActiveSheet()->getStyle('O'.$row)->applyFromArray($style_body_top);

	// Set Repeat Header
	$excel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd($row, $row);

	// BARIS BODY / ISI DATA

	$no = 0;
	$row += 1;
	$tot_timbang = 0;
	$tot_anak_timbang = 0;
	$tot_all = 0;
	$tot_tarif = 0;

	$tot_tm = 0;
	$tot_ts = 0;
	$tot_dl = 0;
	$tot_tp = 0;
	$tot_te = 0;
	$tot_nr = 0;

	$grup_user = array();

	$tot_usr = 0;

	$tot_tb = 0;
	$tot_ttb = 0;

	foreach ($dataSidangTera as $lap) {

		if ($lap['kondisi']=='rusak') {
			$tot_ttb++;
		} else {
			$tot_tb++;
		}

		if (!in_array($lap['id_user_pasar'], $grup_user)) {
			$grup_user[] = $lap['id_user_pasar'];
		}

		if ($lap['jenis_timbangan'] == 'TM') {
			$tot_tm += $lap['jumlah_timbang'];
		} elseif ($lap['jenis_timbangan'] == 'T.Sent') {
			$tot_ts += $lap['jumlah_timbang'];
		} elseif ($lap['jenis_timbangan'] == 'DL') {
			$tot_dl += $lap['jumlah_timbang'];
		} elseif ($lap['jenis_timbangan'] == 'TP') {
			$tot_tp += $lap['jumlah_timbang'];
		} elseif ($lap['jenis_timbangan'] == 'TE') {
			$tot_te += $lap['jumlah_timbang'];
		} elseif ($lap['jenis_timbangan'] == 'NR') {
			$tot_nr += $lap['jumlah_timbang'];
		} 

		$trfTimbang = $lap['tarif_timbang'] * $lap['jumlah_timbang'];
        $trfAnakTimbang = 0;

        foreach ($dataTarifAnakTimbang as $trf) {
            if ($trf['id_list_sidang'] == $lap['id_list_sidang']) {
                $trfAnakTimbang += $trf['tarif_anak_timbang'] * $trf['jml_anak_timbang'];
            }
        }

        $tarif = $trfTimbang + $trfAnakTimbang;
        $tot_tarif += $tarif;
        $tot_timbang += $lap['jumlah_timbang'];
        $tot_anak_timbang += $lap['jumlah_anak_timbang'];
        // $tot_all += $tot_timbang + $tot_anak_timbang;

		$no++;
		$excel->setActiveSheetIndex(0)->setCellValue('A'.$row, $no);
		$excel->setActiveSheetIndex(0)->setCellValue('B'.$row, strtoupper($lap['nama_user']));
		$excel->setActiveSheetIndex(0)->setCellValue('C'.$row, $lap['alamat_user']);
		$excel->setActiveSheetIndex(0)->setCellValue('D'.$row, $lap['jenis_timbangan']);
		$excel->setActiveSheetIndex(0)->setCellValue('E'.$row, $lap['kapasitas']);
		$excel->setActiveSheetIndex(0)->setCellValue('F'.$row, $lap['jumlah_timbang']);
		$excel->setActiveSheetIndex(0)->setCellValue('G'.$row, ($lap['jumlah_anak_timbang'] != 0?($lap['jumlah_anak_timbang'] == null?0:$lap['jumlah_anak_timbang']):0));
		$excel->setActiveSheetIndex(0)->setCellValue('H'.$row, $lap['jumlah_timbang'] + $lap['jumlah_anak_timbang']);
		$excel->setActiveSheetIndex(0)->setCellValue('I'.$row, ($lap['kondisi']=='rusak'?'-':date('M Y', strtotime(($lap['berlaku'])))) );
		$excel->setActiveSheetIndex(0)->setCellValue('J'.$row, ($lap['kondisi']=='rusak'?date('M Y', strtotime($tgl_sidang)):date('M Y', strtotime(($lap['tidak_berlaku'])))) );
		$excel->setActiveSheetIndex(0)->setCellValue('K'.$row, ($lap['kondisi']=='baik'?'✓':'-'));
		$excel->setActiveSheetIndex(0)->setCellValue('L'.$row, ($lap['kondisi']=='rusak'?'✓':'-'));
		$excel->setActiveSheetIndex(0)->setCellValue('M'.$row, ($lap['tindakan']=='ditera'?'✓':'-'));
		$excel->setActiveSheetIndex(0)->setCellValue('N'.$row, ($lap['tindakan']=='diganti'?'✓':'-'));
		$excel->setActiveSheetIndex(0)->setCellValue('O'.$row, uang_koma($tarif), PHPExcel_Cell_DataType::TYPE_STRING);


    	$excel->getActiveSheet()->getStyle('A'.$row)->applyFromArray($style_body1);
		$excel->getActiveSheet()->getStyle('B'.$row)->applyFromArray($style_body2);
		$excel->getActiveSheet()->getStyle('C'.$row)->applyFromArray($style_body2);
		$excel->getActiveSheet()->getStyle('D'.$row)->applyFromArray($style_body1);
		$excel->getActiveSheet()->getStyle('E'.$row)->applyFromArray($style_body1);
		$excel->getActiveSheet()->getStyle('F'.$row)->applyFromArray($style_body1);
		$excel->getActiveSheet()->getStyle('G'.$row)->applyFromArray($style_body1);
		$excel->getActiveSheet()->getStyle('H'.$row)->applyFromArray($style_body1);
		$excel->getActiveSheet()->getStyle('I'.$row)->applyFromArray($style_body1);
		$excel->getActiveSheet()->getStyle('J'.$row)->applyFromArray($style_body1);
		$excel->getActiveSheet()->getStyle('K'.$row)->applyFromArray($style_body1);
		$excel->getActiveSheet()->getStyle('L'.$row)->applyFromArray($style_body1);
		$excel->getActiveSheet()->getStyle('M'.$row)->applyFromArray($style_body1);
		$excel->getActiveSheet()->getStyle('N'.$row)->applyFromArray($style_body1);
		$excel->getActiveSheet()->getStyle('O'.$row)->applyFromArray($style_body4);

		$excel->getActiveSheet()->getRowDimension($row)->setRowHeight(20);

		$row++;
	}


	$excel->getActiveSheet()->mergeCells('A'.$row.':E'.$row);
	$excel->setActiveSheetIndex(0)->setCellValue('A'.$row, "TOTAL");
	$excel->getActiveSheet()->getStyle('A'.$row.':E'.$row)->applyFromArray($style_foot1);

	$excel->setActiveSheetIndex(0)->setCellValueExplicit('F'.$row, $tot_timbang, PHPExcel_Cell_DataType::TYPE_STRING);
	$excel->getActiveSheet()->getStyle('F'.$row)->applyFromArray($style_foot1);

	$excel->setActiveSheetIndex(0)->setCellValueExplicit('G'.$row, $tot_anak_timbang, PHPExcel_Cell_DataType::TYPE_STRING);
	$excel->getActiveSheet()->getStyle('G'.$row)->applyFromArray($style_foot1);

	$excel->setActiveSheetIndex(0)->setCellValueExplicit('H'.$row, $tot_timbang + $tot_anak_timbang, PHPExcel_Cell_DataType::TYPE_STRING);
	$excel->getActiveSheet()->getStyle('H'.$row)->applyFromArray($style_foot1);

	$excel->getActiveSheet()->mergeCells('I'.$row.':N'.$row);
	$excel->setActiveSheetIndex(0)->setCellValue('I'.$row, "TOTAL TARIF");
	$excel->getActiveSheet()->getStyle('I'.$row.':N'.$row)->applyFromArray($style_foot1);

	$excel->setActiveSheetIndex(0)->setCellValueExplicit('O'.$row, uang_koma($tot_tarif), PHPExcel_Cell_DataType::TYPE_STRING);
	$excel->getActiveSheet()->getStyle('O'.$row)->applyFromArray($style_foot2);

	$excel->getActiveSheet()->getRowDimension($row)->setRowHeight(20);

	// =================================================================================

	$rowKet = $row + 1;

	$excel->getActiveSheet()->mergeCells('A'.$rowKet.':F'.$rowKet);
	$excel->setActiveSheetIndex(0)->setCellValue('A'.$rowKet, "KETERANGAN :");
	$excel->getActiveSheet()->getStyle('A'.$rowKet.':F'.$rowKet)->applyFromArray($style_ket1);

	$rowKet++;
	$excel->getActiveSheet()->mergeCells('A'.$rowKet.':B'.$rowKet);
	$excel->setActiveSheetIndex(0)->setCellValue('A'.$rowKet, "Tanda tera berlaku :");
	$excel->getActiveSheet()->getStyle('A'.$rowKet.':B'.$rowKet)->applyFromArray($style_ket2);

	$excel->getActiveSheet()->mergeCells('C'.$rowKet.':F'.$rowKet);
	$excel->setActiveSheetIndex(0)->setCellValue('C'.$rowKet, " : ".$tot_tb);
	$excel->getActiveSheet()->getStyle('C'.$rowKet.':F'.$rowKet)->applyFromArray($style_ket3);

	$rowKet++;
	$excel->getActiveSheet()->mergeCells('A'.$rowKet.':B'.$rowKet);
	$excel->setActiveSheetIndex(0)->setCellValue('A'.$rowKet, "Tanda tera tidak berlaku :");
	$excel->getActiveSheet()->getStyle('A'.$rowKet.':B'.$rowKet)->applyFromArray($style_ket2);

	$excel->getActiveSheet()->mergeCells('C'.$rowKet.':F'.$rowKet);
	$excel->setActiveSheetIndex(0)->setCellValue('C'.$rowKet, " : ".$tot_ttb);
	$excel->getActiveSheet()->getStyle('C'.$rowKet.':F'.$rowKet)->applyFromArray($style_ket3);

	// =======================================================================================

	$rowKet++;
	$excel->getActiveSheet()->mergeCells('A'.$rowKet.':F'.$rowKet);
	$excel->setActiveSheetIndex(0)->setCellValue('A'.$rowKet, "RINCIAN UTTP :");
	$excel->getActiveSheet()->getStyle('A'.$rowKet.':F'.$rowKet)->applyFromArray($style_ket1);

	$rowKet++;
	$excel->getActiveSheet()->mergeCells('A'.$rowKet.':D'.$rowKet);
	$excel->setActiveSheetIndex(0)->setCellValue('A'.$rowKet, "1. TIMBANGAN MEJA (TM)");
	$excel->getActiveSheet()->getStyle('A'.$rowKet.':D'.$rowKet)->applyFromArray($style_ket4);

	$excel->getActiveSheet()->mergeCells('E'.$rowKet.':F'.$rowKet);
	$excel->setActiveSheetIndex(0)->setCellValue('E'.$rowKet, $tot_tm);
	$excel->getActiveSheet()->getStyle('E'.$rowKet.':F'.$rowKet)->applyFromArray($style_ket5);

	$rowKet++;
	$excel->getActiveSheet()->mergeCells('A'.$rowKet.':D'.$rowKet);
	$excel->setActiveSheetIndex(0)->setCellValue('A'.$rowKet, "2. TIMBANGAN SENTISIMAL (T.SENT)");
	$excel->getActiveSheet()->getStyle('A'.$rowKet.':D'.$rowKet)->applyFromArray($style_ket4);

	$excel->getActiveSheet()->mergeCells('E'.$rowKet.':F'.$rowKet);
	$excel->setActiveSheetIndex(0)->setCellValue('E'.$rowKet, $tot_ts);
	$excel->getActiveSheet()->getStyle('E'.$rowKet.':F'.$rowKet)->applyFromArray($style_ket5);

	$rowKet++;
	$excel->getActiveSheet()->mergeCells('A'.$rowKet.':D'.$rowKet);
	$excel->setActiveSheetIndex(0)->setCellValue('A'.$rowKet, "3. DACIN LOGAM (DL)");
	$excel->getActiveSheet()->getStyle('A'.$rowKet.':D'.$rowKet)->applyFromArray($style_ket4);

	$excel->getActiveSheet()->mergeCells('E'.$rowKet.':F'.$rowKet);
	$excel->setActiveSheetIndex(0)->setCellValue('E'.$rowKet, $tot_dl);
	$excel->getActiveSheet()->getStyle('E'.$rowKet.':F'.$rowKet)->applyFromArray($style_ket5);

	$rowKet++;
	$excel->getActiveSheet()->mergeCells('A'.$rowKet.':D'.$rowKet);
	$excel->setActiveSheetIndex(0)->setCellValue('A'.$rowKet, "4. TIMBANGAN PEGAS (TP)");
	$excel->getActiveSheet()->getStyle('A'.$rowKet.':D'.$rowKet)->applyFromArray($style_ket4);

	$excel->getActiveSheet()->mergeCells('E'.$rowKet.':F'.$rowKet);
	$excel->setActiveSheetIndex(0)->setCellValue('E'.$rowKet, $tot_tp);
	$excel->getActiveSheet()->getStyle('E'.$rowKet.':F'.$rowKet)->applyFromArray($style_ket5);

	$rowKet++;
	$excel->getActiveSheet()->mergeCells('A'.$rowKet.':D'.$rowKet);
	$excel->setActiveSheetIndex(0)->setCellValue('A'.$rowKet, "5. TIMBANGAN ELEKTRONIK (TE)");
	$excel->getActiveSheet()->getStyle('A'.$rowKet.':D'.$rowKet)->applyFromArray($style_ket4);

	$excel->getActiveSheet()->mergeCells('E'.$rowKet.':F'.$rowKet);
	$excel->setActiveSheetIndex(0)->setCellValue('E'.$rowKet, $tot_te);
	$excel->getActiveSheet()->getStyle('E'.$rowKet.':F'.$rowKet)->applyFromArray($style_ket5);

	$rowKet++;
	$excel->getActiveSheet()->mergeCells('A'.$rowKet.':D'.$rowKet);
	$excel->setActiveSheetIndex(0)->setCellValue('A'.$rowKet, "6. NERACA EMAS (NR)");
	$excel->getActiveSheet()->getStyle('A'.$rowKet.':D'.$rowKet)->applyFromArray($style_ket4);

	$excel->getActiveSheet()->mergeCells('E'.$rowKet.':F'.$rowKet);
	$excel->setActiveSheetIndex(0)->setCellValue('E'.$rowKet, $tot_nr);
	$excel->getActiveSheet()->getStyle('E'.$rowKet.':F'.$rowKet)->applyFromArray($style_ket5);

	$rowKet++;
	$excel->getActiveSheet()->mergeCells('A'.$rowKet.':D'.$rowKet);
	$excel->setActiveSheetIndex(0)->setCellValue('A'.$rowKet, "7. ANAK TIMBANGAN (AT)");
	$excel->getActiveSheet()->getStyle('A'.$rowKet.':D'.$rowKet)->applyFromArray($style_ket4);

	$excel->getActiveSheet()->mergeCells('E'.$rowKet.':F'.$rowKet);
	$excel->setActiveSheetIndex(0)->setCellValue('E'.$rowKet, $tot_anak_timbang);
	$excel->getActiveSheet()->getStyle('E'.$rowKet.':F'.$rowKet)->applyFromArray($style_ket5);

	$rowKet++;
	$excel->getActiveSheet()->mergeCells('A'.$rowKet.':D'.$rowKet);
	$excel->setActiveSheetIndex(0)->setCellValue('A'.$rowKet, "JUMLAH UTTP");
	$excel->getActiveSheet()->getStyle('A'.$rowKet.':D'.$rowKet)->applyFromArray($style_ket6);

	$excel->getActiveSheet()->mergeCells('E'.$rowKet.':F'.$rowKet);
	$excel->setActiveSheetIndex(0)->setCellValue('E'.$rowKet, $tot_timbang + $tot_anak_timbang);
	$excel->getActiveSheet()->getStyle('E'.$rowKet.':F'.$rowKet)->applyFromArray($style_ket7);

	// ===========================================================================================

	$rowKet++;
	$excel->getActiveSheet()->mergeCells('A'.$rowKet.':F'.$rowKet);
	$excel->setActiveSheetIndex(0)->setCellValue('A'.$rowKet, "REKAPITULASI :");
	$excel->getActiveSheet()->getStyle('A'.$rowKet.':F'.$rowKet)->applyFromArray($style_ket1);

	$rowKet++;
	$excel->getActiveSheet()->mergeCells('A'.$rowKet.':C'.$rowKet);
	$excel->setActiveSheetIndex(0)->setCellValue('A'.$rowKet, "JUMLAH UTTP");
	$excel->getActiveSheet()->getStyle('A'.$rowKet.':C'.$rowKet)->applyFromArray($style_ket8);

	$excel->getActiveSheet()->mergeCells('D'.$rowKet.':F'.$rowKet);
	$excel->setActiveSheetIndex(0)->setCellValue('D'.$rowKet, " : ".($tot_timbang + $tot_anak_timbang).' UTTP');
	$excel->getActiveSheet()->getStyle('D'.$rowKet.':F'.$rowKet)->applyFromArray($style_ket9);

	$rowKet++;
	$excel->getActiveSheet()->mergeCells('A'.$rowKet.':C'.$rowKet);
	$excel->setActiveSheetIndex(0)->setCellValue('A'.$rowKet, "JUMLAH TIMBANGAN");
	$excel->getActiveSheet()->getStyle('A'.$rowKet.':C'.$rowKet)->applyFromArray($style_ket8);

	$excel->getActiveSheet()->mergeCells('D'.$rowKet.':F'.$rowKet);
	$excel->setActiveSheetIndex(0)->setCellValue('D'.$rowKet, " : ".$tot_timbang.' TIMBANGAN');
	$excel->getActiveSheet()->getStyle('D'.$rowKet.':F'.$rowKet)->applyFromArray($style_ket9);

	$rowKet++;
	$excel->getActiveSheet()->mergeCells('A'.$rowKet.':C'.$rowKet);
	$excel->setActiveSheetIndex(0)->setCellValue('A'.$rowKet, "JUMLAH PEMILIK UTTP");
	$excel->getActiveSheet()->getStyle('A'.$rowKet.':C'.$rowKet)->applyFromArray($style_ket10);

	$excel->getActiveSheet()->mergeCells('D'.$rowKet.':F'.$rowKet);
	$excel->setActiveSheetIndex(0)->setCellValue('D'.$rowKet, " : ".count($grup_user).' ORANG');
	$excel->getActiveSheet()->getStyle('D'.$rowKet.':F'.$rowKet)->applyFromArray($style_ket11);


	// =================================================================================

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
	$excel->setActiveSheetIndex(0)->setCellValue('K'.$newRow2,"Mengetahui,");
	$excel->getActiveSheet()->getStyle('K'.$newRow2)->getFont()->setName('Calibri');
	$excel->getActiveSheet()->getStyle('K'.$newRow2)->getFont()->setSize(12);
	$excel->getActiveSheet()->getStyle('K'.$newRow2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


	$excel->getActiveSheet()->mergeCells('K'.$newRow3.':O'.$newRow3);
	$excel->setActiveSheetIndex(0)->setCellValue('K'.$newRow3,"Kepala Bidang Metrologi");
	$excel->getActiveSheet()->getStyle('K'.$newRow3)->getFont()->setName('Calibri');
	$excel->getActiveSheet()->getStyle('K'.$newRow3)->getFont()->setSize(12);
	$excel->getActiveSheet()->getStyle('K'.$newRow3)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


	// $excel->getActiveSheet()->mergeCells('K'.$newRow4.':O'.$newRow4);
	// $excel->setActiveSheetIndex(0)->setCellValue('K'.$newRow4,"KABUPATEN MAGELANG");
	// $excel->getActiveSheet()->getStyle('K'.$newRow4)->getFont()->setName('Calibri');
	// $excel->getActiveSheet()->getStyle('K'.$newRow4)->getFont()->setSize(12);
	// $excel->getActiveSheet()->getStyle('K'.$newRow4)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


	$excel->getActiveSheet()->mergeCells('K'.$newRow5.':O'.$newRow5);
	$excel->setActiveSheetIndex(0)->setCellValue('K'.$newRow5, $kabid->nama_user);
	$excel->getActiveSheet()->getStyle('K'.$newRow5)->getFont()->setName('Calibri');
	$excel->getActiveSheet()->getStyle('K'.$newRow5)->getFont()->setSize(12);
	$excel->getActiveSheet()->getStyle('K'.$newRow5)->getFont()->setBold(TRUE);
	$excel->getActiveSheet()->getStyle('K'.$newRow5)->getFont()->setUnderline(TRUE);
	$excel->getActiveSheet()->getStyle('K'.$newRow5)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


	$excel->getActiveSheet()->mergeCells('K'.$newRow6.':O'.$newRow6);
	$excel->setActiveSheetIndex(0)->setCellValue('K'.$newRow6, $kabid->golongan);
	$excel->getActiveSheet()->getStyle('K'.$newRow6)->getFont()->setName('Calibri');
	$excel->getActiveSheet()->getStyle('K'.$newRow6)->getFont()->setSize(12);
	// $excel->getActiveSheet()->getStyle('K'.$newRow6)->getFont()->setBold(TRUE);
	$excel->getActiveSheet()->getStyle('K'.$newRow6)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


	$excel->getActiveSheet()->mergeCells('K'.$newRow7.':O'.$newRow7);
	$excel->setActiveSheetIndex(0)->setCellValue('K'.$newRow7,"NIP. ".$kabid->nip);
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

	$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

	$excel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LEGAL);



	// Set Footer

	$excel->getActiveSheet()->getHeaderFooter()->setOddFooter('&R Halaman Ke-&P dari &N');

	$excel->getActiveSheet()->getHeaderFooter()->setEvenFooter('&R Halaman Ke-&P dari &N');



	// Set judul file excel nya

	$excel->getActiveSheet(0)->setTitle("Daftar Sidang Tera");

	$excel->setActiveSheetIndex(0);

	// Proses file excel

	// ob_end_clean();

	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

	header('Content-Disposition: attachment; filename="Daftar Sidang Tera '.$nama_pasar.' '.date('d-m-Y', strtotime($tgl_sidang)).'.xlsx"'); // Set nama file excel nya

	header('Cache-Control: max-age=0');

	ob_end_clean();

	$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');

	$write->save('php://output');



 ?>