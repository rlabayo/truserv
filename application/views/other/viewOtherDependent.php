<?php
/**
 * File             : View Other Dependents
 * @author          : Rhea Labayo
 * @copyright       : 2016 December
 * Date Updated     : December 1, 2016
 *
 */
?>

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/bootstrap/plugins/datatable.min.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/bootstrap/plugins/datepicker/bootstrap-datepicker.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/bootstrap/plugins/datepicker/datepicker.css" />

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap/plugins/dataTables/datatable.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap/plugins/datepicker/bootstrap-datepicker.js"></script>

<style>
    .error {
        border-color: #e96666;
        outline: 0;
        -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(128, 0, 0, 0.9);
        box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(128, 0, 0, 0.9);
    }
</style>
<div id="wrapper">
    <div class="row col-lg-12">
        <div class="col-xs-12" id="create-div-1">
            <div class="panel panel-info">
                <div class="panel-heading">Other Dependents</div>
                <div class="panel-body">
                    <div class="table-responsive col-lg-12">
                        <input type="hidden" id="primaryId" value="<?php echo $data['id'];?>" />
                        <input type="hidden" id="primaryPassportNumber" value="<?php echo $data['principalPassportNumber'];?>" />
                        <div class="form-group">
                            <h4>Principal Name: <b><?php echo " [".$data['principalPassportNumber']."] ".$data['principalName']; ?></b></h4><br>
                        </div>
                        <table class="table table-striped table-bordered table-hover dataTable no-footer" id="example">
                            <thead class="sorting" aria-label="Browser: activate to sort column ascending">
                            <tr>
                                <th>Passport Number</th>
                                <th>Dependent Name</th>
                                <th>Folder Name</th>
                                <th>Gender</th>
                                <th>Birthdate</th>
                                <th>Contact Number</th>
                                <th>Petitioner</th>
                                <th>Visa Status</th>
                                <th>Visa Issue Date</th>
                                <th>Visa Valid Until</th>
                                <th>Others</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach( $data['result'] as $item ){
                                echo "
                                            <tr>
                                                <td>".$item['passport_number']."</td>
                                                <td>".$item['principal_name']."</td>
                                                <td>".$item['folder_number']."</td>
                                                <td>".$item['gender']."</td>
                                                <td>".$item['birthdate']."</td>
                                                <td>".$item['contact_number']."</td>
                                                <td>".$item['petitioner']."</td>
                                                <td>".$item['visa_status']."</td>
                                                <td>".$item['visa_issue_date']."</td>
                                                <td>".$item['visa_valid_until']."</td>
                                                <td>".$item['others']."</td>
                                                <td>
                                                    <button type=\"button\" class=\"btn btn-default edit\" data-toggle=\"modal\" data-target=\"#editModal\" onclick = 'edit(".$item['id'].")' title=\"Edit\">
                                                        <i class=\"fa fa-edit fa-fw\"></i>
                                                    </button>
                                                    <button type=\"button\" class=\"btn btn-default delete\" data-toggle=\"modal\" data-target=\"#deleteModal\" onclick = 'deleteData(".$item['id'].")' title=\"Delete\">
                                                        <i class=\"fa fa-trash fa-fw\"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        ";
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                    <div>
                        <button type="button" onclick = "back()" class="btn btn-default"><i class="fa fa-arrow-left fa-fw"></i>Back</button>
                        <button type="button" onclick = "addData()" class="btn btn-default"><i class="fa fa-plus-circle fa-fw"></i>Add</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Modal-->
    <div class="modal bs-example-modal-lg" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Edit</h4>
                </div>
                <div class="modal-body">
                    <form id="editForm" class="form-horizontal">
                        <input type="hidden" id="temp_id">
                        <table class="table table-bordered">
                            <tbody>
                            <tr>
                                <td>Folder Name</td>
                                <td>
                                    <select class="form-control" id="edit_folder_name" name="edit_folder_name" ng-model="edit_folder_name" required>
                                        <option value="">Select Folder Name</option>
                                        <?php
                                        foreach( $data['folderNamesList'] as $folderItem ){
                                            echo "<option value='".$folderItem['folderName']."'>".$folderItem['folderName']."</option>";
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Passport Number</td>
                                <td><input type="text" class="form-control" id="edit_passport_number" name="edit_passport_number" aria-describedby="edit_passport_number_Help" placeholder="Passport Number" /></td>
                            </tr>
                            <tr>
                                <td>Dependent's Name <br>[First Name first]</td>
                                <td><input type="text" class="form-control" id="edit_principal_name" name="edit_principal_name" aria-describedby="pedit_rincipal_name_Help" placeholder="Dependent's Name" required /></td>
                            </tr>
                            <tr>
                                <td>Gender</td>
                                <td>
                                    <select class="form-control" id="edit_gender" name="edit_gender" required>
                                        <option value="">Select Gender</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Contact Number</td>
                                <td><input type="text" class="form-control" id="edit_contact_number" name="edit_contact_number" aria-describedby="edit_contact_number_Help" placeholder="Contact Number" required /></td>
                            </tr>
                            <tr>
                                <td>Petitioner</td>
                                <td>
                                    <select class="form-control" id="edit_petitioner" name="edit_petitioner" ng-model="edit_petitioner" required>
                                        <option value="">Select Petitioner</option>
                                        <?php
                                        foreach( $data['petitionersList'] as $petitionerItem ){
                                            echo "<option value='".$petitionerItem['petitioner']."'>".$petitionerItem['petitioner']."</option>";
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Visa Issue Date</td>
                                <td><input type="text" class="form-control datePicker" id="edit_visa_issue_date" placeholder="Visa Issue Date" name="edit_visa_issue_date" autocomplete="off"  value="" data-date-format="yyyy-mm-dd"  /></td>
                            </tr>
                            <tr>
                                <td>Others<br>(Please Specify)</td>
                                <td><input type="text" class="form-control" id="edit_others" name="edit_others" aria-describedby="edit_others_Help" placeholder="Others" /></td>
                            </tr>
                            <tr>
                                <td>Birthdate</td>
                                <td><input type="text" class="form-control datePicker" id="edit_birthdate" placeholder="Birthdate" name="edit_birthdate" autocomplete="off"  value="" data-date-format="yyyy-mm-dd" required /></td>
                            </tr>
                            <tr>
                                <td>Visa Valid Until</td>
                                <td><input type="text" class="form-control datePicker" id="edit_visa_valid_until" placeholder="Visa Valid Until" name="edit_visa_valid_until" autocomplete="off"  value="" data-date-format="yyyy-mm-dd" /></td>
                            </tr>
                            <tr>
                                <td>Visa Status</td>
                                <td>
                                    <select class="form-control" id="edit_visa_status" name="edit_visa_status" ng-model="edit_visa_status">
                                        <option value="">Select Visa Status</option>
                                        <?php
                                        foreach( $data['visaStatusList'] as $visaStatusItem ){
                                            echo "<option value='".$visaStatusItem['visaStatus']."'>".$visaStatusItem['visaStatus']."</option>";
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" onclick = "editData()" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal bs-example-modal-lg" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Add Record</h4>
                </div>
                <div class="modal-body">
                    <form id="addForm" class="form-horizontal">
                        <table class="table table-bordered">
                            <tbody>
                            <tr>
                                <td>Folder Name</td>
                                <td>
                                    <select class="form-control" id="folder_name" name="folder_name" ng-model="folder_name" required>
                                        <option value="">Select Folder Name</option>
                                        <?php
                                        foreach( $data['folderNamesList'] as $folderItem ){
                                            echo "<option value='".$folderItem['folderName']."'>".$folderItem['folderName']."</option>";
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Passport Number</td>
                                <td><input type="text" class="form-control" id="passport_number" name="passport_number" aria-describedby="passport_number_Help" placeholder="Passport Number" /></td>
                            </tr>
                            <tr>
                                <td>Dependent's Name <br>[First Name first]</td>
                                <td><input type="text" class="form-control" id="principal_name" name="principal_name" aria-describedby="principal_name_Help" placeholder="Dependent's Name" required /></td>
                            </tr>
                            <tr>
                                <td>Gender</td>
                                <td>
                                    <select class="form-control" id="gender" name="gender" required>
                                        <option value="">Select Gender</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Contact Number</td>
                                <td><input type="text" class="form-control" id="contact_number" name="contact_number" aria-describedby="contact_number_Help" placeholder="Contact Number" required /></td>
                            </tr>
                            <tr>
                                <td>Petitioner</td>
                                <td>
                                    <select class="form-control" id="petitioner" name="petitioner" ng-model="petitioner" required>
                                        <option value="">Select Petitioner</option>
                                        <?php
                                        foreach( $data['petitionersList'] as $petitionerItem ){
                                            echo "<option value='".$petitionerItem['petitioner']."'>".$petitionerItem['petitioner']."</option>";
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Visa Issue Date</td>
                                <td><input type="text" class="form-control datePicker" id="visa_issue_date" placeholder="Visa Issue Date" name="visa_issue_date" autocomplete="off"  value="<?php echo date('Y-m-d'); ?>" data-date-format="yyyy-mm-dd"  /></td>
                            </tr>
                            <tr>
                                <td>Others<br>(Please Specify)</td>
                                <td><input type="text" class="form-control" id="others" name="others" aria-describedby="others_Help" placeholder="Others" /></td>
                            </tr>
                            <tr>
                                <td>Birthdate</td>
                                <td><input type="text" class="form-control datePicker" id="birthdate" placeholder="Birthdate" name="birthdate" autocomplete="off"  value="<?php echo date('Y-m-d'); ?>" data-date-format="yyyy-mm-dd" required /></td>
                            </tr>
                            <tr>
                                <td>Visa Valid Until</td>
                                <td><input type="text" class="form-control datePicker" id="visa_valid_until" placeholder="Visa Valid Until" name="visa_valid_until" autocomplete="off"  value="<?php echo date('Y-m-d'); ?>" data-date-format="yyyy-mm-dd" /></td>
                            </tr>
                            <tr>
                                <td>Visa Status</td>
                                <td>
                                    <select class="form-control" id="visa_status" name="visa_status" ng-model="visa_status" required >
                                        <option value="">Select Visa Status</option>
                                        <?php
                                        foreach( $data['visaStatusList'] as $visaStatusItem ){
                                            echo "<option value='".$visaStatusItem['visaStatus']."'>".$visaStatusItem['visaStatus']."</option>";
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" id="submitData" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal bs-example-modal-lg" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Confirmation</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="temp_delete_id">
                    <p>Do you really want to delete the item? </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    <button type="button" id="yes" class="btn btn-primary">Yes</button>
                </div>
            </div>
        </div>
    </div>
    <!--End of Modal-->
</div>

<script>

    $(document).ready(function() {
        $('#example').DataTable( {
            select: true
        } );
    } );

    // add modal
    $('#visa_issue_date').datepicker().on("changeDate", function (ev) {
        $(this).datepicker("hide");
    });

    $('#visa_valid_until').datepicker().on("changeDate", function (ev) {
        $(this).datepicker("hide");
    });

    $('#birthdate').datepicker().on("changeDate", function (ev) {
        $(this).datepicker("hide");
    });

    // edit modal

    $('#edit_visa_issue_date').datepicker().on("changeDate", function (ev) {
        $(this).datepicker("hide");
    });

    $('#edit_visa_valid_until').datepicker().on("changeDate", function (ev) {
        $(this).datepicker("hide");
    });

    $('#edit_birthdate').datepicker().on("changeDate", function (ev) {
        $(this).datepicker("hide");
    });

    function edit(id){
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/other/getDetails",
            data: { 'ID' : id },
            dataType: 'json',
            success: function(data){
                $.each(data.result, function( key, item){
                    $('#edit_folder_name').val(item['folder_number']);
                    $('#edit_gender').val(item['gender']);
                    $('#edit_contact_number').val(item['contact_number']);
                    $('#edit_petitioner').val(item['petitioner']);
                    $('#edit_visa_issue_date').val(item['visa_issue_date']);
                    $('#edit_others').val(item['others']);
                    $('#edit_principal_name').val(item['principal_name']);
                    $('#edit_passport_number').val(item['passport_number']);
                    $('#edit_birthdate').val(item['birthdate']);
                    $('#edit_visa_status').val(item['visa_status']);
                    $('#edit_visa_valid_until').val(item['visa_valid_until']);
                    $('#temp_id').val(item['id']);
                });
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    }

    function editData(){
        var primaryId = $('#primaryId').val();
        if( $('#edit_passport_number').val() == '' ){
            $( '#edit_passport_number' ).addClass('error');
            $("#edit_passport_number").keyup(function(){
                $("#edit_passport_number").removeClass('error');
            });
        }else if( $('#edit_folder_name').val() == '' ){
            $( '#edit_folder_name' ).addClass('error');
            $("#edit_folder_name").keyup(function(){
                $("#edit_folder_name").removeClass('error');
            });
        }else if( $('#edit_gender').val() == '' ){
            $( '#edit_gender' ).addClass('error');
            $("#edit_gender").keyup(function(){
                $("#edit_gender").removeClass('error');
            });
        }else if( $('#edit_contact_number').val() == '' ){
            $( '#edit_contact_number' ).addClass('error');
            $("#edit_contact_number").keyup(function(){
                $("#edit_contact_number").removeClass('error');
            });
        }else if( $('#edit_petitioner').val() == '' ){
            $( '#edit_petitioner' ).addClass('error');
            $("#edit_petitioner").keyup(function(){
                $("#edit_petitioner").removeClass('error');
            });
        }else if( $('#edit_principal_name').val() == '' ){
            $( '#edit_principal_name' ).addClass('error');
            $("#edit_principal_name").keyup(function(){
                $("#edit_principal_name").removeClass('error');
            });
        }else if( $('#edit_visa_status').val() == '' ){
            $( '#edit_visa_status' ).addClass('error');
            $("#edit_visa_status").keyup(function(){
                $("#edit_visa_status").removeClass('error');
            });
        }else {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>index.php/other/editDetails",
                data: {
                    'folder_name': $('#edit_folder_name').val(),
                    'gender': $('#edit_gender').val(),
                    'contact_number': $('#edit_contact_number').val(),
                    'petitioner': $('#edit_petitioner').val(),
                    'visa_issue_date': $('#edit_visa_issue_date').val(),
                    'others': $('#edit_others').val(),
                    'principal_name': $('#edit_principal_name').val(),
                    'passport_number': $('#edit_passport_number').val(),
                    'birthdate': $('#edit_birthdate').val(),
                    'visa_status': $('#edit_visa_status').val(),
                    'visa_valid_until': $('#edit_visa_valid_until').val(),
                    'id': $('#temp_id').val()
                },
                dataType: 'json',
                success: function (data) {
                    if (data.status == true) {
                        $('#editModal').modal('hide');
                        alert(data.message);
                        window.location.assign("<?php echo base_url(); ?>index.php/other/viewOtherDependent/" + primaryId);
                    } else {
                        alert(data.error);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
        }
    }

    function addData(){
        $('#addModal').modal('show');

        // reset the fields
        $('#addForm').trigger("reset");
    }

    function deleteData(id){
        $('#temp_delete_id').val(id);
    }

    // yes delete the record
    $('#yes').click(function(){
        var primaryId = $('#primaryId').val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/other/deletePrimary",
            data: { 'ID' : $('#temp_delete_id').val() },
            dataType: 'json',
            success: function(data){
                if( data.status == true ){
                    $('#deleteModal').modal('hide');
                    alert('Record has been deleted.');
                    window.location.assign("<?php echo base_url(); ?>index.php/other/viewOtherDependent/"+primaryId);
                }else{
                    alert('Error found while deleting an item.');
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    });

    $('#submitData').click(function(){
        var principal_id = $('#primaryId').val();
        if( $('#passport_number').val() == '' ){
            $( '#passport_number' ).addClass('error');
            $("#passport_number").keyup(function(){
                $("#passport_number").removeClass('error');
            });
        }else if( $('#folder_name').val() == '' ){
            $( '#folder_name' ).addClass('error');
            $("#folder_name").keyup(function(){
                $("#folder_name").removeClass('error');
            });
        }else if( $('#gender').val() == '' ){
            $( '#gender' ).addClass('error');
            $("#gender").keyup(function(){
                $("#gender").removeClass('error');
            });
        }else if( $('#contact_number').val() == '' ){
            $( '#contact_number' ).addClass('error');
            $("#contact_number").keyup(function(){
                $("#contact_number").removeClass('error');
            });
        }else if( $('#petitioner').val() == '' ){
            $( '#petitioner' ).addClass('error');
            $("#petitioner").keyup(function(){
                $("#petitioner").removeClass('error');
            });
        }else if( $('#principal_name').val() == '' ){
            $( '#principal_name' ).addClass('error');
            $("#principal_name").keyup(function(){
                $("#principal_name").removeClass('error');
            });
        }else if( $('#visa_status').val() == '' ){
            $( '#visa_status' ).addClass('error');
            $("#visa_status").keyup(function(){
                $("#visa_status").removeClass('error');
            });
        }else {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>index.php/other/addDependent",
                data: {
                    'folder_name': $('#folder_name').val(),
                    'gender': $('#gender').val(),
                    'contact_number': $('#contact_number').val(),
                    'petitioner': $('#petitioner').val(),
                    'visa_issue_date': $('#visa_issue_date').val(),
                    'others': $('#others').val(),
                    'dependent_name': $('#principal_name').val(),
                    'passport_number': $('#passport_number').val(),
                    'birthdate': $('#birthdate').val(),
                    'visa_status': $('#visa_status').val(),
                    'visa_valid_until': $('#visa_valid_until').val(),
                    'principal_passport_number': $('#primaryPassportNumber').val(),
                },
                dataType: 'json',
                success: function (data) {
                    if (data.status == true) {
                        $('#addModal').modal('hide');
                        alert(data.message);
                        window.location.assign("<?php echo base_url(); ?>index.php/other/viewOtherDependent/" + principal_id);
                    } else {
                        alert(data.error);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
        }
    });

    function viewData(id){

    }

    function back(){
        window.location.assign("<?php echo base_url(); ?>index.php/other/view");
    }

</script>

<style type="text/css">
    .datepicker{
        z-index: 2000 !important;
    }
</style>