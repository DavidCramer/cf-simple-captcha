<?php
/**
 * @package   Caldera_Forms_Simple_Captcha
 * @author    David Cramer <david@digilab.co.za>
 * @license   GPL-2.0+
 * @link      
 * @copyright 2014 - 2105 David Cramer <david@digilab.co.za> and CalderaWP LLC.
 *
 * @wordpress-plugin
 * Plugin Name: Caldera Forms Simple Captcha Field
 * Plugin URI:  
 * Description: Creates a simple math based question for checking for bots
 * Version: 1.0.0
 * Author:      David Cramer for CalderaWP
 * Author URI:  http://calderawp.com
 * Text Domain: cf-simple-captcha
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path: /languages
 */

// define constants
define( 'CF_SIMPLE_CAPTCHA_PATH',  plugin_dir_path( __FILE__ ) );
define( 'CF_SIMPLE_CAPTCHA_CORE',  __FILE__ );
define( 'CF_SIMPLE_CAPTCHA_URL',  plugin_dir_url( __FILE__ ) );
define( 'CF_SIMPLE_CAPTCHA_VER', '1.0.0' );

/**
 * Register the field type with Caldera Forms
 *
 * @since 1.0.0
 *
 *
 * @param array 	$fieldtypes		list of currently registered field types
 *
 * @return array	altered list of fieldtypes with field added.
 */
function cf_register_simple_captcha_field($fieldtypes){

	$fieldtypes['cf_simple_captcha'] = array(
		"field"		=>	"Simple Captcha",
		"file"		=>	CF_SIMPLE_CAPTCHA_PATH . "field.php",
		"category"	=>	__("Special", "cf-simple-captcha"),
		"description" => __('A Simple math based verification field', "cf-simple-captcha"),
		"handler"	 =>	'cf_simple_captcha_check',
		"setup"		=>	array(
			//"template"	=>	CF_SIMPLE_CAPTCHA_PATH . "config.php",
			"preview"	=>	CF_SIMPLE_CAPTCHA_PATH . "preview.php",
			"not_supported"	=>	array(
				'required',
				'entry_list',
			)
		)
	);
	return $fieldtypes;
}

// add filter to register the fieldtype
add_filter('caldera_forms_get_field_types', 'cf_register_simple_captcha_field');

/**
 * Handler function to check the answer
 *
 * @since 1.0.0
 *
 *
 * @param string 	$data	value of the submitted field
 * @param array 	$field	field config
 *
 * @return string|error	submitted value or wp_error if failed
 */
function cf_simple_captcha_check( $data, $field ){
	$opps = array('+','-','+','-','+','-');
	if( !empty( $_POST['cfscf'] ) ){
		foreach( $_POST['cfscf'] as $field_part=>$field_id ){
			if( $field_id === $field['ID'] ){
				$parts = str_replace( $field['ID'], '', $field_part );
				$first = substr( $parts, 1, 1);
				$second = $opps[ substr( $parts, 0, 1) ];
				$third = substr( $parts, 2, 1);
			}
		}
	}
	if( $second == '+' ){
		$val = $first + $third;
	}else{
		$val = $first - $third;
	}
	if( $val !== (int) $data ){
		return new WP_Error('error', __('Incorrect, please try again.', 'cf-simple-captcha') );
	}
	return $data;
}


/**
 * Set field to be required
 *
 * @since 1.0.0
 *
 *
 * @param array 	$field	field config array
 *
 * @return array	altered field config with 'required' key set true
 */
function cf_simple_captcha_set_required( $field ){
	$field['required'] = true;
	return $field;
};
// add filter to field to set it required.
add_filter( 'caldera_forms_render_get_field_type-cf_simple_captcha', 'cf_simple_captcha_set_required' );