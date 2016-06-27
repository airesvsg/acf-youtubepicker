<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'acf_field_youtubepicker' ) ) {

	class acf_field_youtubepicker extends acf_field {

		public $settings = array();

		public $defaults = array();

		private static $SEARCH_PARAMS = array( 
			'channelId', 'channelType', 'eventType', 'order', 'regionCode', 
			'safeSearch', 'topicId', 'videoCaption', 'videoCategoryId', 'videoDefinition', 
			'videoDimension', 'videoDuration', 'videoEmbeddable', 'videoLicense', 
			'videoSyndicated', 'videoType', 'maxResults', 'relatedVideoId', 'relevanceLanguage' 
		);

		public function __construct( $settings ) {
			$this->name     = 'youtubepicker';
			
			$this->label    = __( 'YouTube Picker', 'acf-youtubepicker' );
			
			$this->category = 'jQuery';
			
			$this->defaults = array(
				'api_key'           => 'AIzaSyAuHQVhEmD4m2AXL6TvADwZIxZjNogVRF0',
				'multiple'          => 0,
				'channelType'       => '',
				'order'             => 'relevance',
				'safeSearch'        => 'none',
				'videoCaption'      => 'any',
				'videoDefinition'   => 'any',
				'videoDimension'    => 'any',
				'videoDuration'     => 'any',
				'videoEmbeddable'   => 'true',
				'videoLicense'      => 'any',
				'videoSyndicated'   => 'any',
				'videoType'         => 'any',
				'channelId'         => '',
				'eventType'         => '',
				'regionCode'        => '',
				'topicId'           => '',
				'videoCategoryId'   => '',
				'maxResults'        => '',
				'relatedVideoId'    => '',
				'relevanceLanguage' => '',
				'answerOptions'     => array( 'vid', 'title', 'thumbs', 'iframe', 'url' ),
			);

			parent::__construct();
			
			$this->settings = $settings;
		}

		function create_options( $field ) {

			$field = array_merge( $this->defaults, $field );

			self::_render_field_setting( $field, array(
				'label'   => __( 'Select multiple videos?','acf-youtubepicker' ),
				'type'    => 'radio',
				'name'    => 'multiple',
				'layout'  => 'horizontal',
				'choices' => array(
					1 => __( 'Yes', 'acf-youtubepicker' ),
					0 => __( 'No', 'acf-youtubepicker' ),
				),
			) );

			self::_render_field_setting( $field, array(
				'label'        => __( 'Advanced Options','acf-youtubepicker' ),
				'instructions' => __( 'Set advanced options for YouTube Picker.','acf-youtubepicker' ),
				'type'         => 'radio',
				'name'         => 'yp_advanced_options',
				'layout'       => 'horizontal',
				'value'        => 0,
				'class'        => 'yp-advanced-options',
				'choices'      => array(
					1 => __( 'Show', 'acf-youtubepicker' ),
					0 => __( 'Hide', 'acf-youtubepicker' ),
				),
			) );

			self::_render_field_setting( $field, array(
				'label'        => __( 'API KEY - YouTube Data API','acf-youtubepicker' ),
				'instructions' => sprintf ( __( '<a href="%s" target="_blank">click here</a> for you know how to obtain the api key','acf-youtubepicker' ), 'https://developers.google.com/youtube/v3/getting-started' ),
				'type'         => 'text',
				'name'         => 'api_key',
				'wrapper' => array( 
					'class' => 'field_advanced' 
				),
			) );

			self::_render_field_setting( $field, array(
				'label'   => __( 'Answer Options','acf-youtubepicker' ),
				'type'    => 'checkbox',
				'name'    => 'answerOptions',
				'layout'  => 'horizontal',
				'wrapper' => array( 
					'class' => 'field_advanced' 
				),
				'choices' => array(
					'title'    => __( 'Title', 'acf-youtubepicker' ),
					'vid'      => __( 'Video ID', 'acf-youtubepicker' ),
					'url'      => __( 'Video URL', 'acf-youtubepicker' ),
					'thumbs'   => __( 'Video thumbnails', 'acf-youtubepicker' ),
					'duration' => __( 'Duration', 'acf-youtubepicker' ),
					'iframe'   => __( 'Embed Code', 'acf-youtubepicker' ),
				),
			) );

			self::_render_field_setting( $field, array(
				'label'   => __( 'Channel ID','acf-youtubepicker' ),
				'type'    => 'text',
				'name'    => 'channelId',
				'wrapper' => array( 
					'class' => 'field_advanced' 
				),
			) );

			self::_render_field_setting( $field, array(
				'label'   => __( 'Channel Type','acf-youtubepicker' ),
				'type'    => 'radio',
				'name'    => 'channelType',
				'layout'  => 'horizontal',
				'wrapper' => array( 
					'class' => 'field_advanced' 
				),
				'choices' => array(
					''  => __( 'Any', 'acf-youtubepicker' ),
					'show' => __( 'Show', 'acf-youtubepicker' ),
				),
			) );

			self::_render_field_setting( $field, array(
				'label'   => __( 'Event Type','acf-youtubepicker' ),
				'type'    => 'select',
				'name'    => 'eventType',
				'wrapper' => array( 
					'class' => 'field_advanced' 
				),
				'choices' => array(
					''          => __( '-- choose --', 'acf-youtubepicker' ),
					'completed' => __( 'Completed', 'acf-youtubepicker' ),
					'live'      => __( 'Live', 'acf-youtubepicker' ),
					'upcoming'  => __( 'Upcoming', 'acf-youtubepicker' ),
				),
			) );

			self::_render_field_setting( $field, array(
				'label'   => __( 'Order','acf-youtubepicker' ),
				'type'    => 'radio',
				'name'    => 'order',
				'layout'  => 'horizontal',
				'wrapper' => array( 
					'class' => 'field_advanced' 
				),
				'choices' => array(
					'date'       => __( 'Date', 'acf-youtubepicker' ),
					'rating'     => __( 'Rating', 'acf-youtubepicker' ),
					'relevance'  => __( 'Relevance', 'acf-youtubepicker' ),
					'title'      => __( 'Title', 'acf-youtubepicker' ),
					'videoCount' => __( 'Video Count', 'acf-youtubepicker' ),
					'viewCount'  => __( 'View Count', 'acf-youtubepicker' ),
				),
			) );

			self::_render_field_setting( $field, array(
				'label'   => __( 'Safe Search','acf-youtubepicker' ),
				'type'    => 'radio',
				'name'    => 'safeSearch',
				'layout'  => 'horizontal',
				'wrapper' => array( 
					'class' => 'field_advanced' 
				),
				'choices' => array(
					'moderate' => __( 'Moderate', 'acf-youtubepicker' ), 
					'none'     => __( 'None', 'acf-youtubepicker' ), 
					'strict'   => __( 'Strict', 'acf-youtubepicker' )
				),
			) );

			self::_render_field_setting( $field, array(
				'label'   => __( 'Video Caption','acf-youtubepicker' ),
				'type'    => 'radio',
				'name'    => 'videoCaption',
				'layout'  => 'horizontal',
				'wrapper' => array( 
					'class' => 'field_advanced' 
				),
				'choices' => array(
					'any'           => __( 'Any', 'acf-youtubepicker' ), 
					'closedCaption' => __( 'Closed Caption', 'acf-youtubepicker' ), 
					'none'          => __( 'None', 'acf-youtubepicker' ),
				),
			) );

			self::_render_field_setting( $field, array(
				'label'   => __( 'Video Definition','acf-youtubepicker' ),
				'type'    => 'radio',
				'name'    => 'videoDefinition',
				'layout'  => 'horizontal',
				'wrapper' => array( 
					'class' => 'field_advanced' 
				),
				'choices' => array(
					'any'      => __( 'Any', 'acf-youtubepicker' ), 
					'high'     => __( 'High', 'acf-youtubepicker' ), 
					'standard' => __( 'Standard', 'acf-youtubepicker' ),
				),
			) );

			self::_render_field_setting( $field, array(
				'label'   => __( 'Video Dimension','acf-youtubepicker' ),
				'type'    => 'radio',
				'name'    => 'videoDimension',
				'layout'  => 'horizontal',
				'wrapper' => array( 
					'class' => 'field_advanced' 
				),
				'choices' => array(
					'any' => __( 'Any', 'acf-youtubepicker' ), 
					'2d'  => __( '2d', 'acf-youtubepicker' ), 
					'3d'  => __( '3d', 'acf-youtubepicker' ),
				),
			) );

			self::_render_field_setting( $field, array(
				'label'   => __( 'Video Duration','acf-youtubepicker' ),
				'type'    => 'radio',
				'name'    => 'videoDuration',
				'layout'  => 'horizontal',
				'wrapper' => array( 
					'class' => 'field_advanced' 
				),
				'choices' => array(
					'any'    => __( 'Any', 'acf-youtubepicker' ), 
					'long'   => __( 'long', 'acf-youtubepicker' ), 
					'medium' => __( 'medium', 'acf-youtubepicker' ),
					'short'  => __( 'short', 'acf-youtubepicker' ),
				),
			) );

			self::_render_field_setting( $field, array(
				'label'   => __( 'Video Embeddable','acf-youtubepicker' ),
				'type'    => 'radio',
				'name'    => 'videoEmbeddable',
				'layout'  => 'horizontal',
				'wrapper' => array( 
					'class' => 'field_advanced' 
				),
				'choices' => array(
					'true' => __( 'Yes', 'acf-youtubepicker' ), 
					'any'  => __( 'No', 'acf-youtubepicker' ),
				),
			) );

			self::_render_field_setting( $field, array(
				'label'   => __( 'Video License','acf-youtubepicker' ),
				'type'    => 'radio',
				'name'    => 'videoLicense',
				'layout'  => 'horizontal',
				'wrapper' => array( 
					'class' => 'field_advanced' 
				),
				'choices' => array(
					'any'            => __( 'Any', 'acf-youtubepicker' ),
					'creativeCommon' => __( 'Creative Common', 'acf-youtubepicker' ), 
					'youtube'        => __( 'YouTube', 'acf-youtubepicker' ), 
				),
			) );

			self::_render_field_setting( $field, array(
				'label'   => __( 'Video Syndicated','acf-youtubepicker' ),
				'type'    => 'radio',
				'name'    => 'videoSyndicated',
				'layout'  => 'horizontal',
				'wrapper' => array( 
					'class' => 'field_advanced' 
				),
				'choices' => array(
					'true' => __( 'Yes', 'acf-youtubepicker' ),
					'any'  => __( 'No', 'acf-youtubepicker' ),
				),
			) );

			self::_render_field_setting( $field, array(
				'label'   => __( 'Video Type','acf-youtubepicker' ),
				'type'    => 'radio',
				'name'    => 'videoType',
				'layout'  => 'horizontal',
				'wrapper' => array( 
					'class' => 'field_advanced' 
				),
				'choices' => array(
					'any'     => __( 'Any', 'acf-youtubepicker' ),
					'episode' => __( 'Episode', 'acf-youtubepicker' ),
					'movie'   => __( 'Movie', 'acf-youtubepicker' ),
				),
			) );

			self::_render_field_setting( $field, array(
				'label'   => __( 'Video Category ID','acf-youtubepicker' ),
				'type'    => 'text',
				'name'    => 'videoCategoryId',
				'wrapper' => array( 
					'class' => 'field_advanced' 
				),
			) );

			self::_render_field_setting( $field, array(
				'label'   => __( 'Related Video ID','acf-youtubepicker' ),
				'type'    => 'text',
				'name'    => 'relatedVideoId',
				'wrapper' => array( 
					'class' => 'field_advanced' 
				),
			) );

			self::_render_field_setting( $field, array(
				'label'        => __( 'Topic ID','acf-youtubepicker' ),
				'instructions' => __( 'The value identifies a Freebase topic ID.', 'acf-youtubepicker' ),
				'type'         => 'text',
				'name'         => 'topicId',
				'wrapper'      => array( 
					'class' => 'field_advanced' 
				),
			) );

			self::_render_field_setting( $field, array(
				'label'        => __( 'Region Code','acf-youtubepicker' ),
				'instructions' => sprintf ( __( 'The field value is an <a href="%s" target="_blank">ISO 3166-1 alpha-2</a> country code.', 'acf-youtubepicker' ), 'http://www.iso.org/iso/country_codes/iso_3166_code_lists/country_names_and_code_elements.htm' ),
				'type'         => 'text',
				'name'         => 'regionCode',
				'wrapper'      => array( 
					'class' => 'field_advanced' 
				),
			) );

			self::_render_field_setting( $field, array(
				'label'        => __( 'Relevance Language','acf-youtubepicker' ),
				'instructions' => __( 'The field value is typically an ISO 639-1 two-letter language code.', 'acf-youtubepicker' ),
				'type'         => 'text',
				'name'         => 'relevanceLanguage',
				'wrapper'      => array( 
					'class' => 'field_advanced' 
				),
			) );

		}

		function render_field_settings( $field ) {
			self::create_options( $field );
		}
		
		function create_field( $field ) {
			$field = array_merge( $this->defaults, $field);
			
			if ( 5 == $this->settings['acf_version'] ) {
				$field['value'] = self::_format_value( $field['value'], null, $field );
			}

			self::_search_params( $field ); ?>
			<input type="text" id="<?php echo esc_attr( $field['id'] ); ?>" placeholder="<?php _e( 'search on youtube', 'acf-youtubepicker' ); ?>" name="<?php echo esc_attr( $field['name'] ); ?>" class="acf-youtubepicker-field" data-multiple="<?php echo esc_attr( $field['multiple'] ); ?>" data-key="<?php echo esc_attr( $field['api_key'] ); ?>" data-search-delay="1"<?php if ( ! empty( $field['searchParams'] ) ) : ?> data-search-params='<?php echo json_encode( $field['searchParams'] ); ?>'<?php endif; ?>>
			<div class="acf-<?php echo esc_attr( $this->name ); ?>">
				<div id="<?php echo esc_attr( $field['id'] ); ?>-holder" class="thumbnails<?php if ( $field['multiple'] ) : ?> multiple<?php endif; ?>">
					<div class="inner clearfix ui-sortable"> <?php
			if ( $field['value'] ) :
				foreach ( $field['value'] as $v ) : ?>
					<div class="thumbnail acf-soh">
						<input type="hidden" name="<?php echo esc_attr( $field['name'] ); ?>[]" value="<?php echo esc_attr( json_encode( $v ) ); ?>">
						<div class="inner clearfix">
							<img src="http://i.ytimg.com/vi/<?php echo esc_attr( $v['vid'] ); ?>/default.jpg">
						</div>
						<div class="actions acf-soh-target">
							<a href="#" class="acf-button-delete acf-icon -cancel dark"></a>
						</div>
					</div> <?php 
				endforeach; 
			endif; ?>
					</div>
				</div>
			</div> <?php
		}

		function render_field( $field ) {
			self::create_field( $field );
		}

		function input_admin_enqueue_scripts() {
			$url     = $this->settings['url'];
			$version = $this->settings['version'];
			
			wp_register_script( 'acf-youtubepicker', "{$url}assets/js/youtubepicker.js", array( 'jquery' ), $version );
			wp_register_style( 'acf-youtubepicker', "{$url}assets/css/youtubepicker.css", null, $version );
			
			wp_register_script( 'acf-nanoscroller', "{$url}assets/js/nanoscroller.js", array( 'acf-youtubepicker' ), $version );
			wp_register_style( 'acf-nanoscroller', "{$url}assets/css/nanoscroller.css", array( 'acf-youtubepicker' ), $version );
			
			wp_register_script( 'acf-input-youtubepicker', "{$url}assets/js/input.js", array( 'acf-input', 'acf-youtubepicker' ), $version );
			wp_register_style( 'acf-input-youtubepicker', "{$url}assets/css/input.css", array( 'acf-input' ), $version );
			
			wp_enqueue_script( array( 
				'acf-nanoscroller',
				'acf-youtubepicker',
				'acf-input-youtubepicker',
			) );
			
			wp_enqueue_style( array(
				'acf-youtubepicker',
				'acf-nanoscroller',
				'acf-input-youtubepicker',
			) );
		}

		function field_group_admin_enqueue_scripts() {
			$url     = $this->settings['url'];
			$version = $this->settings['version'];

			wp_register_script( 'acf-field-group-youtubepicker', "{$url}assets/js/field-group.js", array( 'acf-field-group' ), $version );
			wp_register_style( 'acf-field-group-youtubepicker', "{$url}assets/css/field-group.css", array( 'acf-field-group' ), $version );

			wp_enqueue_script( array(
				'acf-field-group-youtubepicker'
			) );

			wp_enqueue_style( array(
				'acf-field-group-youtubepicker'
			) );
		}

		function format_value( $value, $post_id, $field ) {
			if ( 5 == $this->settings['acf_version'] ) {
				$format = 'api';
			} else {
				$format = null;
			}

			return self::_format_value( $value, $post_id, $field, $format );
		}
	
		function format_value_for_api( $value, $post_id, $field ) {
			return self::_format_value( $value, $post_id, $field, 'api' );
		}
		
		protected static function _format_value( $value, $post_id, $field, $format = null ) {
			$data = array();

			if ( is_array( $value ) && count( $value ) > 0 ) {
				$answer_options = $field['answerOptions'];

				if ( ! is_array( $answer_options ) || count( $answer_options ) <= 0 ) {
					$answer_options = $this->defaults['answerOptions'];
				}
				
				foreach ( $value as $k => $v ) {
					if ( $v && ( $v = json_decode( $v, true ) ) ) {
						if ( 'api' === $format ) {
							if ( in_array( 'url', $answer_options ) ) {
								$v['url'] = youtubepicker::url( $v['vid'] );
							}
							
							if ( in_array( 'duration', $answer_options ) ) {
								$v['duration'] = youtubepicker::duration( $v['vid'], $field['api_key'] );
							}

							if ( in_array( 'thumbs', $answer_options ) ) {
								$v['thumbs'] = youtubepicker::thumbs( $v['vid'] );
							}

							if ( in_array( 'iframe', $answer_options ) ) {
								$v['iframe'] = html_entity_decode( youtubepicker::iframe( $v['vid'] ) );
							}
							
							if ( ! in_array( 'title', $answer_options ) ) {
								unset( $v['title'] );
							}

							if ( ! in_array( 'vid', $answer_options ) ) {
								unset( $v['vid'] );
							}

							if ( ! $field['multiple'] ) {
								$data = $v;
							}else{
								$data[$k] = $v;
							}
						}else{
							$data[$k] = $v;
						}
					}
					unset( $value[$k] );
				}
			}

			return $data;
		}

		protected function _render_field_setting( $field, $setting ) {
			if ( function_exists( 'acf_render_field_setting' ) ) {
				acf_render_field_setting( $field, $setting );
			} else {
				$setting['value'] = $field[$setting['name']];
				$setting['name']  = 'fields[' . $field['name'] . '][' . $setting['name'] . ']'; 
				$class = '';
				if ( isset( $setting['class'] ) && $setting['class'] ) {
					$class = ' ' . esc_attr( $setting['class'] ); 
				}

				if ( isset( $setting['wrapper']['class'] ) && $setting['wrapper']['class'] ) {
					$class .= ' ' . esc_attr( $setting['wrapper']['class'] );
				} ?>
				<tr class="field_option field_option_youtubpicker<?php echo $class; ?>">
					<td class="label">
						<label><?php echo esc_attr( $setting['label'] ); ?></label>
						<?php if( isset( $setting['instructions'] ) && ! empty( $setting['instructions'] ) ) : ?>
						<p class="description"><?php esc_attr( $setting['instructions'] ); ?></p>
						<?php endif; ?>
					</td>
					<td><?php do_action( 'acf/create_field', $setting ); ?></td>
				</tr> <?php
			}
		}

		protected static function _search_params( &$data ) {
			$params['searchParams'] = array();
			
			if ( is_array( $data ) && ! empty( $data ) ) {
				foreach ( $data as $k => $v ) {
					if ( in_array( $k, self::$SEARCH_PARAMS ) ) {
						if ( ! empty( $v ) ) {
							$params['searchParams'][$k] = esc_js( $v );
						}
						unset( $data[$k] );
					}
				}
			}

			$data = array_merge( $data, $params );
			
			return $data;
		}

	}

	new acf_field_youtubepicker( $this->settings );

}