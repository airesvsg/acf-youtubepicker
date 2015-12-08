<?php

if( ! defined( 'ABSPATH' ) ) exit;

class acf_field_youtubepicker extends acf_field {
	
	private static $YOUTUBE_PARAMS = array( 
		'channelId', 'channelType', 'eventType', 'order', 'regionCode', 
		'safeSearch', 'topicId', 'videoCaption', 'videoCategoryId', 'videoDefinition', 
		'videoDimension', 'videoDuration', 'videoEmbeddable', 'videoLicense', 
		'videoSyndicated', 'videoType', 'maxResults', 'relatedVideoId', 'relevanceLanguage' 
	);

	/*
	*  __construct
	*
	*  This function will setup the field type data
	*
	*  @type	function
	*  @date	5/03/2014
	*  @since	5.0.0
	*
	*  @param	n/a
	*  @return	n/a
	*/
	
	function __construct() {
		
		/*
		*  name (string) Single word, no spaces. Underscores allowed
		*/
		
		$this->name = 'youtubepicker';
		
		
		/*
		*  label (string) Multiple words, can include spaces, visible when selecting a field type
		*/
		
		$this->label = __('YouTube Picker', 'acf-youtubepicker');
		
		
		/*
		*  category (string) basic | content | choice | relational | jquery | layout | CUSTOM GROUP NAME
		*/
		
		$this->category = 'jquery';
		
		
		/*
		*  defaults (array) Array of default settings which are merged into the field object. These are used later in settings
		*/
		
		$this->defaults = array(
			'api_key'           => 'AIzaSyAuHQVhEmD4m2AXL6TvADwZIxZjNogVRF0',
			'multiple'          => false,
			'channelType'       => 'any',
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
		
		
		/*
		*  l10n (array) Array of strings that are used in JavaScript. This allows JS strings to be translated in PHP and loaded via:
		*  var message = acf._e('youtubepicker', 'error');
		*/
		
		$this->l10n = array(
			'error'	=> __('Error! Please enter a higher value', 'acf-youtubepicker'),
		);
						
		// do not delete!
    	parent::__construct();
    	
	}
	
	
	/*
	*  render_field_settings()
	*
	*  Create extra settings for your field. These are visible when editing a field
	*
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$field (array) the $field being edited
	*  @return	n/a
	*/
	
	function render_field_settings( $field ) {
			
		acf_render_field_setting( $field, array(
			'label'        => __('API KEY - YouTube Data API','acf-youtubepicker'),
			'instructions' => sprintf( __('<a href="%s" target="_blank">click here</a> for you know how to obtain the api key','acf-youtubepicker'), 'https://developers.google.com/youtube/v3/getting-started' ),
			'type'         => 'text',
			'name'         => 'api_key',
		));

		acf_render_field_setting( $field, array(
			'label'   => __('Select multiple videos?','acf-youtubepicker'),
			'type'    => 'radio',
			'name'    => 'multiple',
			'layout'  => 'horizontal',
			'choices' => array(
				1 => __('Yes', 'acf-youtubepicker'),
				0 => __('No', 'acf-youtubepicker'),
			)
		));

		acf_render_field_setting( $field, array(
			'label'        => __('Advanced Options','acf-youtubepicker'),
			'instructions' => __('Set advanced options for YouTube Picker.','acf-youtubepicker'),
			'type'         => 'radio',
			'name'         => 'yp_advanced_options',
			'layout'       => 'horizontal',
			'value'        => 0,
			'class'        => 'yp-advanced-options',
			'choices'      => array(
				1 => __('Show', 'acf-youtubepicker'),
				0 => __('Hide', 'acf-youtubepicker'),
			)
		));

		acf_render_field_setting( $field, array(
			'label'   => __('Answer Options','acf-youtubepicker'),
			'type'    => 'checkbox',
			'name'    => 'answerOptions',
			'layout'  => 'horizontal',
			'wrapper' => array( 
				'class' => 'field_advanced' 
			),
			'choices' => array(
				'title'    => __('Title', 'acf-youtubepicker'),
				'vid'      => __('Video ID', 'acf-youtubepicker'),
				'url'      => __('Video URL', 'acf-youtubepicker'),
				'thumbs'   => __('Video thumbnails', 'acf-youtubepicker'),
				'duration' => __('Duration', 'acf-youtubepicker'),
				'iframe'   => __('Embed Code', 'acf-youtubepicker'),
			),
		));

		acf_render_field_setting( $field, array(
			'label'   => __('Channel ID','acf-youtubepicker'),
			'type'    => 'text',
			'name'    => 'channelId',
			'wrapper' => array( 
				'class' => 'field_advanced' 
			),
		));

		acf_render_field_setting( $field, array(
			'label'   => __('Channel Type','acf-youtubepicker'),
			'type'    => 'radio',
			'name'    => 'channelType',
			'layout'  => 'horizontal',
			'wrapper' => array( 
				'class' => 'field_advanced' 
			),
			'choices' => array(
				'any'  => __('Any', 'acf-youtubepicker'),
				'show' => __('Show', 'acf-youtubepicker'),
			),
		));

		acf_render_field_setting( $field, array(
			'label'   => __('Event Type','acf-youtubepicker'),
			'type'    => 'select',
			'name'    => 'eventType',
			'wrapper' => array( 
				'class' => 'field_advanced' 
			),
			'choices' => array(
				''          => __('-- choose --', 'acf-youtubepicker'),
				'completed' => __('Completed', 'acf-youtubepicker'),
				'live'      => __('Live', 'acf-youtubepicker'),
				'upcoming'  => __('Upcoming', 'acf-youtubepicker'),
			),
		));

		acf_render_field_setting( $field, array(
			'label'   => __('Order','acf-youtubepicker'),
			'type'    => 'radio',
			'name'    => 'order',
			'layout'  => 'horizontal',
			'wrapper' => array( 
				'class' => 'field_advanced' 
			),
			'choices' => array(
				'date'       => __('Date', 'acf-youtubepicker'),
				'rating'     => __('Rating', 'acf-youtubepicker'),
				'relevance'  => __('Relevance', 'acf-youtubepicker'),
				'title'      => __('Title', 'acf-youtubepicker'),
				'videoCount' => __('Video Count', 'acf-youtubepicker'),
				'viewCount'  => __('View Count', 'acf-youtubepicker'),
			)
		));

		acf_render_field_setting( $field, array(
			'label'   => __('Safe Search','acf-youtubepicker'),
			'type'    => 'radio',
			'name'    => 'safeSearch',
			'layout'  => 'horizontal',
			'wrapper' => array( 
				'class' => 'field_advanced' 
			),
			'choices' => array(
				'moderate' => __('Moderate', 'acf-youtubepicker'), 
				'none'     => __('None', 'acf-youtubepicker'), 
				'strict'   => __('Strict', 'acf-youtubepicker')
			)
		));

		acf_render_field_setting( $field, array(
			'label'   => __('Video Caption','acf-youtubepicker'),
			'type'    => 'radio',
			'name'    => 'videoCaption',
			'layout'  => 'horizontal',
			'wrapper' => array( 
				'class' => 'field_advanced' 
			),
			'choices' => array(
				'any'           => __('Any', 'acf-youtubepicker'), 
				'closedCaption' => __('Closed Caption', 'acf-youtubepicker'), 
				'none'          => __('None', 'acf-youtubepicker'),
			)
		));

		acf_render_field_setting( $field, array(
			'label'   => __('Video Definition','acf-youtubepicker'),
			'type'    => 'radio',
			'name'    => 'videoDefinition',
			'layout'  => 'horizontal',
			'wrapper' => array( 
				'class' => 'field_advanced' 
			),
			'choices' => array(
				'any'      => __('Any', 'acf-youtubepicker'), 
				'high'     => __('High', 'acf-youtubepicker'), 
				'standard' => __('Standard', 'acf-youtubepicker'),
			)
		));

		acf_render_field_setting( $field, array(
			'label'   => __('Video Dimension','acf-youtubepicker'),
			'type'    => 'radio',
			'name'    => 'videoDimension',
			'layout'  => 'horizontal',
			'wrapper' => array( 
				'class' => 'field_advanced' 
			),
			'choices' => array(
				'any' => __('Any', 'acf-youtubepicker'), 
				'2d'  => __('2d', 'acf-youtubepicker'), 
				'3d'  => __('3d', 'acf-youtubepicker'),
			)
		));

		acf_render_field_setting( $field, array(
			'label'   => __('Video Duration','acf-youtubepicker'),
			'type'    => 'radio',
			'name'    => 'videoDuration',
			'layout'  => 'horizontal',
			'wrapper' => array( 
				'class' => 'field_advanced' 
			),
			'choices' => array(
				'any'    => __('Any', 'acf-youtubepicker'), 
				'long'   => __('long', 'acf-youtubepicker'), 
				'medium' => __('medium', 'acf-youtubepicker'),
				'short'  => __('short', 'acf-youtubepicker'),
			)
		));

		acf_render_field_setting( $field, array(
			'label'   => __('Video Embeddable','acf-youtubepicker'),
			'type'    => 'radio',
			'name'    => 'videoEmbeddable',
			'layout'  => 'horizontal',
			'wrapper' => array( 
				'class' => 'field_advanced' 
			),
			'choices' => array(
				'true' => __('Yes', 'acf-youtubepicker'), 
				'any'  => __('No', 'acf-youtubepicker'),
			)
		));

		acf_render_field_setting( $field, array(
			'label'   => __('Video License','acf-youtubepicker'),
			'type'    => 'radio',
			'name'    => 'videoLicense',
			'layout'  => 'horizontal',
			'wrapper' => array( 
				'class' => 'field_advanced' 
			),
			'choices' => array(
				'any'            => __('Any', 'acf-youtubepicker'),
				'creativeCommon' => __('Creative Common', 'acf-youtubepicker'), 
				'youtube'        => __('YouTube', 'acf-youtubepicker'), 
			)
		));

		acf_render_field_setting( $field, array(
			'label'   => __('Video Syndicated','acf-youtubepicker'),
			'type'    => 'radio',
			'name'    => 'videoSyndicated',
			'layout'  => 'horizontal',
			'wrapper' => array( 
				'class' => 'field_advanced' 
			),
			'choices' => array(
				'true' => __('Yes', 'acf-youtubepicker'),
				'any'  => __('No', 'acf-youtubepicker'),
			)
		));

		acf_render_field_setting( $field, array(
			'label'   => __('Video Type','acf-youtubepicker'),
			'type'    => 'radio',
			'name'    => 'videoType',
			'layout'  => 'horizontal',
			'wrapper' => array( 
				'class' => 'field_advanced' 
			),
			'choices' => array(
				'any'     => __('Any', 'acf-youtubepicker'),
				'episode' => __('Episode', 'acf-youtubepicker'),
				'movie'   => __('Movie', 'acf-youtubepicker'),
			)
		));

		acf_render_field_setting( $field, array(
			'label'   => __('Video Category ID','acf-youtubepicker'),
			'type'    => 'text',
			'name'    => 'videoCategoryId',
			'wrapper' => array( 
				'class' => 'field_advanced' 
			),
		));

		acf_render_field_setting( $field, array(
			'label'   => __('Related Video ID','acf-youtubepicker'),
			'type'    => 'text',
			'name'    => 'relatedVideoId',
			'wrapper' => array( 
				'class' => 'field_advanced' 
			),
		));

		acf_render_field_setting( $field, array(
			'label'        => __('Topic ID','acf-youtubepicker'),
			'instructions' => __('The value identifies a Freebase topic ID.', 'acf-youtubepicker'),
			'type'         => 'text',
			'name'         => 'topicId',
			'wrapper'      => array( 
				'class' => 'field_advanced' 
			),
		));

		acf_render_field_setting( $field, array(
			'label'        => __('Region Code','acf-youtubepicker'),
			'instructions' => sprintf(__('The field value is an <a href="%s" target="_blank">ISO 3166-1 alpha-2</a> country code.', 'acf-youtubepicker'), 'http://www.iso.org/iso/country_codes/iso_3166_code_lists/country_names_and_code_elements.htm'),
			'type'         => 'text',
			'name'         => 'regionCode',
			'wrapper'      => array( 
				'class' => 'field_advanced' 
			),
		));

		acf_render_field_setting( $field, array(
			'label'        => __('Relevance Language','acf-youtubepicker'),
			'instructions' => __('The field value is typically an ISO 639-1 two-letter language code.', 'acf-youtubepicker'),
			'type'         => 'text',
			'name'         => 'relevanceLanguage',
			'wrapper'      => array( 
				'class' => 'field_advanced' 
			),
		));

	}
		
	/*
	*  render_field()
	*
	*  Create the HTML interface for your field
	*
	*  @param	$field (array) the $field being rendered
	*
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$field (array) the $field being edited
	*  @return	n/a
	*/
	
	function render_field( $field ) {

		if(!array_key_exists('api_key', $field) || empty($field['api_key'])){
			echo '<p>'.__('Please, set your api key.', 'acf').'</p>';
			return;
		}

		$field['value'] = $this->_format_value( $field['value'], null, $field );

		$options = array();
		foreach( self::$YOUTUBE_PARAMS as $p ) {
			if( array_key_exists($p, $field ) ) {
				$options[$p] = esc_js( $field[$p] );
			}
		}
		$options['type'] = 'video';

		?>
		<input type="text" id="<?php echo esc_attr( $field['key'] ); ?>" name="<?php echo esc_attr( $field['name'] ); ?>" data-name="<?php echo esc_attr( $field['name'] ); ?>" class="acf-<?php echo esc_attr( $this->name ); ?>-field" data-pro="true" data-multiple="<?php echo esc_attr( $field['multiple'] ); ?>"  data-api-key="<?php echo $field['api_key']; ?>" data-options="<?php echo json_encode( $options ); ?>">
		<div class="acf-<?php echo esc_attr($this->name); ?>">		
			<div id="<?php echo esc_attr($field['key']); ?>-holder" class="thumbnails<?php echo ($field['multiple'] ? ' multiple' : ''); ?>">
				<div class="inner clearfix ui-sortable">
		<?php
		if($field['value']):
			foreach($field['value'] as $v): ?>
				<div class="thumbnail">
					<input type="hidden" name="<?php echo esc_attr($field['name']); ?>[]" value="<?php echo esc_attr(json_encode($v)); ?>">
					<div class="inner clearfix">
						<img src="http://i.ytimg.com/vi/<?php echo esc_attr($v['vid']); ?>/default.jpg">
					</div>
					<div class="hover">
						<ul class="bl">
							<li>
								<a href="#" class="acf-button-delete acf-icon">
									<i class="acf-sprite-delete"></i>
								</a>
							</li>
						</ul>
					</div>
				</div>
		<?php 
			endforeach; 
		endif; ?>
				</div>
			</div>
		</div>
		<?php
	}
	
		
	/*
	*  input_admin_enqueue_scripts()
	*
	*  This action is called in the admin_enqueue_scripts action on the edit screen where your field is created.
	*  Use this action to add CSS + JavaScript to assist your render_field() action.
	*
	*  @type	action (admin_enqueue_scripts)
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	n/a
	*  @return	n/a
	*/
	
	function input_admin_enqueue_scripts() {		
		$dir = plugin_dir_url( __FILE__ );

		wp_register_script( 'acf-nanoscroller', "{$dir}js/nanoscroller.js" );
		wp_register_script( 'acf-youtubepicker', "{$dir}js/youtubepicker.js" );
		wp_register_script( 'acf-input-youtubepicker', "{$dir}js/input.js" );
		
		wp_register_style( 'acf-youtubepicker', "{$dir}css/youtubepicker.css" ); 
		wp_register_style( 'acf-nanoscroller', "{$dir}css/nanoscroller.css" ); 
		wp_register_style( 'acf-input-youtubepicker', "{$dir}css/input.css" );
			
		// scripts
		wp_enqueue_script(array(
			'acf-nanoscroller',	
			'acf-youtubepicker',	
			'acf-input-youtubepicker',	
			'jquery-ui-sortable',
		));

		// styles
		wp_enqueue_style(array(
			'acf-youtubepicker',	
			'acf-nanoscroller',	
			'acf-input-youtubepicker',	
		));
	}
	
	/*
	*  field_group_admin_enqueue_scripts()
	*
	*  This action is called in the admin_enqueue_scripts action on the edit screen where your field is edited.
	*  Use this action to add CSS + JavaScript to assist your render_field_options() action.
	*
	*  @type	action (admin_enqueue_scripts)
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	n/a
	*  @return	n/a
	*/

	function field_group_admin_enqueue_scripts() {
		$dir = plugin_dir_url( __FILE__ );

		wp_register_script( 'acf-field-group-youtubepicker', "{$dir}js/field-group.js");
		wp_register_style( 'acf-field-group-youtubepicker', "{$dir}css/field-group.css");

		wp_enqueue_script(array('acf-field-group-youtubepicker'));
		wp_enqueue_style(array('acf-field-group-youtubepicker'));		
	}
	
	/*
	*  format_value()
	*
	*  This filter is appied to the $value after it is loaded from the db and before it is returned to the template
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$value (mixed) the value which was loaded from the database
	*  @param	$post_id (mixed) the $post_id from which the value was loaded
	*  @param	$field (array) the field array holding all the field options
	*
	*  @return	$value (mixed) the modified value
	*/
			
	function format_value( $value, $post_id, $field ) {
		return $this->_format_value( $value, $post_id, $field, 'api' );
	}

	private function _format_value( $value, $post_id = null, $field = null, $format = null ) {
		$data = array();
		if( is_array( $value ) && count( $value ) > 0 ) {
			$answer_options = $field['answerOptions'];
			if( ! is_array( $answer_options) || count( $answer_options ) <= 0 ) {
				$answer_options = $this->defaults['answerOptions'];
			}
			foreach( $value as $k => $v ) {
				if( $v && ( $v = json_decode( $v, true ) ) ) {
					if( 'api' === $format ) {
						if( in_array( 'url', $answer_options ) ) {
							$v['url'] = youtubepicker::url( $v['vid'] );
						}
						
						if( in_array( 'duration', $answer_options ) ) {
							$v['duration'] = youtubepicker::duration( $v['vid'], $field['api_key'] );
						}

						if( in_array( 'thumbs', $answer_options ) ) {
							$v['thumbs'] = youtubepicker::thumbs( $v['vid'] );
						}

						if( in_array( 'iframe', $answer_options ) ) {
							$v['iframe'] = html_entity_decode( youtubepicker::iframe( $v['vid'] ) );
						}
						
						if( ! in_array( 'title', $answer_options ) ) {
							unset( $v['title'] );
						}

						if( ! in_array( 'vid', $answer_options ) ) {
							unset( $v['vid'] );
						}

						if( ! $field['multiple'] ) {
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
	
}

new acf_field_youtubepicker();