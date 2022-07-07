<?php
/**
 * Deep WooCommerce Dashboard Page.
 *
 * @package Deep
 */

namespace Deep\Components\WooCommerce;

defined( 'ABSPATH' ) || exit;

use Deep\Components\WooCommerce;
use Deep\Components\Helper;

/**
 * Class Dashboard.
 */
class Dashboard {

	/**
	 * Instance of this class.
	 *
	 * @since  2.0.0
	 * @access public
	 * @var    Dashboard
	 */
	public static $instance;

	/**
	 * Assets URL.
	 *
	 * @var string
	 */
	private static $url;

	/**
	 * Settings
	 *
	 * @var array
	 */
	private static $settings = array();

	/**
	 * WooCommerce pages.
	 *
	 * @var array
	 */
	private static $woo_pages = array();

	/**
	 * WooCommerce account pages.
	 *
	 * @var array
	 */
	private static $woo_account_pages = array();

	/**
	 * WooCommerce loop pages.
	 *
	 * @var array
	 */
	private static $woo_loop_pages = array();

	/**
	 * Option name.
	 *
	 * @var string
	 */
	private static $option_name = 'deep_woocommerce_dashboard';

	/**
	 * Provides access to a single instance of a module using the singleton pattern.
	 *
	 * @since  2.0.0
	 * @return object
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
	 * @since  2.0.0
	 * @access private
	 */
	private function __construct() {
		$this->hooks();
		$this->definition();
	}

	/**
	 * Definition.
	 *
	 * @since  2.0.0
	 * @access private
	 */
	private function definition() {
		self::$url               = DEEP_COMPONENTS_URL . 'woocommerce-builder/dashboard/';
		self::$woo_pages         = array(
			'thankYou'  => 'Thank You',
			'wishlist'  => 'Wishlist',
			'emptyCart' => 'Empty Cart',
			'cart'      => 'Cart',
			'checkout'  => 'Checkout',
			'archive'   => 'Archive',
			'shop'      => 'Shop',
			'single'    => 'Single',
		);
		self::$woo_account_pages = array(
			'dashboard'      => 'Dashboard',
			'orders'         => 'Orders',
			'downloads'      => 'Downloads',
			'addresses'      => 'Addresses',
			'accountDetails' => 'Account Details',
			'myAccount'      => 'My Account',
		);
		self::$woo_loop_pages    = array(
			'upSellProducts'      => 'Up Sell Products',
			'crossSellProducts'   => 'Cross Sell Products',
			'featuredProducts'    => 'Featured Products',
			'bestSellingProducts' => 'Best Selling Products',
			'topRatedProducts'    => 'Top Rated Products',
			'saleProducts'        => 'Sale Products',
			'relatedProducts'     => 'Related Products',
			'recentProducts'      => 'Recent Products',
		);
	}

