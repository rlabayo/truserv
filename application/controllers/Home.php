<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

 function __construct()
 {
   parent::__construct();
   
     $this->load->model('koreanModel');
     $this->load->model('otherModel');

 }

 function index()
 {
  
    $data['username'] = $_SESSION['username'];
    $notif = $this->koreanModel->korean_visa_to_be_expire(); // for notification
    $notification['data']['korean']['notificationCount']  = $notif['notificationCount'];

    $notifOthers = $this->otherModel->other_visa_to_be_expire(); // for notification
    $notification['data']['other']['notificationCount']  = $notifOthers['notificationCount'];

    $this->load->view('common/header', $notification);
    $this->load->view('home/admin_page', $data);
    $this->load->view('common/footer');
  //  if($this->session->userdata('logged_in'))
  //  {
  //    $session_data = $this->session->userdata('logged_in');
  //    $data['username'] = $session_data['username'];
  //    $this->load->view('home_view', $data);
  //  }
  //  else
  //  {
  //    //If no session, redirect to login page
  //    redirect('login', 'refresh');
  //  }
 }

//  function logout()
//  {
//    $this->session->unset_userdata('logged_in');
//    session_destroy();
//    redirect('home', 'refresh');
//  }

}

?>