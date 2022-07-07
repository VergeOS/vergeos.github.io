<?php
/**
 * Single Product Title
 *
 * @package Deep\Components\WooCommerce\Templates
 *
 * @version 2.0.0
 */

defined( 'ABSPATH' ) || exit;

$tag   = $args['tag'];
$title = get_the_title();

echo '<' . $tag . ' class="product_title entry-title">' . $title . '</' . $tag . '>';
