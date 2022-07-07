<?php
/**
 * Deep Product Widget Base.
 *
 * @package Deep
 */

namespace Deep\WooCommerce\Elementor;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Deep\Components\WooCommerce\Templates;

defined('ABSPATH') || exit;

/**
 * Deep_Product_Widget_Base class
 *
 * @version 1.0.0
 */
abstract class Deep_Product_Widget_Base extends Deep_Widget_Base {

    /**
     * Can Display Product
     *
     * @since 2.0.0
     *
     * @return bool
     */
    public function can_display_product(){

        global $product;

        if( !$this->is_edit_mode() && 'product' !== get_post_type() ){

            return false;
        }elseif( $this->is_edit_mode() && empty( $product ) ){ //// TODO: Add condition for check

            //TODO: Notice empty product or enable woocommerce
            return false;
        }

        return true;
    }

    /**
     * Get Post
     *
     * @param int $post_id
     *
     * @since 2.0.0
     *
     * @return WP_Post
     */
    public function get_post( $post_id ){

        global $deep_post;

        if( !is_a( $deep_post, 'WP_Post' ) || $deep_post->ID !== $post_id ){

            $deep_post = get_post( $post_id );
        }

        return $deep_post;
    }

    /**
     * Get Product
     *
     * @since 2.0.0
     *
     * @return void
     */
    public function get_product() {

        $is_edit_mode = $this->is_edit_mode();

        global $product;
        if ( $is_edit_mode && ! is_a( $product, '\WC_Product' ) ) {

            $q_args = [
                'limit' => 1,
            ];
            $product = wc_get_products( $q_args );
            $product = is_array( $product ) ? current( $product ) : '';
        }

        return $is_edit_mode ? $product : false;
    }

    /**
	 * Get Product ID
	 *
	 * @since 2.0.0
	 *
	 * @return int
	 */
    public function get_product_id(){

        $product = $this->get_product();

        return is_a( $product, '\WC_product' ) ? $product->get_id() : false;
    }

    /**
     * Prepare Render
     *
     * @param int $post_id
     *
     * @since 2.0.0
     *
     * @return void
     */
    public function prepare_render(){

        if( ! $this->is_edit_mode() ){

            return;
        }

        global $post;
        global $deep_old_post;

        $deep_old_post = $post;
        $product_id = $this->get_product_id();
        $post_id = is_a($post,'\WP_Post') ? $post->ID : 0;

        if( $post_id !== $product_id ){

            $post = $this->get_post( $product_id );
            setup_postdata( $post );
        }
    }

    /**
     * Reset Render
     *
     * @since 2.0.0
     *
     * @return void
     */
    public function reset_render(){

        if( ! $this->is_edit_mode() ){

            return;
        }

        global $post;
        global $deep_old_post;

        $post = $deep_old_post;
    }
}
