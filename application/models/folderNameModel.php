<?php 

// Using PDO

Class FolderNameModel extends CI_Model {

	public $connectionId;
	public $userId;
	public $dateToday;

	public function __construct(){
        parent::__construct();

        $this->connectionId = $this->db->conn_id;
		$this->dateToday	= date('Y-m-d');
		
		if( isset($this->session->userdata['userId']) ){
			$this->userId 		= $this->session->userdata['userId'];
		}
    }

    public function folder_name_list( $id = NULL ) {
    	$sql = "SELECT * FROM folderNames";
		$statement = $this->connectionId->prepare($sql);
		
		$statement->execute();
		$result = $statement->fetchAll( PDO::FETCH_ASSOC );	
        
        return $result;
    }

    public function add_folder_name($post_data) {
    	$sql = "SELECT * FROM folderNames WHERE folderName = :folder_name";
    	$statement = $this->connectionId->prepare($sql);

    	$statement->execute(array(':folder_name' => $post_data['folder_name']));
    	$resultQuery = $statement->fetchAll(PDO::FETCH_ASSOC);

    	// if result is greater than 0
    	if(count($resultQuery) > 0) {
    		// folder name is already in the database
    		return false;
    	} else {
    		$addSql = "INSERT INTO folderNames (folderName, description) VALUES (:folder_name, :description)";
    		$addStatement = $this->connectionId->prepare($addSql);
    		$addStatement->bindParam(':folder_name', $post_data['folder_name']);
    		$addStatement->bindParam(':description', $post_data['description']);
    		
    		$result = $addStatement->execute();

    		return $result;
    	}
    }

    public function get_folder_name_details($id) {
    	$sql = "SELECT * FROM folderNames WHERE id = :id";
    	$statement = $this->connectionId->prepare($sql);
    	$statement->execute(array(':id' => $id));
    	$resultQuery = $statement->fetchAll(PDO::FETCH_ASSOC);

    	return $resultQuery; 
    }

    public function edit_folder_name($post_data) {
    	$updateSql = "UPDATE folderNames SET folderName = :folder_name, description = :description WHERE id = :id";
    	$updateStatement = $this->connectionId->prepare($updateSql);
    	$updateStatement->bindParam(':folder_name', $post_data['folder_name']);
    	$updateStatement->bindParam(':description', $post_data['description']);
    	$updateStatement->bindParam(':id', $post_data['id']);

    	$result = $updateStatement->execute();

    	return $result;
    }

    public function delete_folder_name($id) {
    	$deleteSql = "DELETE FROM folderNames WHERE id = :id";
    	$deleteStatement = $this->connectionId->prepare($deleteSql);
    	$deleteStatement->bindParam(':id', $id);

    	$result = $deleteStatement->execute();

    	return $result;
    }
}
?>