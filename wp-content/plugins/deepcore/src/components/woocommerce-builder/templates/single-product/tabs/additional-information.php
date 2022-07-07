<?php
/**
 * Additional Information tab
 *
 * @package Deep\Components\WooCommerce\Templates
 *
 * @version 2.0.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

do_action( 'woocommerce_product_additional_information', $product );
