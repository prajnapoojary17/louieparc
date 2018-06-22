$(".forgot").on('click',function(){
var email = $('#email').val();
var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
    
var err = 0; 
$('emailerror').html(''); 
if(email == ""){
    err = 1;                            
    $('.emailerror').html('Email is required');}            
else if(pattern.test(email) == false){
    err = 1;                        
    $('.emailerror').html('Invalid Email');
}else{
    $('.emailerror').html('');            
}

if(err == 0){
    $('.loader').show();
    $.ajax({
        type: "POST",
        url: "forgotpassword",
        data: {email:email},
        async:true,
        success:function(data) {
            
               if(data == 0)
               {                
                    $(".error_box").show();
                    $('.loader').hide();
                    $("#submit").attr('disabled',false);
                    $('.error_box').html("This email Id is not registered for admin.");
               }
               else
               {
                    $(".error_box").show();
                    $('.loader').hide();
                    $("#submit").attr('disabled',true);
                    $('.error_box').html("A link has been sent to your registered email id.Please check your email");                
               }
            }            
    });
    }
});
