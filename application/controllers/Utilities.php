<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Utilities extends CI_Controller {

    /**
     * Initialization of koreanModel, otherModel, reportModel and the database
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

    /* for folder name */
    public function viewFolderName()
    {
        $notif = $this->koreanModel->korean_visa_to_be_expire(); // for notification
        $notification['data']['korean']['notificationCount']  = $notif['notificationCount'];
        $notification['data']['korean']['notification']       = $notif['notification'];

        $notifOthers = $this->otherModel->other_visa_to_be_expire(); // for notification
        $notification['data']['other']['notificationCount']  = $notifOthers['notificationCount'];
        $notification['data']['other']['notification']       = $notifOthers['notification'];

        // for header and footer
        $this->load->view('common/header', $notification);
        $this->load->view('common/footer');

        $data['data']['result'] = $this->folderNameModel->folder_name_list();
        $this->load->view('utilities/viewFolderName', $data);
    }

    public function addFolderNameDetails() {
        $result = $this->folderNameModel->add_folder_name($_POST);
        
        if( $result == false ){
            $data['status'] = FALSE;
            $data['error'] = 'Error adding new record.';
        }else{
            $data['status'] = TRUE;
            $data['result'] = $result;
            $data['message'] = 'Record has been added.';
        }

        echo json_encode($data);
    }

    public function getFolderNameDetails() {
        $result = $this->folderNameModel->get_folder_name_details($_POST['ID']);

        $data['result'] = $result;
        $data['status'] = FALSE;

        if( !empty($result) ){
            $data['status'] = TRUE;
        }

        echo json_encode($data);
    }

    public function editFolderNameDetails() {
        $result = $this->folderNameModel->edit_folder_name($_POST);

        if($result == true) {
            $data['status'] = TRUE;
            $data['result'] = $result;
            $data['message'] = 'Record has been updated.';
        } else {
            $data['status'] = FALSE;
            $data['result'] = $result;
            $data['message'] = 'Failed to update data';
        }

        echo json_encode($data);
    }

    public function deleteFolderName() {
        $result = $this->folderNameModel->delete_folder_name($_POST["id"]);

        if($result == true) {
            $data['status'] = TRUE;
            $data['result'] = $result;
            $data['message'] = 'Record has been deleted.';
        } else {
            $data['status'] = FALSE;
            $data['result'] = $result;
            $data['error'] = 'Failed to delete data';
        }

        echo json_encode($data);
    }

    /* for visa status*/
    public function viewVisaStatus() {
        $notif = $this->koreanModel->korean_visa_to_be_expire(); // for notification
        $notification['data']['korean']['notificationCount']  = $notif['notificationCount'];
        $notification['data']['korean']['notification']       = $notif['notification'];

        $notifOthers = $this->otherModel->other_visa_to_be_expire(); // for notification
        $notification['data']['other']['notificationCount']  = $notifOthers['notificationCount'];
        $notification['data']['other']['notification']       = $notifOthers['notification'];

        // for header and footer
        $this->load->view('common/header', $notification);
        $this->load->view('common/footer');

        $data['data']['result'] = $this->visaStatusModel->visa_status_list();
        $this->load->view('utilities/viewVisaStatus', $data);
    }

    public function addVisaStatusDetails() {
        $result = $this->visaStatusModel->add_visa_status($_POST);

        if($result == true) {
            $data['status'] = TRUE;
            $data['result'] = $result;
            $data['message'] = "Record has been added.";
        } else {
            $data['status'] = FALSE;
            $data['result'] = $result;
            $data['message'] = "Failed in adding record.";
        }
        echo json_encode($data);
    }

    public function getVisaStatusDetails() {
        $result = $this->visaStatusModel->get_visa_status_details($_POST['ID']);

        $data['result'] = $result;
        $data['status'] = FALSE;

        if( !empty($result) ){
            $data['status'] = TRUE;
        }

        echo json_encode($data);
    }

    public function editVisaStatusDetails() {
        $result = $this->visaStatusModel->edit_visa_status($_POST);

        if($result == true) {
            $data['status'] = TRUE;
            $data['result'] = $result;
            $data['message'] = "Record has been updated.";
        } else {
            $data['status'] = FALSE;
            $data['result'] = $result;
            $data['message'] = "Failed in updating record.";
        }
        echo json_encode($data);
    }

    public function deleteVisaStatus() {
        $result = $this->visaStatusModel->delete_visa_status($_POST['id']);

        if($result == true) {
            $data['status'] = TRUE;
            $data['result'] = $result;
            $data['message'] = 'Record has been deleted.';
        } else {
            $data['status'] = FALSE;
            $data['result'] = $result;
            $data['error'] = 'Failed to delete data';
        }

        echo json_encode($data);
    }

    /* for Petitioner */
    public function viewPetitioner() {
        $notif = $this->koreanModel->korean_visa_to_be_expire(); // for notification
        $notification['data']['korean']['notificationCount']  = $notif['notificationCount'];
        $notification['data']['korean']['notification']       = $notif['notification'];

        $notifOthers = $this->otherModel->other_visa_to_be_expire(); // for notification
        $notification['data']['other']['notificationCount']  = $notifOthers['notificationCount'];
        $notification['data']['other']['notification']       = $notifOthers['notification'];

        // for header and footer
        $this->load->view('common/header', $notification);
        $this->load->view('common/footer');

        $data['data']['result'] = $this->petitionerModel->petitioner_list();
        $this->load->view('utilities/viewPetitioner', $data);
    }

    public function addPetitionerDetails() {
        $result = $this->petitionerModel->add_petitioner($_POST);

        if($result == true) {
            $data['status'] = TRUE;
            $data['result'] = $result;
            $data['message'] = "Record has been added.";
        } else {
            $data['status'] = FALSE;
            $data['result'] = $result;
            $data['message'] = "Failed to add data";
        }

        echo json_encode($data);
    }

    public function getPetitionerDetails() {
        $result = $this->petitionerModel->get_petitioner_details($_POST['ID']);

        $data['result'] = $result;
        $data['status'] = FALSE;

        if( !empty($result) ){
            $data['status'] = TRUE;
        }

        echo json_encode($data);
    }

    public function editPetitionerDetails() {
        $result = $this->petitionerModel->edit_petitioner($_POST);

        if($result == true) {
            $data['status'] = TRUE;
            $data['result'] = $result;
            $data['message'] = "Record has been updated.";
        } else {
            $data['status'] = FALSE;
            $data['result'] = $result;
            $data['message'] = "Failed in updating record.";
        }
        echo json_encode($data);
    }

    public function deletePetitioner() {
        $result = $this->petitionerModel->delete_petitioner($_POST['id']);
        
        if($result == true) {
            $data['status'] = TRUE;
            $data['result'] = $result;
            $data['message'] = 'Record has been deleted.';
        } else {
            $data['status'] = FALSE;
            $data['result'] = $result;
            $data['error'] = 'Failed to delete data';
        }

        echo json_encode($data);
    }
}