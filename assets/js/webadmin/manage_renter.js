$(".editbtn").on('click',function(){
	var currentTD = $(this).parents('tr').find('td');
	if ($(this).html() == 'Edit') {
		var trid = $(this).closest('tr').attr('id');
        $.each(currentTD, function () {
			var id = currentTD.closest("tr").find('.cid').text();
			$('.span_rusername'+trid).hide();
			$('.span_remail'+trid).hide();
			$('.span_rphone'+trid).hide();
			$('.span_rdob'+trid).hide();
			$('.span_rstatus'+trid).hide();
			$('.span_raddress'+trid).hide();
				
			$('.input_rusername'+trid).show();
			$('.input_remail'+trid).show();
			$('.input_rphone'+trid).show();
			$('.input_rdob'+trid).show();
			$('.input_rstatus'+trid).show();
			$('.input_raddress'+trid).show();
			$('.undobtn'+trid).show();
			$('.deletebtn'+trid).hide();
		    // $(this).prop('contenteditable', true);
			//$(this).css('background-color','#E0EAF1');
				
        });
		$(this).html('Save');
	
    } else {
		
		var rusername = 0;
		var remail = 0;
		var rphone =0;
		var rdob = 0;
		var err = 0;
		var $this = $(this);
		var $tr = $this.closest("tr");
		var trid = $(this).closest('tr').attr('id');
       		
        $.each(currentTD, function () {
			
			rusername = $tr.find('.input_rusername'+trid).val();
			if(rusername == ""){
				err = 1;
				//$tr.find('.input_rusername'+trid).addClass('tderror');					
				$('.rusernameerr'+trid).html('User Name is required');}			
			else{
				$('.rusernameerr'+trid).html('');
				//$tr.find('.input_rusername'+trid).removeClass('tderror');
			}
			
			remail = $tr.find('.input_remail'+trid).val();
			if(remail == ""){
				err = 1;
				//$tr.find('.input_remail'+trid).addClass('tderror');					
				$('.remailerr'+trid).html('Email is required');}			
			else{
				$('.remailerr'+trid).html('');
				//$tr.find('.input_remail'+trid).removeClass('tderror');
			}
			
			rphone = $tr.find('.input_rphone'+trid).val();
			if(rphone == ""){
				err = 1;
				//$tr.find('.input_rphone'+trid).addClass('tderror');					
				$('.rphoneerr'+trid).html('Phone is required');}			
			else{
				$('.rphoneerr'+trid).html('');
				//$tr.find('.input_rphone'+trid).removeClass('tderror');
			}
			
			
			rdob = $tr.find('.input_rdob'+trid).val();
			if(rdob == ""){
				err = 1;
			    //$tr.find('.input_rdob'+trid).addClass('tderror');
				$('.rdoberr'+trid).html('DOB is required');}	
			else{	
				$('.rdoberr'+trid).html('');
				//$tr.find('.input_rdob'+trid).removeClass('tderror');
			}
			rstatus = $('input[name=status'+trid+']:checked').val();
			rinput_building = $tr.find('.input_building'+trid).val();			
			rinput_streetAddress = $tr.find('.input_streetAddress'+trid).val();
			rinput_route = $tr.find('.input_route'+trid).val();
			rinput_city = $tr.find('.input_city'+trid).val();
			rinput_state = $tr.find('.input_state'+trid).val(); 
			rinput_zip = $tr.find('.input_zip'+trid).val();
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
			}
			else{	
				$('.raddresserr'+trid).html('');
				//$tr.find('.input_rdob'+trid).removeClass('tderror');
			}
			if(err == 0){			
			//	$(this).css('background-color','#FFFFFF');	
			}
        });
		if(err == 0){
		   
			$('.loader').show();			  
			$.ajax({	
		        method: "POST",		
				url: baseUrl + "webadmin/update_renterinfo",
				dataType : "json",					           
				data: {
         				id:trid,
						username:rusername,
						email :remail,
		                phone :rphone,
		                dob   :rdob,						
						building :rinput_building,		
						streetAddress :rinput_streetAddress,
						route :rinput_route,
						city :rinput_city,
						state :rinput_state,
						zip :rinput_zip,
						status :rstatus
				},			
				success:function(data) {			
					if(typeof data.status !== typeof undefined){
						if(data.status){						
							console.log('Updated');
							$('.input_rusername'+trid).hide();
							$('.input_remail'+trid).hide();
							$('.input_rphone'+trid).hide();
							$('.input_rdob'+trid).hide();
							$('.input_rstatus'+trid).hide();
							$('.input_raddress'+trid).hide();
							$('.undobtn'+trid).hide();
							$('.deletebtn'+trid).show();

							$('.span_rusername'+trid).html(rusername);
							$('.span_remail'+trid).html(remail);
							$('.span_rphone'+trid).html(rphone);
							$('.span_rdob'+trid).html(rdob);
							$('.span_rstatus'+trid).html(rstatus);
							if(rstatus == 1){
								$('.span_rstatus'+trid).html('Active');
							}else{
								$('.span_rstatus'+trid).html('Inactive');
							}
							$('.span_raddress'+trid).html(rinput_building+'</br>'+rinput_streetAddress+','+rinput_route+'</br>'+rinput_city+','+rinput_state+'-'+rinput_zip );
							
							$('.span_rusername'+trid).show();
							$('.span_remail'+trid).show();
							$('.span_rphone'+trid).show();
							$('.span_rdob'+trid).show();
							$('.span_rstatus'+trid).show();
							$('.span_raddress'+trid).show();						    
							$('.loader').hide();
							$("#mailSent").show().delay(2000).fadeOut();
						}else{	
							console.log('failed');
							$('.input_rusername'+trid).hide();
							$('.input_remail'+trid).hide();
							$('.input_rphone'+trid).hide();
							$('.input_rdob'+trid).hide();
							$('.input_rstatus'+trid).hide();
							$('.input_raddress'+trid).hide();
							$('.undobtn'+trid).hide();
							$('.deletebtn'+trid).show();
							
							$('.span_rusername'+trid).show();
							$('.span_remail'+trid).show();
							$('.span_rphone'+trid).show();
							$('.span_rdob'+trid).show();
							$('.span_rstatus'+trid).show();
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
	
	$('.input_rusername'+trid).val($('.input_rusername'+trid).data("original-value"));
	$('.input_remail'+trid).val($('.input_remail'+trid).data("original-value"));
	$('.input_rphone'+trid).val($('.input_rphone'+trid).data("original-value"));
	$('.input_rdob'+trid).val($('.input_rdob'+trid).data("original-value"));
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
	//$('.input_rstatus'+trid).val($('.input_rstatus'+trid).data("original-value"));
	//$('.input_raddress'+trid).val();
	
	$('.input_rusername'+trid).hide();
	$('.input_remail'+trid).hide();
	$('.input_rphone'+trid).hide();
	$('.input_rdob'+trid).hide();
	$('.input_rstatus'+trid).hide();
	$('.input_raddress'+trid).hide();
	$('.undobtn'+trid).hide();
	
	$('.deletebtn'+trid).show();	
	$('.span_rusername'+trid).show();
	$('.span_remail'+trid).show();
	$('.span_rphone'+trid).show();
	$('.span_rdob'+trid).show();
	$('.span_rstatus'+trid).show();
	$('.span_raddress'+trid).show();
	$('.rusernameerr'+trid).html('');
	$('.remailerr'+trid).html('');
	$('.rphoneerr'+trid).html('');
	$('.rdoberr'+trid).html('');
//	$tr.find('.input_model'+cid).removeClass('tderror');
//	$tr.find('.input_cyear'+cid).removeClass('tderror');
//	$tr.find('.input_ccolor'+cid).removeClass('tderror');
//	$tr.find('.input_cnumber'+cid).removeClass('tderror');
	var currentTD = $(this).parents('tr').find('td');
			
	//$.each(currentTD, function () {		
	//	$(this).css('background-color','#FFFFFF');		
	//});
	//location.reload();
});


	 updatedriveway = function(userId) {
					 $('#update_driveway').html('<form action="'+ baseUrl+'webadmin/updateDriveway" name="updatedriveway" class="updatedriveway" method="post" style="display:none;"><input type="text" name="userId" value="'+userId+'" /></form>');
					 $( ".updatedriveway" ).submit();					
	};
