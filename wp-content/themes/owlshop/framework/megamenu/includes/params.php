<?php

class PGL_Params{

	public static function getInstance(){
		static $_instance;
		if( !$_instance ){
			$_instance = new PGL_Params();
		}
		return $_instance;
	}

	public function getParam($option){
		$output = '<div class="form-group">';
			$output.='<label for="pgl_input_'.$option['id'].'">'.$option["label"].'</label>';
			switch ($option['type']) {
				case 'text':
					$output .= '<input value="'.$option['default'].'" class="form-control" type="text" id="pgl_input_'.$option['id'].'" name="pgl_input['.$option['id'].']" >';
					break;
				case 'select':
					$output .= $this->renderSelect($option);
					break;
				case 'textarea':
					$output .='<textarea class="form-control" rows="4" id="pgl_input_'.$option['id'].'" name="pgl_input['.$option['id'].']">'.stripslashes($option['default']).'</textarea>';
					break;
				case 'radio':
					foreach($option['options'] as $key => $value){
						$output .= '
						<div class="radio">
							<label>
								<input type="radio" '.checked($option['default'],$key,false).' name="pgl_input['.$option['id'].']" id="pgl_input['.$option['id'].']_'.$key.'" value="'.$key.'">
								'.$value.'
							</label>
						</div>';
					}
					break;
				case 'sidebars':
					$sidebars = $GLOBALS['wp_registered_sidebars'];

		 			$values = array();

		 			$values['none'] = __('Select A Sidebar','owlshop');
		 			foreach( $sidebars as $key => $sidebar ){
						$values[$sidebar['id']] = $sidebar["name"];
		 			}
		 			$output.=$this->renderSelect($option,$values);
					break;
				case 'posttypes':
					$output .= $this->renderPosttypes($option);
					break;
				case 'image':
					$output .= $this->renderImages($option);
					break;
				case 'category_parent':
					$output.=$this->renderCategoryParent($option);
					break;
				case 'hidden_id':
					$output.=$this->renderHiddenID($option);
					break;
				case 'gmap':
					$output.=$this->renderGmap($option);
					break;
				case 'embed':
					$output.=$this->renderEmbed($option);
					break;
				default:
					$output .= '<input value="'.$option['default'].'" class="form-control" type="text" id="pgl_input_'.$option['id'].'" name="pgl_input['.$option['id'].']" >';
					break;
			}
		$output.='</div>';
		echo "\t" . $output;
	}

	private function renderImages($option){
		ob_start();
		?>
			<div class="screenshot">
				<?php if($option['default']!=''){ echo wp_get_attachment_image($option['default'],'full'); } ?>
			</div>
			<button class="btn btn-success btn-add-image">Add</button>
			<?php echo '<input value="'.$option['default'].'" class="form-control" type="hidden" id="pgl_input_'.$option['id'].'" name="pgl_input['.$option['id'].']" >'; ?>
			<button class="btn btn-danger btn-remove-image">Remove</button>
		<?php
		return ob_get_clean();
	}

	private function renderEmbed($option){
		$output = '<div id="pgl-embed-'.$option["id"].'" class="pgl-embed">';
		$output .= '<input value="'.$option['default'].'" class="form-control" type="text" id="pgl_input_'.$option['id'].'" name="pgl_input['.$option['id'].']" >';
		ob_start();
	?>
		<div class="pgl_embed_view">
	        <span class="spinner" style="float:none;"></span>
	        <div class="result"></div>
	    </div>
	    <script>
	    	!function($) {
	    		PGL_megamenu.params_Embed('#pgl_input_<?php echo esc_attr($option['id']); ?>','#pgl-embed-<?php echo esc_attr($option['id']); ?>');
    		}(window.jQuery);
	    </script>
	<?php
		$output.=ob_get_clean();
		$output.='</div>';
		return $output;
	}

