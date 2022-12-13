<?php
/**
 * File             : View Other Report
 * @author          : Rhea Labayo
 * @copyright       : 2016 December
 * Date Updated     : December 1, 2016
 *
 */

?>

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/bootstrap/plugins/datatable.min.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/bootstrap/plugins/datepicker/bootstrap-datepicker.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/bootstrap/plugins/datepicker/datepicker.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/bootstrap/select2.min.css" />

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap/plugins/dataTables/datatable.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap/plugins/datepicker/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap/select2.full.js"></script>

<div id="wrapper">
    <div class="row col-lg-12">
        <div class="col-xs-12" id="create-div-1">
            <div class="panel panel-info">
                <div class="panel-heading">Other Report</div>
                <div class="panel-body">
                    <form class="form-horizontal">
                        <div class="form-group form-group-sm">
                            <label class = "col-sm-1 control-label" for="">Start Date</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control datePicker" id="startDate" placeholder="Start Date" name="startDate" autocomplete="off"  value="<?php echo date('Y-m-d'); ?>" data-date-format="yyyy-mm-dd" required />
                            </div>
                        </div>
                        <div class="form-group form-group-sm">
                            <label class = "col-sm-1 control-label" for="">End Date</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control datePicker" id="endDate" placeholder="End Date" name="endDate" autocomplete="off"  value="<?php echo date('Y-m-d'); ?>" data-date-format="yyyy-mm-dd" required />
                            </div>
                        </div>
                        <div class="form-group form-group-sm">
                            <label class = "col-sm-1 control-label" for="">Date Type</label>
                            <div class="col-sm-2">
                                <select class="form-control" id="date_type" name="date_type">
                                    <option value="">Select Date Type</option>
                                    <option value="visa_issue_date">Visa Issue Date</option>
                                    <option value="visa_valid_until">Visa Valid Until</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group form-group-sm">
                            <label class = "col-sm-1 control-label" for="">Principal Name</label>
                            <div class="col-sm-2">
                                <select class="form-control principal_name_select" id="principal_passport_number" name="principal_passport_number">
                                    <option value="">Select Principal Name</option>
                                    <?php
                                    foreach( $data['otherData'] as $item ){
                                        echo "<option value=\"".$item->passport_number."\">".$item->principal_name."</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group form-group-sm">
                            <div class="col-sm-3">
                                <button class="btn btn-primary btn-sm pull-right" id="view" type="button">View</button>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive col-lg-12">
                        <h4>Results</h4><hr><br>
                        <table class="table table-striped table-bordered table-hover no-footer" id="example">
                            <thead class="sorting" aria-label="Browser: activate to sort column ascending">
                            <tr>
                                <th>#</th>
                                <th>Principal's Passport Number</th>
                                <th>Passport Number</th>
                                <th>Principal Name</th>
                                <th>Folder Name</th>
                                <th>Gender</th>
                                <th>Birthdate</th>
                                <th>Contact Number</th>
                                <th>Petitioner</th>
                                <th>Visa Status</th>
                                <th>Visa Issue Date</th>
                                <th>Visa Valid Until</th>
                                <th>Others</th>
                            </tr>
                            </thead>
                            <tbody id="tbody_other">
                            </tbody>
                        </table>
                    </div>
                </div>
                <br>
                <div class="panel-footer clearfix" id="panel-footer">

                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $(".principal_name_select").select2();
    });

    $('#startDate').datepicker().on("changeDate", function (ev) {
        $(this).datepicker("hide");
    });

    $('#endDate').datepicker().on("changeDate", function (ev) {
        $(this).datepicker("hide");
    });

    $('#view').click(function(){
        var start_date = $('#startDate').val();
        var end_date = $('#endDate').val();
        var date_type = $('#date_type').val();
        var principal_passport_number = $('#principal_passport_number').val();
        $('.download_button').remove();
        $('.tr_added').remove();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/report/getOtherReport",
            data: {
                'startDate'                 : start_date,
                'endDate'                   : end_date,
                'dateType'                  : date_type,
                'principalPassportNumber'   : principal_passport_number
            },
            dataType: 'json',
            success: function(data){
                $('#tbody_other tr').remove();
                var html = '';
                if( (data.result).length > 0 ){
                    $.each(data.result, function( key, item){
                        var dependent = item['dependent'];
                        if( item['dependent'] == 'Principal Name' ){
                            dependent = 'Principal';
                        }
                        $('#tbody_other').append("<tr class='tr_added'>" +
                            "<td>"+(key+1)+"</td>" +
                            "<td>"+dependent+"</td>" +
                            "<td>"+item['passport_number']+"</td>" +
                            "<td>"+item['principal_name']+"</td>" +
                            "<td>"+item['folder_number']+"</td>" +
                            "<td>"+item['gender']+"</td>" +
                            "<td>"+item['birthdate']+"</td>" +
                            "<td>"+item['contact_number']+"</td>" +
                            "<td>"+item['petitioner']+"</td>" +
                            "<td>"+item['visa_status']+"</td>" +
                            "<td>"+item['visa_issue_date']+"</td>" +
                            "<td>"+item['visa_valid_until']+"</td>" +
                            "<td>"+item['others']+"</td>" +
                            "</tr>");
                    });
                    $('#panel-footer').append("<div class='form-group form-group-sm download_button'>"+
                        "<div class='col-sm-3'>" +
                        "<a href='<?php echo base_url(); ?>application/user/downloads/"+data.excelFileName+".xls'>" +
                        "<button class='btn btn-default' id='downloadExcelFile' type='button'>"+
                        "Download Excel File" +
                        "</button>" +
                        "</a>" +
                        "</div>" +
                        "</div>"
                    );
                }
               // document.getElementById("downloadExcelFile").disabled = false;
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });

    });

   /* $('#downloadExcelFile').click(function(){
        var start_date = $('#startDate').val();
        var end_date = $('#endDate').val();
        var date_type = $('#date_type').val();

        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/report/downloadOtherReport",
            data: {
                'startDate' : start_date,
                'endDate'   : end_date,
                'dateType'  : date_type
            },
            dataType: 'json',
            success: function(data){
                if( data.excelFileName != '' ){
                    window.location.href = "<?php echo base_url() . 'application/user/downloads/'?>" + data.excelFileName + ".xls";
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    });*/
</script>

<style type="text/css">
    .datepicker{
        z-index: 2000 !important;
    }
</style>