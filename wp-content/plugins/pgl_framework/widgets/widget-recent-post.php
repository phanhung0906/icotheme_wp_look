<?php

class PGL_Recent_Post_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct(
            // Base ID of your widget
            'pgl_recent_post_widget',
            // Widget name will appear in UI
            __('PGL Recent Post Widget', 'bromic'),
            // Widget description
            array( 'description' => __( 'Recent post widgets.', 'bromic' ), )
        );
    }

    public function widget( $args, $instance ) {
        extract( $args );
        extract( $instance );

        $posts = $instance['posts'];
        $title = apply_filters('widget_title', $instance['title']);

        echo $before_widget;
        if ( $title ) {
            echo $before_title . $title . $after_title;
        }
        ?>
        <?php 
            $sticky = get_option('sticky_posts');
            $args = array(
                'showposts' => $posts,
                'post__not_in'  => $sticky
            );
            $recent_posts = new WP_Query($args);
        ?>
        <?php if($recent_posts->have_posts()): ?>
            <div class="post-widget">
                <?php  while( $recent_posts->have_posts() ) : $recent_posts->the_post(); ?>
                    <?php get_template_part( 'templates/blog/blog-widget' ); ?>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>
        <?php wp_reset_query(); ?>
        <?php
        echo $after_widget;
    }
// Widget Backend
    public function form( $instance ) {
        $defaults = array(  
            'posts' => 3,
            'title' => "Recent Post"
        );
        $instance = wp_parse_args((array) $instance, $defaults);
        // Widget admin form
        ?>
         <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
            <input class="widefat" type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('posts'); ?>">Number of popular posts:</label>
            <input class="widefat" type="text" style="width: 30px;" id="<?php echo $this->get_field_id('posts'); ?>" name="<?php echo $this->get_field_name('posts'); ?>" value="<?php echo $instance['posts']; ?>" />
        </p>
<?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;

        $instance['posts'] = $new_instance['posts'];
        $instance['title'] = $new_instance['title'];
        return $instance;

    }
}