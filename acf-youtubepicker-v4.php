<?php

if( ! defined( 'ABSPATH' ) ) exit;

class acf_field_youtubepicker extends acf_field {
	
	// vars
	var $settings, // will hold info such as dir / path
		$defaults; // will hold default field options
		
	private static $YOUTUBE_PARAMS = array( 
		'channelId', 'channelType', 'eventType', 'order', 'regionCode', 
		'safeSearch', 'topicId', 'videoCaption', 'videoCategoryId', 'videoDefinition', 
		'videoDimension', 'videoDuration', 'videoEmbeddable', 'videoLicense', 
		'videoSyndicated', 'videoType', 'maxResults', 'relatedVideoId', 'relevanceLanguage' 
	);

	/*
	*  __construct
	*
	*  Set name / label needed for actions / filters
	*
	*  @since	3.6
	*  @date	23/01/13
	*/
	
	function __construct() {
		$this->name     = 'youtubepicker';
		$this->label    = __('YouTube Picker');
		$this->category = __("jQuery",'acf'); // Basic, Content, Choice, etc
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

		// do not delete!
    	parent::__construct();
    	
    	$this->settings = array(
			'path'    => apply_filters('acf/helpers/get_path', __FILE__),
			'dir'     => apply_filters('acf/helpers/get_dir', __FILE__),
			'version' => '2.0.0'
		);
	}
	
	
	/*
	*  create_options()
	*
	*  Create extra options for your field. This is rendered when editing a field.
	*  The value of $field['name'] can be used (like below) to save extra data to the $field
	*
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$field	- an array holding all the field's data
	*/
	
