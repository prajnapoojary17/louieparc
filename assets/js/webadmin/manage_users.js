var usenamevalid = 0;
var emailvalid   = 0;
$(".editbtn").on('click',function(){
    var currentTD = $(this).parents('tr').find('td');
    if ($(this).html() == 'Edit') {
        var trid = $(this).closest('tr').attr('id');
        $.each(currentTD, function () {            
            $('.span_rusername'+trid).hide();
            $('.span_remail'+trid).hide();
            $('.span_rphone'+trid).hide();
            $('.span_rdob'+trid).hide();            
            $('.span_raddress'+trid).hide();
                
            
            $('.input_rusername'+trid).show();
            $('.input_remail'+trid).show();
            $('.input_rphone'+trid).show();
            $('.input_rdob'+trid).show();            
            $('.input_raddress'+trid).show();
            $('.undobtn'+trid).show();
            $('.deletebtn'+trid).hide();                
        });
        $(this).html('Save');    
    } else {        
        var rusername = '';
        var remail = '';
        var rphone ='';
        var rdob = '';
        var err = 0;
        var $this = $(this);
        var $tr = $this.closest("tr");
        var trid = $(this).closest('tr').attr('id');
        
        rusername = $tr.find('.input_rusername'+trid).val();
        if(rusername == ""){
            err = 1;                            
            $('.rusernameerr'+trid).html('User Name is required');}            
        else if(rusername.indexOf(' ') >= 0){                
            err = 1;                            
            $('.rusernameerr'+trid).html('No space please');            
        }else if(usenamevalid != 0){                
            err = 1;                            
            $('.rusernameerr'+trid).html('User Name already exists');            
        }else{
            $('.rusernameerr'+trid).html('');            
        }
            
        remail = $tr.find('.input_remail'+trid).val();
        var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
    
        if(remail == ""){
            err = 1;                            
            $('.remailerr'+trid).html('Email is required');}            
        else if(pattern.test(remail) == false){
            err = 1;                        
            $('.remailerr'+trid).html('Invalid Email');
        }else if(emailvalid != 0){
            err = 1;                    
            $('.remailerr'+trid).html('Email already exists');
        }else{
            $('.remailerr'+trid).html('');            
        }
            
        rphone = $tr.find('.input_rphone'+trid).val();
        if(rphone == ""){
            err = 1;                            
            $('.rphoneerr'+trid).html('Phone is required');
        }else if((!rphone.match(/^\d+$/)) || (rphone.toString().length >12) || (rphone.toString().length < 10)) {
            err = 1;                        
            $('.rphoneerr'+trid).html('Invalid Phone');
        }else{
            $('.rphoneerr'+trid).html('');            
        }
                    
        rdob = $tr.find('.input_rdob'+trid).val();
        if(rdob == ""){
            err = 1;            
            $('.rdoberr'+trid).html('DOB is required');}    
        else{    
            $('.rdoberr'+trid).html('');            
        }
            
        rinput_building = $tr.find('.input_building'+trid).val();            
        rinput_streetAddress = $tr.find('.input_streetAddress'+trid).val();
        rinput_route = $tr.find('.input_route'+trid).val();
        rinput_city = $tr.find('.input_city'+trid).val();
        rinput_state = $tr.find('.input_state'+trid).val(); 
        rinput_zip = $tr.find('.input_zip'+trid).val();
        
        if($('.span_raddress'+trid).html() != 'N/A'){
        
        if(rinput_building == ""){
            err = 1;              
            $('.raddresserr'+trid).html('Building is required');
        }else if(rinput_streetAddress == ""){
            err = 1;    
            $('.raddresserr'+trid).html('Street is required');
        }else if(rinput_route == ""){
            err = 1;    
            $('.raddresserr'+trid).html('Route is required');
        } else if(rinput_city == ""){
            err = 1;    
            $('.raddresserr'+trid).html('City is required');
        } else if(rinput_state == ""){
            err = 1;    
            $('.raddresserr'+trid).html('State is required');
        } else if(rinput_zip == "") {
            err = 1;    
            $('.raddresserr'+trid).html('ZIP is required');
        } else if((!rinput_zip.match(/^[0-9]+$/)) || rinput_zip.length > 5 || rinput_zip.length < 4) {
            err = 1;    
            $('.raddresserr'+trid).html('Invalid ZIP');
        }
        else{    
            $('.raddresserr'+trid).html('');        
        }        
        }
        if(err == 0){           
            $('.loader').show();              
            $.ajax({    
                method: "POST",        
                url: baseUrl + "webadmin/update_userinfo",
                dataType : "json",                               
                data: {
                     id            : trid,
                    username      : rusername,
                    email         : remail,
                    phone         : rphone,
                    dob           : rdob,                        
                    building      : rinput_building,        
                    streetAddress : rinput_streetAddress,
                    route         : rinput_route,
                    city          : rinput_city,
                    state         : rinput_state,
                    zip           : rinput_zip            
                },            
                success:function(data) {            
                    if(typeof data.status !== typeof undefined){
                        if(data.status){                        
                            //console.log('Updated');                
                            $('.input_rusername'+trid).attr('value', rusername);
                            $('.input_remail'+trid).attr('value', remail);
                            $('.input_rphone'+trid).attr('value', rphone);
                            if($('.span_rdob'+trid).html() != 'N/A'){
                                $('.input_rdob'+trid).attr('data-date', rdob);
                            }
                            if($('.span_raddress'+trid).html() != 'N/A'){
                                $('.input_building'+trid).attr('value', rinput_building);
                                $('.input_streetAddress'+trid).attr('value', rinput_streetAddress);
                                $('.input_route'+trid).attr('value', rinput_route);
                                $('.input_city'+trid).attr('value', rinput_city);
                                $('.input_state'+trid).attr('value', rinput_state);
                                $('.input_zip'+trid).attr('value', rinput_zip);
                            }
                            
                            $('.input_rusername'+trid).attr('data-original-value', rusername);
                            $('.input_remail'+trid).attr('data-original-value', remail);
                            $('.input_rphone'+trid).attr('data-original-value', rphone);
                            if($('.span_rdob'+trid).html() != 'N/A'){
                                $('.input_rdob'+trid).attr('data-original-value', rdob);
                            }
                            if($('.span_raddress'+trid).html() != 'N/A'){
                                $('.input_building'+trid).attr('data-original-value', rinput_building);
                                $('.input_streetAddress'+trid).attr('data-original-value', rinput_streetAddress);
                                $('.input_route'+trid).attr('data-original-value', rinput_route);
                                $('.input_city'+trid).attr('data-original-value', rinput_city);
                                $('.input_state'+trid).attr('data-original-value', rinput_state);
                                $('.input_zip'+trid).attr('data-original-value', rinput_zip);
                            }                            
                            
                            $('.input_rusername'+trid).hide();
                            $('.input_remail'+trid).hide();
                            $('.input_rphone'+trid).hide();
                            $('.input_rdob'+trid).hide();                            
                            $('.input_raddress'+trid).hide();
                            $('.undobtn'+trid).hide();
                            $('.deletebtn'+trid).show();                            
                        
                            $('.span_rusername'+trid).html(rusername);
                            $('.span_remail'+trid).html(remail);
                            $('.span_rphone'+trid).html(rphone);
                            $('.span_rdob'+trid).html(rdob);
                            if($('.span_raddress'+trid).html() == 'N/A'){
                                $('.span_raddress'+trid).html('N/A')
                            }else{
                                $('.span_raddress'+trid).html(rinput_building+'</br>'+rinput_streetAddress+','+rinput_route+'</br>'+rinput_city+','+rinput_state+'-'+rinput_zip );
                            }
                            $('.span_rusername'+trid).show();
                            $('.span_remail'+trid).show();
                            $('.span_rphone'+trid).show();
                            $('.span_rdob'+trid).show();                        
                            $('.span_raddress'+trid).show();                            
                            $('.loader').hide();
                            $("#mailSent").show().delay(2000).fadeOut();
                        }else{    
                            //console.log('failed');
                            $('.input_rusername'+trid).hide();
                            $('.input_remail'+trid).hide();
                            $('.input_rphone'+trid).hide();
                            $('.input_rdob'+trid).hide();                            
                            $('.input_raddress'+trid).hide();
                            $('.undobtn'+trid).hide();
                            $('.deletebtn'+trid).show();
                            
                            $('.span_rusername'+trid).show();
                            $('.span_remail'+trid).show();
                            $('.span_rphone'+trid).show();
                            $('.span_rdob'+trid).show();                        
                            $('.span_raddress'+trid).show();
                            $('.servererror').html('Failed To Update. Please try again');                    
                            $('.loader').hide();                            
                        }
                    }              
                }            
            });
            $(this).html('Edit');                
        }            
    }    
});

