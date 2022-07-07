<?php
/**
 * Product Rating
 *
 * @package Deep\Components\WooCommerce\Templates
 *
 * @version 2.0.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( ! wc_review_ratings_enabled() ) {
	return;
}

$rating_count = $product->get_rating_count();
$review_count = $product->get_review_count();
$average      = $product->get_average_rating();

?>
<div class="deep-woo-product-rating woocommerce-product-rating">
	<?php echo $rating_count ? wc_get_rating_html( $average, $rating_count ) : __( 'No Rating','deep' ); // WPCS: XSS ok. ?>
	<span class="rating-average"><?php echo $rating_count ? $average : ''; ?></span>
</div>

