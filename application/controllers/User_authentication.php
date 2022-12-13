<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class User_Authentication extends CI_Controller {

	public function __construct() {
		parent::__construct();
		
		// Load database
		$this->load->model('login_database');

	}

	// Show login page
	public function index() {
		$this->load->view('login/login_form');
	}

	// Show registration page
	public function user_registration_show() {
		$this->load->view('login/registration_form');
	}

	public function new_user_registration() {

		// Check validation for user input in SignUp form
		$this->form_validation->set_rules($_POST['userName'], 'Username', 'trim|required|xss_clean');
		$this->form_validation->set_rules($_POST['lastName'], 'Email', 'trim|required|xss_clean');
		$this->form_validation->set_rules($_POST['firstName'], 'Password', 'trim|required|xss_clean');
		$this->form_validation->set_rules($_POST['password'], 'Password', 'trim|required|xss_clean');

		$result = $this->login_database->registration_insert($_POST);

		if ($result == TRUE) {
			$data['message_display'] = 'New user added successfully!';
			$data['status'] = true;
		} else {
			$data['message_display'] = 'Username already exist!';
			$data['status'] = false;
		}

		echo json_encode($data);
	}

	// Check for user login process
	public function user_login_process() {
		
		$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean'); //trim|required|xss_clean

		if ($this->form_validation->run() == FALSE) {
			// error
			$user_data = array(
				'login_attempt_failed' => true
			);
			$this->session->set_userdata($user_data);  

			$data = array(
				'error_message' => 'Please enter username and password'
			);
			$this->load->view('login/login_form', $data);

		} else {
				
			$data = array(
				'username' => $this->input->post('username'),
				'password' => $this->input->post('password')
			);
			
			$result = $this->login_database->login($data);
			
			if ($result === true) {
				$username = $this->input->post('username');
				$user_result = $this->login_database->read_user_information($username);
				
				if ($user_result !== false) {
					$user_data = array(
						'username' => $user_result[0]['user_name'],
						'email' => $user_result[0]['user_email'],
						'firstName' => $user_result[0]['firstName'],
						'lastName' => $user_result[0]['lastName'],
						'userId' => $user_result[0]['id'],
						'is_logged_in' => true,
						'page_visit' => false
					);
					$this->session->set_userdata($user_data);   
				}
				redirect('home');
			} else {
				$user_data = array(
					'login_attempt_failed' => true
				);
				$this->session->set_userdata($user_data);  

				$data = array(
					'error_message' => 'Invalid Username or Password'
				);
				$this->load->view('login/login_form', $data);
			}
		}
	}

	// Logout from admin page
	public function logout() {

		// Removing session data
		$sess_array = array(
			'username' => '',
			'email' => '',
			'firstName' => '',
			'lastName' => '',
			'userId' => '',
			'is_logged_in' => false,
			'page_visit' => false,
			'login_attempt_failed' => false
		);
		
		$this->session->unset_userdata($sess_array);
		$this->session->sess_destroy();
		
		redirect('login');
	}

}

?>