$('.undobtn').on('click',function(){        
    var $this = $(this);
    var $tr = $this.closest("tr");    
    var trid = $(this).closest('tr').attr('id');
    $tr.find('.editbtn').text('Edit');    
    
    $('.input_rusername'+trid).attr('value', $('.input_rusername'+trid).data("original-value"));    
    
    $('.input_remail'+trid).val($('.input_remail'+trid).data("original-value"));
    $('.input_rphone'+trid).val($('.input_rphone'+trid).data("original-value"));
    $('.input_rdob'+trid).val($('.input_rdob'+trid).data("original-value"));
    $('.input_building'+trid).val($('.input_building'+trid).data("original-value"));    
    $('.input_streetAddress'+trid).val($('.input_streetAddress'+trid).data("original-value"));
    $('.input_route'+trid).val($('.input_route'+trid).data("original-value"));
    $('.input_city'+trid).val($('.input_city'+trid).data("original-value"));
    $('.input_state'+trid).val($('.input_state'+trid).data("original-value"));
    $('.input_zip'+trid).val($('.input_zip'+trid).data("original-value"));    
    $('.input_rusername'+trid).hide();
    $('.input_remail'+trid).hide();
    $('.input_rphone'+trid).hide();
    $('.input_rdob'+trid).hide();
    $('.input_raddress'+trid).hide();
    $('.undobtn'+trid).hide();
    
    $('.deletebtn'+trid).show();    
    $('.span_rusername'+trid).show();
    $('.span_remail'+trid).show();
    $('.span_rphone'+trid).show();
    $('.span_rdob'+trid).show();
    $('.span_raddress'+trid).show();
    $('.rusernameerr'+trid).html('');
    $('.remailerr'+trid).html('');
    $('.rphoneerr'+trid).html('');
    $('.rdoberr'+trid).html('');
    $('.raddresserr'+trid).html('');    
});


