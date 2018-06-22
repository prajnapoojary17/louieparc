/*
///////////////////////////////////////////////////

Project Name: LOUIE PARC
Author: Rinu Madathil
Website: http://rinumadz.com

///////////////////////////////////////////////////
*/

$(document).ready(function () {
    
    $(".owl-carousel").owlCarousel({
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

    $('a[href="#tab2"]').on('shown.bs.tab', function () {
        initialize_owl($('.testimonial-owl'));
    }).on('hide.bs.tab', function () {
        destroy_owl($('.testimonial-owl'));
    });

    $('a[href="#tab3"]').on('shown.bs.tab', function () {
        initialize_owl($('.house-owl'));
    }).on('hide.bs.tab', function () {
        destroy_owl($('.house-owl'));
    });
	
    $('a[href="#tab4"]').on('shown.bs.tab', function () {
        initialize_owl($('.house-owl'));
    }).on('hide.bs.tab', function () {
        destroy_owl($('.house-owl'));
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

function destroy_owl(el) {
    el.data('owlCarousel').destroy();
}