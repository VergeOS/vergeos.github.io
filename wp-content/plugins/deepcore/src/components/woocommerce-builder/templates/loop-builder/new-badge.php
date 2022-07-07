<?php
/**
 * Product loop sale flash
 *
 * @package Deep\Components\WooCommerce\Templates
 *
 * @version 2.0.0
 */

defined( 'ABSPATH' ) || exit;

global $post, $product;
$label = isset( $args['label'] ) ? $args['label'] : esc_html__( 'ٔNew', 'deep' );
$show_up_to = isset( $args['show_up_to'] ) ? $args['show_up_to'] : '24';
$creation_date = $product->get_date_created();
$creation_timestamp = strtotime( $creation_date );
$current_timestamp = strtotime( date_i18n('Y-m-d H:i:s') );
$show_up_to = strtotime( '1970-01-01 +'.$show_up_to.' hours' );//.$show_up_to
$i = $current_timestamp - $creation_timestamp;
if( $i >= $show_up_to ){
	return;
}

ob_start();
	\Elementor\Icons_Manager::render_icon( $args['icon'], array( 'aria-hidden' => 'true' ) );
$icon = ob_get_clean();

$bicon = isset( $args['icon_pos'], $icon ) && 'before' == $args['icon_pos'] ? $icon : '';
$aicon = isset( $args['icon_pos'], $icon ) && 'after' == $args['icon_pos'] ? $icon : '';
?>
<div class="deep-woo-new-badge">
	<?php echo $bicon; ?>
	<span class="label"><?php echo $label; ?></span>
	<?php echo $aicon; ?>
</div>