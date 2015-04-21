<?php

if( ! defined( 'ABSPATH' ) ) exit;

class acf_field_youtubepicker extends acf_field {
	
	var $settings,
		$defaults;
		
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
			'multiple' => 0,
			'channel'  => '',
		);

    	parent::__construct();
    	
    	$this->settings = array(
			'path'    => apply_filters('acf/helpers/get_path', __FILE__),
			'dir'     => apply_filters('acf/helpers/get_dir', __FILE__),
			'version' => '1.0.0'
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
		<label><?php _e("Select multiple videos?",'acf'); ?></label>
	</td>
	<td>
		<?php
		
		do_action('acf/create_field', array(
			'type'		=>	'radio',
			'name'		=>	'fields['.$key.'][multiple]',
			'value'		=>	$field['multiple'],
			'layout'	=>	'horizontal',
			'choices'	=>	array(
				1 => __('Yes', 'acf'),
				0 => __('No', 'acf'),
			)
		));
		
		?>
	</td>
</tr>
<tr class="field_option field_option_<?php echo $this->name; ?>">
	<td class="label">
		<label><?php _e("User uploads?",'acf'); ?></label>
		<p class="description"><?php _e("if you want to search only for videos of a user.<br>I'll put in the field: google"); ?></p>
	</td>
	<td>
		<?php
		
		do_action('acf/create_field', array(
			'type'		=>	'text',
			'name'		=>	'fields['.$key.'][channel]',
			'value'		=>	$field['channel'],
			'layout'	=>	'horizontal'
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

		$atts  = array(
			'id'            => $field['id'], 
			'name'          => $field['name'], 
			'class'         => "acf-{$this->name}-field", 
			'data-multiple' => $field['multiple'], 
			'data-channel'  => $field['channel'] 
		);

		$a = '';
		foreach( $atts as $k => $v ) {
			$a .= $k.'="'.esc_attr($v).'" ';
		}

		?>
		<input type="text" <?php echo $a; ?>>
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

	private function _format_value( $value, $post_id, $field, $format = null ) {
		$data = array();
		if( is_array( $value ) && count( $value ) > 0 ) {
			foreach( $value as $k => $v ) {
				if( $v && ( $v = json_decode( $v, true ) ) ) {
					if( 'api' === $format ) {
						$v = array_merge(
							$v, 
							array( 
								'thumbs' => youtubepicker::thumbs( $v['vid'] ),
								'iframe' => html_entity_decode( youtubepicker::iframe( $v['vid'] ) )
							)
						);
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
		
}

new acf_field_youtubepicker();