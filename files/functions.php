<?php
function simple_banner_loop($limit_word_title, $limit_word_content, $format_date, $img_type) {
	$img_options = get_option( 'simple_banner_settings' );
	echo '<li>';
if ( has_post_thumbnail() ) :
	echo '<a href="' . get_post_meta(get_the_ID(), '_my_meta_value_key', true)  . '">';
	echo '<img src="' .get_the_post_thumbnail_url(get_the_ID(), $img_type). '">';
	echo '</a>';
endif;
echo '<p class="flex-caption">'. wp_trim_words(get_the_title(), $limit_word_title) . '</p>';
echo '<p class="flex-content">'. wp_trim_words(get_the_excerpt(), $limit_word_content) . '</p>';
echo '</li>';
}