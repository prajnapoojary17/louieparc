<style>
    .form-group.form-placeholder label.error {
        top: 35px !important;
    }
</style>
<?php $_SESSION['drivewayId'] = $driveway->drivewayID; ?>
<script type="text/javascript">
    var baseUrl = "<?php echo base_url(); ?>";
</script>  

<div class="loader" style="display:none"><div class="loader-container"><div class="spinner"></div>Please wait...</div></div>

<!-- START page-->
<div class="full-screen">
    <div class="main-content single-page">
        <div class="triangles wow lightSpeedIn" data-wow-duration="1s" data-wow-delay="2s">
            <span class="triangle1"></span>
            <span class="triangle2"></span>
            <span class="triangle3"></span>
        </div>
        <div class="signin-page">
            <h1 class="main-title wow fadeInUp" data-wow-duration="1s" data-wow-delay=".5s">Edit Driveway</h1>
            <h2 class="sub-title wow fadeInUp" data-wow-duration="1s" data-wow-delay=".6s">Please provide some photos, a brief description and instructions.</h2>
            <div class="container">
                <div class="row">                        
                    <div class="col-md-4 fancy-form signin-form wow flipInX" data-wow-duration="1s" data-wow-delay="1.3s">
                        <form class="wow fadeInUp drivewayinfo" data-wow-duration="1s" data-wow-delay=".9s" name="drivewayinfo" id="drivewayinfo">
                            <input type="hidden" id="drivewayId" name="drivewayId" value="<?php echo $driveway->drivewayID; ?>"> 
                            <input type="hidden" name="flname" id="flname" value="" />
                            <div class="form-group form-placeholder">
                                <label>Building</label>
                                <input type="text" name="building" class="form-control" value="<?php echo $driveway->building; ?>">                                    
                            </div>
                            <div class="form-group form-placeholder">
                                <label>Description of your driveway</label>
                                <textarea class="max-text" maxlength="240" name="description"><?php echo $driveway->description; ?></textarea>
                                <span class="bar"></span>
                            </div>
                            <div class="form-group form-placeholder">
                                <label>Instructions for the driver</label>
                                <textarea class="max-text" maxlength="240" name="instructions"><?php echo $driveway->instructions; ?></textarea>
                                <span class="bar"></span>
                            </div>
                            <div class="form-group form-placeholder">
                                <label>Parking Slots</label>
                                <input type="text" name="slot" id="slot" class="form-control" data-original-value="<?php echo $driveway->slot; ?>" value="<?php echo $driveway->slot; ?>" required>                                    
                            </div>
                            <div class="form-group form-placeholder">
                                <label>Hourly Price</label>
                                <input type="text" name="hourlyprice" id="currency1" class="form-control" value="<?php echo $driveway->price; ?>" required>                                    
                            </div>
                            <div class="form-group form-placeholder">
                                <label>Flat Price</label>
                                <input type="text" name="flatprice"  id="currency" class="form-control" value="<?php echo $driveway->dailyprice; ?>" required>                                    
                            </div>
                            <div class="form-group">                                
                                <button type="submit" class="btn btn-brand"><i class="icon-check22"></i>Save</button>
                                <a href="<?php echo base_url(); ?>dashboard" class="btn btn-brand"><i class="icon-cross2"></i>Close </a>
                            </div>
                        </form>
                    </div>
                    <div class="drivewayimages col-md-8 signin-graphics wow fadeInUp" data-wow-duration="1s" data-wow-delay=".8s">

                        <div class="form-group">
                            <input id="drivewayphotos" class="file"    name="drivewayphotos[]" type="file" multiple>
                        </div>

                        <p>You can add upto four photos of your driveway. Please note that one photo is required before making your driveway available for rent.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END page-->    
<script src="<?php echo base_url(); ?>assets/js/driveway_edit.js" type="text/javascript"></script>
<!-- File input -->
<script src="<?php echo base_url(); ?>assets/js/fileinput.min.js"></script>

<script>
    var images;
    var drivewayId = $('#drivewayId').val();
