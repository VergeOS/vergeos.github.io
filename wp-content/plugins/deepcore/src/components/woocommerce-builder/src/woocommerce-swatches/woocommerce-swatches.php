<?php

if( ! defined('WPINC') ) { die; }

if ( ! function_exists('is_woocommerce_active') ) {
	function is_woocommerce_active() {
	    $active_plugins = (array) get_option( 'active_plugins', [] );
	    if( is_multisite() ){
		   $active_plugins = array_merge( $active_plugins, get_site_option('active_sitewide_plugins', [] ) );
	    }
	    return in_array('woocommerce/woocommerce.php', $active_plugins) || array_key_exists('woocommerce/woocommerce.php', $active_plugins) || class_exists('WooCommerce');
	}
}

if ( is_woocommerce_active() ) {
	
	define('THWVSF_VERSION', '2.0.2');
	!defined('THWVSF_FILE') && define('THWVSF_FILE', __FILE__);
	!defined('THWVSF_PATH') && define('THWVSF_PATH', plugin_dir_path( __FILE__ ));
	!defined('THWVSF_URL') && define('THWVSF_URL', plugins_url( '/', __FILE__ ));
	!defined('THWVSF_BASE_NAME') && define('THWVSF_BASE_NAME', plugin_basename( __FILE__ ));
	
	/**
	 * The core plugin class that is used to define internationalization,
	 * admin-specific hooks, and public-facing site hooks.
	 */
	require plugin_dir_path( __FILE__ ) . 'includes/class-thwvsf.php';
	
	/**
	 * Begins execution of the plugin.
	 */
	function run_thwvsf() {
		$plugin = new THWVSF();
	}
	run_thwvsf();
}

?>