<?php

if( ! defined( 'ABSPATH' ) ) exit;

class acf_field_youtubepicker extends acf_field {
	
	
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
		$this->name = 'youtubepicker';
		$this->label = __('YouTube Picker', 'acf-youtubepicker');
		$this->category = 'jquery';
		$this->defaults = array(
			'multiple' => 0,
			'channel'  => '',
		);
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
			'label'   => __('Select multiple videos?','acf-youtubepicker'),
			'type'    => 'radio',
			'name'    => 'multiple',
			'layout' => 'horizontal',
			'choices' =>	array(
				1 => __('Yes', 'acf'),
				0 => __('No', 'acf'),
			)
		));

		acf_render_field_setting( $field, array(
			'label'   => __('User uploads?','acf-youtubepicker'),
			'instrucation' => __('if you want to search only for videos of a user.<br>I\'ll put in the field: google','acf-youtubepicker'),
			'type'    => 'text',
			'name'    => 'channel',
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
		$field['value'] = $this->_format_value( $field['value'], null, $field );

		$atts  = array(
			'id'            => $field['key'], 
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
			<div id="<?php echo esc_attr($atts['id']); ?>-holder" class="thumbnails<?php echo ($field['multiple'] ? ' multiple' : ''); ?>">
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
		
		wp_register_script( 'acf-nanoscroller', $dir . 'js/nanoscroller.js', array('acf-input'), $this->settings['version'] );
		wp_register_script( 'acf-youtubepicker', $dir . 'js/youtubepicker.js', array('acf-input'), $this->settings['version'] );
		wp_register_script( 'acf-input-youtubepicker', $dir . 'js/input.js', array('acf-input'), $this->settings['version'] );
		
		wp_register_style( 'acf-youtubepicker', $dir . 'css/youtubepicker.css', array('acf-input'), $this->settings['version'] ); 
		wp_register_style( 'acf-nanoscroller', $dir . 'css/nanoscroller.css', array('acf-input'), $this->settings['version'] ); 
		wp_register_style( 'acf-input-youtubepicker', $dir . 'css/input.css', array('acf-input'), $this->settings['version'] );
			
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
	
	private function _format_value( $value, $post_id = null, $field = null, $format = null ) {
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
	
}


// create field
new acf_field_youtubepicker();

?>
