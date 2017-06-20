<?php
/**
 * Plugin Name: Mapplic
 * Plugin URI: http://www.mapplic.com/
 * Description: Mapplic can turn your simple images or vector graphics into fully functional, responsive interactive maps. The plugin is available on CodeCanyon, check the description page for more information.
 * Version: 4.0
 * Author: sekler
 * Author URI: http://www.codecanyon.net/user/sekler?ref=sekler
 */

include('admin/mapplic-database.php');

function mapplic_menu() {
	$pagehook = add_menu_page('Custom Interactive Maps', 'Custom Maps', 'edit_theme_options', 'mapplic_menu', 'mapplic_function', 'dashicons-location-alt', '26.1002');
	add_action('load-' . $pagehook, 'mapplic_on_page_load');
	add_action('admin_enqueue_scripts', 'mapplic_enqueue_admin');
}
add_action('admin_menu', 'mapplic_menu');

function mapplic_on_page_load() {
	wp_enqueue_script('common');
	wp_enqueue_script('wp-lists');
	wp_enqueue_script('postbox');
}

function mapplic_enqueue_admin($hook) {
	if ($hook === 'toplevel_page_mapplic_menu') {
		// Admin style
		wp_enqueue_style('mapplic-admin-style', plugin_dir_url(__FILE__) . 'admin/css/admin-style.css');

		// Iris colorpicker
		wp_enqueue_style('wp-color-picker');

		// Plugin styles
		wp_enqueue_style('mapplic-style', plugins_url('css/mapplic.css', __FILE__));
		wp_enqueue_style('mapplic-map-style', plugins_url('css/map.css', __FILE__));

		// Libraries
		wp_enqueue_script('mousewheel', plugins_url('js/jquery.mousewheel.js', __FILE__), array('jquery'));
		wp_enqueue_script('hammer', plugins_url('js/hammer.min.js', __FILE__));

		// Admin scripts
		wp_enqueue_script('mapplic-admin-script', plugin_dir_url(__FILE__) . 'admin/js/admin-script.js', array('jquery', 'wp-color-picker'));
		wp_enqueue_script('mapplic-admin', plugins_url('admin/js/mapplic-admin.js', __FILE__), array('jquery', 'mousewheel'), '1.0', true);

		// Media uploader
		wp_enqueue_media();
	}
}

function mapplic_enqueue() {
	// Plugin styles
	wp_enqueue_style('mapplic-style', plugins_url('css/mapplic.css', __FILE__));
	wp_enqueue_style('magnific-popup', plugins_url('css/magnific-popup.css', __FILE__));
	wp_enqueue_style('mapplic-map-style', plugins_url('css/map.css', __FILE__));

	// Libraries
	wp_enqueue_script('magnific-popup', plugins_url('js/magnific-popup.js', __FILE__), array('jquery'));
	wp_enqueue_script('mousewheel', plugins_url('js/jquery.mousewheel.js', __FILE__), array('jquery'));
	wp_enqueue_script('hammer', plugins_url('js/hammer.min.js', __FILE__));

	// Mapplic script
	wp_register_script('mapplic-script', plugins_url('js/mapplic.js', __FILE__), array('jquery', 'mousewheel'), '3.2');
	$mapplic_localization = array(
		'more_button' => __('More', 'mapplic'),
		'search_field' => __('Search', 'mapplic')
	);
	wp_localize_script('mapplic-script', 'mapplic_localization', $mapplic_localization);
}

function mapplic_function() {
	// Load admin page
	include('admin/mapplic-admin.php');
}

// Ajax function to get map data from database
if (!function_exists('mapdata_callback')) {
	function mapdata_callback() {
		global $wpdb;

		$id = intval($_REQUEST['map']);
		$table = $wpdb->prefix . 'custommaps';

		$map = $wpdb->get_row("SELECT * FROM $table WHERE id = $id", 'ARRAY_A');

		echo $map['data'];

		die();
	}
}
add_action('wp_ajax_mapdata', 'mapdata_callback');
add_action('wp_ajax_nopriv_mapdata', 'mapdata_callback');

// Add SVG Support to Media Uploader
if (!function_exists('mapplic_mime_types')) {
	function mapplic_mime_types($mimes) {
		$mimes['svg'] = 'image/svg+xml';
		return $mimes;
	}
}
add_filter('upload_mimes', 'mapplic_mime_types');

// Mapplic shortcode
function mapplic_shortcode($atts) {
	extract(shortcode_atts(array(
		'id' => false,
		'h' => 420,
		'landmark' => false
	), $atts, 'mapplic'));

	// Generate an unique id for every instance of the shortcode
	STATIC $i = 0;
	$i++;
	$instance = 'mapplic' . $i;

	mapplic_enqueue();
	wp_enqueue_script('mapplic-instance', plugins_url('js/mapplic.instance.js', __FILE__), array('mapplic-script'), null, true);
	wp_localize_script('mapplic-instance', $instance, array(
		'ajaxurl' => admin_url('admin-ajax.php'),
		'id' => $id,
		'height' => $h,
		'landmark' => $landmark
	));

	$output = '<div id="' . $instance . '"></div>';

	// Edit button
	if (current_user_can('activate_plugins')) $output .= '<a href="' . admin_url('admin.php?page=mapplic_menu&action=edit&map=' . $id) .'">' . __('Edit map', 'mapplic') . '</a>';
	return $output;
}
add_shortcode('mapplic', 'mapplic_shortcode');