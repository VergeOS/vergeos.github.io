<?php
/**
 * The common utility functionalities for the plugin.
 *
 * @package Deep
 */
if(!defined('WPINC')){	die; }

if(!class_exists('THWVSF_Utils')):

class THWVSF_Utils {
	const OPTION_KEY_ADVANCED_SETTINGS = 'thwvs_swatches_advanced_settings';
	const OPTION_KEY_DESIGN_SETTINGS   = 'thwvs_swatches_design_settings';
	
	public static function get_advanced_swatches_settings($settings_key = false){
		$settings = get_option(self::OPTION_KEY_ADVANCED_SETTINGS,true);
		if($settings_key) {
			$settings_value = isset($settings[$settings_key])? $settings[$settings_key] : '';
			return empty($settings_value) ? false : $settings_value;
		}
		
		return empty($settings) ? false : $settings;
	}

	public static function get_global_swatches_settings($settings_key, $settings = false ){
		
		$settings = $settings ? $settings : get_option(self::OPTION_KEY_ADVANCED_SETTINGS,true);

		if($settings && is_array($settings)){

			$global_settings = isset($settings['swatch_global_settings']) ? $settings['swatch_global_settings'] :  $settings;
			$settings_value  = isset($global_settings[$settings_key ]) ? $global_settings[$settings_key ] : false;
			return $settings_value;

		} 
		return false;
	}

	public static function get_design_swatches_settings($attr_id = false, $settings_key = false){

		$settings = get_option(self::OPTION_KEY_DESIGN_SETTINGS,true);
		if($attr_id){
			$settings_values = isset($settings[$attr_id])? $settings[$attr_id] : array();

			if($settings_key){

				$settings_value = isset($settings_values[$settings_key])? $settings_values[$settings_key] : '';
				return empty($settings_value) ? false : $settings_value;
			}
			return empty($settings_values) ? false : $settings_values;
		}
		return empty($settings) ? false : $settings;
	}

	public static function thwvsf_capability() {
		$allowed = array('manage_woocommerce', 'manage_options');
		$capability = apply_filters('thwvsf_required_capability', 'manage_woocommerce');

		if(!in_array($capability, $allowed)){
			$capability = 'manage_woocommerce';
		}
		return $capability;
	}
}

endif;