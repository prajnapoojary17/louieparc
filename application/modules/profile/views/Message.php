<script type="text/javascript">
    var baseUrl = "<?php echo base_url(); ?>";
</script>
<div class="loader" style="display:none"><div class="loader-container"><div class="spinner"></div>Please wait...</div></div>
<div class="main-content">
    <div class="profile-message">
        <div class="aside-pic hidden-sm hidden-xs wow fadeInUp" data-wow-duration="1s" data-wow-delay=".2s">
            <img src="<?php echo base_url(); ?>assets/images/traffic.png" />
            <address>                      
                LouiePark<br />
                Louiseville<br />
                Kentucky, KY<br />
                <i class="icon-phone"></i> (555)-123 456 7890<br />
                <i class="icon-envelope-o"></i><a href="mailto:<?php echo $constants->fromEmail; ?>?Subject=LouiePark" target="_top" style="color: #ffffff"> LouiePark@gmail.com </a><br />
            </address>
        </div>
        <div class="aside-bottom hidden-sm hidden-xs wow fadeInLeft" data-wow-duration="1s" data-wow-delay=".2s">
            <img src="<?php echo base_url(); ?>assets/images/traffic-bottom.png" />
        </div>

        <div class="container">
            <div class="message-container">
                <div class="collapse margin-top20" id="mailSent" style="display:none;">
                    <div role="alert" class="alert alert-success"> <strong>Well done!</strong> Your message has been sent. </div>
                </div>
                <h1 class="wow fadeInUp" data-wow-duration="1s" data-wow-delay=".2s">Messages</h1>
                <div class="row  wow fadeInUp" data-wow-duration="1s" data-wow-delay=".4s">
                    <div class="col-md-4">
                        <form method="POST" name="message" class="message">
                            <input type="hidden" name="emailId" value="<?php echo $emailId; ?>">                            
                            <div class="form-group">
                                <input type="text" id="subject" name="subject">
                                <label>Subject</label>
                                <span class="bar"></span>
                            </div>
                            <div class="form-group">
                                <textarea rows="8" id="message" name="message"></textarea>
                                <label>Message</label>
                                <span class="bar"></span>
                            </div>                            
                            <button type="submit" class="btn btn-brand send-btn" data-toggle="collapse" aria-expanded="false" aria-controls="mailSent"><span>Send</span> <i class="icon-paper-plane-o"></i></button>
                            <a href="<?php echo base_url(); ?>dashboard" class="btn btn-brand"><i class="icon-cross2"></i>Close </a>    


                        </form>
                    </div>
                    <div class="col-md-4 col-md-offset-4 signin-form hidden-md hidden-lg">
                        <address>                      
                            LouiePark<br />
                            Louiseville<br />
                            Kentucky, KY<br />
                            <i class="icon-phone"></i> (555)-123 456 7890<br />
                            <i class="icon-envelope-o"></i> LouiePark@gmail.com<br />
                        </address>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url(); ?>assets/js/message.js" type="text/javascript"></script>
