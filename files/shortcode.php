<?php
// Tạo Banners Shortcode

add_shortcode('banner', 'gg_banner');
function gg_banner($atts) {
    global $post;
    ob_start();

// định nghĩa thuộc tính và giá trị mặc định
    extract(shortcode_atts(array('order' => 'order', 'number' => - 1, 'cat' => 'cat', 'limit_word_title' => 2, 'limit_word_content' => 5, 'format_date' => 'd/m/Y', 'img_type' => 'banner_plugin_full', 'col' => 0, 'excerpt' => 'yes' ), $atts));


    if ( $col > 0) {
        $column = 'banner-column';
    }
    else {
        $column = 'no-column';
    }


// định nghĩa tham số truy vấn cơ bản dựa trên thuộc tính đã cung cấp

/* single post = banner */
    if ( is_singular('banner') ) {
        $options = array(
            'post_type' => 'banner',
            'post__not_in' => array($post->ID),
            'order' => $order,
            'orderby' => 'date',
            'posts_per_page' => $number,
            'tax_query' => array(
                array(
                    'taxonomy' => 'type-banner',
                    'field'    => 'term_id',
                    'terms'    => array($cat),
                )
            )
        );
    }

/* pages, cat */
    else {
        $options = array(
            'post_type' => 'banner',
            'order' => $order,
            'orderby' => 'date',
            'posts_per_page' => $number,
            'tax_query' => array(
                array(
                    'taxonomy' => 'type-banner',
                    'field'    => 'term_id',
                    'terms'    => array($cat),
                )
            )           
        );
    }

$the_query = new WP_Query($options);
$img_options = get_option( 'simple_banner_settings' );

 // chạy vòng lặp theo truy vấn bên trên
?>
<?php
 if ($the_query->have_posts()) {
    echo '<div id="container" class="cf">
    <div id="main" role="main">
    <section class="slider">
      <div class="flexslider">
        <ul class="slides">';
    while ($the_query->have_posts()): $the_query->the_post();
        simple_banner_loop($limit_word_title, $limit_word_content, $format_date, $img_type);
    endwhile; wp_reset_postdata();
    echo '</ul>
    </div>
  </section>
</div>
</div>';
 }
    $myvariable = ob_get_clean();
        return $myvariable;
}
?>