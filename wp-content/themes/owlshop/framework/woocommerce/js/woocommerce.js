!function ($) {
	"use strict";
	$(document).ready(function() {
		$('.quickview').on("click",function(){
        	var proid = $(this).data('proid');
   			var data = { action: 'pgl_quickview', product: proid};
   			$.post(ajaxurl, data, function(response) {
   				$.magnificPopup.open({
					items: {
						src: '<div class="product-quickview">'+response+'</div>', // can be a HTML string, jQuery object, or CSS selector
						type: 'inline'
					}
				});
				$('.quickview-slides').owlCarousel({
					navigation : false,
					pagination: true,
					items :1,
				});
   			});
			return false;
        });

        $(".quantity .plus").on("click",function(){
        	var $qty = $(this).prev();
			var val = $qty.val();
			val = parseInt(val);
			$qty.val(val + 1);
		});
		$(".quantity .minus").on("click",function(){
			var $qty = $(this).next();
			var val = $qty.val();
			val = parseInt(val);
			if( val > 1 ){
				$qty.val(val - 1);
			}
		});

		// Switch Layout
        $('#pgl-filter .switch-layout a').on("click",function(){
            var action = $(this).data('action');
            var $form = $(this).closest('.form-switch-layout');
            $form.find('input[name="layout"]').val(action);
            $form.submit();
        });

		// Ajax Remove Cart
		$(document).on('click', '.pgl_product_remove', function(event) {
			var $this = $(this);
			var product_key = $this.data('product-key');
			var product_id = $this.data('product-id');
	        $.ajax({
	            type: 'POST',
	            dataType: 'json',
	            url: ajaxurl,
	            data: { action: "cart_remove_product", 
                    product_key: product_key,
                    product_id : product_id
	            },success: function(data){
	                var $cart = $('#pgl_cart_canvas');
	                $('.shoppingcart a span').text('('+data.count+')');
	                if(data.count==0){
	                	$cart.find('.cart_list').html('<li class="empty">'+$cart.find('.cart_container').data('text-emptycart')+'</li>');
	                	$cart.find('.total,.buttons').remove();
	                }else{
		                $cart.find('.total .amount').remove();
		                $cart.find('.total').append(data.subtotal);
		                $this.parent().remove();
	                }
	            }
	        });
	        return false;
		});
		$('.pgl_product_remove').on("click",function(){
			
		});

		$('body').delegate('.button-item .btn-wishlist', 'click', function(event) {
			var $button = $(this).next();
			$button.find('.add_to_wishlist').trigger('click');
			return false;
		});

		$('body').delegate('.button-item .btn-compare', 'click', function(event) {
			var $button = $(this).next().trigger('click');
			return false;
		});

		// Single Product
		$('body').delegate('#single-product .btn-wishlist', 'click', function(event) {
			$('#single-product .add_to_wishlist').trigger('click');
			return false;
		});

		$('body').delegate('#single-product .btn-compare', 'click', function(event) {
			$('#single-product .entry-summary .compare').trigger('click');
			return false;
		});

	});
}(jQuery);


(function($) {
	"use strict";
	$.countdown.regionalOptions[''] = {
		labels: [pgl_countdown_l10n.years, pgl_countdown_l10n.months, pgl_countdown_l10n.weeks, pgl_countdown_l10n.days , pgl_countdown_l10n.hours, pgl_countdown_l10n.minutes, pgl_countdown_l10n.seconds],
		labels1: [pgl_countdown_l10n.year, pgl_countdown_l10n.month, pgl_countdown_l10n.week, pgl_countdown_l10n.day, pgl_countdown_l10n.hour, pgl_countdown_l10n.minute, pgl_countdown_l10n.second],
		compactLabels: ['y', 'm', 'w', 'd'],
		whichLabels: null,
		digits: ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'],
		timeSeparator: ':', isRTL: true};
	$.countdown.setDefaults($.countdown.regionalOptions['']);


	// regionalOptions: { // Available regional settings, indexed by language/country code
	// 		'': { // Default regional settings - English/US
	// 			labels: ['Years', 'Months', 'Weeks', 'Days', 'Hours', 'Minutes', 'Seconds'],
	// 			labels1: ['Year', 'Month', 'Week', 'Day', 'Hour', 'Minute', 'Second'],
	// 			compactLabels: ['y', 'm', 'w', 'd'],
	// 			whichLabels: null,
	// 			digits: ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'],
	// 			timeSeparator: ':',
	// 			isRTL: false
	// 		}
	// 	},
	$('.countdown').each(function() {
        var count = $(this);
        var austDay =  new Date(count.data('countdown'));
        $(this).countdown({
        	until: austDay,
        	format: 'dHMS'
        });
    });
}).apply(this, [jQuery]);