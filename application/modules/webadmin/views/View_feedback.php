<script type="text/javascript">
    var baseUrl = "<?php echo base_url(); ?>";
</script> 
<?php $_SESSION['feedback_userid'] = $userID; ?>
<?php $_SESSION['feedback_drvid'] = $drivewayID; ?>
<div class="col-md-10">
    <div class="content-box-large">
        <div class="panel-heading">
            <center><h3>Reviews</h3></center>             
        </div>                
        <div class="collapse margin-top20" id="mailSent">
            <div role="alert" class="alert alert-success">Feedback approved successfully.</div>
        </div>
        <input type="hidden" name="userID" value="<?php echo $userID; ?>">
        <div class="panel-body">
            <div class="servererror" style="color:red;"></div>
            <?php
            if (!empty($feedbacks)) {
                $i = 1;
                ?>                     
                <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
                    <thead>
                        <tr>
                            <th>Sl. No</th>
                            <th>User </th>
                            <th>Title</th>
                            <th>Comments</th>
                            <th>Ratings</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($feedbacks as $feedback) { ?>
                            <tr class="odd gradeX" id="<?php echo $feedback->reviewID ?>">
                                <td><?php echo $i; ?></td>
                                <td><?php echo $feedback->firstName; ?>&nbsp;<?php echo $feedback->lastName; ?></td>
                                <td>
                                    <span><?php echo $feedback->title ?> </span>                           
                                </td>
                                <td>
                                    <span><?php echo $feedback->comments; ?></span>                          
                                </td>
                                <td>
                                    <span><?php echo $feedback->rating; ?></span>                          
                                </td>
                                <td>
                                    <?php if ($feedback->approvedStatus == 1) { ?>
                                        <label class="label label-success">Approved</label> <?php } else { ?> <button class="btn btn-warning approve approvebtn<?php echo $feedback->reviewID ?>">Approve</button>  <label class="label label-success approvelabel<?php echo $feedback->reviewID ?>" style="display:none;">Approved</label><?php } ?>
                                </td>
                            </tr>
                            <?php
                            $i = $i + 1;
                        }
                        ?>
                    </tbody>
                </table>
            <?php } else { ?>
                <center><h3>No Feedbacks</h3></center>
            <?php } ?>
        </div>    
    </div>
    <div style="margin-left: 467px; margin-bottom: 20px;"><a href="#" onclick="feedbackclose('<?php echo $userID ?>')" class="btn btn-lg btn-block btn-primary" style="width:200px;">CLOSE</a></div>
</div>
<div id="feedback_form">
</div>
<script src="https://code.jquery.com/jquery.js"></script>
<!-- jQuery UI -->
<script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script src="<?php echo base_url(); ?>assets/vendors/form-helpers/js/bootstrap-formhelpers.min.js"></script>
<link href="<?php echo base_url(); ?>assets/vendors/datatables/dataTables.bootstrap.css" rel="stylesheet" media="screen">
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="<?php echo base_url(); ?>assets/vendors/datatables/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendors/datatables/dataTables.bootstrap.js"></script>
<script src="<?php echo base_url(); ?>assets/js/webadmin/tables.js"></script>
<script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/webadmin/custom.js"></script>
<script src="<?php echo base_url(); ?>assets/js/webadmin/feedback.js"></script>
<script>
        $('document').ready(function () {
            $.ajax({
                method: "POST",
                url: baseUrl + "webadmin/getverifyCount",
                dataType: "json",
                success: function (data) {
                    $(".verifycount").text(data.count);
                }
            });



//$(".verifycount").text("3");

        });
</script>