<?php

Class Login_Database extends CI_Model {

	public $connectionId;

    public function __construct(){
        parent::__construct();

        $this->connectionId = $this->db->conn_id;
		
    }

	public function registration_insert($post_data) {
		$sql = "SELECT * FROM user_login WHERE user_name = :user_name";
		$statement = $this->connectionId->prepare($sql);
		$statement->execute(array(':user_name' => $post_data['userName']));
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);

		if ( count($result) > 0 ) {
			return false;
		} else {
			// Query to insert data in database
			$insertSql = "INSERT INTO user_login (user_name, 
												user_password, 
												firstName, 
												lastName)
									VALUES (:user_name, 
											:user_password, 
											:first_name, 
											:last_name)";
			$insertStatement = $this->connectionId->prepare($insertSql);
			$insertStatement->bindParam(':user_name', $post_data['userName']);
			$insertStatement->bindParam(':user_password', $post_data['password']);
			$insertStatement->bindParam(':first_name', $post_data['firstName']);
			$insertStatement->bindParam(':last_name', $post_data['lastName']);
			$result = $insertStatement->execute();
			
			return $result;
		}
	}

	// Read data using username and password
	public function login($post_data) {
		$sql = "SELECT * FROM user_login WHERE user_name = :user_name AND user_password = :user_password LIMIT 1";
		$statement = $this->connectionId->prepare($sql);
		$statement->execute(array(':user_name' => $post_data['username'], ':user_password' => $post_data['password']));
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);

		if (count($result) == 1) {
			return true;
		} else {
			return false;
		}
	}

	// Read data from database to show data in admin page
	public function read_user_information($username) {
		$sql = "SELECT * FROM user_login WHERE user_name = :user_name LIMIT 1";
		$statement = $this->connectionId->prepare($sql);
		$statement->execute(array(':user_name' => $username));
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);

		if (count($result) == 1) {
			return $result;
		} else {
			return false;
		}
	}

}

?>

