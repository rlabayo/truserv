<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

 function __construct()
 {
     parent::__construct();

     $this->load->model('koreanModel');
     $this->load->model('otherModel');

 }

 public function index(){
    redirect('login');
 }

 public function login()
 {
   $this->load->view('login/login_form');
 }

 public function settings(){

     $params = $this->uri->segment_array();
     $user_name = $params[2];

     $query  = $this->db->query("SELECT * FROM user_login WHERE user_name = '".$user_name."'" );
     $data['data'] = $query->result();

     $notif = $this->koreanModel->korean_visa_to_be_expire(); // for notification
     $notification['data']['korean']['notificationCount']  = $notif['notificationCount'];

     $notifOthers = $this->otherModel->other_visa_to_be_expire(); // for notification
     $notification['data']['other']['notificationCount']  = $notifOthers['notificationCount'];

     $this->load->view('common/header', $notification);
     $this->load->view('user/view_user_settings',$data);
     $this->load->view('common/footer');
     
 }

 public function update_user_settings(){
     $data = array(
         'firstName'            => $_POST['firstName'],
         'lastName'             => $_POST['lastName'],
         'user_name'            => $_POST['userName'],
         'user_password'        => $_POST['password']
     );
     $this->db->where('id', $_POST['id']);
     $result = $this->db->update('user_login', $data);

     $data['status'] = FALSE;

     if( $result == true ){
         $data['status'] = TRUE;
     }

     echo json_encode($data);
 }

 public function add_user(){
    $notif = $this->koreanModel->korean_visa_to_be_expire(); // for notification
    $notification['data']['korean']['notificationCount']  = $notif['notificationCount'];

    $notifOthers = $this->otherModel->other_visa_to_be_expire(); // for notification
    $notification['data']['other']['notificationCount']  = $notifOthers['notificationCount'];

    $this->load->view('common/header', $notification);
    $this->load->view('user/view_add_user');
    $this->load->view('common/footer');
 }

}

?>