	function create_options( $field ) {
		$field = array_merge($this->defaults, $field);
		$key = $field['name'];
		
		?>
<tr class="field_option field_option_<?php echo $this->name; ?>">
	<td class="label">
		<label><?php _e("API KEY - YouTube Data API",'acf-youtubepicker'); ?></label>
		<p class="description"><?php echo sprintf( __('<a href="%s" target="_blank">click here</a> for you know how to obtain the api key','acf'), 'https://developers.google.com/youtube/v3/getting-started' ); ?></p>
	</td>
	<td>
		<?php
		
		do_action('acf/create_field', array(
			'type'   =>	'text',
			'name'   =>	'fields['.$key.'][api_key]',
			'value'  =>	$field['api_key']
		));
		
		?>
	</td>
</tr>

<tr class="field_option field_option_<?php echo $this->name; ?>">
	<td class="label">
		<label><?php _e("Select multiple videos?",'acf-youtubepicker'); ?></label>
	</td>
	<td>
		<?php
		
		do_action('acf/create_field', array(
			'type'		=>	'radio',
			'name'		=>	'fields['.$key.'][multiple]',
			'value'		=>	$field['multiple'],
			'layout'	=>	'horizontal',
			'choices'	=>	array(
				1 => __('Yes', 'acf-youtubepicker'),
				0 => __('No', 'acf-youtubepicker'),
			)
		));
		
		?>
	</td>
</tr>

<tr class="acf-field field_type-radio" data-name="yp_advanced_options" data-type="radio" data-setting="youtubepicker">
	<td class="label">
		<label>Advanced Options</label>
		<p class="description"><?php _e("Set advanced options for YouTube Picker.", 'acf-youtubepicker'); ?></p>
	</td>
	<td>
		<?php
		
		do_action('acf/create_field', array(
			'type'    =>	'radio',
			'name'    =>	'fields['.$key.'][yp_advanced_options]',
			'value'   =>	0,
			'layout'  =>	'horizontal',
			'class'   => 'yp-advanced-options',
			'choices' =>	array(
				1 => __('Show', 'acf-youtubepicker'),
				0 => __('Hide', 'acf-youtubepicker'),
			)
		));
		
		?>
	</td>
</tr>

<tr class="field_option field_option_<?php echo $this->name; ?> field_advanced">
	<td class="label">
		<label><?php _e("Answer Options",'acf-youtubepicker'); ?></label>
	</td>
	<td>
		<?php
		
		do_action('acf/create_field', array(
			'type'		=>	'checkbox',
			'name'		=>	'fields['.$key.'][answerOptions]',
			'value'		=>	$field['answerOptions'],
			'layout'	=>	'horizontal',
			'choices'	=>	array(
				'title'    => __('Title', 'acf-youtubepicker'),
				'vid'      => __('Video ID', 'acf-youtubepicker'),
				'url'      => __('Video URL', 'acf-youtubepicker'),
				'thumbs'   => __('Video thumbnails', 'acf-youtubepicker'),
				'duration' => __('Duration', 'acf-youtubepicker'),
				'iframe'   => __('Embed Code', 'acf-youtubepicker'),
			),
		));
		
		?>
	</td>
</tr>

<tr class="field_option field_option_<?php echo $this->name; ?> field_advanced">
	<td class="label">
		<label><?php _e("Channel ID",'acf-youtubepicker'); ?></label>
	</td>
	<td>
		<?php
		
		do_action('acf/create_field', array(
			'type'		=>	'text',
			'name'		=>	'fields['.$key.'][channelId]',
			'value'		=>	$field['channelId'],
			'layout'	=>	'horizontal',
		));
		
		?>
	</td>
</tr>

<tr class="field_option field_option_<?php echo $this->name; ?> field_advanced">
	<td class="label">
		<label><?php _e("Channel Type",'acf-youtubepicker'); ?></label>
	</td>
	<td>
		<?php
		
		do_action('acf/create_field', array(
			'type'		=>	'radio',
			'name'		=>	'fields['.$key.'][channelType]',
			'value'		=>	$field['channelType'],
			'layout'	=>	'horizontal',
			'choices'	=>	array(
				'any'  => __('Any', 'acf-youtubepicker'),
				'show' => __('Show', 'acf-youtubepicker'),
			)
		));
		
		?>
	</td>
</tr>

<tr class="field_option field_option_<?php echo $this->name; ?> field_advanced">
	<td class="label">
		<label><?php _e("Event Type",'acf-youtubepicker'); ?></label>
	</td>
	<td>
		<?php
		
		do_action('acf/create_field', array(
			'type'		=>	'select',
			'name'		=>	'fields['.$key.'][eventType]',
			'value'		=>	$field['eventType'],
			'layout'	=>	'horizontal',
			'choices'	=>	array(
				''          => __('-- choose --', 'acf-youtubepicker'),
				'completed' => __('Completed', 'acf-youtubepicker'),
				'live'      => __('Live', 'acf-youtubepicker'),
				'upcoming'  => __('Upcoming', 'acf-youtubepicker'),
			)
		));
		
		?>
	</td>
</tr>

<tr class="field_option field_option_<?php echo $this->name; ?> field_advanced">
	<td class="label">
		<label><?php _e("Order",'acf-youtubepicker'); ?></label>
	</td>
	<td>
		<?php
		
		do_action('acf/create_field', array(
			'type'		=>	'radio',
			'name'		=>	'fields['.$key.'][order]',
			'value'		=>	$field['order'],
			'layout'	=>	'horizontal',
			'choices'	=>	array(
				'date'       => __('Date', 'acf-youtubepicker'),
				'rating'     => __('Rating', 'acf-youtubepicker'),
				'relevance'  => __('Relevance', 'acf-youtubepicker'),
				'title'      => __('Title', 'acf-youtubepicker'),
				'videoCount' => __('Video Count', 'acf-youtubepicker'),
				'viewCount'  => __('View Count', 'acf-youtubepicker'),
			)
		));
		
		?>
	</td>
</tr>

<tr class="field_option field_option_<?php echo $this->name; ?> field_advanced">
	<td class="label">
		<label><?php _e("Safe Search",'acf-youtubepicker'); ?></label>
	</td>
	<td>
		<?php
		
		do_action('acf/create_field', array(
			'type'		=>	'radio',
			'name'		=>	'fields['.$key.'][safeSearch]',
			'value'		=>	$field['safeSearch'],
			'layout'	=>	'horizontal',
			'choices'	=>	array(
				'moderate' => __('Moderate', 'acf-youtubepicker'), 
				'none'     => __('None', 'acf-youtubepicker'), 
				'strict'   => __('Strict', 'acf-youtubepicker')
			)
		));
		
		?>
	</td>
</tr>

<tr class="field_option field_option_<?php echo $this->name; ?> field_advanced">
	<td class="label">
		<label><?php _e("Video Caption",'acf-youtubepicker'); ?></label>
	</td>
	<td>
		<?php
		
		do_action('acf/create_field', array(
			'type'		=>	'radio',
			'name'		=>	'fields['.$key.'][videoCaption]',
			'value'		=>	$field['videoCaption'],
			'layout'	=>	'horizontal',
			'choices'	=>	array(
				'any'           => __('Any', 'acf-youtubepicker'), 
				'closedCaption' => __('Closed Caption', 'acf-youtubepicker'), 
				'none'          => __('None', 'acf-youtubepicker'),
			)
		));
		
		?>
	</td>
</tr>

<tr class="field_option field_option_<?php echo $this->name; ?> field_advanced">
	<td class="label">
		<label><?php _e("Video Definition",'acf-youtubepicker'); ?></label>
	</td>
	<td>
		<?php
		
		do_action('acf/create_field', array(
			'type'		=>	'radio',
			'name'		=>	'fields['.$key.'][videoDefinition]',
			'value'		=>	$field['videoDefinition'],
			'layout'	=>	'horizontal',
			'choices'	=>	array(
				'any'      => __('Any', 'acf-youtubepicker'), 
				'high'     => __('High', 'acf-youtubepicker'), 
				'standard' => __('Standard', 'acf-youtubepicker'),
			)
		));
		
		?>
	</td>
</tr>

<tr class="field_option field_option_<?php echo $this->name; ?> field_advanced">
	<td class="label">
		<label><?php _e("Video Dimension",'acf-youtubepicker'); ?></label>
	</td>
	<td>
		<?php
		
		do_action('acf/create_field', array(
			'type'		=>	'radio',
			'name'		=>	'fields['.$key.'][videoDimension]',
			'value'		=>	$field['videoDimension'],
			'layout'	=>	'horizontal',
			'choices'	=>	array(
				'any' => __('Any', 'acf-youtubepicker'), 
				'2d'  => __('2d', 'acf-youtubepicker'), 
				'3d'  => __('3d', 'acf-youtubepicker'),
			)
		));
		
		?>
	</td>
</tr>

<tr class="field_option field_option_<?php echo $this->name; ?> field_advanced">
	<td class="label">
		<label><?php _e("Video Duration",'acf-youtubepicker'); ?></label>
	</td>
	<td>
		<?php
		
		do_action('acf/create_field', array(
			'type'		=>	'radio',
			'name'		=>	'fields['.$key.'][videoDuration]',
			'value'		=>	$field['videoDuration'],
			'layout'	=>	'horizontal',
			'choices'	=>	array(
				'any'    => __('Any', 'acf-youtubepicker'), 
				'long'   => __('long', 'acf-youtubepicker'), 
				'medium' => __('medium', 'acf-youtubepicker'),
				'short'  => __('short', 'acf-youtubepicker'),
			)
		));
		
		?>
	</td>
</tr>

<tr class="field_option field_option_<?php echo $this->name; ?> field_advanced">
	<td class="label">
		<label><?php _e("Video Embeddable",'acf-youtubepicker'); ?></label>
	</td>
	<td>
		<?php
		
		do_action('acf/create_field', array(
			'type'		=>	'radio',
			'name'		=>	'fields['.$key.'][videoEmbeddable]',
			'value'		=>	$field['videoEmbeddable'],
			'layout'	=>	'horizontal',
			'choices'	=>	array(
				'true' => __('Yes', 'acf-youtubepicker'), 
				'any'  => __('No', 'acf-youtubepicker'),
			)
		));
		
		?>
	</td>
</tr>

<tr class="field_option field_option_<?php echo $this->name; ?> field_advanced">
	<td class="label">
		<label><?php _e("Video License",'acf-youtubepicker'); ?></label>
	</td>
	<td>
		<?php
		
		do_action('acf/create_field', array(
			'type'		=>	'radio',
			'name'		=>	'fields['.$key.'][videoLicense]',
			'value'		=>	$field['videoLicense'],
			'layout'	=>	'horizontal',
			'choices'	=>	array(
				'any'            => __('Any', 'acf-youtubepicker'),
				'creativeCommon' => __('Creative Common', 'acf-youtubepicker'), 
				'youtube'        => __('YouTube', 'acf-youtubepicker'), 
			)
		));
		
		?>
	</td>
</tr>

<tr class="field_option field_option_<?php echo $this->name; ?> field_advanced">
	<td class="label">
		<label><?php _e("Video Syndicated",'acf-youtubepicker'); ?></label>
		<p class="description"><?php echo _e('The Video Syndicated lets you to restrict a search to only videos that can be played outside youtube.com', 'acf'); ?></p>
	</td>
	<td>
		<?php
		
		do_action('acf/create_field', array(
			'type'		=>	'radio',
			'name'		=>	'fields['.$key.'][videoSyndicated]',
			'value'		=>	$field['videoSyndicated'],
			'layout'	=>	'horizontal',
			'choices'	=>	array(
				'true' => __('Yes', 'acf-youtubepicker'),
				'any'  => __('No', 'acf-youtubepicker'),
			)
		));
		
		?>
	</td>
</tr>

<tr class="field_option field_option_<?php echo $this->name; ?> field_advanced">
	<td class="label">
		<label><?php _e("Video Type",'acf-youtubepicker'); ?></label>
	</td>
	<td>
		<?php
		
		do_action('acf/create_field', array(
			'type'		=>	'radio',
			'name'		=>	'fields['.$key.'][videoType]',
			'value'		=>	$field['videoType'],
			'layout'	=>	'horizontal',
			'choices'	=>	array(
				'any'     => __('Any', 'acf-youtubepicker'),
				'episode' => __('Episode', 'acf-youtubepicker'),
				'movie'   => __('Movie', 'acf-youtubepicker'),
			)
		));
		
		?>
	</td>
</tr>

<tr class="field_option field_option_<?php echo $this->name; ?> field_advanced">
	<td class="label">
		<label><?php _e("Video Category ID",'acf-youtubepicker'); ?></label>
	</td>
	<td>
		<?php
		
		do_action('acf/create_field', array(
			'type'		=>	'text',
			'name'		=>	'fields['.$key.'][videoCategoryId]',
			'value'		=>	$field['videoCategoryId'],
			'layout'	=>	'horizontal',
		));
		
		?>
	</td>
</tr>

<tr class="field_option field_option_<?php echo $this->name; ?> field_advanced">
	<td class="label">
		<label><?php _e("Related Video ID",'acf-youtubepicker'); ?></label>
	</td>
	<td>
		<?php
		
		do_action('acf/create_field', array(
			'type'		=>	'text',
			'name'		=>	'fields['.$key.'][relatedVideoId]',
			'value'		=>	$field['relatedVideoId'],
			'layout'	=>	'horizontal',
		));
		
		?>
	</td>
</tr>

<tr class="field_option field_option_<?php echo $this->name; ?> field_advanced">
	<td class="label">
		<label><?php _e("Topic ID",'acf-youtubepicker'); ?></label>
		<p class="description"><?php _e('The value identifies a Freebase topic ID.', 'acf'); ?></p>
	</td>
	<td>
		<?php
		
		do_action('acf/create_field', array(
			'type'		=>	'text',
			'name'		=>	'fields['.$key.'][topicId]',
			'value'		=>	$field['topicId'],
			'layout'	=>	'horizontal',
		));
		
		?>
	</td>
</tr>

<tr class="field_option field_option_<?php echo $this->name; ?> field_advanced">
	<td class="label">
		<label><?php _e("Region Code",'acf-youtubepicker'); ?></label>
		<p class="description"><?php echo sprintf(__('The field value is an <a href="%s" target="_blank">ISO 3166-1 alpha-2</a> country code.', 'acf'), 'http://www.iso.org/iso/country_codes/iso_3166_code_lists/country_names_and_code_elements.htm'); ?></p>
	</td>
	<td>
		<?php
		
		do_action('acf/create_field', array(
			'type'		=>	'text',
			'name'		=>	'fields['.$key.'][regionCode]',
			'value'		=>	$field['regionCode'],
			'layout'	=>	'horizontal',
		));
		
		?>
	</td>
</tr>

<tr class="field_option field_option_<?php echo $this->name; ?> field_advanced">
	<td class="label">
		<label><?php _e("Relevance Language",'acf-youtubepicker'); ?></label>
		<p class="description"><?php _e('The field value is typically an ISO 639-1 two-letter language code.', 'acf'); ?></p>
	</td>
	<td>
		<?php
		
		do_action('acf/create_field', array(
			'type'		=>	'text',
			'name'		=>	'fields['.$key.'][relevanceLanguage]',
			'value'		=>	$field['relevanceLanguage'],
			'layout'	=>	'horizontal',
		));
		
		?>
	</td>
</tr>
		<?php	
	}
	
	
	/*
	*  create_field()
	*
	*  Create the HTML interface for your field
	*
	*  @param	$field - an array holding all the field's data
	*
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*/
	
