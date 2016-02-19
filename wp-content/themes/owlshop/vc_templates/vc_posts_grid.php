<?php
$grid_link = $grid_layout_mode = $title = $filter= '';
$posts = array();
extract(shortcode_atts(array(
    'title' => '',
    'grid_columns_count' => 4,
    'grid_teasers_count' => 8,
    'grid_layout' => 'skin1', // title_thumbnail_text, thumbnail_title_text, thumbnail_text, thumbnail_title, thumbnail, title_text
    'grid_link_target' => '_self',
    'filter' => '', //grid,
    'grid_thumb_size' => 'thumbnail',
    'grid_layout_mode' => 'fitRows',
    'el_class' => '',
    'teaser_width' => '12',
    'orderby' => NULL,
    'order' => 'DESC',
    'loop' => '',
), $atts));
if(empty($loop)) return;
global $_config;
$_config = array();

$this->getLoop($loop);
$el_class = $this->getExtraClass($el_class);
$sticky = get_option('sticky_posts');
$this->loop_args['post__not_in'] = $sticky;

$my_query = new WP_Query($this->loop_args);


$column = 12/$grid_columns_count;

?>
<div class="grid-posts grid-posts<?php echo esc_attr( $el_class ); ?>">
    <div class="row">
        <?php while ( $my_query->have_posts() ): $my_query->the_post();global $post; ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class('blog-container blog-visual col-sm-'.$column ); ?>>
                <?php get_template_part( 'templates/blog/blog-visual' ); ?>
            </article>
        <?php endwhile; ?>
    </div>
</div>
<?php
wp_reset_postdata();


