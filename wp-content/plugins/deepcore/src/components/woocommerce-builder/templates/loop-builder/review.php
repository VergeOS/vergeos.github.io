<?php
/**
 * Product Review
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

$review_count = $product->get_review_count();

ob_start();
	\Elementor\Icons_Manager::render_icon( $args['icon'], array( 'aria-hidden' => 'true' ) );
$icon_html = ob_get_clean();

?>
<div class="deep-woo-product-review">
	<?php echo $icon_html; ?>
	<span class="review-count"><?php echo $review_count; ?></span>
</div>
