<?php
if ( isset($_SESSION['logged_in'])){
  if ( $_SESSION['logged_in'] != NULL){       
		$data = $_SESSION['logged_in'];			
		$userId = $data['user_id'];
	
  }
}

?>
       <script type="text/javascript">
        var baseUrl		=	"<?php echo base_url();?>";
		</script>   
	<div class="full-screen">
        <div class="main-content single-page">
		<div class="triangles wow lightSpeedIn" data-wow-duration="1s" data-wow-delay="2s">
			<span class="triangle1"></span>
			<span class="triangle2"></span>
			<span class="triangle3"></span>
		</div>
            <div class="signin-page">
                <h1 class="main-title wow fadeInUp" data-wow-duration="1s" data-wow-delay=".5s">Verify your account</h1>
                <h2 class="sub-title wow fadeInUp" data-wow-duration="1s" data-wow-delay=".6s">Please enter the 5 digit code emailed you below</h2>
                <div class="container">
                    <div class="row">
                        <div class="col-md-6 signin-graphics">
                            <img src="<?php echo base_url(); ?>assets/images/verify.png" alt="louiepark" class="img-responsive wow fadeInUp" data-wow-duration="1s" data-wow-delay="1s" />
                        </div>
						
                        <div class="col-md-4 fancy-form signin-form wow flipInX" data-wow-duration="1s" data-wow-delay="1.3s">
						<div class="error_box"></div>
                            <form class="wow fadeInUp verify"  name="verify" data-wow-duration="1s" data-wow-delay=".9s">
                                <div class="form-group">
								 <input type="hidden" name="userID" id="userID" value="<?php echo $userId;?>" />	
                                    <input type="text" name="vcode">
                                    <label>Verification Code</label>
                                    <span class="bar"></span>
                                </div>
								 <input type="submit"  class="btn btn-brand btn-block" value="Submit" />                              
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
		<script src="<?php echo base_url()?>assets/js/validation.js" type="text/javascript"></script>
