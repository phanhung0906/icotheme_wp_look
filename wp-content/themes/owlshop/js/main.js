(function($){
	"use strict";
	var wow;
	var PGL_Parallax = function(){
		if(!Modernizr.touch){ 
		    jQuery.stellar();
		}
    }

    var PGL_FixIsotope = function(){
    	"use strict";
    	if(jQuery().isotope){
			jQuery('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
				jQuery('.isotope').isotope('reLayout');
			});
			jQuery('[id*="accordion-"]').on('shown.bs.collapse',function(e){
				jQuery('.isotope').isotope('reLayout');
			});
		}
    }
   
    var PGL_Menu_Search_Form = function(){
    	var $search_menu = $("#menu-search-form");
    	$('.search-toggle').click(function(){
    		$search_menu.addClass('active');
    	});
    	$search_menu.find('.search-close').click(function(){
    		$search_menu.removeClass('active');
    	});
    }

    var PGL_Button_Back_Top = function(){
    	var _isScrolling = false;
    	$("#scrollToTop").click(function(e) {
			e.preventDefault();
			$("body, html").animate({scrollTop : 0}, 500);
			return false;
		});

		// Show/Hide Button on Window Scroll event.
		$(window).scroll(function() {
			if(!_isScrolling) {
				_isScrolling = true;
				if($(window).scrollTop() > 150) {
					$("#scrollToTop").stop(true, true).addClass("visible");
					_isScrolling = false;
				} else {
					$("#scrollToTop").stop(true, true).removeClass("visible");
					_isScrolling = false;
				}
			}
		});
    }

    var PGL_Header_Sticky = function(){
        var $action = $('#pgl-header').height()+10;
        $(window).scroll(function(event) {
            if( $(document).scrollTop() > $action ){
                $('#pgl-header').addClass('fixed');
            }else{
                $('#pgl-header').removeClass('fixed');
            }
        });
    }

    var PGL_Language_Topbar = function(){
    	// Set current language to top bar item
		var currentLanguage = $('#header-languages li.active').find('span').text();
		if (currentLanguage !== "") {
			jQuery('#header-topbar .language-icon > a').html(currentLanguage + ' <i class="fa fa-angle-down">');
		}
    }

    var PGL_Set_Width_Ordering = function(){
    	var $order = $('.woocommerce-ordering .orderby');
    	$('#width_order_temp').text($order.find('option:selected').text());
    	$order.width($('#width_order_temp').width());
    }

    var PGL_Set_First_Text = function(){
    	var $headings = $('.heading-title > span');
    	$headings.each(function(index, el) {
    		var $text = $(this).text().trim().replace('/<\/?[^>]+(>|$)/g', "").toUpperCase();
    		$(this).after('<span class="bg">'+$text.charAt(0)+'</span>');
    	});
    }

    var PGL_ButtonSearch_Login = function(){
    	"use strict";
    	var wpsearch = jQuery('#wp-search');
		jQuery('a.search-action').toggle(function() {
			wpsearch.addClass('open');
		}, function() {
			wpsearch.removeClass('open');
		});
    }

	$(document).ready(function() {
		PGL_Set_First_Text();
		PGL_Set_Width_Ordering();
		PGL_Header_Sticky();
		PGL_Button_Back_Top();
		PGL_Parallax();
		PGL_FixIsotope();
		PGL_Menu_Search_Form();
		PGL_ButtonSearch_Login();
		PGL_Language_Topbar();
		// init Animate Scroll
        if( $('body').hasClass('pgl-animate-scroll') && !Modernizr.touch ){
            wow = new WOW(
	            {
	            	mobile : false,
	            }
            );
            wow.init();
        }

	});

	$(window).resize(function(){

	});

})(jQuery);


(function($) {
	"use strict";
    var owl = $('[data-owl="slide"]');
	var $rtl = owl.data('ow-rtl');
	owl.each(function(index, el) {
		var $item = $(this).data('item-slide');
		var $text_next = $(this).data('text-next');
		var $text_prev = $(this).data('text-prev');
		$(this).owlCarousel({
			nav : true,
			dots: false,
			rtl: $rtl,
			items : $item,
			navText : ["<i class='fa fa-angle-left'></i><span>"+$text_prev+"</span>","<span>"+$text_next+"</span><i class='fa fa-angle-right'></i>"],
			responsive:{
				0:{
			      items:1 // In this configuration 1 is enabled from 0px up to 479px screen size 
			    },

			    480:{
			      items:1, // from 480 to 677 
			    },

			    640:{
			      items:3, // from this breakpoint 678 to 959
			    },

			    991:{
			      items:3, // from this breakpoint 960 to 1199

			    },
			    1199:{
			      items:$item,
			    }
			  }
		});
	});

	var $manifier_item = $('.yith_magnifier_gallery').data('item');
	$('.yith_magnifier_gallery').owlCarousel({
		nav : true,
		dots:false,
		rtl: $rtl,
		items : $manifier_item,
		navText : ["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],
		responsive:{
			0:{
		      items:2 // In this configuration 1 is enabled from 0px up to 479px screen size 
		    },

		    480:{
		      items:3, // from 480 to 677 
		    },

		    640:{
		      items:3, // from this breakpoint 678 to 959
		    },
		    1199:{
		      items:$manifier_item,
		    }
		  }
	});

	$('.social-networks .fa').text('');

	// Fix Tab
	$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
	    $($(e.target).attr('href')).find('.owl-carousel')
	        .owlCarousel('invalidate', 'width')
	        .owlCarousel('update');
	});

	$('.language-filter select').change(function(){
		// console.log($(this).val());
		// return;
		window.location = $(this).val();
	});

}).apply(this, [jQuery]);



