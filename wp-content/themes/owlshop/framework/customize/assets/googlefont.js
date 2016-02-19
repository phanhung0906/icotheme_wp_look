(function( $ ) {
    "use strict";
    
    $(window).load(function(){
        // Set Config
        $('.option-googlefont').each(function(index, el) {
            var $this = $(this);
            var $config = $this.find('input[type="hidden"]').data('value');
            if($config){
                $this.find('.font').val($config.font_family);
                var $selected = $this.find('.font-select :selected');
                var $variants = $selected.data('variants');
                var $subsets = $selected.data('subsets');

                // variants
                $this.append('<select class="variants font-select" data-placeholder="Font Weight & Style"></select>');
                var $el_va = $this.find('.variants');
                $.each($variants, function(index, val) {
                    $el_va.append('<option value="'+val.id+'">'+val.name+'</option>');
                });

                //subsets
                $this.append('<select class="subsets font-select" data-placeholder="Font Subsets"></select>');
                var $el_va = $this.find('.subsets');
                $.each($subsets, function(index, val) {
                    $el_va.append('<option value="'+val.id+'">'+val.name+'</option>');
                });
                $this.find('.subsets').val($config.subsets);
                $this.find('.variants').val($config.variants);
            }
        });

        $('.font-select.font').chosen({
            no_results_text: "Oops, nothing found!"
        });

        $('.font-select.font').on('change', function(evt, params) {
            var $container = $(this).parent();
            var $selected = $(this).find(':selected');
            var $variants = $selected.data('variants');
            var $subsets = $selected.data('subsets');
            
            $container.find('.variants').remove();
            $container.find('.subsets').remove();

            // variants
            $container.append('<select class="variants font-select" data-placeholder="Font Weight & Style"></select>');
            var $el_va = $container.find('.variants');
            $.each($variants, function(index, val) {
                $el_va.append('<option value="'+val.id+'">'+val.name+'</option>');
            });

            //subsets
            $container.append('<select class="subsets font-select" data-placeholder="Font Subsets"></select>');
            var $el_va = $container.find('.subsets');
            $.each($subsets, function(index, val) {
                $el_va.append('<option value="'+val.id+'">'+val.name+'</option>');
            });
        });

        $('body').delegate('.font-select', 'change', function(event) {
            var $container = $(this).parent();
            var label = '';
            var $font = $container.find('.font :selected').text();
            var $font_family = $container.find('.font').val();
            var $variants = $container.find('.variants').val();
            var $subsets = $container.find('.subsets').val();

            label = $font_family + (($variants!='')?':'+$variants:'') + (($subsets!='')?'&subset='+$subsets:'');

            var $data = '{"url":"'+label+'","font_family":"'+$font_family+'","variants":"'+$variants+'","subsets":"'+$subsets+'","font":"'+$font+'"}';
            $container.find('input[type="hidden"]').val($data).trigger('change');
        });

        $('body').delegate('.clear-font', 'click', function(event) {
            var $container = $(this).prev();
            $container.find('.variants').remove();
            $container.find('.subsets').remove();
            $container.find('option').prop('selected', false);
            $container.find('.font-select.font').trigger('chosen:updated');
            $container.find('input[type="hidden"]').val('').trigger('change');
            return false;
        });

    });
})( jQuery );