	function create_field( $field )	{
		$field = array_merge($this->defaults, $field);
		
		if(!array_key_exists('api_key', $field) || empty($field['api_key'])){
		?>
			<p><?php _e('Please, set your api key.', 'acf'); ?></p>
		<?php
			return;
		}

		$options = array();
		
		foreach( self::$YOUTUBE_PARAMS as $p ) {
			if( array_key_exists($p, $field ) ) {
				$options[$p] = esc_js( $field[$p] );
			}
		}
		
		$options['type'] = 'video';
		
		?>
		<input type="text" id="<?php echo esc_attr( $field['id'] ); ?>" name="<?php echo esc_attr( $field['name'] ); ?>" class="acf-<?php echo esc_attr( $this->name ); ?>-field" data-multiple="<?php echo esc_attr( $field['multiple'] ); ?>" data-api-key="<?php echo $field['api_key']; ?>" data-options="<?php echo json_encode( $options ); ?>">
		<div class="acf-<?php echo esc_attr($this->name); ?>">
			<div id="<?php echo esc_attr($field['id']); ?>-holder" class="thumbnails<?php echo ($field['multiple'] ? ' multiple' : ''); ?>">
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
							<li><a href="#" class="acf-button-delete ir">remove</a></li>
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
	*  Use this action to add CSS + JavaScript to assist your create_field() action.
	*
	*  $info	http://codex.wordpress.org/Plugin_API/Action_Reference/admin_enqueue_scripts
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*/

	function input_admin_enqueue_scripts() {
		wp_register_script( 'acf-nanoscroller', $this->settings['dir'] . 'js/nanoscroller.js', array('acf-input'), $this->settings['version'] );
		wp_register_script( 'acf-youtubepicker', $this->settings['dir'] . 'js/youtubepicker.js', array('acf-input'), $this->settings['version'] );
		wp_register_script( 'acf-input-youtubepicker', $this->settings['dir'] . 'js/input.js', array('acf-input'), $this->settings['version'] );
		
		wp_register_style( 'acf-youtubepicker', $this->settings['dir'] . 'css/youtubepicker.css', array('acf-input'), $this->settings['version'] ); 
		wp_register_style( 'acf-nanoscroller', $this->settings['dir'] . 'css/nanoscroller.css', array('acf-input'), $this->settings['version'] ); 
		wp_register_style( 'acf-input-youtubepicker', $this->settings['dir'] . 'css/input.css', array('acf-input'), $this->settings['version'] );
			
		wp_enqueue_script(array(
			'acf-nanoscroller',	
			'acf-youtubepicker',	
			'acf-input-youtubepicker',	
			'jquery-ui-sortable',
		));

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
	*  Use this action to add CSS + JavaScript to assist your create_field_options() action.
	*
	*  $info	http://codex.wordpress.org/Plugin_API/Action_Reference/admin_enqueue_scripts
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*/

	function field_group_admin_enqueue_scripts() {
		wp_register_script( 'acf-field-group-youtubepicker', $this->settings['dir'] . 'js/field-group.js', array('acf-field-group'), $this->settings['version'] );
		wp_register_style( 'acf-field-group-youtubepicker', $this->settings['dir'] . 'css/field-group.css', array('acf-field-group'), $this->settings['version'] );

		wp_enqueue_script(array(
			'acf-field-group-youtubepicker'
		));

		wp_enqueue_style(array(
			'acf-field-group-youtubepicker'
		));
	}

	/*
	*  format_value()
	*
	*  This filter is applied to the $value after it is loaded from the db and before it is passed to the create_field action
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$value	- the value which was loaded from the database
	*  @param	$post_id - the $post_id from which the value was loaded
	*  @param	$field	- the field array holding all the field options
	*
	*  @return	$value	- the modified value
	*/
	
	function format_value( $value, $post_id, $field ) {
		return $this->_format_value( $value, $post_id, $field );
	}
	
	
	/*
	*  format_value_for_api()
	*
	*  This filter is applied to the $value after it is loaded from the db and before it is passed back to the API functions such as the_field
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$value	- the value which was loaded from the database
	*  @param	$post_id - the $post_id from which the value was loaded
	*  @param	$field	- the field array holding all the field options
	*
	*  @return	$value	- the modified value
	*/
	
	function format_value_for_api( $value, $post_id, $field ) {
		return $this->_format_value( $value, $post_id, $field, 'api' );
	}

	private function _format_value( $value, $post_id, $field, $format = null ) {
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