<?php
$i = 0;
if (isset($driveway->photo1)) {
    ++$i;
}
if (isset($driveway->photo2)) {
    ++$i;
}
if (isset($driveway->photo3)) {
    ++$i;
}
if (isset($driveway->photo4)) {
    ++$i;
}
?>
    images = "<?php echo $i ?>";
    $("#drivewayphotos").fileinput({
        initialPreview: [
<?php
if (isset($driveway->photo1)) {

    echo '"' . base_url() . 'assets/uploads/driveway/' . $driveway->photo1 . '"';
}
if (isset($driveway->photo2)) {
    echo ',"' . base_url() . 'assets/uploads/driveway/' . $driveway->photo2 . '"';
}
if (isset($driveway->photo3)) {
    echo ',"' . base_url() . 'assets/uploads/driveway/' . $driveway->photo3 . '"';
}
if (isset($driveway->photo4)) {
    echo ',"' . base_url() . 'assets/uploads/driveway/' . $driveway->photo4 . '"';
}
?>
        ],
        initialPreviewAsData: true,
        initialPreviewConfig: [
<?php
$user = $_SESSION[LOGGED_IN];
        $userId = $user[USER_ID];
if (isset($driveway->photo1)) {    
     $drivewayID =  $driveway->drivewayID;
    echo '{caption: "' . $driveway->photo1 . '", url: "' . base_url() . 'usermanagement/api/delete_file/' . $drivewayID . '/'.$userId.'", key: "' . $driveway->photo1 . ', photo1" , showZoom: false}';
}
if (isset($driveway->photo2)) {
    echo ',{caption: "' . $driveway->photo2 . '", url: "' . base_url() . 'usermanagement/api/delete_file/' . $drivewayID . '/'.$userId.'", key: "' . $driveway->photo2 . ', photo2", showZoom: false}';
}
if (isset($driveway->photo3)) {
    echo ',{caption: "' . $driveway->photo3 . '", url: "' . base_url() . 'usermanagement/api/delete_file/' . $drivewayID . '/'.$userId.'", key: "' . $driveway->photo3 . ', photo3", showZoom: false}';
}
if (isset($driveway->photo4)) {
    echo ',{caption: "' . $driveway->photo4 . '", url: "' . base_url() . 'usermanagement/api/delete_file/' . $drivewayID . '", key: "' . $driveway->photo4 . ', photo4", showZoom: false}';
}
?>
            /*{caption: "house1.jpg", url: baseUrl+"usermanagement/api/delete_file", key: 'house1.jpg'},
             {caption: "house2.jpg", url: baseUrl+"usermanagement/api/delete_file", key: 'house2.jpg'}*/
        ],

        deleteUrl: baseUrl + "usermanagement/api/delete_file/" + drivewayId,
        initialCaption: "Click here to add/edit photos of your driveway",
        uploadUrl: baseUrl + 'profile/api/updatedriveway/' + drivewayId, // you must set a valid URL here else you will get an error
        allowedFileExtensions: ['jpg', 'png', 'gif'],
        uploadAsync: false,
        overwriteInitial: false,
        maxFileSize: 1000,
        maxFileCount: 4 - images
        ,
        slugCallback: function (filename) {
            return filename.replace('(', '_').replace(']', '_');
        }
    }).on('filebatchuploadsuccess', function (event, data, previewId, index) {
        $('.kv-file-remove').hide();
        window.location = window.location;
        $('.loader').show(0).delay(5000).hide(0);
        var form = data.form, files = data.files,
                response = data.response;
        var drivewayId = $("#drivewayId").val(response);
    }).on('fileclear', function (event) {
        console.log("fileclear");
    });
    /*  $('#drivewayphotos').on('filedeleteerror', function(event, data, msg) { 
     location.reload(true) ;
     $('.loader').show(0).delay(5000).hide(0);
     }); */
    $('#drivewayphotos').on('filedeleted', function (event, key) {
        //images = images - 1;    
        //console.log('Key = ' + key);
        //console.log(images);    
        window.location = window.location;
    });
    $('.file-upload-indicator').hide();
    $('.file-drag-handle').hide();
    $('#drivewayphotos').on('filebatchselected', function (event, data, files) {
        var fcount = data.length;
        console.log(fcount);
    });

    $('#drivewayphotos').on('fileselect', function (event, numFiles, label) {
        // $(".fileinput-upload").prop('title', 'Please Click here to Upload images');
        // $(".fileinput-upload").addClass('btn-danger pulse animated');       
        // $(".fileinput-upload").tooltip('show');
        //console.log("fileselected");
    });
    //console.log(images);

    if (images == 4) {
        $('.file-caption-main').hide();
    }
    $('#drivewayphotos').on('filereset', function (event) {
        // console.log("filereset");
    });

    $('#drivewayphotos').on('filebatchpreupload', function (event, data, previewId, index) {
        //var form = data.form, files = data.files, extra = data.extra,
        //   response = data.response, reader = data.reader;
        // console.log('File batch pre upload');
        $(".fileinput-upload").removeClass('btn-danger pulse animated');
        $(".fileinput-upload").addClass('btn-default');
        $(".fileinput-upload").tooltip('hide');
    });
    $('#drivewayphotos').on('fileloaded', function (event, file, previewId, index, reader) {
        $(".fileinput-upload").addClass('btn-danger pulse animated');
        $(".fileinput-upload").tooltip('show');
        console.log('fileloaded');
    });


   /* $(".rmImage").click(function () {
        alert("button");
    });*/
</script>    