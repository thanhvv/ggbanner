<?php
/**
 * Adds banner_banner_widget widget.
 */

class banner_banner_widget extends WP_Widget
{

    /**
     * Register widget with WordPress.
     */
    function __construct() {
        parent::__construct('banner_banner_widget',

        // Base ID
        __('banner', 'simple-banner'),

        // Name
        array('description' => __('List banner', 'simple-banner'),)

        // Args
        );
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget($args, $instance) {
        global $post;
        echo $args['before_widget'];
        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }
/* single post = banner */
        if ( is_singular('banner') ) {

            if (!empty($instance['cat'])) {

                $options = array('post_type' => 'banner', 'posts_per_page' => $instance['number'], 'cat' => $instance['cat'], 'post__not_in' => array($post->ID));

            }

            else {

                $options = array('post_type' => 'banner', 'posts_per_page' => $instance['number'], 'post__not_in' => array($post->ID));

            }

        }
/* pages, cat */
        else {

            if (!empty($instance['cat'])) {

                $options = array('post_type' => 'banner', 'posts_per_page' => $instance['number'], 'cat' => $instance['cat']);

            }

            else {

                $options = array('post_type' => 'banner', 'posts_per_page' => $instance['number']);

            }

        }

        $img_options = get_option( 'simple_banner_settings' );

        // The Query
        $the_query = new WP_Query($options); ?>

 <?php if ($the_query->have_posts()) { ?>
    <div class="simple-banner-con no-column">
    <?php while ($the_query->have_posts()): $the_query->the_post(); ?>
        <?php simple_banner_loop(); ?>
     <?php endwhile; wp_reset_postdata(); ?>
    </div>
<?php } ?>

<p class="footer__link"><a href="<?php bloginfo('url') ?>/banner"><?php _e('More banner', 'simple-banner') ?></a></p>

<?php

echo $args['after_widget'];
    }

  /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = sanitize_text_field( $new_instance['title'] );
        $instance['number'] = (int) $new_instance['number'];
        $instance['cat'] = (int) $new_instance['cat'];
        return $instance;
    }

    /**
     * Outputs the settings form for the Recent Posts widget.
     *
     * @since 2.8.0
     * @access public
     *
     * @param array $instance Current settings.
     */
    public function form( $instance ) {
        $title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
        $number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
        $cat    = isset( $instance['cat'] ) ? absint( $instance['cat'] ) : '';
?>

<p>
<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title', 'wp_widget_plugin' ); ?></label><br />
<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
</p>
<p>
<label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of banner to show:' ); ?></label>
<input class="tiny-text" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="number" step="1" min="1" value="<?php echo $number; ?>" size="3" />
</p>
<p>
<label for="<?php echo $this->get_field_id( 'cat' ); ?>"><?php _e( 'Cat id:' ); ?></label>
<input class="tiny-text" id="<?php echo $this->get_field_id( 'cat' ); ?>" name="<?php echo $this->get_field_name( 'cat' ); ?>" type="cat" value="<?php echo $cat; ?>" size="3" />
</p>

        <?php
    }
}

// register banner_banner_Widget widget
function register_banner_banner_widget() {
    register_widget('banner_banner_widget');
}
add_action('widgets_init', 'register_banner_banner_widget');
