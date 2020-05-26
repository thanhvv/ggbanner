<?php
/*
Plugin Name: Breaking News
Version: 1.0
Plugin URI: https://www.thanhvv.com
Description: Show Breaking News (title, description, image, link).
Author: Võ Văn Thành
Text Domain: breaking-news
Domain Path: /translation
Author URI: https://www.thanhvv.com
*/
// Load the plugin's text domain
function gg_breaking_news_init() 
{
    load_plugin_textdomain('breaking_news', false, dirname(plugin_basename(__FILE__)) . '/translation');
}
add_action('plugins_loaded', 'gg_breaking_news_init');

function gg_breaking_news_function() 
{
	  flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'gg_breaking_news_function' );

// Images
if (function_exists('add_theme_support')) 
{
	  add_theme_support('post-thumbnails');
	  add_image_size('breaking_news_plugin_small', 50, 50, true);
	  add_image_size('breaking_news_plugin_normal', 180, 120, true);
}

// Change author
function simple_breaking_news_allowAuthorEditing()
{
    add_post_type_support( 'breaking_news', 'author' );
}
add_action('init','simple_breaking_news_allowAuthorEditing');

// Files
require_once ('files/admin.php');
require_once ('files/functions.php');
require_once ('files/shortcode.php');

// CSS file
$options = get_option( 'breaking_settings' );

if ( 1 == isset($options['breaking_checkbox_css'] )) 
{
		add_action('wp_enqueue_scripts', 'gg_breaking_news_register_plugin_styles');
		function gg_breaking_news_register_plugin_styles() {
			wp_register_style('news', plugins_url('gg-breaking-news/css/custom.css'));
				wp_enqueue_style('news');
		}
}

// Shotcode in widget
add_filter('widget_text', 'do_shortcode');
