<script type="text/javascript">
    var baseUrl = "<?php
echo base_url();
?>";
</script>
<div class="full-screen">
    <div class="main-content single-page">
        <div class="triangles wow lightSpeedIn" data-wow-duration="1s"
             data-wow-delay="2s">
            <span class="triangle1"></span> <span class="triangle2"></span> <span
                class="triangle3"></span>
        </div>
        <div class="signin-page">
            <h1 class="main-title wow fadeInUp" data-wow-duration="1s"
                data-wow-delay=".5s">Welcome to LouiePark</h1>           
            <div class="container">
                <div class="row">                   
                    <div class="col-md-10 fancy-form signin-form wow flipInX"
                         data-wow-duration="1s" data-wow-delay="1.3s">
                             <?php
                             if (isset($msg)) {
                                 echo '<div class="error_box" style="display:block">' . "$msg" . '</div>';
                             } else {
                                 ?>
                            <h1>Thank you for confirming your booking </h1> <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>