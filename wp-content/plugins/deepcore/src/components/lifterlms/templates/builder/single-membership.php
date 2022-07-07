<?php
/**
 * Single Membership
 *
 * @package Deep\Components\LifterLMS\Templates
 *
 * @version 5.0.0
 */

defined( 'ABSPATH' ) || exit;

get_header();

if ( have_posts() ) {
    while ( have_posts() ) : the_post();
        do_action( 'deep_custom_lifterlms_membership_single' );
    endwhile;
}

get_footer();
