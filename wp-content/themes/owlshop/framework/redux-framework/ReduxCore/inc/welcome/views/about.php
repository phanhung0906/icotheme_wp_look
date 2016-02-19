<div class="wrap about-wrap">
    <h1><?php printf( __( 'Welcome to Redux Framework %s', 'owlshop' ), $this->display_version ); ?></h1>

    <div
        class="about-text"><?php printf( __( 'Thank you for updating to the latest version! Redux Framework %s is a huge step forward in Redux Development. Look at all that\'s new.', 'owlshop' ), $this->display_version ); ?></div>
    <div
        class="redux-badge"><i
            class="el el-redux"></i><span><?php printf( __( 'Version %s', 'owlshop' ), ReduxFramework::$_version ); ?></span>
    </div>

    <?php $this->actions(); ?>
    <?php $this->tabs(); ?>

    <div id="redux-message" class="updated">
        <h4><?php _e( 'What is Redux Framework?', 'owlshop' ); ?></h4>

        <p><?php _e( 'Redux Framework is the core of many products on the web. It is an option framework which developers use to
            enhance their products.', 'owlshop' ); ?></p>

        <p class="submit">
            <a class="button-primary" href="http://reduxframework.com"
               target="_blank"><?php _e( 'Learn More', 'owlshop' ); ?></a>
        </p>
    </div>

    <div class="changelog">

        <h2><?php _e( 'New in this Release', 'owlshop' ); ?></h2>

       
        <div class="changelog">
            <div class="feature-section col three-col">
                
                <div class="last-feature">
                    <h4>Elusive Icons Update</h4>

                    <p>Redux is now taking over development of Elusive Icons. As a result, we've refreshed our copy of
                        Elusive to the newest version.</p>
                </div>
            </div>
        </div>
    </div>
</div>