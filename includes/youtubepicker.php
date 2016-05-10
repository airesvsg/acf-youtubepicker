<?php
	
if( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( ! class_exists( 'youtubepicker' ) ) {

	class youtubepicker {

		public static function is_vid( $vid ) {
			if ( is_string( $vid ) && preg_match( '/[a-zA-Z0-9\-\_]{11}/', $vid ) ) {
				return esc_attr( $vid );
			}

			return false;
		}

		public static function thumbs( $vid, $server = 'i1' ) {
			if( $vid = self::is_vid( $vid ) ) {
				$url = "http://%s.ytimg.com/vi/%s/%s.jpg";
				return array(
					'default' => array(
						'url'    => sprintf( $url, $server, $vid, 'default' ),
						'width'  => 120,
						'height' => 90,
					),
					'medium' => array(
						'url'    => sprintf( $url, $server, $vid, 'mqdefault' ),
						'width'  => 320,
						'height' => 180,
					),
					'high' => array(
						'url'    => sprintf( $url, $server, $vid, 'hqdefault' ),
						'width'  => 480,
						'height' => 360,
					),
					'standard' => array(
						'url'    => sprintf( $url, $server, $vid, 'sddefault' ),
						'width'  => 640,
						'height' => 480,
					),
					'maximum' => array(
						'url'    => sprintf( $url, $server, $vid, 'maxresdefault' ),
						'width'  => 640,
						'height' => 480,
					)
				);
			}
		}

		public static function iframe( $vid, $atts = null ) {
			if( $vid = self::is_vid( $vid ) ) {
				$atts = wp_parse_args(
							$atts,
							array(
								'width'       => '100%', 
								'height'      => '100%',
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

		public static function url( $vid ) {
			if ( $vid = self::is_vid( $vid ) ) {
				return sprintf( 'https://www.youtube.com/watch?v=%s', $vid );
			}
		}

		// https://wordpress.org/support/topic/time-9#post-7213085
		public static function duration( $vid, $apikey ) {
			$duration = null;
			if( class_exists( 'DateTime') && class_exists( 'DateInterval' ) && ( $vid = self::is_vid( $vid ) ) ) {
				if ( false === ( $duration = get_transient( 'yp_duration_'.$vid ) ) ) {
					$url  = sprintf( 'https://www.googleapis.com/youtube/v3/videos?part=contentDetails&id=%s&key=%s', $vid, $apikey );
					$data = file_get_contents( $url );
					if ( $data ) {
						$data = json_decode( $data, true );
						if( is_array( $data ) && count( $data) > 0 ) {
							$duration = $data['items'][0]['contentDetails']['duration'];

							$date = new DateTime('2000-01-01');
							$date->add(new DateInterval($duration));
							$duration = $date->format('H:i:s');

							set_transient( 'yp_duration_'.$vid, $duration, YEAR_IN_SECONDS );
						}							
					}
				}
			}
			return $duration;
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