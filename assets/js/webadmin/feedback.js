feedbackclose = function(userID) {
		$('#feedback_form').html('<form action="'+ baseUrl+'webadmin/updateDriveway" name="feedback" class="feedback" method="post" style="display:none;"><input type="text" name="userId" value="'+userID+'" /></form>');
		$( ".feedback" ).submit();
					
};


$(".approve").on('click',function(){
    var trid = $(this).closest('tr').attr('id');
    var currentTD = $(this).parents('tr').find('td');    
    $('.loader').show();
    $.ajax({    
          method: "POST",        
          url: baseUrl + "webadmin/approve_feedback",
          dataType : "json",                               
          data: {
                  reviewID        : trid               
          },            
          success:function(data) { 
               $('.loader').hide();
              if(typeof data.status !== typeof undefined){
                  if(data.status){                        
                    //console.log('Updated');                            
                    $('.approvebtn'+trid).hide();
                    $('.approvelabel'+trid).show();
                    $("#mailSent").show().delay(2000).fadeOut();
                  }else{    
                      //console.log('failed');
                      $('.servererror').html('Failed to send verification Code')              
                  }
              }              
          }            
      });          
       
});

