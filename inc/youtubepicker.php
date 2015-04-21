<?php
	
	if( ! defined( 'ABSPATH' ) ) exit;

	if( ! class_exists( 'youtubepicker' ) ) {

		class youtubepicker {

			public static function is_vid( $vid ) {
				return is_string( $vid ) && preg_match( '/[a-zA-Z0-9\-\_]{11}/', $vid ) ? esc_attr( $vid ) : false;
			}

			public static function thumbs( $vid, $server = 'i1' ) {
				if( $vid = self::is_vid( $vid ) ) {
					$url = "http://%s.ytimg.com/vi/%s/%s.jpg";
					return array(
						'default' => array(
							'url'    => sprintf( $url, $server, $vid, 'default' ),
							'width'  => 120,
							'height' => 90
						),
						'medium' => array(
							'url'    => sprintf( $url, $server, $vid, 'mqdefault' ),
							'width'  => 320,
							'height' => 180
						),
						'high' => array(
							'url'    => sprintf( $url, $server, $vid, 'hqdefault' ),
							'width'  => 480,
							'height' => 360
						),
						'standard' => array(
							'url'    => sprintf( $url, $server, $vid, 'sddefault' ),
							'width'  => 640,
							'height' => 480
						),
						'maximum' => array(
							'url'    => sprintf( $url, $server, $vid, 'maxresdefault' ),
							'width'  => 640,
							'height' => 480
						)
					);
				}
			}

			public static function iframe( $vid, $atts = null ) {
				if( $vid = self::is_vid( $vid ) ) {
					$atts = wp_parse_args(
								$atts,
								array(
									'width' => '100%', 
									'height' => '100%',
									'frameborder' => 0,
									'allowfullscreen',
								)
							);

					$a = '';
					foreach( $atts as $k => $v ){
						if( is_numeric( $k ) ) {
							$a .= esc_attr( $v ) . ' ';
						}else{
							$a .= esc_attr( $k ) . '="' . esc_attr( $v ) . '" ';
						}
					} 
					return sprintf( '<iframe src="https://www.youtube.com/embed/%s" %s></iframe>', $vid, trim( $a ) );
				}
			}
		}
	}

	if( ! function_exists( 'yp_iframe' ) ) {
		function yp_iframe( $vid, $atts = null ) {
			return youtubepicker::iframe( $vid, $atts );
		}
	}

	if( ! function_exists( 'yp_thumbs' ) ) {
		function yp_thumbs( $vid, $server = 'i1' ) {
			return youtubepicker::thumbs( $vid, $server );
		}
	}