<?php
function breaking_loop($limit_word_title, $limit_word_content, $format_date, $img_type) {
	$img_options = get_option( 'breaking_news_settings' );

echo '<div id="post-id-' .get_the_ID() . '" class="simple-news-item">';

if ( has_post_thumbnail() ) :
	echo '<div class="simple-news-img-con">';
	echo '<a class="simple-news-item-link" href="' . get_the_permalink() . '">';
	echo '<img src="' .get_the_post_thumbnail_url(get_the_ID(), $img_type). '">';
	echo '</a>';
	echo '</div>';
endif;

echo '<div class="simple-news-text-con">';
echo '<h4 class="simple-news-title"><a class="simple-news-item-link" href="' . get_the_permalink() . '">' . wp_trim_words(get_the_title(), $limit_word_title) . '</a></h4>';
echo '<div class="simple-news-date">' . get_the_date($format_date) . '</div>';
echo '<div class="simple-news-excerpt">' . wp_trim_words(get_the_excerpt(), $limit_word_content) . '</div>';
echo '</div>';
echo '</div>';

}