<?php
/**
 * File             : View Add User
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
                <div class="panel-heading">User Settings</div>
                <div class="panel-body">
                    <form class="form-horizontal" >
                        <div class="form-group">
                            <label class = "col-sm-1 control-label" for="">First Name</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" id="firstName" placeholder="First Name" name="firstName"  required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class = "col-sm-1 control-label" for="">Last Name</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" id="lastName" placeholder="Last Name" name="lastName"  required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class = "col-sm-1 control-label" for="">User Name</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" id="userName" placeholder="User Name" name="userName"  required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class = "col-sm-1 control-label" for="">Password</label>
                            <div class="col-sm-3">
                                <input type="password" class="form-control" id="password" placeholder="Password" name="password"  required />
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-4">
                                <button class="btn btn-primary btn-sm pull-right" id="add" type="button">Add Record</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="panel-footer clearfix" id="panel-footer">
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('#add').click(function(){
        if( $('#firstName').val() == '' ){
            $( '#firstName' ).addClass('error');
            $("#firstName").keyup(function(){
                $("#firstName").removeClass('error');
            });
        }else if( $('#lastName').val() == '' ){
            $( '#lastName' ).addClass('error');
            $("#lastName").keyup(function(){
                $("#lastName").removeClass('error');
            });
        }else if( $('#userName').val() == '' ){
            $('#userName' ).addClass('error');
            $("#userName").keyup(function(){
                $("#userName").removeClass('error');
            });
        }else if( $('#password').val() == '' ){
            $( '#password' ).addClass('error');
            $("#password").keyup(function(){
                $("#password").removeClass('error');
            });
        }else {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>index.php/user_authentication/new_user_registration",
                data: {
                    'firstName'         : $('#firstName').val(),
                    'lastName'          : $('#lastName').val(),
                    'userName'          : $('#userName').val(),
                    'password'          : $('#password').val()
                },
                dataType: 'json',
                success: function (data) {
                    if (data.status == true) {
                        alert(data.message_display);
                        window.location.assign("<?php echo base_url(); ?>add_user");
                    } else {
                        alert(data.message_display);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
        }
    });
</script>