	/**
	 * Hooks.
	 *
	 * @since  2.0.0
	 * @access private
	 */
	private function hooks() {
		add_action( 'init', array( $this, 'woo_pages_post_type' ) );
		add_action( 'init', array( $this, 'woo_dashboard_pages_post_type' ) );
		add_action( 'init', array( $this, 'woo_products_loop_pages_post_type' ) );
		add_action( 'admin_init', array( $this, 'create_default_pages' ) );
		add_action( 'admin_init', array( $this, 'create_account_pages' ) );
		add_action( 'admin_init', array( $this, 'create_loop_pages' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_filter( 'template_include', array( $this, 'product_builder_templates' ), 99 );
		add_filter( 'option_elementor_cpt_support', array( $this, 'add_support' ) );
		add_filter( 'default_option_elementor_cpt_support', array( $this, 'add_support' ) );
	}

	/**
	 * Load custom product builder template.
	 *
	 * @since  2.0.0
	 * @access public
	 */
	public function product_builder_templates( $template ) {
		if ( is_singular( 'deep_woo_pages' ) || is_singular( 'deep_woo_dash_pages' ) || is_singular( 'deep_woo_loop_pages' ) ) {
			return WooCommerce::$dir . 'templates/single-builder/single.php';
		}

		return $template;
	}

	/**
	 * Register custom post type and meta for WooCommerce pages.
	 *
	 * @since  2.0.0
	 * @access public
	 */
	public function woo_pages_post_type() {
		register_post_type(
			'deep_woo_pages',
			array(
				'labels'              => array(
					'name'          => __( 'Deep Woo Pages', 'deep' ),
					'singular_name' => __( 'Deep Woo Pages', 'deep' ),
				),
				'public'              => true,
				'has_archive'         => true,
				'show_in_menu'        => false,
				'can_export'          => true,
				'rewrite'             => false,
				'exclude_from_search' => true,
				'show_in_rest'        => true,
				'supports'            => array( 'editor', 'title', 'custom-fields' ),
			)
		);

		$args = array(
			'type'           => 'array',
			'single'         => true,
			'object_subtype' => 'deep_woo_pages',
			'show_in_rest'   => array(
				'schema' => array(
					'type'  => 'array',
					'items' => array(
						'type' => 'array',
					),
				),
			),
		);

		register_meta( 'post', 'page_type', $args );
	}

	/**
	 * Register custom post type and meta for WooCommerce dashboard pages.
	 *
	 * @since  2.0.0
	 * @access public
	 */
	public function woo_dashboard_pages_post_type() {
		register_post_type(
			'deep_woo_dash_pages',
			array(
				'labels'              => array(
					'name'          => __( 'Deep Woo Dashboard Pages', 'deep' ),
					'singular_name' => __( 'Deep Woo Dashboard Pages', 'deep' ),
				),
				'public'              => true,
				'has_archive'         => true,
				'show_in_menu'        => false,
				'can_export'          => true,
				'rewrite'             => false,
				'exclude_from_search' => true,
				'show_in_rest'        => true,
				'supports'            => array( 'editor', 'title', 'custom-fields' ),
			)
		);

		$args = array(
			'type'           => 'array',
			'single'         => true,
			'object_subtype' => 'deep_woo_dash_pages',
			'show_in_rest'   => array(
				'schema' => array(
					'type'  => 'array',
					'items' => array(
						'type' => 'array',
					),
				),
			),
		);

		register_meta( 'post', 'page_type', $args );
	}

	/**
	 * Register custom post type and meta for WooCommerce products loop pages.
	 *
	 * @since  2.0.0
	 * @access public
	 */
	public function woo_products_loop_pages_post_type() {
		register_post_type(
			'deep_woo_loop_pages',
			array(
				'labels'              => array(
					'name'          => __( 'Deep Woo Products Loop Pages', 'deep' ),
					'singular_name' => __( 'Deep Woo Products Loop Pages', 'deep' ),
				),
				'public'              => true,
				'has_archive'         => true,
				'show_in_menu'        => false,
				'can_export'          => true,
				'rewrite'             => false,
				'exclude_from_search' => true,
				'show_in_rest'        => true,
				'supports'            => array( 'editor', 'title', 'custom-fields' ),
			)
		);

		$args = array(
			'type'           => 'array',
			'single'         => true,
			'object_subtype' => 'deep_woo_loop_pages',
			'show_in_rest'   => array(
				'schema' => array(
					'type'  => 'array',
					'items' => array(
						'type' => 'array',
					),
				),
			),
		);

		register_meta( 'post', 'page_type', $args );
	}

	/**
	 * Create default pages for WooCommerce.
	 *
	 * @since 2.0.0
	 * @access public
	 */
	public function create_default_pages() {
		if ( is_array( self::$woo_pages ) && ! empty( self::$woo_pages ) ) {
			foreach ( self::$woo_pages as $key => $page ) {
				$post_id = Helper::instance()->insert_post( 'deep_woo_pages', $page, '' );
				update_post_meta( $post_id, 'page_type', $key );
			}
		}
	}

	/**
	 * Create default account pages for WooCommerce.
	 *
	 * @since 2.0.0
	 * @access public
	 */
	public function create_account_pages() {
		if ( is_array( self::$woo_account_pages ) && ! empty( self::$woo_account_pages ) ) {
			foreach ( self::$woo_account_pages as $key => $page ) {
				$post_id = Helper::instance()->insert_post( 'deep_woo_dash_pages', $page, '' );
				update_post_meta( $post_id, 'page_type', $key );
			}
		}
	}

	/**
	 * Create default loop pages for WooCommerce.
	 *
	 * @since 2.0.0
	 * @access public
	 */
	public function create_loop_pages() {
		if ( is_array( self::$woo_loop_pages ) && ! empty( self::$woo_loop_pages ) ) {
			foreach ( self::$woo_loop_pages as $key => $page ) {
				$post_id = Helper::instance()->insert_post( 'deep_woo_loop_pages', $page, '' );
				update_post_meta( $post_id, 'page_type', $key );
			}
		}
	}

	/**
	 * Add Elementor support for the post type.
	 *
	 * @since  2.0.0
	 * @access public
	 */
	public function add_support( $value ) {
		if ( empty( $value ) ) {
			$value = array();
		}

		return array_merge(
			$value,
			array(
				'deep_woo_pages',
				'deep_woo_dash_pages',
				'deep_woo_loop_pages',
			)
		);
	}

	/**
	 * enqueue scripts.
	 *
	 * @since  2.0.0
	 * @access public
	 */
	public function enqueue_scripts() {
		if ( isset( $_GET['page'] ) && $_GET['page'] == 'wn-admin-woo-dashboard' ) {
			wp_enqueue_script(
				'deep-woo-dashboard',
				self::$url . 'build/index.js',
				array( 'wp-element' ),
				DEEP_VERSION,
				true
			);

			wp_localize_script(
				'deep-woo-dashboard',
				'deepWooOptions',
				array(
					'nonce'     => wp_create_nonce( 'wp_rest' ),
					'url'       => esc_url_raw( rest_url() ),
					'admin_url' => esc_url_raw( get_admin_url() ),
				)
			);

			wp_enqueue_style(
				'deep-woo-dashboard',
				self::$url . 'build/index.css',
				array(),
				DEEP_VERSION,
				'all'
			);

			wp_enqueue_script(
				'deep-nprogress-js',
				DEEP_ASSETS_URL . 'js/backend/nprogress.js',
				array(),
				DEEP_VERSION,
				false
			);

			wp_enqueue_style(
				'deep-nprogress-css',
				DEEP_ASSETS_URL . 'css/backend/nprogress.css',
				array(),
				DEEP_VERSION,
				'all'
			);
		}
	}
}

Dashboard::get_instance();
