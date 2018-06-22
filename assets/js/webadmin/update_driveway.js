$(".editbtn").on('click',function(){
    var currentTD = $(this).parents('tr').find('td');
    if ($(this).html() == 'Edit') {
        var trid = $(this).closest('tr').attr('id');
        $.each(currentTD, function () {
            var id = currentTD.closest("tr").find('.cid').text();
            $('.span_daddress'+trid).hide();
            $('.span_ddescription'+trid).hide();
            $('.span_dinstructions'+trid).hide();
            $('.span_dhprice'+trid).hide();
            $('.span_ddprice'+trid).hide();
            $('.span_dslot'+trid).hide();
            $('.span_dstatus'+trid).hide();            
                
            $('.input_daddress'+trid).show();
            $('.input_ddescription'+trid).show();
            $('.input_dinstructions'+trid).show();
            $('.input_dhprice'+trid).show();
            $('.input_ddprice'+trid).show();
            $('.input_dslot'+trid).show();
            $('.input_dstatus'+trid).show();            
            $('.undobtn'+trid).show();
            $('.deletebtn'+trid).hide();                
        });
        $(this).html('Save');    
    } else {    
        var ddescription = 0;
        var dinstructions =0;
        var dhprice = 0;
        var ddprice = 0;
        var dslot = 0;
        var err = 0;
        var dstatus = 0;
        var $this = $(this);
        var $tr = $this.closest("tr");
        var trid = $(this).closest('tr').attr('id');               
        $.each(currentTD, function () {            
            ddescription = $tr.find('.input_ddescription'+trid).val();
            if(ddescription == ""){
                err = 1;                                
                $('.ddescriptionerr'+trid).html('Description is required');}            
            else{
                $('.ddescriptionerr'+trid).html('');            
            }
            
            dinstructions = $tr.find('.input_dinstructions'+trid).val();
            if(dinstructions == ""){
                err = 1;                            
                $('.dinstructionserr'+trid).html('Instruction is required');}            
            else{
                $('.dinstructionserr'+trid).html('');        
            }
            
            dhprice = $tr.find('.input_dhprice'+trid).val();
            if(dhprice == ""){
                err = 1;                            
                $('.hpriceerr'+trid).html('Price is required');
            }else if((dhprice > 150) || (dhprice < 1)) {
                err = 1;                            
                $('.hpriceerr'+trid).html('Invalid');
            }            
            else{
                $('.hpriceerr'+trid).html('');            
            }
            
            ddprice = $tr.find('.input_ddprice'+trid).val();
            if(ddprice == ""){
                err = 1;                            
                $('.dpriceerr'+trid).html('Price is required');
            }else if((ddprice > 150) || (ddprice < 1)) {
                err = 1;                        
                $('.dpriceerr'+trid).html('Invalid');
            }            
            else{
                $('.dpriceerr'+trid).html('');            
            }
            
            dslot = $tr.find('.input_dslot'+trid).val();
            dslotoriginalval = $('.input_dslot'+trid).data("original-value");
            if(dslot == ""){
                err = 1;                        
                $('.sloterr'+trid).html('Slot is required');
            }else if(dslot < dslotoriginalval){
                err = 1;                        
                $('.sloterr'+trid).html('Slots cannot be reduced');
            }else{
                $('.sloterr'+trid).html('');            
            }
            
            dstatus                = $('input[name=status'+trid+']:checked').val();            
            dinput_building        = $tr.find('.input_building'+trid).val();            
            dinput_streetAddress   = $tr.find('.input_streetAddress'+trid).val();
            dinput_route           = $tr.find('.input_route'+trid).val();
            dinput_city            = $tr.find('.input_city'+trid).val();
            dinput_state           = $tr.find('.input_state'+trid).val(); 
            dinput_zip             = $tr.find('.input_zip'+trid).val();
            if(dinput_building == ""){
                err = 1;              
                $('.daddresserr'+trid).html('Building is required');
            }else if(dinput_streetAddress == ""){
                err = 1;    
                $('.daddresserr'+trid).html('Street is required');
            }else if(dinput_route == ""){
                err = 1;    
                $('.daddresserr'+trid).html('Route is required');
            } else if(dinput_city == ""){
                err = 1;    
                $('.daddresserr'+trid).html('City is required');
            } else if(dinput_state == ""){
                err = 1;    
                $('.daddresserr'+trid).html('State is required');
            } else if(dinput_zip == "") {
                err = 1;    
                $('.daddresserr'+trid).html('ZIP is required');
            } else if((!dinput_zip.match(/^[0-9]+$/)) || dinput_zip.length > 5 || dinput_zip.length < 4) {
                err = 1;    
                $('.daddresserr'+trid).html('Invalid ZIP');
            } else{    
                $('.daddresserr'+trid).html('');            
            }        
        });
        if(err == 0){           
            $('.loader').show();              
            $.ajax({    
                method: "POST",        
                url: baseUrl + "webadmin/update_drivewayinfo",
                dataType : "json",                               
                data: {
                         drivewayId        : trid,
                        description       : ddescription,
                        instructions      : dinstructions,
                        price             : dhprice,    
                        dailyprice        : ddprice,
                        building          : dinput_building,        
                        streetAddress     : dinput_streetAddress,
                        route             : dinput_route,
                        city              : dinput_city,
                        state             : dinput_state,
                        zip               : dinput_zip,
                        drivewaystatus    : dstatus,
                        slot              : dslot
                },            
                success:function(data) {            
                    if(typeof data.status !== typeof undefined){
                        if(data.status){                        
                            //console.log('Updated');                            
                            $('.input_ddescription'+trid).attr('value', ddescription);
                            $('.input_dinstructions'+trid).attr('value', dinstructions);
                            $('.input_dhprice'+trid).attr('value', dhprice);
                            $('.input_ddprice'+trid).attr('value', ddprice);
                            $('.input_dslot'+trid).attr('value', dslot);
                            $('.input_building'+trid).attr('value', dinput_building);
                            $('.input_streetAddress'+trid).attr('value', dinput_streetAddress);
                            $('.input_route'+trid).attr('value', dinput_route);
                            $('.input_city'+trid).attr('value', dinput_city);
                            $('.input_state'+trid).attr('value', dinput_state);
                            $('.input_zip'+trid).attr('value', dinput_zip);
                            
                            $('.input_ddescription'+trid).attr('data-original-value', ddescription);
                            $('.input_dinstructions'+trid).attr('data-original-value', dinstructions);
                            $('.input_dhprice'+trid).attr('data-original-value', dhprice);
                            $('.input_ddprice'+trid).attr('data-original-value', ddprice);
                            $('.input_dslot'+trid).attr('data-original-value', dslot);
                            $('.input_building'+trid).attr('data-original-value', dinput_building);
                            $('.input_streetAddress'+trid).attr('data-original-value', dinput_streetAddress);
                            $('.input_route'+trid).attr('data-original-value', dinput_route);
                            $('.input_city'+trid).attr('data-original-value', dinput_city);
                            $('.input_state'+trid).attr('data-original-value', dinput_state);
                            $('.input_zip'+trid).attr('data-original-value', dinput_zip);
                            
                            $('.input_daddress'+trid).hide();
                            $('.input_ddescription'+trid).hide();
                            $('.input_dinstructions'+trid).hide();
                            $('.input_dhprice'+trid).hide();
                            $('.input_ddprice'+trid).hide();
                            $('.input_dslot'+trid).hide();
                            $('.input_dstatus'+trid).hide();
                            $('.undobtn'+trid).hide();
                            $('.deletebtn'+trid).show();                    
                            
                            $('.span_ddescription'+trid).html(ddescription);
                            $('.span_dinstructions'+trid).html(dinstructions);
                            $('.span_dhprice'+trid).html(dhprice);
                            $('.span_ddprice'+trid).html(ddprice);
                            $('.span_dslot'+trid).html(dslot);
                            if(dstatus == 1){
                                $('.span_dstatus'+trid).html('Active');
                            }else{
                                $('.span_dstatus'+trid).html('Inactive');
                            }
                            $('.span_daddress'+trid).html(dinput_building+'</br>'+dinput_streetAddress+','+dinput_route+'</br>'+dinput_city+','+dinput_state+'-'+dinput_zip );                            
                            $('.span_ddescription'+trid).show();
                            $('.span_dinstructions'+trid).show();
                            $('.span_dhprice'+trid).show();
                            $('.span_ddprice'+trid).show();
                            $('.span_dslot'+trid).show();
                            $('.span_daddress'+trid).show();
                            $('.span_dstatus'+trid).show();                                                    
                            $('.loader').hide();
                            $("#mailSent").show().delay(2000).fadeOut();
                        }else{    
                            //console.log('failed');
                            $('.input_daddress'+trid).hide();
                            $('.input_ddescription'+trid).hide();
                            $('.input_dinstructions'+trid).hide();
                            $('.input_dhprice'+trid).hide();
                            $('.input_ddprice'+trid).hide();
                            $('.input_dslot'+trid).hide();
                            $('.input_dstatus'+trid).hide();
                            $('.undobtn'+trid).hide();
                            $('.deletebtn'+trid).show();
                            
                            $('.span_ddescription'+trid).show();
                            $('.span_dinstructions'+trid).show();
                            $('.span_dhprice'+trid).show();
                            $('.span_ddprice'+trid).show();
                            $('.span_dslot'+trid).show();
                            $('.span_daddress'+trid).show();
                            $('.span_dstatus'+trid).show();    
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
    
    $('.input_ddescription'+trid).val($('.input_ddescription'+trid).data("original-value"));
    $('.input_dinstructions'+trid).val($('.input_dinstructions'+trid).data("original-value"));
    $('.input_dhprice'+trid).val($('.input_dhprice'+trid).data("original-value"));
    $('.input_ddprice'+trid).val($('.input_ddprice'+trid).data("original-value"));
    $('.input_dslot'+trid).val($('.input_dslot'+trid).data("original-value"));
    $('.input_building'+trid).val($('.input_building'+trid).data("original-value"));
    $('.input_streetAddress'+trid).val($('.input_streetAddress'+trid).data("original-value"));
    $('.input_route'+trid).val($('.input_route'+trid).data("original-value"));
    $('.input_city'+trid).val($('.input_city'+trid).data("original-value"));
    $('.input_state'+trid).val($('.input_state'+trid).data("original-value"));
    $('.input_zip'+trid).val($('.input_zip'+trid).data("original-value"));
    if ( $('#active'+trid).data("original-value") == 1){
        $('#active'+trid).prop('checked',true);    
    } else {
        $('#active'+trid).prop('checked',false);    
    }
    if ( $('#inactive'+trid).data("original-value") == 1){
        $('#inactive'+trid).prop('checked',true);    
    } else {
        $('#inactive'+trid).prop('checked',false);    
    }
    //$('.input_dstatus'+trid).val($('.input_dstatus'+trid).data("original-value"));
    
    $('.input_ddescription'+trid).hide();
    $('.input_dinstructions'+trid).hide();
    $('.input_dhprice'+trid).hide();    
    $('.input_ddprice'+trid).hide();
    $('.input_dslot'+trid).hide();    
    $('.input_dstatus'+trid).hide();
    $('.input_daddress'+trid).hide();
    $('.undobtn'+trid).hide();
    
    
    $('.deletebtn'+trid).show();    
    $('.span_ddescription'+trid).show();
    $('.span_dinstructions'+trid).show();
    $('.span_dhprice'+trid).show();
    $('.span_ddprice'+trid).show();
    $('.span_dslot'+trid).show();
    $('.span_daddress'+trid).show();
    $('.span_dstatus'+trid).show();    
    $('.daddresserr'+trid).html('');
    $('.ddescriptionerr'+trid).html('');
    $('.dinstructionserr'+trid).html('');
    $('.dpriceerr'+trid).html('');
    $('.hpriceerr'+trid).html('');
    $('.sloterr'+trid).html('');
});

updatedriveway = function(userId) {
    $('#update_driveway').html('<form action="'+ baseUrl+'webadmin/updateDriveway" name="updatedriveway" class="updatedriveway" method="post" style="display:none;"><input type="text" name="userId" value="'+userId+'" /></form>');
    $( ".updatedriveway" ).submit();                    
};

$(".deletebtn").on('click',function(){
    var agree = confirm("Are you sure that you want to delete this item?");
    if (agree) {
       var currentTD = $(this).parents('tr').find('td');
    var drivewayId = $(this).closest('tr').attr('id');
    $.ajax({    
            method: "POST",        
            url: baseUrl + "webadmin/delete_driveway",
            dataType : "json",                               
            data: {id:drivewayId},            
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


 viewphotos = function(drivewayId,userID) {
    $('#view_photos').html('<form action="'+ baseUrl+'webadmin/viewDrivewayphoto" name="viewPhoto" class="viewPhoto" method="post" style="display:none;"><input type="text" name="drivewayID" value="'+drivewayId+'" /><input type="text" name="userID" value="'+userID+'" /></form>');
    $( ".viewPhoto" ).submit();                    
};

viewfeedback = function(drivewayId,userID) {
    $('#view_photos').html('<form action="'+ baseUrl+'webadmin/viewFeedback" name="feedback" class="feedback" method="post" style="display:none;"><input type="text" name="drivewayID" value="'+drivewayId+'" /><input type="text" name="userID" value="'+userID+'" /></form>');
    $( ".feedback" ).submit();                    
};

$(".price").on("keyup", function(){
    var valid = /^\d{0,3}(\.\d{0,2})?$/.test(this.value),
    val = this.value;    
    if(!valid){
        //console.log("Invalid input!");
        this.value = val.substring(0, val.length - 1);
    }
});