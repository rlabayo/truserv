<?php 

// Using PDO

Class PetitionerModel extends CI_Model {

	public $connectionId;
	public $userId;
	public $dateToday;

	public function __construct(){
        parent::__construct();

        $this->connectionId = $this->db->conn_id;
		$this->dateToday	= date('Y-m-d');
		
		if( isset($this->session->userdata['userId']) ){
			$this->userId = $this->session->userdata['userId'];
		}
    }

    public function petitioner_list() {
    	$sql = "SELECT * FROM petitioner";
    	$statement = $this->connectionId->prepare($sql);
    	$statement->execute();

    	$result = $statement->fetchAll(PDO::FETCH_ASSOC);

    	return $result;
    }

    public function add_petitioner($post_data) {
    	$addSql = "INSERT INTO petitioner (petitioner) VALUES (:petitioner)";
    	$statement = $this->connectionId->prepare($addSql);
    	$statement->bindParam(":petitioner", $post_data['petitioner']);
    	$result = $statement->execute();

    	return $result;
    }

    public function get_petitioner_details($id) {
    	$sql = "SELECT * FROM petitioner WHERE id = :id";
    	$statement = $this->connectionId->prepare($sql);
    	$statement->bindParam(":id", $id);
    	$statement->execute();

    	$result = $statement->fetchAll(PDO::FETCH_ASSOC);

    	return $result;
    }

    public function edit_petitioner($post_data) {
    	$updateSql = "UPDATE petitioner SET petitioner = :petitioner WHERE id = :id";
    	$statement = $this->connectionId->prepare($updateSql);
    	$statement->bindParam(":petitioner", $post_data['petitioner']);
    	$statement->bindParam(":id", $post_data['id']);

    	$result = $statement->execute();
    	return $result;
    }

    public function delete_petitioner($id) {
    	$deleteSql = "DELETE FROM petitioner WHERE id = :id";
    	$statement = $this->connectionId->prepare($deleteSql);
    	$statement->bindParam(":id", $id);
    	
    	$result = $statement->execute();
    	return $result;
    }
}