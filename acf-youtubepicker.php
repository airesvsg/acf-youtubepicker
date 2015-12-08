<?php

/*
Plugin Name: Advanced Custom Fields: YouTube Picker
Plugin URI: https://github.com/airesvsg/acf-youtubepicker
Description: Search and select videos on YouTube without leaving the page.
Version: 2.4
Author: Aires Gonçalves
Author URI: https://github.com/airesvsg
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

if( ! defined( 'ABSPATH' ) ) exit;

if( ! class_exists( 'youtubepicker' ) ) {
	require_once plugin_dir_path( __FILE__ ) . 'inc/youtubepicker.php';
}

load_plugin_textdomain( 'acf-youtubepicker', false, dirname( plugin_basename(__FILE__) ) . '/lang/' ); 

function include_field_types_youtubepicker( $version ) {	
	include_once('acf-youtubepicker-v5.php');	
}

add_action('acf/include_field_types', 'include_field_types_youtubepicker');	

function register_fields_youtubepicker() {
	include_once('acf-youtubepicker-v4.php');
}

add_action('acf/register_fields', 'register_fields_youtubepicker');