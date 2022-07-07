<?php
/**
 * Single Product
 *
 * @package Deep\Components\WooCommerce\Templates
 *
 * @version 2.0.0
 */

defined( 'ABSPATH' ) || exit;

get_header();

if ( have_posts() ) {
	while ( have_posts() ) :
		the_post();
		do_action( 'deep_woocommerce_custom_single' );
	endwhile;
}

get_footer();
