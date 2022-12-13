<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Korean extends CI_Controller {

    /**
     * Initialization of koreanModel, otherModel and the database
    */
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
    {}

    /**
     * function view
     * @return the number of notification for the header and all the principal korean to the view
     */
    public function view(){
        $notif = $this->koreanModel->korean_visa_to_be_expire(); // for notification
        $notification['data']['korean']['notificationCount']  = $notif['notificationCount'];
        $notification['data']['korean']['notification']       = $notif['notification'];

        $notifOthers = $this->otherModel->other_visa_to_be_expire(); // for notification
        $notification['data']['other']['notificationCount']  = $notifOthers['notificationCount'];
        $notification['data']['other']['notification']       = $notifOthers['notification'];

        $this->load->view('common/header', $notification);
        $this->load->view('common/footer');

        $data['data']['result'] = $this->koreanModel->korean_data();
        $data['data']['folderNamesList'] = $this->folderNameModel->folder_name_list();
        $data['data']['petitionersList'] = $this->petitionerModel->petitioner_list();
        $data['data']['visaStatusList'] = $this->visaStatusModel->visa_status_list();
        $this->load->view('korean/viewKorean', $data);

    }

    /**
     * @param int ID a value required to get the information
     * @return json_encoded data that contains the korean information of the param ID
    */
    public function getDetails(){
        $id = $_POST['ID'];

        $result = $this->koreanModel->get_data($id);
        $data['result'] = $result;
        $data['status'] = FALSE;

        if( !empty($result) ){
            $data['status'] = TRUE;
        }

        echo json_encode($data);
    }


    public function editDetails(){
        $result = $this->koreanModel->edit_korean_data( $_POST );

        if( $result == false ){
            $data['status'] = FALSE;
            $data['error'] = 'Personal Number already exists.';
        }else{
            $data['status'] = TRUE;
            $data['result'] = $result;
            $data['message'] = 'Record has been updated.';
        }

        echo json_encode($data);
    }

    public function addDependent(){
        $result = $this->koreanModel->add_korean_dependent_data($_POST);

        if( $result == false ){
            $data['status'] = FALSE;
            $data['error'] = 'Error in adding new record.';
        }else{
            $data['status'] = TRUE;
            $data['result'] = $result;
            $data['message'] = 'Record has been added.';
        }

        echo json_encode($data);
    }
    
    public function addPrimary(){
        $result = $this->koreanModel->add_korean_primary_data($_POST);
        
        if( $result == false ){
            $data['status'] = FALSE;
            $data['error'] = 'Error in adding new record.';
        }else{
            $data['status'] = TRUE;
            $data['result'] = $result;
            $data['message'] = 'Record has been added.';
        }

        echo json_encode($data);
    }

    public function deletePrimary(){
        $id = $_POST['ID'];

        $result = $this->koreanModel->delete_korean_primary_data($id);

        $data['result'] = $result;
        $data['status'] = FALSE;

        if( $result !== FALSE ){
            $data['status'] = TRUE;
        }

        echo json_encode($data);
    }

    public function deleteDependent(){
        $id = $_POST['ID'];

        $result = $this->koreanModel->delete_korean_dependent_data($id);

        $data['result'] = $result;
        $data['status'] = FALSE;

        if( $result !== FALSE ){
            $data['status'] = TRUE;
        }

        echo json_encode($data);
    }

    public function viewDependent(){
        $params = $this->uri->segment_array();
        $id = $params[3];

        $result = $this->koreanModel->korean_dependent_data($id);
        if( $result['status'] === false ){
            show_404();
        }
        $data['data']['result'] = $result['dependents'];
        $data['data']['principalName'] = $result['principalName'];
        $data['data']['principalPersonalNumber'] = $result['principalPersonalNumber'];
        $data['data']['id'] = $id;

        $notif = $this->koreanModel->korean_visa_to_be_expire(); // for notification
        $notification['data']['korean']['notificationCount']  = $notif['notificationCount'];
        $notification['data']['korean']['notification']       = $notif['notification'];

        $notifOthers = $this->otherModel->other_visa_to_be_expire(); // for notification
        $notification['data']['other']['notificationCount']  = $notifOthers['notificationCount'];
        $notification['data']['other']['notification']       = $notifOthers['notification'];

        $data['data']['folderNamesList'] = $this->folderNameModel->folder_name_list();
        $data['data']['petitionersList'] = $this->petitionerModel->petitioner_list();
        $data['data']['visaStatusList'] = $this->visaStatusModel->visa_status_list();

        $this->load->view('common/header', $notification);
        $this->load->view('common/footer');
        $this->load->view('korean/viewDependent', $data);
    }

    public function notification(){
        $notif = $this->koreanModel->korean_visa_to_be_expire(); // for notification
        $notification['data']['notification']  = $notif['notification'];
        $notification['data']['excelFileName'] = '';

        $notif = $this->koreanModel->korean_visa_to_be_expire(); // for notification
        $notification['data']['korean']['notificationCount']  = $notif['notificationCount'];
        $notification['data']['korean']['notification']       = $notif['notification'];

        $notifOthers = $this->otherModel->other_visa_to_be_expire(); // for notification
        $notification['data']['other']['notificationCount']  = $notifOthers['notificationCount'];
        $notification['data']['other']['notification']       = $notifOthers['notification'];

        $this->load->view('common/header', $notification);
        $this->load->view('common/footer');
        $this->load->view('korean/ViewNotificationPage', $notification);
    }

    public function searchPersonalNumber() {
        $result = $this->koreanModel->findPersonalNoIfExist($_POST['pno']);

        echo json_encode($result);
    }
}

?>