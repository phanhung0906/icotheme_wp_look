(function( $ ) {
    "use strict";
    $(window).load(function(){
    	$('.option-pattern .list-pattern li').click(function(){
    		var $this = $(this);
    		var $container = $this.closest('.option-pattern');
    		$container.find('li').removeClass('active');
    		$this.addClass('active');
    		
    		var $value = $this.data('value');
    		$container.find('input[type="hidden"]').val($value).trigger('change');
    	});

    	$('.option-pattern .clear-pattern').click(function(){
    		var $container = $(this).closest('.option-pattern');
    		$container.find('li').removeClass('active');
    		$container.find('input[type="hidden"]').val('').trigger('change');
    		return false;
    	});

    });

})( jQuery );