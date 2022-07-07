<?php
/**
 * WooCommerce Compatibilities.
 *
 * Load WooCommerce templates.
 *
 * @package Deep
 */

namespace Deep\Components\WooCommerce;

defined( 'ABSPATH' ) || exit;

use Deep\Components\WooCommerce;

/**
 * Class Templates.
 */
class Templates {
	/**
	 * Instance of this class.
	 *
	 * @since   2.0.0
	 * @access  public
	 * @var     Templates
	 */
	public static $instance;

    /**
	 * WooCommerce directory.
	 *
	 * @var string
	 */
	private static $dir;

	/**
	 * Widget name.
	 *
	 * @var string
	 */
	private static $name;

	/**
	 * Widget settings.
	 *
	 * @var array
	 */
	private static $settings = array();

	/**
	 * Provides access to a single instance of a module using the singleton pattern.
	 *
	 * @since   2.0.0
	 * @return  object
	 */
	public static function get_instance() {
		if ( self::$instance === null ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Constructor.
	 *
	 * @since 2.0.0
	 * @access private
	 */
	private function __construct() {
        $this->definition();
        $this->hooks();
	}

    /**
	 * Definition.
	 *
	 * @since 2.0.0
	 * @access private
	 */
	private function definition() {
		self::$dir = DEEP_COMPONENTS_DIR . 'woocommerce-builder/';
	}

    /**
	 * Hooks.
	 *
	 * @since 2.0.0
	 * @access private
	 */
    private function hooks() {
		add_filter( 'template_include', [$this, 'product_custom_templates'], 99 );
		add_filter( 'wc_get_template', [$this, 'wc_custom_templates'], 10, 3 );
    }

    /**
	 * Load custom product templates.
	 *
	 * @since 2.0.0
	 * @access public
	 */
    public function product_custom_templates( $template ) {

        if ( WooCommerce::is_single_builder() && is_product() ) {
            return self::$dir . 'templates/single-product/single-product.php';
        }

		if ( WooCommerce::is_my_account_builder() && is_account_page() ) {
			return self::$dir . 'templates/dashboard-endpoints/my-account.php';
		}

        return $template;
    }

	/**
	 * Load WC custom templates.
	 *
	 * @since 2.0.0
	 * @access public
	 */
	public function wc_custom_templates( $located, $template_name ) {

		if ( WooCommerce::is_single_builder() && 'single-product/add-to-cart/variation-add-to-cart-button.php' === $template_name ) {
			$located = self::$dir . 'templates/single-product/add-to-cart/variation-add-to-cart-button.php';
		}

		if ( WooCommerce::is_single_builder() && 'single-product/add-to-cart/simple.php' === $template_name ) {
			$located = self::$dir . 'templates/single-product/add-to-cart/simple.php';
		}

		if ( WooCommerce::is_single_builder() && 'single-product/add-to-cart/grouped.php' === $template_name ) {
			$located = self::$dir . 'templates/single-product/add-to-cart/grouped.php';
		}

		if ( WooCommerce::is_single_builder() && 'single-product/add-to-cart/external.php' === $template_name ) {
			$located = self::$dir . 'templates/single-product/add-to-cart/external.php';
		}

		if ( WooCommerce::is_single_builder() && 'single-product/tabs/description.php' === $template_name ) {
			$located = self::$dir . 'templates/single-product/tabs/description.php';
		}

		if ( WooCommerce::is_single_builder() && 'single-product/tabs/additional-information.php' === $template_name ) {
			$located = self::$dir . 'templates/single-product/tabs/additional-information.php';
		}

		return $located;
	}

    /**
	 * Load product template.
	 *
	 * @since 2.0.0
	 * @access private
	 */
    private static function load_template( string $template ) {
        load_template( self::$dir . 'templates/' . $template . '' . '.php', false, self::$settings );
    }

    /**
	 * Set widget name.
	 *
	 * Set widget settings.
     *
     * Returns product.
	 *
	 * @since 2.0.0
	 * @access public
	 */
    public static function widget( string $name, array $settings ) {
		self::$name = $name;
		self::$settings = $settings;

        return self::product();
    }

    /**
	 * Get product templates.
	 *
	 * @since 2.0.0
	 * @access private
	 */
    private static function product() {
		self::load_templates();
    }

	/**
	 * Templates switch.
	 *
	 * @since 2.0.0
	 * @access private
	 */
	private static function load_templates() {

		switch ( self::$name ) {
			case 'title': {
				self::load_template( 'single-product/title' );

				break;
			}

			case 'price': {
				self::load_template( 'single-product/price' );

				break;
			}

			case 'description': {
				self::load_template( 'single-product/description' );

				break;
			}

			case 'image': {
				self::load_template( 'single-product/image' );

				break;
			}

			case 'stock': {
				self::load_template( 'single-product/stock' );

				break;
			}

			case 'meta': {
				self::load_template( 'single-product/meta' );

				break;
			}

			case 'breadcrumb': {
				self::load_template( 'single-product/breadcrumb' );

				break;
			}

			case 'tabs': {
				self::load_template( 'single-product/tabs/tabs' );

				break;
			}

			case 'rating': {
				self::load_template( 'single-product/rating' );

				break;
			}

			case 'content': {
				self::load_template( 'single-product/content' );

				break;
			}

			case 'add-to-cart': {
				self::load_template( 'single-product/add-to-cart/add-to-cart' );

				break;
			}

			case 'review': {
				self::load_template( 'single-product/review' );

				break;
			}

			case 'attributes': {
				self::load_template( 'single-product/attributes' );

				break;
			}

			case 'sharing': {
				self::load_template( 'single-product/sharing' );

				break;
			}

			case 'navigation': {
				self::load_template( 'single-product/navigation' );

				break;
			}

			case 'dashboard': {
				self::load_template( 'dashboard/dashboard' );

				break;
			}

			case 'dashboard-order': {
				self::load_template( 'dashboard/orders' );

				break;
			}

			case 'dashboard-downloads': {
				self::load_template( 'dashboard/downloads' );

				break;
			}

			case 'dashboard-addresses': {
				self::load_template( 'dashboard/addresses' );

				break;
			}

			case 'dashboard-edit-account': {
				self::load_template( 'dashboard/edit-account' );

				break;
			}

			case 'sale-flash': {
				self::load_template( 'loop-builder/sale-flash' );

				break;
			}

			case 'product-meta': {
				self::load_template( 'loop-builder/meta' );

				break;
			}

			case 'product-categories': {
				self::load_template( 'loop-builder/categories' );

				break;
			}

			case 'product-tags': {
				self::load_template( 'loop-builder/tags' );

				break;
			}

			case 'product-thumbnail': {
				self::load_template( 'loop-builder/thumbnail' );

				break;
			}

			case 'product-title': {
				self::load_template( 'loop-builder/title' );

				break;
			}

			case 'product-description': {
				self::load_template( 'loop-builder/description' );

				break;
			}

			case 'product-price': {
				self::load_template( 'loop-builder/price' );

				break;
			}

			case 'product-stock': {
				self::load_template( 'loop-builder/stock' );

				break;
			}

			case 'product-sku': {
				self::load_template( 'loop-builder/sku' );

				break;
			}

			case 'product-rating': {
				self::load_template( 'loop-builder/rating' );

				break;
			}

			case 'product-review': {
				self::load_template( 'loop-builder/review' );

				break;
			}

			case 'product-add-to-cart': {
				self::load_template( 'loop-builder/add-to-cart' );

				break;
			}

			default:
				return '';
				break;
		}
	}
}

Templates::get_instance();
