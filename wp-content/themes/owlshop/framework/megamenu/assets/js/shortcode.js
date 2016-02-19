(function($) {
	$.fn.PGL_Shortcode = function(opts) {
		// default configuration
		var config = $.extend({}, {
			lang:null,
		}, opts);

		var $this = this;

		function ajax_shortcode_button(){
			$('.pgl-shortcodes').undelegate( '.pgl-shorcode-button', 'click');
			$('.pgl-shortcodes').delegate( '.pgl-shorcode-button', 'click', function(e){
				$('#modal-widgets .modal-content .spinner.top').show();
				$('#modal-widgets .modal-content .modal-body-inner').html("");
				var $type = $(this).attr('data-name');
				$('#modal-widgets .modal-body .modal-body-inner').load(ajaxurl+'?action=pgl_shortcode_button&type='+$type,function(){
					$('#modal-widgets .modal-content .spinner.top').hide();
				});
	    	});
		}

		function ajax_shortcode_back(){
			$('#modal-widgets .modal-content').undelegate( '.pgl-button-back', 'click');
			$('#modal-widgets .modal-content').delegate( '.pgl-button-back', 'click', function(e){
				$('#modal-widgets .modal-content .spinner.top').show();
				$('#modal-widgets .pgl-widget-message').empty();
				$('#modal-widgets .modal-content .modal-body-inner').html("");
				$('#modal-widgets .modal-body .modal-body-inner').load(ajaxurl+'?action=pgl_list_shortcodes',function(){
					$('#modal-widgets .modal-content .spinner.top').hide();
				});
			});
		}

		function ajax_shortcode_save(){
			$('#modal-widgets .modal-content').undelegate('.pgl-button-save', 'click');
			$('#modal-widgets .modal-content').delegate( '.pgl-button-save', 'click', function(e){
				var datastring = $('#modal-widgets #pgl-shortcode-form').serialize();
				$.ajax({
					url: ajaxurl+'?action=pgl_shortcode_save',
					type: 'POST',
					dataType:'JSON',
					data: datastring,
					beforeSend:function(){
						$('#modal-widgets .pgl-widget-message').html("");
						$('#modal-widgets #pgl-shortcode-form').find('input,button,select,radio').prop('disabled',true);
						$('#modal-widgets #pgl-shortcode-form .spinner-button').show();
					},
					success: function(response){
						$('#modal-widgets .pgl-widget-message').append('<div class="alert alert-success"><strong>'+response.message+'</strong><a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a></div>');
						$('#modal-widgets #pgl-shortcode-form').find('input,button,select,radio').prop('disabled',false);
						$('#modal-widgets #pgl-shortcode-form .spinner-button').hide();
						if(response.type=='insert'){
							$('#modal-widgets #pgl-shortcode-form input[name="shortcodeid"]').val(response.id);
							// Add Widget in Select
							console.log()
							$('#pgl-admin-mm-toolcol [name="toolcol-position"]').append('<option value="'+response.id+'">'+response.title+'</option>');
							$('#pgl-admin-mm-toolcol .chzn-results').append('<li class="active-result" style="" data-option-array-index="'+response.id+'">'+response.title+'</li>');

							// Add Widget in Table
							$('#pgl-admin-listwidgets table').append('<tr><td>'+response.title+'</td><td>'+response.type_widget+'</td><td><a class="pgl-edit-widget" rel="edit" data-type="'+response.type_widget+'" data-id="'+response.id+'" href="#">Edit</a>|<a rel="delete" class="pgl-delete" data-id="'+response.id+'" href="#">Delete</a></td></tr>');
						}else if(response.type=='update'){
							var managetable = $('#pgl-admin-listwidgets table tr[data-widget-id="'+response.id+'"]');
							$('#pgl-admin-listwidgets table tr[data-widget-id="'+response.id+'"] .name').text(response.title);
							$('#pgl-admin-mm-toolcol [name="toolcol-position"] option[value="'+response.id+'"]').text(response.title);;
							$('#pgl-admin-mm-toolcol .chzn-results li[data-option-array-index="'+response.id+'"]').text(response.title);;
						}
					}
				});
			});
		}

	 	/**
	 	 * initialize every element
	 	 */
		this.each(function() {
			ajax_shortcode_button();
			ajax_shortcode_back();
			ajax_shortcode_save();
		});
		return this;
	};

	$(document).ready(function() {
		var pgl_media_upload;

		function optionsframework_add_file(event, selector) {

			var upload = $(".uploaded-file"), frame;
			var $el = $(this);

			event.preventDefault();

			// If the media frame already exists, reopen it.
			if ( pgl_media_upload ) {
				pgl_media_upload.open();
			} else {
				// Create the media frame.
				pgl_media_upload = wp.media.frames.pgl_media_upload =  wp.media({
					// Set the title of the modal.
					title: "Select Image",

					// Customize the submit button.
					button: {
						// Set the text of the button.
						text: "Selected",
						// Tell the button not to close the modal, since we're
						// going to refresh the page when the image is selected.
						close: false
					}
				});

				// When an image is selected, run a callback.
				pgl_media_upload.on( 'select', function() {
					// Grab the selected attachment.
					var attachment = pgl_media_upload.state().get('selection').first();
					pgl_media_upload.close();
					selector.prev().html('<img src="' + attachment.attributes.url + '">');
					selector.next().val(attachment.id);
				});

			}
			// Finally, open the modal.
			pgl_media_upload.open();
		}
		
		$('body').delegate('.btn-remove-image', 'click', function(event) {
			var _parent = $(this).parent();
			_parent.find('.screenshot').empty();
			_parent.find('input').val('');
			return false;
		});

		$('body').delegate('.btn-add-image', 'click', function(event) {
			optionsframework_add_file(event, $(this) );
			return false;
		});
	});
})(jQuery);
