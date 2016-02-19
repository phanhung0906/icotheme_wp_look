
<form method="get" id="searchform" action="<?php echo esc_url(home_url('/')); ?>">
	<div class="pgl_search">
		<input name="s" id="s" maxlength="20" class="form-control " type="text" size="20" placeholder="<?php echo __('search ...','owlshop'); ?>">
        <input type="submit" id="searchsubmit" value="Search" />
        <i class="fa fa-search"></i>
        <?php if(PLG_WOOCOMMERCE_ACTIVED){ ?>
        <input type="hidden" name="post_type" value="product" />
        <?php } ?>
	</div>
</form>