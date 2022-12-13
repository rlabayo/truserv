<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {

	public function index()
	{
		$this->load->view('address/test');
		$this->load->model('Test_name');
		$this->Test_name->test();
		
		$this->load->database();
	}
	
	public function select(){
		// select statement
		echo "SELECT STATEMENT <br>";
		$query = $this->db->query("SELECT * FROM name");
		$value = $query->result();
		//var_dump($value); echo "<br>OTHER SELECT STATEMENT<br>";
		
		$query = $this->db->get('name');
		$data['records'] = $query->result();
		var_dump($data['records']);
	}
	
	public function insert(){
		echo "INSERT STATEMENT<br>";
		// insert statement
		$data = array( "firstName" => "Rio" );
		$insert = $this->db->insert("name",$data);
		echo $insert;
	}
	
	public function delete(){
		$this->db->delete("name","firstName = 'Rheah'");
	}
	
	public function update(){
		$data = array( "firstName" => "Rheah" );
		$this->db->set($data);
		$this->db->where('firstName',"Rio");
		$this->db->update("name",$data);
	}
	
	public function dbClose(){
		$dbClose = $this->db->close();
		echo $dbClose;
	}
	
}
