<?php
/*
Plugin Name: Advanced Custom Fields: YouTube Picker
Plugin URI: https://github.com/airesvsg/acf-youtubepicker
Description: Search and select videos on YouTube without leaving the page
Version: 3.1.0
Author: Aires Gonçalves
Author URI: https://github.com/airesvsg
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

if( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( !class_exists( 'acf_plugin_youtubepicker' ) ) {

	class acf_plugin_youtubepicker {
		
		function __construct() {	
			$this->settings = array(
				'version'  => '3.1.0',
				'url'      => plugin_dir_url( __FILE__ ),
				'path'     => plugin_dir_path( __FILE__ ),
			);
			
			add_action( 'acf/include_field_types', array( $this, 'include_field_types' ) ); // v5
			add_action( 'acf/register_fields', array( $this, 'include_field_types' ) ); // v4
			
			include_once 'includes/youtubepicker.php';
		}
		
		function include_field_types( $version ) {
			if ( ! is_numeric( $version ) ) {
				$version = 4;
			}

			$this->settings['acf_version'] = absint( $version );

			include_once 'fields/acf-youtubepicker.php';		
		}
		
	}

	new acf_plugin_youtubepicker();

}