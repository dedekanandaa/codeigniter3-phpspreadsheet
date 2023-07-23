<?php
   class export_excel extends CI_Controller {

   	function export_excel() {
         /* Data */
         $data = $this->home_model->fetch_transactions();
 
         /* Spreadsheet Init */
         $spreadsheet = new Spreadsheet();
         $sheet = $spreadsheet->getActiveSheet();
 
         /* Excel Header */
         $sheet->setCellValue('B5', 'No');
         $sheet->mergeCells('B5:B6');
 
         $sheet->setCellValue('C5', 'Kriteria');
         $sheet->mergeCells('C5:H5');
 
         $sheet->setCellValue('I5', 'Target');
 
         $sheet->setCellValue('C6', 'A');
         $sheet->setCellValue('D6', 'B');
         $sheet->setCellValue('E6', 'C');
         $sheet->setCellValue('F6', 'D');
         $sheet->setCellValue('G6', 'E');
         $sheet->setCellValue('H6', 'F');
         $sheet->setCellValue('I6', 'Z');
         
         /* Excel Data */
         $row_number = 7;
         foreach($data as $key => $row)
         {
             $sheet->setCellValue('B'.$row_number, $key+1);
             $sheet->setCellValue('C'.$row_number, $row['A']);
             $sheet->setCellValue('D'.$row_number, $row['B']);
             $sheet->setCellValue('E'.$row_number, $row['C']);
             $sheet->setCellValue('F'.$row_number, $row['D']);
             $sheet->setCellValue('G'.$row_number, $row['E']);
             $sheet->setCellValue('H'.$row_number, $row['F']);
             $sheet->setCellValue('I'.$row_number, $row['Z']);
         
             $row_number++;
         }
 
         //result
         for($i = 'c', $letter = 'a'; $i != 'j'; $i++, $letter++) {
            for($j = 1; $j <= 3; $j++) {
                 if($i === 'i') {
                     
                 } else {
                     $count = "=COUNTIF((".$i ."7:".$i.($row_number-1)."), '".$letter.$j."')";
                     $sheet->setCellValue($i.($row_number+$j), $count);
                     $sheet->getStyle($i.($row_number+$j))->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
                 }
             }
         }
 
         /* Styling */
         $sheet->getStyle('B5:I'.($row_number-1))->getAlignment()->setHorizontal('center');
         $sheet->getStyle('B5:I'.($row_number-1))->getAlignment()->setVertical('middle');
         $sheet->getStyle('B5:I'.($row_number-1))->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
 
         $sheet->getStyle('B5:I6')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
         $sheet->getStyle('B5:I6')->getFill()->getStartColor()->setARGB('538DD5');
 
         /* Excel File Format */
         $writer = new Xlsx($spreadsheet);
         $filename = 'excel-report';
         
         header('Content-Type: application/vnd.ms-excel');
         header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
         header('Cache-Control: max-age=0');
 
         $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
         $writer->save('php://output');
     }
   }
?>