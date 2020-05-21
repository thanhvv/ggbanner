<?php
/*
Plugin Name: Banner
Version: 1.0
Plugin URI: https://www.thanhvv.com
Description: Show banner (title, description, link).
Author: Võ Văn Thành
Text Domain: simple-banner
Domain Path: /translation
Author URI: https://www.thanhvv.com
*/
// Load the plugin's text domain
function gg_banner_init() 
{
    load_plugin_textdomain('simple-banner', false, dirname(plugin_basename(__FILE__)) . '/translation');
}
add_action('plugins_loaded', 'gg_banner_init');

// Banner Posttype
add_action( 'init', 'gg_banner_create_posttype' );
function gg_banner_create_posttype() 
{
    register_post_type('banner',
        array(
	    	    'labels' => array('name' => __('Banner', 'simple-banner'),
	    	    'singular_name' => __('Banner', 'simple-banner')),
	    			'public' => true,
						'publicly_queryable' => true,
						'menu_icon' => 'dashicons-calendar-alt',
						'taxonomies' => array('type-banner'),
						'has_archive' => true,
						'supports' => array(
								'title',
								'editor',
								'excerpt',
								'thumbnail',
								'comments'
						),
						'show_in_rest' => true,
						'rewrite' => array('slug' => 'banner'),
    	  )
    );
}
function create_loaibanner_taxonomy() {

	/* Biến $label chứa các tham số thiết lập tên hiển thị của Taxonomy
	 */
	$labels = array(
					'name' => 'Loại Banner',
					'singular' => 'Loại Banner',
					'menu_name' => 'Loại Banner'
	);

	/* Biến $args khai báo các tham số trong custom taxonomy cần tạo
	 */
	$args = array(
					'labels'                     => $labels,
					'hierarchical'               => true,
					'public'                     => true,
					'show_ui'                    => true,
					'rewrite' => array( 'slug' => 'banner'),
					'show_admin_column'          => true,
					'show_in_nav_menus'          => true,
					'show_tagcloud'              => true,
	);

	/* Hàm register_taxonomy để khởi tạo taxonomy
	 */
	register_taxonomy('type-banner', 'banner', $args);

}

// Hook into the 'init' action
add_action( 'init', 'create_loaibanner_taxonomy', 0 );

function gg_banner_function() 
{
	  gg_banner_create_posttype();
	  flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'gg_banner_function' );

// Images
if (function_exists('add_theme_support')) 
{
	  add_theme_support('post-thumbnails');
	  add_image_size('banner_plugin_small', 1200, 300, true);
	  add_image_size('banner_plugin_full', 1407, 508, true);
}

// Change author
function simple_banner_allowAuthorEditing()
{
    add_post_type_support( 'banner', 'author' );
}
add_action('init','simple_banner_allowAuthorEditing');

// Files
require_once ('files/admin.php');
require_once ('files/metabox-link.php');
require_once ('files/functions.php');
require_once ('files/shortcode.php');
require_once ('files/widget.php');

// CSS file
$options = get_option( 'simple_banner_settings' );

if ( 1 == ! isset($options['simple_banner_checkbox_css'] )) 
{
		add_action('wp_enqueue_scripts', 'gg_banner_register_plugin_styles');
		add_action('wp_enqueue_scripts', 'gg_banner_register_plugin_script');
		function gg_banner_register_plugin_styles() {
			wp_register_style('banner', plugins_url('simple-banner/css/demo.css'));
			wp_register_style('flexslider', plugins_url('simple-banner/css/flexslider.css'));
			wp_register_style('custom', plugins_url('simple-banner/css/custom.css'));
				wp_enqueue_style('banner');
				wp_enqueue_style('flexslider');
				wp_enqueue_style('custom');
		}
		function gg_banner_register_plugin_script() {
			wp_enqueue_script('modernizr.js', plugins_url('simple-banner/js/modernizr.js'), ['jquery'], null, true);
			wp_enqueue_script('apikey', 'http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js', ['jquery'], null, true);
			wp_enqueue_script('flexslider.js', plugins_url('simple-banner/js/jquery.flexslider.js'), ['jquery'], null, true);
			wp_enqueue_script('custom1.js', plugins_url('simple-banner/js/custom.js'), ['jquery'], null, true);
			wp_enqueue_script('modernizr');
			wp_enqueue_script('flexslider');
			wp_enqueue_script('custom1');
		}
}

// Shotcode in widget
add_filter('widget_text', 'do_shortcode');
