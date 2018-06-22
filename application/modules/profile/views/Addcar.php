<script type="text/javascript">
    var baseUrl = "<?php echo base_url(); ?>";
</script>
<div class="full-screen">
    <div class="main-content single-page">
        <div class="triangles wow lightSpeedIn" data-wow-duration="1s" data-wow-delay="2s">
            <span class="triangle1"></span>
            <span class="triangle2"></span>
            <span class="triangle3"></span>
        </div>
        <div class="signin-page">
            <h1 class="main-title wow fadeInUp" data-wow-duration="1s" data-wow-delay=".5s">Add a car</h1>
            <h2 class="sub-title wow fadeInUp" data-wow-duration="1s" data-wow-delay=".6s">Please add your car information below</h2>
            <h4 class="info-title wow fadeInUp" data-wow-duration="1s" data-wow-delay=".7s">Car information</h4>
            <div class="container">
                <div class="row">
                    <div class="col-md-6 signin-graphics">
                        <img src="<?php echo base_url(); ?>assets/images/add-car.png" alt="LouiePark" class="img-responsive wow fadeInUp" data-wow-duration="1s" data-wow-delay="1s" />
                    </div>
                    <div class="col-md-4 fancy-form signin-form wow flipInX" data-wow-duration="1s" data-wow-delay="1.3s">
                        <div class="error_box"></div>
                        <form class="wow fadeInUp addcar" data-wow-duration="1s" data-wow-delay=".9s" method="post" name="addcar">
                            <div class="form-group">
                                <input type="text" id="model" name="model">
                                <label>Model</label>
                                <span class="bar"></span>
                            </div>
                            <div class="form-group">
                                <input type="text" id="year" name="year">
                                <label>Year</label>
                                <span class="bar"></span>
                            </div>
                            <div class="form-group">
                                <input type="text" id="color" name="color">
                                <label>Color</label>
                                <span class="bar"></span>
                            </div>
                            <div class="form-group">
                                <input type="text" id="vnumber" name="vnumber">
                                <label>License Plate Number</label>
                                <span class="bar"></span>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-brand"><i class="icon-thumbs-o-up"></i>Done </button>                                
                                <a href="<?php echo base_url(); ?>dashboard" class="btn btn-brand"><i class="icon-ban"></i>Cancel </a>                                                
                            </div>                            
                            <!--<div class="form-group">
                                <a href="#" class="btn btn-brand btn-block"><i class="icon-thumbs-o-up"></i>Done</a>
                            </div>-->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url(); ?>assets/js/addcar.js" type="text/javascript"></script>