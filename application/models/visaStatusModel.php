<?php 

// Using PDO

Class VisaStatusModel extends CI_Model {

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

    public function visa_status_list() {
    	$sql = "SELECT * FROM visaStatus";
    	$statement = $this->connectionId->prepare($sql);
    	$statement->execute();

    	$result = $statement->fetchAll(PDO::FETCH_ASSOC);

    	return $result;
    }

    public function add_visa_status($post_data) {
    	$addSql = "INSERT INTO visaStatus (visaStatus) VALUES (:visa_status)";
    	$statement = $this->connectionId->prepare($addSql);
    	$statement->bindParam(":visa_status", $post_data['visa_status']);
    	$result = $statement->execute();

    	return $result;
    }

    public function get_visa_status_details($id) {
    	$sql = "SELECT * FROM visaStatus WHERE id = :id";
    	$statement = $this->connectionId->prepare($sql);
    	$statement->bindParam(":id", $id);
    	$statement->execute();
    	$result = $statement->fetchAll(PDO::FETCH_ASSOC);

    	return $result;
    }

    public function edit_visa_status($post_data) {
    	$updateSql = "UPDATE visaStatus SET visaStatus = :visa_status WHERE id = :id";
    	$statement = $this->connectionId->prepare($updateSql);
    	$statement->bindParam(":visa_status", $post_data['visa_status']);
    	$statement->bindParam(":id", $post_data['id']);
    	$result = $statement->execute();

    	return $result;
    }

    public function delete_visa_status($id) {
    	$deleteSql = "DELETE FROM visaStatus WHERE id = :id";
    	$deleteStatement = $this->connectionId->prepare($deleteSql);
    	$deleteStatement->bindParam(':id', $id);

    	$result = $deleteStatement->execute();

    	return $result;
    }
}

?>