<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Other extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->load->model('koreanModel');
        $this->load->model('otherModel');
        $this->load->model('folderNameModel');
        $this->load->model('visaStatusModel');
        $this->load->model('petitionerModel');
        $this->load->database();

    }

    public function index()
    {
        $this->load->database();
    }

    public function view(){

        $data['data']['result'] = $this->otherModel->other_data();
        $data['data']['folderNamesList'] = $this->folderNameModel->folder_name_list();
        $data['data']['petitionersList'] = $this->petitionerModel->petitioner_list();
        $data['data']['visaStatusList'] = $this->visaStatusModel->visa_status_list();

        $notif = $this->koreanModel->korean_visa_to_be_expire(); // for notification
        $notification['data']['korean']['notificationCount']  = $notif['notificationCount'];
        $notification['data']['korean']['notification']       = $notif['notification'];

        $notifOthers = $this->otherModel->other_visa_to_be_expire(); // for notification
        $notification['data']['other']['notificationCount']  = $notifOthers['notificationCount'];
        $notification['data']['other']['notification']       = $notifOthers['notification'];

        $this->load->view('common/header', $notification);

        $this->load->view('other/viewOther', $data);
        $this->load->view('common/footer');
    }

    public function addPrimary(){

        $result = $this->otherModel->add_other_primary_data( $_POST );

        if( $result == false ){
            $data['status'] = FALSE;
            $data['error'] = $result;
        }else{
            $data['status'] = TRUE;
            $data['result'] = $result;
            $data['message'] = 'Record has been added.';
        }

        echo json_encode($data);

    }

    public function viewOtherDependent(){

        $params = $this->uri->segment_array();
        $id = $params[3];

        $result = $this->otherModel->other_dependent_data($id);
        if( $result['status'] === false ){
            show_404();
        }
        $data['data']['result'] = $result['dependents'];
        $data['data']['principalName'] = $result['principalName'];
        $data['data']['principalPassportNumber'] = $result['principalPassportNumber'];
        $data['data']['id'] = $id;
        $data['data']['folderNamesList'] = $this->folderNameModel->folder_name_list();
        $data['data']['petitionersList'] = $this->petitionerModel->petitioner_list();
        $data['data']['visaStatusList'] = $this->visaStatusModel->visa_status_list();


        $notif = $this->koreanModel->korean_visa_to_be_expire(); // for notification
        $notification['data']['korean']['notificationCount']  = $notif['notificationCount'];
        $notification['data']['korean']['notification']       = $notif['notification'];

        $notifOthers = $this->otherModel->other_visa_to_be_expire(); // for notification
        $notification['data']['other']['notificationCount']  = $notifOthers['notificationCount'];
        $notification['data']['other']['notification']       = $notifOthers['notification'];

        $this->load->view('common/header', $notification);
        $this->load->view('other/viewOtherDependent', $data);
        $this->load->view('common/footer');
    }

    public function getDetails(){

        $id = $_POST['ID'];

        $result = $this->otherModel->get_data($id);
        $data['result'] = $result;
        $data['status'] = FALSE;

        if( !empty($result) ){
            $data['status'] = TRUE;
        }

        echo json_encode($data);

    }

    public function editDetails(){

        $result = $this->otherModel->edit_other_data( $_POST );

        if( $result == false ){
            $data['status'] = FALSE;
            $data['error'] = $result;
        }else{
            $data['status'] = TRUE;
            $data['result'] = $result;
            $data['message'] = 'Record has been updated.';
        }

        echo json_encode($data);

    }

    public function deletePrimary(){

        $id = $_POST['ID'];

        $result = $this->otherModel->delete_other_primary_data($id);

        $data['result'] = $result;
        $data['status'] = FALSE;

        if( $result !== FALSE ){
            $data['status'] = TRUE;
        }

        echo json_encode($data);

    }

    public function addDependent(){

        $result = $this->otherModel->add_other_dependent_data($_POST);

        if( $result == false ){
            $data['status'] = FALSE;
            $data['error'] = $result;
        }else{
            $data['status'] = TRUE;
            $data['result'] = $result;
            $data['message'] = 'Record has been added.';
        }

        echo json_encode($data);

    }
    public function notification(){

        $notif = $this->otherModel->other_visa_to_be_expire(); // for notification
        $notification['data']['notification']  = $notif['notification'];
        $notification['data']['excelFileName'] = '';

        $notif = $this->koreanModel->korean_visa_to_be_expire(); // for notification
        $notification['data']['korean']['notificationCount']  = $notif['notificationCount'];
        $notification['data']['korean']['notification']       = $notif['notification'];

        $notifOthers = $this->otherModel->other_visa_to_be_expire(); // for notification
        $notification['data']['other']['notificationCount']  = $notifOthers['notificationCount'];
        $notification['data']['other']['notification']       = $notifOthers['notification'];

        $this->load->view('common/header', $notification);
        $this->load->view('other/ViewNotificationPage', $notification);
        $this->load->view('common/footer');
    }
}

?>