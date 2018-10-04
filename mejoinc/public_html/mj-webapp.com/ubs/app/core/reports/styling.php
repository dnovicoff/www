<?php
// Header Row
$styleHeaderRow = array(
  'font'    => array(
    'bold'      => true
  ),
  'alignment' => array(
    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
  ),
  'borders' => array(
    'bottom'     => array(
      'style' => PHPExcel_Style_Border::BORDER_THICK
    )
  )
);

// Footer Row
$styleFooterRow = array(
  'font'    => array(
    'bold'      => true
  ),
  'alignment' => array(
    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
  ),
  'borders' => array(
    'top'     => array(
      'style' => PHPExcel_Style_Border::BORDER_THICK
    )
  )
);


// Fill in the blank
$styleBlankRow = array(
  'borders' => array(
    'bottom'     => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN
    )
  )
);
?>

