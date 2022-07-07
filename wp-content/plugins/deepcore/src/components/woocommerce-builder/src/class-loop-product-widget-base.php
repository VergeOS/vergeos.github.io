<?php
/**
 * Deep Loop Product Widget Base.
 *
 * @package Deep
 */

namespace Deep\WooCommerce\Elementor;

defined('ABSPATH') || exit;

/**
 * Deep_Loop_Product_Widget_Base class
 *
 * @version 1.0.0
 */
abstract class Deep_Loop_Product_Widget_Base extends Deep_Product_Widget_Base {

    /**
     * Can Display Loop Product
     *
     * @since 2.0.0
     *
     * @return bool
     */
    public function can_display_item_product(){

        global $product;

        if( !$this->is_edit_mode() && 'product' !== get_post_type() ){

            return false;
        }elseif( $this->is_edit_mode() && empty( $product ) ){ //// TODO: Add condition for check

            //TODO: Notice empty product or enable woocommerce
            return false;
        }

        return true;
    }
}
