<?php
/**
 * Single Product Builder
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
		the_content();
	endwhile;
}

get_footer();
