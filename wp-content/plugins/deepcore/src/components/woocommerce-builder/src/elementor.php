<?php
/**
 * WooCommerce widgets.
 *
 * Register the products widgets.
 *
 * @package Deep
 */

namespace Deep\Components;

defined( 'ABSPATH' ) || exit;

use Elementor\Plugin;
use Deep\WooCommerce\Elementor\Widgets;

/**
 * Class WooCommerce_Widgets.
 */
class WooCommerce_Widgets {
	/**
	 * Instance of this class.
	 *
	 * @since   2.0.0
	 * @access  public
	 * @var     WooCommerce_Widgets
	 */
	public static $instance;

	/**
	 * WooCommerce widgets directory.
	 *
	 * @var string
	 */
	private static $dir;

	/**
	 * WooCommerce Builder src directory.
	 *
	 * @var string
	 */
	private static $src_dir;

	/**
	 * WooCommerce widgets assets directory.
	 *
	 * @var string
	 */
	private static $assets;

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
		self::$dir     = DEEP_COMPONENTS_DIR . 'woocommerce-builder/widgets/';
		self::$assets  = DEEP_COMPONENTS_URL . 'woocommerce-builder/assets/';
		self::$src_dir = DEEP_COMPONENTS_DIR . 'woocommerce-builder/src/';
	}


	/**
	 * Load the dependencies.
	 *
	 * @since 2.0.0
	 * @access private
	 */
	private function load_dependencies() {
		/**
		 * Social Share
		 */
		require_once self::$src_dir . 'helper/social-share.php';

		/**
		 * Base Widgets
		 */
		require_once self::$src_dir . 'class-widget-base.php';
		require_once self::$src_dir . 'class-product-widget-base.php';
		require_once self::$src_dir . 'class-loop-product-widget-base.php';
		require_once self::$src_dir . 'class-loop-products-widget-base.php';

		require_once self::$dir . 'products/products-loop.php';
	}

	/**
	 * Include widgets files.
	 *
	 * @since 2.0.0
	 * @access private
	 */
	private function widgets_files() {
		$widgets = glob( self::$dir . '**/*.php' );

		foreach ( $widgets as $widget ) {
			if ( __FILE__ != basename( $widget ) ) {
				require_once $widget;
			}
		}
	}

	/**
	 * Hooks.
	 *
	 * @since 2.0.0
	 * @access private
	 */
	private function hooks() {
		add_action( 'elementor/frontend/after_register_scripts', array( $this, 'register_scripts' ) );
		add_action( 'elementor/frontend/after_register_styles', array( $this, 'register_styles' ) );
		add_action( 'elementor/widgets/widgets_registered', array( $this, 'register_widgets' ) );
		add_action( 'elementor/elements/categories_registered', array( $this, 'widget_categories' ) );
	}

	/**
	 * WooCommerce widgets category.
	 *
	 * @since 2.0.0
	 * @access public
	 */
	public function widget_categories( $elements_manager ) {
		$elements_manager->add_category(
			'Deep_WooCommerce',
			array(
				'title' => __( 'WooCommerce', 'deep' ),
			)
		);

		$elements_manager->add_category(
			'Deep_Cart',
			array(
				'title' => __( 'Cart', 'deep' ),
			)
		);

		$elements_manager->add_category(
			'Deep_Checkout',
			array(
				'title' => __( 'Checkout', 'deep' ),
			)
		);

		$elements_manager->add_category(
			'Deep_Dashboard',
			array(
				'title' => __( 'Dashboard', 'deep' ),
			)
		);

		$elements_manager->add_category(
			'Deep_Single_Product',
			array(
				'title' => __( 'Single Product', 'deep' ),
			)
		);

		$elements_manager->add_category(
			'Deep_Product_Loop',
			array(
				'title' => __( 'Product Loop', 'deep' ),
			)
		);

		$elements_manager->add_category(
			'Deep_Products_Loop',
			array(
				'title' => __( 'Products Loop', 'deep' ),
			)
		);
	}

	/**
	 * Register widgets styles.
	 *
	 * @since 2.0.0
	 * @access public
	 */
	public function register_styles() {
		wp_register_style( 'deep-woo-image', self::$assets . 'css/image.css' );
		wp_register_style( 'deep-woo-sharing', self::$assets . 'css/sharing.css' );
		wp_register_style( 'deep-woo-add-to-cart', self::$assets . 'css/add-to-cart.css' );
		wp_register_style( 'deep-woo-meta', self::$assets . 'css/meta.css' );
		wp_register_style( 'deep-woo-price', self::$assets . 'css/price.css' );
		wp_register_style( 'deep-woo-tabs', self::$assets . 'css/tabs.css' );
		wp_register_style( 'deep-woo-products-loop', self::$assets . 'css/products.css' );
		wp_register_style( 'deep-pagination', self::$assets . 'css/pagination.css' );
	}

	/**
	 * Register widgets scripts.
	 *
	 * @since 2.0.0
	 * @access public
	 */
	public function register_scripts() {
		wp_register_script( 'deep-woo-sharing', self::$assets . 'js/sharing.js', array( 'jquery' ), true );
		wp_register_script( 'deep-woo-add-to-cart', self::$assets . 'js/add-to-cart.js', array( 'jquery' ), true );
		wp_register_script( 'deep-woo-products-loop', self::$assets . 'js/products.js', array( 'jquery' ), true );
	}

	/**
	 * Register Elementor Widgets.
	 *
	 * @since 2.0.0
	 * @access public
	 */
	public function register_widgets() {

		$this->load_dependencies();
		$this->widgets_files();

		$page_type = 'undefined';
		$page_id   = get_the_ID();
		$post_type = get_post_type();

		$is_edit_mode = \Elementor\Plugin::$instance->editor->is_edit_mode();
		if( $is_edit_mode || isset( $_POST['elementor_ajax'] ) ){

			$must_check = in_array( $post_type, ['deep_woo_pages','deep_woo_dash_pages','deep_woo_loop_pages'] );
			if( $must_check ){
				$is_edit_mode = true;
			} elseif ( !$must_check && $post_type === 'elementor_library' ){
				$is_edit_mode = false;
			}
		}


		if ( $page_id ) {

			$page_type = get_post_meta( $page_id, 'page_type', true );
		}

		$is_my_account = ( 'myAccount' === $page_type ) ? true : false;

		if ( ! $is_edit_mode || 'single' === $page_type || 'quick_view' === $page_type ) {

			Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Title() );
			Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Price() );
			Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Description() );
			Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Image() );
			Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Stock() );
			Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Meta() );
			Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Breadcrumb() );
			Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Tabs() );
			Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Rating() );
			Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Content() );
			Plugin::instance()->widgets_manager->register_widget_type( new Widgets\AddToCart() );
			Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Review() );
			Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Attributes() );
			Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Sharing() );
			Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Navigation() );
		}

		if ( ! $is_edit_mode || $is_my_account || 'dashboard' === $page_type ) {

			Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Dashboard() );
		}

		if ( ! $is_edit_mode || $is_my_account || 'orders' === $page_type ) {

			Plugin::instance()->widgets_manager->register_widget_type( new Widgets\DashboardOrders() );
		}

		if ( ! $is_edit_mode || $is_my_account || 'downloads' === $page_type ) {

			Plugin::instance()->widgets_manager->register_widget_type( new Widgets\DashboardDownloads() );
		}

		if ( ! $is_edit_mode || $is_my_account || 'addresses' === $page_type ) {

			Plugin::instance()->widgets_manager->register_widget_type( new Widgets\DashboardAddresses() );
		} if ( ! $is_edit_mode || $is_my_account || 'accountDetails' === $page_type ) {

			Plugin::instance()->widgets_manager->register_widget_type( new Widgets\DashboardEditAccount() );
		}

		$is_products_loop = in_array( $page_type, array( 'shop', 'archive' ) );
		if ( ! $is_edit_mode || $is_products_loop || in_array( $post_type, array( 'page','post' ) ) ) {

			Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Products_Loop\Recent_Products() );
		}

		if ( ! $is_edit_mode || 'single' === $page_type || 'relatedProducts' === $page_type || in_array( 'relatedProducts', (array) $page_type, true ) ) {

			Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Products_Loop\Related_Products() );
		}

		if ( ! $is_edit_mode || 'single' === $page_type || 'upSellProducts' === $page_type || in_array( 'upSellProducts', (array) $page_type, true ) ) {

			Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Products_Loop\Up_Sell_Products() );
		}

		if ( ! $is_edit_mode || 'deep_woo_loop_pages' === $post_type || in_array( 'custom_page', (array) $page_type ) || wp_doing_ajax() ) {

			Plugin::instance()->widgets_manager->register_widget_type( new Widgets\LoopBuilder\OnSale() );
			Plugin::instance()->widgets_manager->register_widget_type( new Widgets\LoopBuilder\Categories() );
			Plugin::instance()->widgets_manager->register_widget_type( new Widgets\LoopBuilder\Tags() );
			Plugin::instance()->widgets_manager->register_widget_type( new Widgets\LoopBuilder\Thumbnail() );

			Plugin::instance()->widgets_manager->register_widget_type( new Widgets\LoopBuilder\Title() );
			Plugin::instance()->widgets_manager->register_widget_type( new Widgets\LoopBuilder\Description() );
			Plugin::instance()->widgets_manager->register_widget_type( new Widgets\LoopBuilder\Price() );
			Plugin::instance()->widgets_manager->register_widget_type( new Widgets\LoopBuilder\Stock() );
			Plugin::instance()->widgets_manager->register_widget_type( new Widgets\LoopBuilder\Sku() );
			Plugin::instance()->widgets_manager->register_widget_type( new Widgets\LoopBuilder\Rating() );
			Plugin::instance()->widgets_manager->register_widget_type( new Widgets\LoopBuilder\Review() );
			Plugin::instance()->widgets_manager->register_widget_type( new Widgets\LoopBuilder\AddToCart() );
			Plugin::instance()->widgets_manager->register_widget_type( new Widgets\LoopBuilder\NewBadge() );
		}
	}
}

WooCommerce_Widgets::get_instance();
