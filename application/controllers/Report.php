<?php

/**
 * File             : Report Controller
 * @author          : Rhea Labayo
 * @copyright       : 2016 December
 * Date Updated     : December 1, 2016
 *
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report extends CI_Controller
{

    function __construct()
    {
        parent::__construct();


        $this->load->database();
        $this->load->helper('url');
        $this->load->model('reportModel');
        $this->load->model('koreanModel');
        $this->load->model('otherModel');

    }

    public function index()
    {
        $this->load->database();

    }

    public function viewKoreanReports(){

        $this->load->model('koreanModel');
        $this->load->model('otherModel');

        // get the principal names
        $data['data']['koreanData'] = $this->koreanModel->korean_data();

        $notif = $this->koreanModel->korean_visa_to_be_expire(); // for notification
        $notification['data']['korean']['notificationCount']  = $notif['notificationCount'];
        $notification['data']['korean']['notification']       = $notif['notification'];

        $notifOthers = $this->otherModel->other_visa_to_be_expire(); // for notification
        $notification['data']['other']['notificationCount']  = $notifOthers['notificationCount'];
        $notification['data']['other']['notification']       = $notifOthers['notification'];

        $this->load->view('common/header', $notification);
        $this->load->view('report/koreanReport',$data);
        $this->load->view('common/footer');

    }

    public function getKoreanReport(){

        $result = $this->reportModel->getKoreanReport( $_POST );

        $data['result'] = $result;
        $data['status'] = FALSE;

        if( $result !== false ){
            $data['status'] = TRUE;

            // excel contents
            $fileData["fileName"] = 'Korean_Report_'. date("Y-m-d") ."_". time();
            $fileData["data"] = array();

            $fileData["data"][] = array("Date Start",$_POST['startDate']);
            $fileData["data"][] = array("Date End",$_POST['endDate']);
            $fileData["data"][] = array("Principal Personal Number",$_POST['principalPersonalNumber']);

            //Add the heading
            $fileData["data"][] = array(
                '#',
                'Principal\'s Personal Number',
                'Personal Number',
                'Folder Name',
                'Passport Number',
                'Name',
                'Gender',
                'Birthdate',
                'Contact Number',
                'Petitioner',
                'Visa Status',
                'Visa date Issue',
                'Visa Valid Until',
                'Others',
            );
            //Process the File Data
            foreach( $data['result'] as $key => $item ){
                $dependent = $item->dependent;
                if( $item->dependent == 'Principal Name' ){
                    $dependent = 'Principal';
                }
                $fileData["data"][] = array(
                    $key+1,
                    $dependent,
                    $item->personal_number,
                    $item->folder_number,
                    $item->passport_number,
                    $item->principal_name,
                    $item->gender,
                    $item->birthdate,
                    $item->contact_number,
                    $item->petitioner,
                    $item->visa_status,
                    $item->visa_issue_date,
                    $item->visa_valid_until,
                    $item->others,
                );
            }

            $excelPath =  APPPATH . "user/downloads/";

            $filePathCreated = array();
            // Commented it when using mac, there is no ms excel app 
            // $excel = $this->reportModel->createXlsFileToPath($fileData["data"], $fileData["fileName"], $excelPath);
            // $data['excelFileName'] = $fileData["fileName"];
        }
        echo json_encode($data);
    }

    public function viewOtherReports(){

        $this->load->model('koreanModel');
        $this->load->model('otherModel');

        $notif = $this->koreanModel->korean_visa_to_be_expire(); // for notification
        $notification['data']['korean']['notificationCount']  = $notif['notificationCount'];
        $notification['data']['korean']['notification']       = $notif['notification'];

        $notifOthers = $this->otherModel->other_visa_to_be_expire(); // for notification
        $notification['data']['other']['notificationCount']  = $notifOthers['notificationCount'];
        $notification['data']['other']['notification']       = $notifOthers['notification'];

        //get the principal names
        $data['data']['otherData'] = $this->otherModel->other_data();

        $this->load->view('common/header', $notification);
        $this->load->view('report/otherReport',$data);
        $this->load->view('common/footer');

    }

    public function getOtherReport(){

        $result = $this->reportModel->getOtherReport( $_POST );

        $data['result'] = $result;
        $data['status'] = FALSE;

        if( $result !== false ){

            $data['status'] = TRUE;

            // excel contents
            $fileData["fileName"] = 'Other_Report_'. date("Y-m-d") ."_". time();
            $fileData["data"] = array();

            $fileData["data"][] = array("Date Start",$_POST['startDate']);
            $fileData["data"][] = array("Date End",$_POST['endDate']);
            $fileData["data"][] = array("Principal Passport Number",$_POST['principalPassportNumber']);

            //Add the heading
            $fileData["data"][] = array(
                '#',
                'Principal\'s Passport Number',
                'Passport Number',
                'Principal Name',
                'Folder Name',
                'Gender',
                'Birthdate',
                'Contact Number',
                'Petitioner',
                'Visa Status',
                'Visa date Issue',
                'Visa Valid Until',
                'Others',
            );
            //Process the File Data
            foreach( $data['result'] as $key => $item ){
                $dependent = $item->dependent;
                if( $item->dependent == 'Principal Name' ){
                    $dependent = 'Principal';
                }
                $fileData["data"][] = array(
                    $key+1,
                    $dependent,
                    $item->passport_number,
                    $item->principal_name,
                    $item->folder_number,
                    $item->gender,
                    $item->birthdate,
                    $item->contact_number,
                    $item->petitioner,
                    $item->visa_status,
                    $item->visa_issue_date,
                    $item->visa_valid_until,
                    $item->others,
                );
            }

            $excelPath =  APPPATH . "user/downloads/";

            // Commented it when using mac, there is no ms excel app 
            //$filePathCreated = array();
            //$excel = $this->reportModel->createXlsFileToPath($fileData["data"], $fileData["fileName"], $excelPath);
            //$data['excelFileName'] = $fileData["fileName"];
        }

        echo json_encode($data);

    }

    public function downloadOtherReport(){
        $this->load->helper('download');

        $result = $this->reportModel->getOtherReport( $_POST );

        $data['result'] = $result;
        $data['status'] = FALSE;

        if( $result !== false ){
            $data['status'] = TRUE;

            // excel contents
            $fileData["fileName"] = 'Other_Report_'. date("Y-m-d") ."_". time();
            $fileData["data"] = array();

            //Add the heading
            $fileData["data"][] = array(
                '#',
                'Principal\'s Passport Number',
                'Passport Number',
                'Principal Name',
                'Folder Name',
                'Gender',
                'Birthdate',
                'Contact Number',
                'Petitioner',
                'Visa Status',
                'Visa date Issue',
                'Visa Valid Until',
                'Others',
            );
            //Process the File Data
            foreach( $data['result'] as $key => $item ){
                $dependent = $item->dependent;
                if( $item->dependent == 'Principal Name' ){
                    $dependent = 'Principal';
                }
                $fileData["data"][] = array(
                    $key+1,
                    $dependent,
                    $item->passport_number,
                    $item->principal_name,
                    $item->folder_number,
                    $item->gender,
                    $item->birthdate,
                    $item->contact_number,
                    $item->petitioner,
                    $item->visa_status,
                    $item->visa_issue_date,
                    $item->visa_valid_until,
                    $item->others,
                );
            }

            $excelPath =  APPPATH . "user/downloads/";

            // Commented it when using mac, there is no ms excel app 
            $filePathCreated = array();
           // $excel = $this->reportModel->createXlsFileToPath($fileData["data"], $fileData["fileName"], $excelPath);
            //$data['excelFileName'] = $fileData["fileName"];
        }
       // force_download(base_url().'application/user/downloads/'.$fileData["fileName"].'.xls', NULL);
        echo json_encode($data);
    }

    public function getKoreanNotification(){

        $notif = $this->koreanModel->korean_visa_to_be_expire(); // for notification
        $notification['data']['excelFileName'] = '';

        if( $notif['notificationCount'] > 0 ){
            // excel contents
            $fileData["fileName"] = 'KoreanNotification_'. date("Y-m-d") ."_". time();
            $fileData["data"] = array();

            //Add the heading
            $fileData["data"][] = array(
                '#',
                'Principal\'s Personal Number',
                'Personal Number',
                'Folder Name',
                'Passport Number',
                'Principal Name',
                'Gender',
                'Birthdate',
                'Contact Number',
                'Petitioner',
                'Visa Status',
                'Visa date Issue',
                'Visa Valid Until',
                'Others',
            );
            //Process the File Data
            foreach( $notif['notification'] as $key => $item ){
                $dependent = $item['dependent'];
                if( $item['dependent'] == 'Principal Name' ){
                    $dependent = 'Principal';
                }
                $fileData["data"][] = array(
                    $key+1,
                    $dependent,
                    $item['personal_number'],
                    $item['folder_number'],
                    $item['passport_number'],
                    $item['principal_name'],
                    $item['gender'],
                    $item['birthdate'],
                    $item['contact_number'],
                    $item['petitioner'],
                    $item['visa_status'],
                    $item['visa_issue_date'],
                    $item['visa_valid_until'],
                    $item['others'],
                );
            }

            $excelPath =  APPPATH . "user/downloads/";

            $filePathCreated = array();
            //$excel = $this->reportModel->createXlsFileToPath($fileData["data"], $fileData["fileName"], $excelPath);
            //$notification['data']['excelFileName'] = $fileData["fileName"];
        }

        echo json_encode($notification);
    }

    public function getOtherNotification(){

        $notif = $this->otherModel->other_visa_to_be_expire(); // for notification
        $notification['data']['excelFileName'] = '';

        if( $notif['notificationCount'] > 0 ){
            // excel contents
            $fileData["fileName"] = 'OtherNotification_'. date("Y-m-d") ."_". time();
            $fileData["data"] = array();

            //Add the heading
            $fileData["data"][] = array(
                '#',
                'Principal\'s Passport Number',
                'Passport Number',
                'Principal Name',
                'Folder Name',
                'Gender',
                'Birthdate',
                'Contact Number',
                'Petitioner',
                'Visa Status',
                'Visa date Issue',
                'Visa Valid Until',
                'Others',
            );
            //Process the File Data
            foreach( $notif['notification'] as $key => $item ){
                $dependent = $item->dependent;
                if( $item->dependent == 'Principal Name' ){
                    $dependent = 'Principal';
                }
                $fileData["data"][] = array(
                    $key+1,
                    $dependent,
                    $item->passport_number,
                    $item->principal_name,
                    $item->folder_number,
                    $item->gender,
                    $item->birthdate,
                    $item->contact_number,
                    $item->petitioner,
                    $item->visa_status,
                    $item->visa_issue_date,
                    $item->visa_valid_until,
                    $item->others,
                );
            }

            $excelPath =  APPPATH . "user/downloads/";

            $filePathCreated = array();
          //  $excel = $this->reportModel->createXlsFileToPath($fileData["data"], $fileData["fileName"], $excelPath);
            //$notification['data']['excelFileName'] = $fileData["fileName"];
        }

        echo json_encode($notification);
    }

}