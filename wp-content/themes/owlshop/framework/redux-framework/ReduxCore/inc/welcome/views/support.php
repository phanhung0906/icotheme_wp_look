<div class="wrap about-wrap" xmlns="http://www.w3.org/1999/html">
    <h1><?php _e( 'Redux Framework - Support', 'owlshop' ); ?></h1>

    <div
        class="about-text"><?php printf( __( 'We are an open source project used by developers to make powerful control panels.', 'owlshop' ), $this->display_version ); ?></div>
    <div
        class="redux-badge"><i
            class="el el-redux"></i><span><?php printf( __( 'Version %s', 'owlshop' ), ReduxFramework::$_version ); ?></span>
    </div>

    <?php $this->actions(); ?>
    <?php $this->tabs(); ?>

    <div id="support_div" class="support">

        


        <div class="clear" style="clear:both;"></div>
    </div>

</div>