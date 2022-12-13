<?php
/**
 * File             : View Korean Principal
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

<!--angular js-->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/angular.min.js"></script>

<style>
    .error {
        border-color: #e96666;
        outline: 0;
        -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(128, 0, 0, 0.9);
        box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(128, 0, 0, 0.9);
    }
</style>
<div id="wrapper" ng-app="petitionerApp" >
    <div class="row col-lg-12">
        <div class="col-xs-12" id="create-div-1">
            <div class="panel panel-info">
                <div class="panel-heading">Petitioner</div>
                <div class="panel-body">
                    <div class="table-responsive col-lg-12" ng-controller="tablePetitionerController">
                        <table class="table table-striped table-bordered table-hover dataTable no-footer" id="example">
                            <thead class="sorting" aria-label="Browser: activate to sort column ascending">
                            <tr>
                                <th>Petitioner</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach( $data['result'] as $item ){
                                echo "
                                            <tr>
                                                <td>".$item['petitioner']."</td>
                                                <td>
                                                    <button type=\"button\" class=\"btn btn-default edit\" data-toggle=\"modal\" data-target=\"#editModal\" ng-click='edit(".$item['id'].")' title=\"Edit\">
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
                        <button type="button" onclick = "addData()" class="btn btn-default"><i class="fa fa-plus-circle fa-fw"></i>Add</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Modal-->
    <div class="modal bs-example-modal-lg" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" ng-controller="editPetitionerController">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Edit</h4>
                </div>
                <div class="modal-body">
                    <form id="editForm" class="form-horizontal" name="editForm" >
                        <input type="hidden" id="temp_id">
                        <table class="table table-bordered" >
                            <tbody>
                            <tr>
                                <td>Petitioner</td>
                                <td><input type="text" class="form-control" id="edit_petitioner" name="edit_petitioner" ng-model="edit_petitioner" aria-describedby="edit_petitioner_Help" placeholder="Petitioner" required /></td>
                            </tr>
                            </tbody>
                        </table>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" ng-click = "editData()" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal bs-example-modal-lg" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" ng-controller="addPetitionerController">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Add Record</h4>
                </div>
                <div class="modal-body">
                    <form id="addForm" class="form-horizontal" name="addForm" >
                        <table class="table table-bordered">
                            <tbody>
                            <tr>
                                <td>Petitioner</td>
                                <td><input type="text" ng-model="petitioner" class="form-control" id="petitioner" name="petitioner" aria-describedby="petitioner_Help" placeholder="Petitioner" required /></td>
                            </tr>
                            </tbody>
                        </table>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" id="submitData" class="btn btn-primary" ng-click ="add()">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal bs-example-modal-lg" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" ng-controller="deletePetitionerController">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Confirmation</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="temp_delete_id">
                    <p>Do you really want to delete the item?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    <button type="button" id="yes" class="btn btn-primary" ng-click="deleteData()">Yes</button>
                </div>
            </div>
        </div>
    </div>
    <!--End of Modal-->
</div>

<!--script type="text/javascript" src="<?php echo base_url(); ?>assets/js/sampleController.js"></script-->
<script>

var petitionerApp = angular.module("petitionerApp", []);

petitionerApp.controller('addPetitionerController', function($scope){
    $scope.add = function(){
       $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>utilities/addPetitionerDetails",
            data: {
                'petitioner'       : $('#petitioner').val()
            },
            dataType: 'json',
            success: function (data) {
                if (data.status == true) {
                    $('#addModal').modal('hide');
                    alert(data.message);
                    window.location.assign("<?php echo base_url(); ?>utilities/viewPetitioner");
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

petitionerApp.controller('tablePetitionerController', function($scope){
    $scope.edit = function(id){
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>utilities/getPetitionerDetails",
            data: {
                'ID' : id
            },
            dataType: 'json',
            success: function (data) {
                $.each(data.result, function( key, item){
                    $('#edit_petitioner').val(item['petitioner']);
                    $('#temp_id').val(item['id']);
                });
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            } 
        });
    };
});

petitionerApp.controller('editPetitionerController', function($scope){
    $scope.editData = function(){
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>utilities/editPetitionerDetails",
            data: {
                'petitioner'       : $('#edit_petitioner').val(),
                'id'               : $('#temp_id').val()
            },
            dataType: 'json',
            success: function (data) {
                if (data.status == true) {
                    $('#editModal').modal('hide');
                    alert(data.message);
                    window.location.assign("<?php echo base_url(); ?>utilities/viewPetitioner");
                } else {
                    alert(data.error);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    };
});

petitionerApp.controller('deletePetitionerController', function($scope){
    $scope.deleteData = function() {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>utilities/deletePetitioner",
            data: { 
                'id' : $('#temp_delete_id').val() 
            },
            dataType: 'json',
            success: function (data) {console.log(data);
                if(data.status == true) {
                    $('#deleteModal').modal('hide');
                    alert(data.message);
                    window.location.assign("<?php echo base_url(); ?>utilities/viewPetitioner");
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

function addData(){
    $('#addModal').modal('show');

    // reset the fields
    $('#addForm').trigger("reset");
}

function deleteData(id){
    $('#temp_delete_id').val(id);
}

$(document).ready(function() {
    $('#example').DataTable({
        select: true
    } );
});

</script>

<style type="text/css">
    .datepicker{
        z-index: 2000 !important;
    }
</style>