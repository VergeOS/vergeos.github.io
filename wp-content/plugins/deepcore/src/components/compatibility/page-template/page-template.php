<?php
/**
 * Page Template.
 *
 * @package Deep
 */

namespace Deep\Compatibility;

defined( 'ABSPATH' ) || exit;

class PageTemplates {

	/**
	 * Add custom page template.
	 *
	 * @since 2.1.0
	 *
	 * @access public
	 */
	public static function add_page_template( $page_template ) {
		$page_template = array(
			'Deep Page' => _x( 'Deep Page', 'Page Template', 'deep' ),
		) + $page_template;

		return $page_template;
	}

	/**
	 * Load Deep page template.
	 *
	 * @since 2.1.0
	 *
	 * @access public
	 */
	public static function page_template( $page_template ) {
		if ( 'Deep Page' == get_page_template_slug() ) {
			$page_template = dirname( __FILE__ ) . '/deep-page.php';
		}

		return $page_template;
	}
}

add_filter( 'theme_page_templates', array( 'Deep\Compatibility\PageTemplates', 'add_page_template' ), 10, 4 );
add_filter( 'page_template', array( 'Deep\Compatibility\PageTemplates', 'page_template' ), 11 );
