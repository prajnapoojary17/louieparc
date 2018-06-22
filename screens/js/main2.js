/*
///////////////////////////////////////////////////

Project Name: LOUIE PARC
Author: Rinu Madathil
Website: http://rinumadz.com

///////////////////////////////////////////////////
*/

window.onload = function() {
	$('.form-group input, .form-group textarea').filter(function() {
		return this.value;
	}).addClass('has-value');
};

;(function () {
	
	'use strict';

	// iPad and iPod detection	
	var isiPad = function(){
		return (navigator.platform.indexOf("iPad") != -1);
	};

	var isiPhone = function(){
	    return (
			(navigator.platform.indexOf("iPhone") != -1) || 
			(navigator.platform.indexOf("iPod") != -1)
	    );
	};

    // Handles Bootstrap Tooltips.
    var handleTooltips = function () {
       $('.tooltips').tooltip();
    }
	
	// Click outside of offcanvass
	var mobileMenuOutsideClick = function() {
		$(document).click(function (e) {
	    var container = $("#fh5co-offcanvass, .js-fh5co-mobile-toggle");
	    if (!container.is(e.target) && container.has(e.target).length === 0) {
	    	$('html').removeClass('mobile-menu-expanded');
	    	$('.js-fh5co-mobile-toggle').removeClass('active');
	    }
		});
	};

	// Burger Menu
	var burgerMenu = function() {

		$('body').on('click', '.js-fh5co-nav-toggle', function(event){
			if ( $('#navbar').is(':visible') ) {
				$(this).removeClass('active');	
			} else {
				$(this).addClass('active');	
			}
			event.preventDefault();
		});

	};

	// Off Canvass
	var offCanvass = function() {

		if ( $('#fh5co-offcanvass').length == 0 ) {
			if ( $('.fh5co-nav-style-1').length > 0 ) {
				$('body').prepend('<div id="fh5co-offcanvass" />');

				$('.fh5co-link-wrap').each(function(){
					$('#fh5co-offcanvass').append($(this).find('[data-offcanvass="yes"]').clone());	
				})
				$('#fh5co-offcanvass').find('.js-fh5co-mobile-toggle').remove();
				$('#fh5co-offcanvass, #fh5co-page').addClass($('.fh5co-nav-style-1').data('offcanvass-position'));
				$('#fh5co-offcanvass').addClass('offcanvass-nav-style-1');
			}		
				
		}

		$('body').on('click', '.js-fh5co-mobile-toggle', function(e){
			var $this = $(this);
			$this.toggleClass('active');
			$('html').toggleClass('mobile-menu-expanded');

		});

		if ( $(window).width() < 769 ) {
			$('body, html').addClass('fh5co-overflow');
		}

		$(window).resize(function(){
			if ( $(window).width() < 769 ) {
				$('body, html').addClass('fh5co-overflow');
			}
			if ( $(window).width() > 767 ) {
				if ( $('html').hasClass('mobile-menu-expanded')) {
					$('.js-fh5co-mobile-toggle').removeClass('active');
					$('html').removeClass('mobile-menu-expanded');
				}
			}
		});

	};	
	
	// Offcanvas and cloning of the main menu
	var offcanvas = function() {

		var $clone = $('#fh5co-menu-wrap').clone();
		$clone.attr({
			'id' : 'offcanvas-menu'
		});
		$clone.find('> ul').attr({
			'class' : '',
			'id' : ''
		});

		$('#fh5co-page').prepend($clone);

		// click the burger
		$('.js-fh5co-nav-toggle-bur').on('click', function(){

			if ( $('body').hasClass('fh5co-offcanvas') ) {
				$('body').removeClass('fh5co-offcanvas');
				$(this).removeClass('active');	
			} else {
				$('body').addClass('fh5co-offcanvas');
				$(this).addClass('active');	
			}
			// $('body').toggleClass('fh5co-offcanvas');

		});

		$('#offcanvas-menu').css('height', $(window).height());

		$(window).resize(function(){
			var w = $(window);


			$('#offcanvas-menu').css('height', w.height());

			if ( w.width() > 769 ) {
				if ( $('body').hasClass('fh5co-offcanvas') ) {
					$('body').removeClass('fh5co-offcanvas');
				}
			}

		});	

	};
			
	// Input Highlight
	var inputHighlight = function() {
	  $('.form-group input, .form-group textarea').focusout(function(){
		var text_val = $(this).val();		
		if(text_val === "") {		  
		  $(this).removeClass('has-value');		  
		} else {		  
		  $(this).addClass('has-value');		  
		}		
	  });
	};
	
	// body Class
	var bodyClass = function() {
	  if ( $('.main-content').hasClass('settings-page') || $('#fullpage-home').hasClass('settings-page')) {
		$('body').addClass('home-page');
	  }
	  
	  if ( $('.main-content').hasClass('single-page') ) {
		$('body').addClass('inverse-page');
	  }
	  
	};
	
	// Wizard
	var rootwizard = function() {
	  $('#rootwizard').bootstrapWizard({'nextSelector': '#fb-signup, .wizard .next, .btn-press, .gonext', onTabShow: function(tab, navigation, index) {
			var $total = navigation.find('li').length;
			var $current = index+1;
			var $percent = ($current/$total) * 100;
			$('#rootwizard .progress-bar').css({width:$percent+'%'});
		}});		
		window.prettyPrint && prettyPrint()
		
	};
	
	// datepicker
	var datePicker = function() {
		$('.date').datepicker();
	};
	
	// date range picker
	var dateRangePicker = function() {
		$('.input-daterange input').each(function() {
			$(this).datepicker("clearDates");
		});
	};
	// Time picker
	var timePicker = function() {
		$('.timepicker-no-seconds').timepicker({
			autoclose: true,
			minuteStep: 1
		});

		// handle input group button click
		$('.timepicker').parent('.input-group').on('click', '.input-group-btn', function(e){
			e.preventDefault();
			$(this).parent('.input-group').find('.timepicker').timepicker('showWidget');
		});
	};
	
	// inputmask
	var inputmask = function() {
	  $(":input").inputmask({ showMaskOnHover: false });
	  $("#currency").inputmask({ alias: "currency"});
	};
	
	// facebook signup
	var facebooksignup = function() {
		$('#fb-signup').on('click', function(){
			$('#facebook-signup').removeClass('hide');
			$('#facebook-signup').addClass('show');
			$('#normal-signup').addClass('hide');
		});
	};
	
	// no Rental
	var noRental = function() {
		$('input[name=about]').click(function () {
			if (this.id == "no-rental") {
				$("#rental-container").slideDown('slow');
			} else {
				$("#rental-container").slideUp('slow');
			}
		});
	};
	
	// no Rental
	var futureUse = function() {
		$('input[name=use]').click(function () {
			if (this.id == "future-radio") {
				$("#future-container").slideDown('slow');
			} else {
				$("#future-container").slideUp('slow');
			}
		});
	};
	// driveway off
	var drivewayLive = function() {
		$('input[name=driveway]').click(function () {
			if (this.id == "driveway-radio") {
				$("#driveway-container").slideDown('slow');
			} else {
				$("#driveway-container").slideUp('slow');
			}
		});
	};
	
	// max Length
	var maxLength = function() {
		$('textarea.max-text').maxlength({
			alwaysShow: true
		});
	};
	
	
	
	// Document on load.
	$(function(){
	
		handleTooltips();
		mobileMenuOutsideClick();
		inputHighlight();
		bodyClass();
		burgerMenu();
		offCanvass();
		offcanvas();	
		inputmask();
		rootwizard();
		facebooksignup();
		futureUse();
		drivewayLive();	
		noRental();		
		datePicker();	
		dateRangePicker();
		timePicker();
		maxLength();			

	});


}());