	/**
	 *
	 */
	private function renderGmap($option){
		$output ='<input value="'.$option['default'].'" type="hidden" id="pgl_input_'.$option['id'].'" name="pgl_input['.$option['id'].']" >';
		$output.='
			<div id="pgl-element-map">
				<div class="map_canvas" style="height:200px;"></div>

				<div class="vc_row-fluid googlefind">
					<input id="geocomplete_'.$option["id"].'" type="text" class="pgl-location" placeholder="Type in an address" size="90" />
					<button class="button-primary find">Find</button>
				</div>

				<div class="row-fluid mapdetail">
					<div class="form-group">
						<label for="pgl_input_class">Latitude</label>
						<input name="lat" class="form-control pgl-latgmap" type="text" value="">
					</div>
					<div class="form-group">
						<label for="pgl_input_class">Longitude</label>
						<input name="lng" class="form-control pgl-lnggmap" type="text" value="">
					</div>
				</div>
			</div>
		';
		ob_start();
		?>
		<script>
			!function($) {
				if($('#geocomplete_<?php echo esc_attr($option['id']); ?>').length>0){
					var _lat_lng = $('#pgl_input_<?php echo esc_attr($option['id']); ?>').val();
					console.log(_lat_lng);
					var loca = _lat_lng;
					_lat_lng = _lat_lng.split(',');
					var center = new google.maps.LatLng(_lat_lng[0],_lat_lng[1]);
				    $("#geocomplete_<?php echo esc_attr($option['id']); ?>").geocomplete({
						map: ".map_canvas",
						types: ["establishment"],
						country: "de",
						details: ".mapdetail",
						markerOptions: {
							draggable: true
						},
						location:loca,
						mapOptions: {
							scrollwheel :true,
							zoom:15,
							center:center
						}
				    });
				    $(".googlefind button.find").click(function(){
						$("#geocomplete_<?php echo esc_attr(esc_attr($option['id'])); ?>").trigger("geocode");
					});
				    $("#geocomplete_<?php echo esc_attr($option['id']); ?>").bind("geocode:dragged", function(event, latLng){
						$("input[name=lat]").val(latLng.lat());
						$("input[name=lng]").val(latLng.lng());
						$("#pgl_input_<?php echo esc_attr($option['id']); ?>").val(latLng.lat()+','+latLng.lng());
				    }).bind("geocode:result",function(event, result){
				    	$('.pgl-latgmap').trigger('change');
				    });

				    $('.pgl-latgmap,.pgl-lnggmap').keyup(function(event) {
				    	var value = $('.pgl-latgmap').val()+','+$('.pgl-lnggmap').val();
				    	$("#pgl_input_<?php echo esc_attr($option['id']); ?>").val(value);
				    }).change(function(){
				    	var value = $('.pgl-latgmap').val()+','+$('.pgl-lnggmap').val();
				    	$("#pgl_input_<?php echo esc_attr($option['id']); ?>").val(value);
				    });
				}
			}(window.jQuery);
		</script>
		<?php
		$output.=ob_get_clean();
		return $output;
	}

	/**
	 *
	 */
	private function renderHiddenID($option){
		$value = (esc_attr( $option['default'] )=='')?time():esc_attr($option['default']);
		$output = '<input value="'.$value.'" type="hidden" id="pgl_input_'.$option['id'].'" name="pgl_input['.$option['id'].']" >';
		return $output;
	}

	/**
	 *
	 */
	private function renderCategoryParent($option){
		$terms = get_categories(array('parent'=>0,'hide_empty'=>0));
		ob_start();
	?>
		<select class="form-control" name="pgl_input[<?php echo esc_attr($option['id']); ?>]" id="pgl_input_<?php echo esc_attr($option['id']); ?>">
			<?php foreach($terms as $key => $value){ ?>
				<option value="<?php echo esc_attr( $value->term_id ); ?>" <?php selected( $option['default'],$value->term_id ) ?>><?php echo esc_html($value->name); ?></option>
			<?php } ?>
		</select>
		<?php
		$output = ob_get_clean();
		return $output;
	}

	/**
	 *
	 */
	private function renderSelect($option,$values=array()){
		ob_start();
		echo '<select class="form-control" id="pgl_input_'.$option['id'].'" name="pgl_input['.$option['id'].']">';
			if(count($values)<=0){
				foreach($option['options'] as $key => $value){
					echo '<option value="'.$key.'" '.selected( $option['default'],$key ).'>'.$value.'</option>';
				}
			}else{
				foreach($values as $key => $value){
					echo '<option value="'.$key.'" '.selected( $option['default'],$key ).'>'.$value.'</option>';
				}
			}
		echo '</select>';
		$output = ob_get_clean();
		return $output;
	}

	/**
	 *
	 */
	private function renderPosttypes($option){
		$output = '';
		$args = array(
                    'public'   => true
                );
    	$post_types = get_post_types($args);
    	foreach ($post_types as $key => $value) {
    		$checked="";
    		if ( $value != 'attachment' ) {
    			if ( in_array($value, explode(",", $option['default'])) ) $checked = ' checked="checked"';
	    		$output.='
			    	<div class="checkbox">
						<label>
							<input class="form-control" value="'.$value.'" type="checkbox" name="pgl_input['.$option['id'].'][]" '.$checked.'>'.$value.'
						</label>
					</div>';
			}
    	}
		return $output;
	}

}