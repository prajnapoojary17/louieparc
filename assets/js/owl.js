/*
///////////////////////////////////////////////////

Project Name: LOUIE PARC
Author: Rinu Madathil
Website: http://rinumadz.com

///////////////////////////////////////////////////
*/

$(document).ready(function () { 

    $('a[href="#tab2"]').on('shown.bs.tab', function () {
        initialize_owl($('.testimonial-owl'));
    });
    $('#keeplooking').on('click',function(){
	  destroy_slider();
	});
   

});
function initialize_owl(el) {
    el.owlCarousel({
        items: 1,
			margin: 0,
			responsiveClass: true,
			loop: true,
			nav: true,
			dots: true,
			autoPlay: true,
			smartSpeed: 500,
			responsive:{
				0:{
					nav:false
				},
				480: {
					nav:false
				},
				768:{
					nav:false
				},
				1000:{
					nav:true,
				}
			},
			navigation : true,
			navigationText : [
			  "<i class='icon-arrow-left owl-direction'></i>",
			  "<i class='icon-arrow-right owl-direction'></i>"
			]
    });
}

function destroy_slider() {
   // $("#slider").remove();
   // el.data('owlCarousel').removeItem();
   $('.owl-image').remove();
   $('.owl-nonav').remove();
  // var content = '<div class="item1">'+
  //                                          '<figure class="figure-container"><img src="" alt="LouieParc1" id="slide1" class="img-responsive">'+
  //                                         '</figure>'+
   //                                    '</div>';
   var content = '<div class="owl-carousel testimonial-owl owl-image">'+
                                       
                                        '<div class="item1">'+
                                            '<figure class="figure-container"><img src="" alt="LouieParc1" id="slide1" class="img-responsive">'+
                                           '</figure>'+
                                        '</div>'+

                                        '<div class="item2">'+
                                            '<figure class="figure-container"><img src="" alt="LouieParc2" id="slide2" class="img-responsive">'+
                                            '</figure>'+
                                        '</div>'+

                                        '<div class="item3">'+
                                            '<figure class="figure-container"><img src="" alt="LouieParc3" id="slide3" class="img-responsive">'+
                                            '</figure>'+
                                        '</div>'+
										'<div class="item4">'+
                                            '<figure class="figure-container"><img src="" alt="LouieParc4" id="slide4" class="img-responsive">'+
                                            '</figure>'+
                                       '</div>'+

                                    '</div>';
	$('#slider').append(content);
	 var content2 = '<div class="owl-carousel testimonial-owl owl-image">'+
                                       
                                        '<div class="item1">'+
                                            '<figure class="figure-container"><img src="" alt="LouieParc1" id="slide21" class="img-responsive">'+
                                           '</figure>'+
                                        '</div>'+

                                        '<div class="item2">'+
                                            '<figure class="figure-container"><img src="" alt="LouieParc2" id="slide22" class="img-responsive">'+
                                            '</figure>'+
                                        '</div>'+

                                        '<div class="item3">'+
                                            '<figure class="figure-container"><img src="" alt="LouieParc3" id="slide23" class="img-responsive">'+
                                            '</figure>'+
                                        '</div>'+
										'<div class="item4">'+
                                            '<figure class="figure-container"><img src="" alt="LouieParc4" id="slide24" class="img-responsive">'+
                                            '</figure>'+
                                       '</div>'+

                                    '</div>';
	$('#slider2').append(content2);
		 var content3 = '<div class="owl-carousel testimonial-owl owl-image">'+
                                       
                                        '<div class="item1">'+
                                            '<figure class="figure-container"><img src="" alt="LouieParc1" id="slide31" class="img-responsive">'+
                                           '</figure>'+
                                        '</div>'+

                                        '<div class="item2">'+
                                            '<figure class="figure-container"><img src="" alt="LouieParc2" id="slide32" class="img-responsive">'+
                                            '</figure>'+
                                        '</div>'+

                                        '<div class="item3">'+
                                            '<figure class="figure-container"><img src="" alt="LouieParc3" id="slide33" class="img-responsive">'+
                                            '</figure>'+
                                        '</div>'+
										'<div class="item4">'+
                                            '<figure class="figure-container"><img src="" alt="LouieParc4" id="slide34" class="img-responsive">'+
                                            '</figure>'+
                                       '</div>'+

                                    '</div>';
	$('#slider3').append(content3);
}
