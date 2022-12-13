<?php

/**
 * File             : Report Model
 * @author          : Rhea Labayo
 * @copyright       : 2016 December
 * Date Updated     : December 1, 2016
 *
 */


Class ReportModel extends CI_Model
{

    Public function __construct()
    {
        parent::__construct();

        $db = $this->load->database();
    }
    
    public function getKoreanReport( $post_data ){
        $where = '';
        if( $post_data['principalPersonalNumber'] != '' ){
            $where = "( korean.dependent LIKE '".$post_data['principalPersonalNumber']."' OR korean.personal_number LIKE '".$post_data['principalPersonalNumber']."' ) AND ";
        }

        if( $post_data['dateType'] == 'visa_issue_date' ){
            $query  = $this->db->query("SELECT * FROM korean WHERE ".$where."( DATE( korean.visa_issue_date ) BETWEEN DATE( '".$post_data['startDate']."' ) AND DATE( '".$post_data['endDate']."' ) )");
        }else if( $post_data['dateType'] == 'visa_valid_until' ){
            $query  = $this->db->query("SELECT * FROM korean WHERE ".$where."( DATE( korean.visa_valid_until ) BETWEEN DATE( '".$post_data['startDate']."' ) AND DATE( '".$post_data['endDate']."' ) )");
        }else if( $post_data['dateType'] != 'visa_issue_date' AND $post_data['startDate'] != 'visa_valid_until'){
            $query  = $this->db->query("SELECT * FROM korean WHERE ".$where."( ( DATE( korean.visa_issue_date ) BETWEEN DATE( '".$post_data['startDate']."' ) AND DATE( '".$post_data['endDate']."' ) ) OR ( DATE( korean.visa_valid_until ) BETWEEN DATE( '".$post_data['startDate']."' ) AND DATE( '".$post_data['endDate']."' ) ) )");
        }
        $result = $query->result();
        return $result;
    }

    public function getOtherReport( $post_data ){
        $where = '';
        if( $post_data['principalPassportNumber'] != '' ){
            $where = "( others.dependent LIKE '".$post_data['principalPassportNumber']."' OR others.passport_number LIKE '".$post_data['principalPassportNumber']."' ) AND ";
        }
        if( $post_data['dateType'] == 'visa_issue_date' ){
            $query  = $this->db->query("SELECT * FROM others WHERE ".$where."( DATE( others.visa_issue_date ) BETWEEN DATE( '".$post_data['startDate']."' ) AND DATE( '".$post_data['endDate']."' ) ) ");
            $result = $query->result();
        }else if( $post_data['dateType'] == 'visa_valid_until' ){
            $query  = $this->db->query("SELECT * FROM others WHERE ".$where."( DATE( others.visa_valid_until ) BETWEEN DATE( '".$post_data['startDate']."' ) AND DATE( '".$post_data['endDate']."' ) ) ");
            $result = $query->result();
        }else if( $post_data['dateType'] != 'visa_issue_date' AND $post_data['startDate'] != 'visa_valid_until'){
            $query  = $this->db->query("SELECT * FROM others WHERE ".$where."( ( DATE( others.visa_issue_date ) BETWEEN DATE( '".$post_data['startDate']."' ) AND DATE( '".$post_data['endDate']."' ) ) OR ( DATE( others.visa_valid_until ) BETWEEN DATE( '".$post_data['startDate']."' ) AND DATE( '".$post_data['endDate']."' ) ) ) ");
            $result = $query->result();
        }

        return $result;
    }

    // function for creation of excel file
    public function createXlsFileToPath($data, $fileName, $path)
    {
        header('Content-Type: application/vnd.ms-excel');
        
        $fileName .= '.xls';
        //XLS File Request
        if (PHP_SAPI == 'cli') die('This example should only be run from a Web Browser');

        //  Include PHPExcel_IOFactory
        require_once APPPATH . "libraries/PHPExcel/IOFactory.php";
        /** Include PHPExcel */
        require_once APPPATH . "libraries/PHPExcel.php";

        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        // Set document properties
        $objPHPExcel->getProperties()->setCreator("Truserv")
            ->setLastModifiedBy("Rhea Labayo")
            ->setTitle("Truserv Report")
            ->setSubject("Truserv Report")
            ->setDescription("Truserv Report 2007 Excel file")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Truserv Report");

        if (empty($data)) {
            $data = array();
        }

        for ($row = 0; $row < count($data); $row++) {

            for ($col = 0; $col < count($data[$row]); $col++) {

                $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($col, $row + 1, htmlspecialchars_decode($data[$row][$col]));

            }
        }

        // Rename worksheet
        $objPHPExcel->getActiveSheet()->setTitle("Report");

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $filePath = $path . $fileName;

        $objWriter->save($filePath);

        return $filePath;
    }
}