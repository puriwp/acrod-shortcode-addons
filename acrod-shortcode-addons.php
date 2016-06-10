<?php
/**
 * @link              http://puriwp.com/
 * @since             1.0.0
 * @package           Acrod_Shortcode_Addons
 *
 * @wordpress-plugin
 * Plugin Name:		Acrod Shortcode Addons
 * Plugin URI: 		https://github.com/puriwp/acrod-shortcode-addons
 * Description: 	Custom shortcode for integrated visual composer plugin.
 * Version: 			1.0
 * Author: 				PuriWP
 * Author URI:		http://puriwp.com/
 */

// don't load directly
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Including all shorcodes files
foreach ( glob( plugin_dir_path( __FILE__ ) . 'shortcodes/*.php' ) as $sc_outputs ) {
	require_once $sc_outputs;
}

function acrod_shortcode_style() {
	/* Portfolio*/
	wp_enqueue_style( 'acrod-owl-carousel', plugin_dir_url( __FILE__ ) . 'css/owlcarousel.min.css', NULL, '2.1.0', 'all' );
	wp_enqueue_style( 'acrod-shortcode', plugin_dir_url( __FILE__ ) . 'css/shortcode.css', NULL, '1.0', 'all' );

	wp_enqueue_script( 'acrod-owl-carousel', plugin_dir_url( __FILE__ ) . 'js/lib/owlcarousel.min.js', array( 'jquery' ), '2.1.0', true );
	wp_enqueue_script( 'acrod-equal-height', plugin_dir_url( __FILE__ ) . 'js/equal-height.js', array( 'jquery' ), '1.0', true );
	wp_enqueue_script( 'acrod-carousel', plugin_dir_url( __FILE__ ) . 'js/acrod-carousel.js', array( 'jquery' ), '1.0', true );
}
add_action( 'wp_enqueue_scripts', 'acrod_shortcode_style', 9999 );