updatedriveway = function(userId) {
    $('#update_driveway').html('<form action="'+ baseUrl+'webadmin/updateDriveway" name="updatedriveway" class="updatedriveway" method="post" style="display:none;"><input type="text" name="userId" value="'+userId+'" /></form>');
    $( ".updatedriveway" ).submit();                    
};

$(".deletebtn").on('click',function(){
    var agree = confirm("Are you sure that you want to delete this item?");
    if (agree) {
        var currentTD = $(this).parents('tr').find('td');
        var id = $(this).closest('tr').attr('id');
        $.ajax({    
            method: "POST",        
            url: baseUrl + "webadmin/delete_user",
            dataType : "json",                               
            data: {id:id},            
            success:function(data) {            
                if(typeof data.status !== typeof undefined){
                    if(data.status){                        
                        //console.log('Updated');
                        currentTD.remove();
                        $('.loader').hide();    
                    }else{    
                        //console.log('failed');
                        $('.servererror').html('Failed To Delete. Please try again');                    
                        $('.loader').hide();                            
                    }
                }              
            }            
        });   
        return true;
    }
    return false;    
});

$(".username").on("keyup", function(){
    var trid = $(this).closest('tr').attr('id');            
    $.ajax({    
        method: "POST",        
        url: baseUrl + "webadmin/check_username",
        dataType : "json",                               
        data: {                         
            username:this.value,
            id:trid
        },            
        success:function(data) {            
            if(data == false){
                usenamevalid = 1;
                //console.log("User Name already exists");
                $('.rusernameerr'+trid).html('User Name already exists');        
            }else {
                usenamevalid = 0;
                $('.rusernameerr'+trid).html('');
            }
        }            
    });
});

$(".emailID").on("keyup", function(){
    var trid = $(this).closest('tr').attr('id');            
    $.ajax({    
        method: "POST",        
        url: baseUrl + "webadmin/check_username",
        dataType : "json",                               
        data: {                         
            email:this.value,
            id:trid
        },            
        success:function(data) {            
            if(data == false){
                emailvalid = 1;
                //console.log("Email ID already exists");
                $('.remailerr'+trid).html('Email ID already exists');        
            }else {
                emailvalid = 0;
                $('.remailerr'+trid).html('');
            }
        }            
    });
});

logintoaccount = function(userId) {
    $('#update_driveway').html('<form action="'+ baseUrl+'webadmin/logintoaccount" name="logintoaccount" class="logintoaccount" method="post" style="display:none;"><input type="text" name="userId" value="'+userId+'" /></form>');
    $( ".logintoaccount" ).submit();                    
};
