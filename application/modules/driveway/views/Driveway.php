<script src="<?php echo base_url()?>assets/js/jquery-1.11.0.min.js"
    type="text/javascript"></script>
<script type="text/javascript"
    src="http://maps.google.com/maps/api/js?key=AIzaSyDgfXeqTWhM1bpTV7dk0G6VU5TH3Fy5Wxk"></script>
<script type="text/javascript">     
        var locations = <?php echo json_encode($locations); ?> ;
        var baseUrl        =    "<?php echo base_url();?>";
</script>
<div id="map" style="width: 800px; height: 700px;"></div>
<script src="<?php echo base_url(); ?>assets/js/driveway.js"
    type="text/javascript"></script>