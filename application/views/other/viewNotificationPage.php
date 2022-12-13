<?php
/**
 * File             : View Other Notification
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

<div id="wrapper">
    <div class="row col-lg-12">
        <div class="col-xs-12" id="create-div-1">
            <div class="panel panel-info">
                <div class="panel-heading">Notification</div>
                <div class="panel-body">
                    <div class="table-responsive col-lg-12">
                        <table class="table table-striped table-bordered table-hover dataTable no-footer" id="example">
                            <thead class="sorting" aria-label="Browser: activate to sort column ascending">
                            <tr>
                                <th>Principal's Name</th>
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
                            <tbody>
                            <?php
                            foreach( $data['notification'] as $item ){
                                $dependent = $item['dependent'];
                                if( $item['dependent'] == 'Principal Name' ){
                                    $dependent = 'Principal';
                                }
                                echo "
                                                <tr>
                                                    <td>".$dependent."</td>
                                                    <td>".$item['passport_number']."</td>
                                                    <td>".$item['principal_name']."</td>
                                                    <td>".$item['folder_number']."</td>
                                                    <td>".$item['gender']."</td>
                                                    <td>".$item['birthdate']."</td>
                                                    <td>".$item['contact_number']."</td>
                                                    <td>".$item['petitioner']."</td>
                                                    <td>".$item['visa_status']."</td>
                                                    <td>".$item['visa_issue_date']."</td>
                                                    <td style='color:red;'>".$item['visa_valid_until']."</td>
                                                    <td>".$item['others']."</td>
                                                </tr>
                                            ";
                            }
                            ?>
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

<script>
    $(document).ready(function() {
        $('#example').DataTable( {
            select: true
        } );
    } );

    $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>index.php/report/getOtherNotification",
        dataType: 'json',
        success: function(data){
            $.each( data, function (key, item ){
                excelFileName = item['excelFileName'];
            });
            if( excelFileName != '' ){
                $('#panel-footer').append("<div class='form-group form-group-sm download_button'>"+
                    "<div class='col-sm-3'>" +
                    "<a href='<?php echo base_url(); ?>application/user/downloads/"+excelFileName+".xls'>" +
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
</script>
