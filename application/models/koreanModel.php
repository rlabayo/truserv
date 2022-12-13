<?php

Class KoreanModel extends CI_Model{

	public $connectionId;
	public $userId;
	public $dateToday;
	
    public function __construct(){
        parent::__construct();

        $this->connectionId = $this->db->conn_id;
		$this->dateToday	= date('Y-m-d');
		
		if( isset($this->session->userdata['userId']) ){
			$this->userId 	= $this->session->userdata['userId'];
		}
        // var_dump($this->session->userdata('userId'));
    }

    public function korean_data( $id = NULL ){
        $sql = "SELECT * FROM korean WHERE dependent = :dependent";
		$statement = $this->connectionId->prepare($sql);
			
    	if( $id == NULL ){
            $array = array( ':dependent'=>'Principal Name' );
    	}else if( $id != NULL ){
            $array = array( ':dependent'=>$id );
    	}
		
		$statement->execute($array);
		$result = $statement->fetchAll( PDO::FETCH_ASSOC );	
        
        return $result;
    }

    public function get_data( $id = NULL ){
        $sql = "SELECT * FROM korean WHERE ID = :id";
		$statement = $this->connectionId->prepare($sql);
		$statement->execute( array( ':id' => $id ) );
		$result = $statement->fetchAll( PDO::FETCH_ASSOC );

        return $result;
    }

    public function edit_korean_data( $post_data ){
		$sql = "SELECT * FROM korean WHERE personal_number = :personal_number AND id = :id";
		$statement = $this->connectionId->prepare($sql);
		$statement->execute(array(':personal_number'=>$post_data['personal_number'], ':id'=>$post_data['id']));
		$resultQuery = $statement->fetchAll( PDO::FETCH_ASSOC );
		
        if ( count($resultQuery) > 1 ) {
            return false;
        } else {
        	$updateSql = "UPDATE korean SET personal_number = :personal_number,
        									folder_number = :folder_number,
        									gender = :gender,
        									contact_number = :contact_number,
        									petitioner = :petitioner,
        									visa_issue_date = :visa_issue_date,
        									others = :others,
        									principal_name = :principal_name,
        									passport_number = :passport_number,
        									birthdate = :birthdate,
        									visa_status = :visa_status,
        									visa_valid_until = :visa_valid_until,
        									updatedBy = :updatedBy,
        									date_updated = :date_updated
        									WHERE id = :id";
			$updateStatement = $this->connectionId->prepare($updateSql);
			$updateStatement->bindParam( ':personal_number', $post_data['personal_number']);
			$updateStatement->bindParam( ':folder_number', $post_data['folder_name'] );
			$updateStatement->bindParam( ':gender', $post_data['gender'] );
			$updateStatement->bindParam( ':contact_number', $post_data['contact_number'] );
			$updateStatement->bindParam( ':petitioner', $post_data['petitioner'] );
			$updateStatement->bindParam( ':visa_issue_date', $post_data['visa_issue_date'] );
			$updateStatement->bindParam( ':others', $post_data['others'] );
			$updateStatement->bindParam( ':principal_name', $post_data['principal_name'] );
			$updateStatement->bindParam( ':passport_number', $post_data['passport_number'] );
			$updateStatement->bindParam( ':birthdate', $post_data['birthdate'] );
			$updateStatement->bindParam( ':visa_status', $post_data['visa_status'] );
			$updateStatement->bindParam( ':visa_valid_until', $post_data['visa_valid_until'] );
			$updateStatement->bindParam( ':updatedBy', $this->userId );
			$updateStatement->bindParam( ':date_updated', $this->dateToday );
			$updateStatement->bindParam( ':id', $post_data['id'] );
			$result = $updateStatement->execute();

            return $result;
        }
    }
    
    public function add_korean_primary_data( $post_data ){
		$sql = "SELECT * FROM korean WHERE personal_number = :personal_number";
		$statement = $this->connectionId->prepare($sql);
		$statement->execute(array(':personal_number'=>$post_data['personal_number']));
		$resultQuery = $statement->fetchAll( PDO::FETCH_ASSOC );
		$dependent = 'Principal Name';
		$nationality = 'korean';
		
        if ( count($resultQuery) > 0 ) {
            return false;
        } else {
        	$addSql = "INSERT INTO korean ( personal_number,
        									folder_number, gender,
        									contact_number, petitioner,
        									visa_issue_date, others,
        									principal_name, passport_number,
        									birthdate, visa_status,
        									visa_valid_until, dependent,
        									nationality, dateCreated,
        									createdBy )
        									VALUES ( :personal_number,
        									:folder_number, :gender,
        									:contact_number, :petitioner,
        									:visa_issue_date, :others,
        									:principal_name, :passport_number,
        									:birthdate, :visa_status,
											:visa_valid_until, :dependent,
											:nationality, :dateCreated,
											:createdBy)";
			$addStatement = $this->connectionId->prepare($addSql);
			$addStatement->bindParam(':personal_number', $post_data['personal_number']);
			$addStatement->bindParam(':folder_number', $post_data['folder_name']);
			$addStatement->bindParam(':gender', $post_data['gender']);
			$addStatement->bindParam(':contact_number', $post_data['contact_number']);
			$addStatement->bindParam(':petitioner', $post_data['petitioner']);
			$addStatement->bindParam(':visa_issue_date', $post_data['visa_issue_date']);
			$addStatement->bindParam(':others', $post_data['others']);
			$addStatement->bindParam(':principal_name', $post_data['principal_name']);
			$addStatement->bindParam(':passport_number', $post_data['passport_number']);
			$addStatement->bindParam(':birthdate', $post_data['birthdate']);
			$addStatement->bindParam(':visa_status', $post_data['visa_status']);
			$addStatement->bindParam(':visa_valid_until', $post_data['visa_valid_until']);
			$addStatement->bindParam(':dependent', $dependent);
			$addStatement->bindParam(':nationality', $nationality);
			$addStatement->bindParam(':dateCreated', $this->dateToday);
			$addStatement->bindParam(':createdBy', $this->userId);
			$result = $addStatement->execute();
			// var_dump($result);
            return $result;
        }
    }

    public function add_korean_dependent_data( $post_data ){
		$sql = "SELECT * FROM korean WHERE personal_number = :personal_number";
		$statement = $this->connectionId->prepare($sql);
		$statement->execute(array(':personal_number'=>$post_data['personal_number']));
		$resultQuery = $statement->fetchAll( PDO::FETCH_ASSOC );

        if ( count($resultQuery) > 0 ) {
            return false;
        } else {
            $nationality = "korean";
            $insertSql = "INSERT INTO korean (personal_number, folder_number,
                                        gender, contact_number,
                                        petitioner, visa_issue_date, others,
                                        principal_name, passport_number,
                                        birthdate, visa_status,
                                        visa_valid_until, dependent,
                                        nationality, dateCreated,
                                        createdBy)
                                VALUES (:personal_number, :folder_number,
                                        :gender, :contact_number,
                                        :petitioner, :visa_issue_date,
                                        :others, :principal_name,
                                        :passport_number, :birthdate,
                                        :visa_status, :visa_valid_until,
                                        :dependent, :nationality,
                                        :dateCreated, :createdBy)";
            $addStatement = $this->connectionId->prepare($insertSql);
            $addStatement->bindParam(':personal_number', $post_data['personal_number']);
            $addStatement->bindParam(':folder_number', $post_data['folder_name']);
            $addStatement->bindParam(':gender', $post_data['gender']);
            $addStatement->bindParam(':contact_number', $post_data['contact_number']);
            $addStatement->bindParam(':petitioner', $post_data['petitioner']);
            $addStatement->bindParam(':visa_issue_date', $post_data['visa_issue_date']);
            $addStatement->bindParam(':others', $post_data['others']);
            $addStatement->bindParam(':principal_name', $post_data['dependent_name']);
            $addStatement->bindParam(':passport_number', $post_data['passport_number']);
            $addStatement->bindParam(':birthdate', $post_data['birthdate']);
            $addStatement->bindParam(':visa_status', $post_data['visa_status']);
            $addStatement->bindParam(':visa_valid_until', $post_data['visa_valid_until']);
            $addStatement->bindParam(':dependent', $post_data['principal_personal_number']);
            $addStatement->bindParam(':nationality', $nationality);
            $addStatement->bindParam(':dateCreated', $this->dateToday);
            $addStatement->bindParam(':createdBy', $this->userId);
            $result = $addStatement->execute();
            // var_dump($addStatement->errorInfo());
            return $result;
        }
    }

    public function delete_korean_primary_data( $id ){
        $sql = "SELECT * FROM korean WHERE id = :id";
        $statement = $this->connectionId->prepare($sql);
        $statement->execute(array('id' => $id));
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        $personal_number = $result[0]['personal_number'];
        
        // delete the primary
        $deletePrimarySql = "DELETE FROM korean WHERE ID = :id";
        $deletePrimaryStatement = $this->connectionId->prepare($deletePrimarySql);
        $deletePrimaryStatement->execute(array(':id' => $id));

        // delete the dependents
        $deleteDependentSql = "DELETE FROM korean WHERE dependent = :personal_number";
        $deleteDependentStatement = $this->connectionId->prepare($deleteDependentSql);
        $deleteDependentStatement->execute(array(':personal_number' => $personal_number));

        return $deletePrimaryStatement;
    }

    public function delete_korean_dependent_data( $id ){
        $deleteSql = "DELETE FROM korean WHERE id = :id";
        $statement = $this->connectionId->prepare($deleteSql);
        $statement->bindParam(':id', $id);
        $result = $statement->execute();

        return $result;
    }

    public function korean_dependent_data( $id ){
        $sql = "SELECT * FROM korean WHERE id = :id";
        $statement = $this->connectionId->prepare($sql);
        $statement->execute(array(':id' => $id));
        $resultStatement = $statement->fetchAll(PDO::FETCH_ASSOC);
        
        $result['status'] = true;
        if($result === false) {
            $result['status'] = false;
            return $result;
        }

        $personal_number = $resultStatement[0]['personal_number'];
        $principal_name = $resultStatement[0]['principal_name'];

        //  get dependents
        $sqlDependents = "SELECT * FROM korean WHERE dependent = :personal_number";
        $dependentStatement = $this->connectionId->prepare($sqlDependents);
        $dependentStatement->execute(array(':personal_number' => $personal_number));
        $resultDependent = $dependentStatement->fetchAll(PDO::FETCH_ASSOC);

        $result['dependents']                   = $resultDependent;
        $result['principalName']                = $principal_name;
        $result['principalPersonalNumber']      = $personal_number;

        return $result;

    }

    public function korean_visa_to_be_expire(){
        $current_month = date('Y-m-d');
        $next_2month = date('Y-m-d',strtotime('+2 month'));

        $sql = "SELECT * FROM korean";
        $statement = $this->connectionId->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        $notif = array();
        foreach( $result as $item ){
            if( $item['visa_valid_until'] >= $current_month && $item['visa_valid_until'] <= $next_2month ){
                // if dependent is not equal to Principal Name
                if($item['dependent'] != "Principal Name") {
                    // Get the principal name of the korean
                    $getPrincipalSql = "SELECT * FROM korean WHERE personal_number = :dependent";
                    $principalStatement = $this->connectionId->prepare($getPrincipalSql);
                    $principalStatement->execute(array(':dependent' => $item['dependent']));
                    $principalResult = $principalStatement->fetchAll(PDO::FETCH_ASSOC);
                    // get principal name
                    $principal_name = $principalResult[0]['principal_name'];

                    $item['dependent'] = $principal_name;
                }
                array_push( $notif, $item );
            }
        }

        $data['notification'] = $notif;
        $data['notificationCount'] = count($notif);
        return $data;

    }

    public function findPersonalNoIfExist($personal_number){
        $sql = "SELECT * FROM korean WHERE personal_number = :personal_number";
        $statement = $this->connectionId->prepare($sql);
        $statement->execute(array(':personal_number' => $personal_number));
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        $principalName = "";

        if (count($result) > 0) {
            $principalName = $result[0]['principal_name'];
        }

        return $principalName;
    }
}
?>