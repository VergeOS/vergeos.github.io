<?php
/**
 * Deep Loop Products Widget Base.
 *
 * @package Deep
 */

namespace Deep\WooCommerce\Elementor;

use Deep\Components\WooCommerce;

defined('ABSPATH') || exit;

/**
 * Deep_Loop_Products_Widget_Base class
 *
 * @version 1.0.0
 */
abstract class Deep_Loop_Products_Widget_Base extends Deep_Product_Widget_Base {

    /**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'Deep_Products_Loop' ];
	}

    /**
     * Get Loop Templates
     *
     * @since 2.0.0
     *
     * @access public
     *
     * @return bool
     */
    public function get_loop_templates(){

        $group_id = $this->get_template_group_id();
        $args = [
            'post_type' => 'deep_woo_loop_pages',
            'posts_per_page' => -1,
            'meta_query' => [
                [
                    'relation' => 'OR',
                    [
                        'key' => 'page_type',
                        'compare' => 'LIKE',
                        'value' => '"'.$group_id.'"',
                    ],
                    [
                        'key' => 'page_type',
                        'compare' => '=',
                        'value' => $group_id,
                    ],
                ]
            ]
        ];

        $posts = get_posts( $args );
        $templates = [
            0 => __( 'Default', 'deep' ),
        ];
        foreach( $posts as $post ){

            $templates[ $post->ID ] = $post->post_title;
        }

        return $templates;
    }

    /**
     * Return Template Group ID
     *
     * @since 2.0.0
     *
     * @access public
     *
     * @return int
     */
    public function get_template_group_id(){

        $groups = array(
            'deep-woo-recent-products' => 'recentProducts',
            'deep-woo-related-products' => 'relatedProducts',
            'deep-woo-up-sell-products' => 'upSellProducts',
            'deep-woo-cross-sell-products' => 'crossSellProducts',
            'deep-woo-featured-products' => 'featuredProducts',
            'deep-woo-best-selling-products' => 'bestSellingProducts',
            'deep-woo-top-rated-products' => 'topRatedProducts',
            'deep-woo-sales-products' => 'salesProducts',
        );

        $w = $this->get_name();

        return isset( $groups[$w] ) ? $groups[$w] : 0;
    }

    /**
     * Can Display Loop Products
     *
     * @since 2.0.0
     *
     * @access public
     *
     * @return bool
     */
    public function can_display_loop_products(){

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
	 * Load WC custom templates.
	 *
	 * @since 2.0.0
	 * @access public
	 */
	public function custom_template_loop_item( $located, $template_name ) {

        global $deep_custom_template_id;
		if( 'content' === $template_name && !empty( $deep_custom_template_id ) ){

			$located = DEEP_COMPONENTS_DIR . 'woocommerce-builder/templates/products/custom-content-product.php';
		}

		return $located;
	}

    /**
     * Prepare Query Args
     *
     * @param array $query_args
     * @param array $attributes
     * @param string $type
     *
     * @since 2.0.0
	 * @access public
     *
     * @return array
     */
    public function prepare_query_args( $query_args, $attributes, $type ){

        if( false === strpos( $type, 'deep-woo-' ) ){

            return $query_args;
        }

        $search = isset( $_GET['s'] ) && !empty( $_GET['s'] ) ? sanitize_text_field( $_GET['s'] ) : '';
        if( !empty( $search ) ){

            $query_args['s'] = $search;
        }

        return $query_args;
    }

    /**
     * Loop Start
     *
     * @since 2.0.0
     *
     * @access public
     *
     * @return bool
     */
    public function prepare_loop( $args ){

        global $deep_custom_template_id;
        $deep_custom_template_id = isset( $args['template_id'] ) && absint( $args['template_id'] ) ? $args['template_id'] : '';

        add_filter( 'woocommerce_shortcode_products_query', [ $this, 'prepare_query_args' ], 10, 3 );
        add_filter( 'wc_get_template_part', [ $this, 'custom_template_loop_item'], 10, 2 );
    }

    /**
     * Loop End
     *
     * @since 2.0.0
     *
     * @access public
     *
     * @return bool
     */
    public function reset_loop( $args ){

        global $deep_custom_template_id;
        $deep_custom_template_id = '';

        remove_filter( 'woocommerce_shortcode_products_query', [ $this, 'prepare_query_args' ] );
        remove_filter( 'wc_get_template_part', [ $this, 'custom_template_loop_item'] );
    }

    /**
     * Get Loop Template ID
     *
     * @since 2.0.0
     *
     * @access public
     *
     * @return int
     */
    public function get_template_id( $widget_id, $settings ){

        $template_id = isset( $settings['template_id'] ) ? (int)$settings['template_id'] : 0;

        return $template_id;
    }
}
