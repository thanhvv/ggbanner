<?php
// Tạo breaking-newss Shortcode

add_shortcode('breaking-news', 'gg_breaking_news');
function gg_breaking_news($atts) {
    global $post;
    ob_start();

// định nghĩa thuộc tính và giá trị mặc định
    extract(shortcode_atts(array('order' => 'order', 'number' => - 1, 'offset' => 0, 'post_type' => 'post', 'taxonomy' => 'category', 'cat' => 'cat', 'limit_word_title' => 2, 'limit_word_content' => 5, 'format_date' => 'd/m/Y', 'img_type' => 'breaking_news_plugin_small', 'col' => 0, 'excerpt' => 'yes' ), $atts));


    if ( $col > 0) {
        $column = 'news-column';
    }
    else {
        $column = 'no-column';
    }


// định nghĩa tham số truy vấn cơ bản dựa trên thuộc tính đã cung cấp

/* single post = breaking-news */
    if ( is_singular($posttype) ) {
        $options = array(
            'post_type' => $posttype,
            'post__not_in' => array($post->ID),
            'order' => $order,
            'orderby' => 'date',
            'posts_per_page' => $number,
            'offset' => $offset,
            'tax_query' => array(
                array(
                    'taxonomy' => $taxonomy,
                    'field'    => 'term_id',
                    'terms'    => array($cat),
                )
            )
        );
    }

/* pages, cat */
    else {
        $options = array(
            'post_type' => $posttype,
            'order' => $order,
            'orderby' => 'date',
            'posts_per_page' => $number,
            'offset' => $offset,
            'tax_query' => array(
                array(
                    'taxonomy' => $taxonomy,
                    'field'    => 'term_id',
                    'terms'    => array($cat),
                )
            )           
        );
    }

$the_query = new WP_Query($options);
$img_options = get_option( 'breaking_news_settings' );

 // chạy vòng lặp theo truy vấn bên trên
?>
<?php
 if ($the_query->have_posts()) {

    static $i = 1;
    $shortcode = 'sh-id-' . $i;

    echo '<div class="simple-news-con ' . $column . ' ' . $shortcode . '">';
        while ($the_query->have_posts()): $the_query->the_post();
            breaking_loop($limit_word_title, $limit_word_content, $format_date, $img_type); wp_reset_postdata();
        endwhile;
    echo '</div>';

    echo '<style type="text/css">';
    echo '@media (min-width: 700px) {';
        echo '.simple-news-con.news-column.' . $shortcode . '{';
        echo '-ms-grid-columns: (1fr)[' . $col . '];';
        echo 'grid-template-columns: repeat(' . $col . ', 1fr);}';
    echo '}';
    echo '</style>';

 }
    $myvariable = ob_get_clean();
        return $myvariable;
}
?>