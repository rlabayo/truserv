<?php

Class OtherModel extends CI_Model{

    public $connectionId;
    public $userId;
    public $dateToday;

    public function __construct(){
        parent::__construct();

        $db = $this->load->database();

        $this->connectionId = $this->db->conn_id;
        $this->dateToday    = date('Y-m-d');
        
        if( isset($this->session->userdata['userId']) ){
            $this->userId   = $this->session->userdata['userId'];
        }
    }

    public function other_data( $id = NULL ){
        if( $id == NULL ){
            $sql = "SELECT * FROM others WHERE dependent = 'Principal Name'";
            $statement = $this->connectionId->prepare($sql);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        }else{
            $sql = "SELECT * FROM others WHERE id = :id";
            $statement = $this->connectionId->prepare($sql);
            $statement->execute(array(':id' => $id));
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);

            $passport_number = $result[0]['passport_number'];
            $principal_name = $result[0]['principal_name'];

            $sql2 = "SELECT * FROM others WHERE dependent = :passport_number";
            $statement2 = $this->connectionId->prepare($sql2);
            $statement2->execute(array(':passport_number' => $passport_number));
            $result = $statement2->fetchAll(PDO::FETCH_ASSOC);
        }

        return $result;
    }
    
    public function add_other_primary_data( $post_data ){
        $sql = "SELECT * FROM others WHERE passport_number = :passport_number";
        $statement = $this->connectionId->prepare($sql);
        $statement->execute(array(':passport_number' => $post_data['passport_number']));
        $resultQuery = $statement->fetchAll(PDO::FETCH_ASSOC);
        
        if ( count($resultQuery) > 0 ) {
            return false;
        } else {
            $dependent = 'Principal Name';
            $nationality = 'others';
            $insertSql = "INSERT INTO others (folder_number,
                                            gender, contact_number,
                                            petitioner, visa_issue_date,
                                            others, principal_name,
                                            passport_number, birthdate,
                                            visa_status, visa_valid_until,
                                            dependent, nationality,
                                            dateCreated, createdBy)
                                    VALUES (:folder_number,
                                        :gender, :contact_number,
                                        :petitioner, :visa_issue_date,
                                        :others, :principal_name,
                                        :passport_number, :birthdate,
                                        :visa_status, :visa_valid_until,
                                        :dependent, :nationality,
                                        :dateCreated, :createdBy)";
            $addStatement = $this->connectionId->prepare($insertSql);
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
           
            return $result;
        }
    }

    public function other_dependent_data( $id ){
        $sql = "SELECT * FROM others WHERE id = :id";
        $statement = $this->connectionId->prepare($sql);
        $statement->execute(array(':id' => $id));
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $result['status'] = true;

        $passport_number = $result[0]['passport_number'];
        $principal_name = $result[0]['principal_name'];

        //  get dependents
        $dependentSql = "SELECT * FROM others WHERE dependent = :passport_number";
        $dependentStatement = $this->connectionId->prepare($dependentSql);
        $dependentStatement->execute(array(':passport_number' => $passport_number));
        $resultDependents = $dependentStatement->fetchAll(PDO::FETCH_ASSOC);

        $result['dependents']                   = $resultDependents;
        $result['principalName']                = $principal_name;
        $result['principalPassportNumber']      = $passport_number;

        return $result;
    }

    public function get_data( $id = NULL ){
        $sql = "SELECT * FROM others WHERE ID = :id";
        $statement = $this->connectionId->prepare($sql);
        $statement->execute(array(':id' => $id));
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public function edit_other_data( $post_data ){
        $sql = "SELECT * FROM others WHERE passport_number = :passport_number AND id != :id ";
        $statement = $this->connectionId->prepare($sql);
        $statement->execute(array(':passport_number' => $post_data['passport_number'], ':id' => $post_data['id']));
        $resultQuery = $statement->fetchAll(PDO::FETCH_ASSOC);

        if ( count($resultQuery) > 0 ) {
            return false;
        } else {
            $addSql = "UPDATE others SET folder_number = :folder_number,
                                gender = :gender, contact_number = :contact_number,
                                petitioner = :petitioner, visa_issue_date = :visa_issue_date,
                                others = :others, principal_name = :principal_name,
                                passport_number = :passport_number, birthdate = :birthdate,
                                visa_status = :visa_status, visa_valid_until = :visa_valid_until,
                                updatedBy = :updatedBy, date_updated = :date_updated
                                WHERE id = :id";
            $addStatement = $this->connectionId->prepare($addSql);
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
            $addStatement->bindParam(':updatedBy', $this->userId);
            $addStatement->bindParam(':date_updated', $this->dateToday);
            $addStatement->bindParam(':id', $post_data['id']);
            $result = $addStatement->execute();
           
            return $result;
        }
    }

    public function delete_other_primary_data( $id ){
        $sql = "SELECT * FROM others WHERE id = :id";
        $statement = $this->connectionId->prepare($sql);
        $statement->execute(array(':id' => $id));
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $passport_number = $result[0]['passport_number'];

        // delete the primary
        $deletePrimarySql = "DELETE FROM others WHERE ID = :id";
        $deletePrimaryStatement = $this->connectionId->prepare($deletePrimarySql);
        $resultPrimary = $deletePrimaryStatement->execute(array(':id' => $id));

        // delete the dependents
        $deleteDependentsSql = "DELETE FROM others WHERE dependent = :passport_number";
        $deleteDependentStatement = $this->connectionId->prepare($deleteDependentsSql);
        $deleteDependentStatement->execute(array(':passport_number' => $passport_number));

        return $resultPrimary;
    }

    public function add_other_dependent_data( $post_data ){
        $sql = "SELECT * FROM others WHERE passport_number = :passport_number";
        $statement = $this->connectionId->prepare($sql);
        $statement->execute(array(':passport_number' => $post_data['passport_number']));
        $resultQuery = $statement->fetchAll(PDO::FETCH_ASSOC);

        if ( count($resultQuery) > 0 ) {
            return false;
        } else {
            $nationality = "others";
            $insertSql = "INSERT INTO others (folder_number,
                                            gender, contact_number,
                                            petitioner, visa_issue_date,
                                            others, principal_name,
                                            passport_number, birthdate,
                                            visa_status, visa_valid_until,
                                            dependent, nationality,
                                            dateCreated, createdBy)
                                    VALUES (:folder_number,
                                        :gender, :contact_number,
                                        :petitioner, :visa_issue_date,
                                        :others, :principal_name,
                                        :passport_number, :birthdate,
                                        :visa_status, :visa_valid_until,
                                        :dependent, :nationality,
                                        :dateCreated, :createdBy)";
            $addStatement = $this->connectionId->prepare($insertSql);
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
            $addStatement->bindParam(':dependent', $post_data['principal_passport_number']);
            $addStatement->bindParam(':nationality', $nationality);
            $addStatement->bindParam(':dateCreated', $this->dateToday);
            $addStatement->bindParam(':createdBy', $this->userId);
            $result = $addStatement->execute();

            return $result;
        }
    }

    public function other_visa_to_be_expire(){
        $current_month = date('Y-m-d');
        $next_month = date('Y-m-d',strtotime('+1 month'));

        $sql = "SELECT * FROM others";
        $statement = $this->connectionId->prepare($sql);
        $statement->execute();
        $result_query = $statement->fetchAll(PDO::FETCH_ASSOC);

        $notif = array();
        foreach( $result_query as $item ){
            if( $item['visa_valid_until'] >= $current_month && $item['visa_valid_until'] <= $next_month ){
                 // if dependent is not equal to Principal Name
                if($item['dependent'] != "Principal Name") {
                    // Get the principal name of the korean
                    $principalSql = "SELECT * FROM others WHERE passport_number = :dependent";
                    $principalStatement = $this->connectionId->prepare($principalSql);
                    $principalStatement->execute(array(':dependent' => $item['dependent']));
                    $get_principal_result = $principalStatement->fetchAll(PDO::FETCH_ASSOC);

                    $principal_name = $get_principal_result[0]['principal_name'];

                    $item['dependent'] = $principal_name;
                }
                array_push( $notif, $item );
            }
        }

        $data['notification'] = $notif;
        $data['notificationCount'] = count($notif);
        return $data;
    }
    
}