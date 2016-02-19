<?php

global $theme_option;
?>
        	<footer id="pgl-footer" class="pgl-footer">
                <?php 
                   do_action( 'owlshop_footer_layout_style' );
                ?>
                <div class="footer-copyright">
				    <div class="container">
				        <?php echo wp_kses_post($theme_option['footer-copyright']); ?>
				    </div>
				</div>
        	</footer>
        </div><!--  End .wrapper-inner -->
    </div><!--  End .pgl-wrapper -->
    
    <?php do_action('owlshop_after_wrapper'); ?>

	<?php wp_footer(); ?>
</body>
</html>