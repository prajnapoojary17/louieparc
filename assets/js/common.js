$(document).ready(function(){
//

$(".form-group input").load(function() {
alert('g1');	   
		var text_val = $(this).val();		
		if(text_val === "") {		  
		  $(this).removeClass('has-value');		  
		} else {		  
		  $(this).addClass('has-value');		  
		}	
	 });
	 
});

	