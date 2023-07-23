<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class Home extends MY_Controller {

    /*
    |-------------------------------------------------------------------
    | Construct
    |-------------------------------------------------------------------
    | 
    */
    function __construct()
    {
        parent::__construct();
        $this->load->model('home_model');
    }

    /*
    |-------------------------------------------------------------------
    | Index
    |-------------------------------------------------------------------
    |
    */
	function index()
	{
        $data['title'] = 'Codeigniter 3 - PHPSpreadsheet';
        $data['transaction_list'] = $this->home_model->fetch_transactions();
        $data['total'] = $this->home_model->count();

        $this->load->view('frontend/homepage/header', $data);
        $this->load->view('frontend/homepage/content', $data);
        $this->load->view('frontend/homepage/footer', $data);
    }
    
    /*
    |-------------------------------------------------------------------
    | Import Excel
    |-------------------------------------------------------------------
    |
    */
	function import_excel()
	{
        $this->load->helper('file');

        /* Allowed MIME(s) File */
        $file_mimes = array(
            'application/octet-stream', 
            'application/vnd.ms-excel', 
            'application/x-csv', 
            'text/x-csv', 
            'text/csv', 
            'application/csv', 
            'application/excel', 
            'application/vnd.msexcel', 
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        );

        if(isset($_FILES['uploadFile']['name']) && in_array($_FILES['uploadFile']['type'], $file_mimes)) {

            $array_file = explode('.', $_FILES['uploadFile']['name']);
            $extension  = end($array_file);

            if('csv' == $extension) {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
            } else {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            }

            $spreadsheet = $reader->load($_FILES['uploadFile']['tmp_name']);
            $sheet_data  = $spreadsheet->getActiveSheet()->toArray();
            $array_data  = [];

            for($i = 6; $i < count($sheet_data)-1; $i++) {
                $data = array(
                    'A'=> $sheet_data[$i]['2'],
                    'B'=> $sheet_data[$i]['3'],
                    'C'=> $sheet_data[$i]['4'],
                    'D'=> $sheet_data[$i]['5'],
                    'E'=> $sheet_data[$i]['6'],
                    'F'=> $sheet_data[$i]['7'],
                    'Z'=> $sheet_data[$i]['8'],
                );
                $array_data[] = $data;
            }
            
            if($array_data != '') {
                $this->home_model->insert_transaction_batch($array_data);
            }
            $this->modal_feedback('success', 'Success', 'Data Imported', 'OK');
        } else {
            $this->modal_feedback('error', 'Error', 'Import failed', 'Try again');
        }
        redirect('/');
    }

    /*
    |-------------------------------------------------------------------
    | Export Excel
    |-------------------------------------------------------------------
    |
    */
	function export() {
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
                    $count = "=\"Z$j = \" &COUNTIF((".$i ."7:".$i.($row_number-1)."), \"Z$j\")";
                } else {
                    $count = "=\"$letter$j = \" &COUNTIF((".$i ."7:".$i.($row_number-1)."), \"$letter$j\")";
                }
                $cell = $i.($row_number+$j);
                $sheet->setCellValue($cell, $count);
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
        $writer->setPreCalculateFormulas(true);
        $writer->save('php://output');
    }
    
    function clear() {
        $this->home_model->clear();
        redirect('/');
    }
}
