<?php
/**
 * WooCommerce Compatibilities.
 *
 * WooCommerce builder with Elementor.
 *
 * @package Deep
 */

namespace Deep\Components;

defined( 'ABSPATH' ) || exit;

use Elementor\Plugin;

/**
 * Class WooCommerce.
 */
class WooCommerce {
	/**
	 * Instance of this class.
	 *
	 * @since   2.0.0
	 * @access  public
	 * @var     WooCommerce
	 */
	public static $instance;

	/**
	 * WooCommerce directory.
	 *
	 * @var string
	 */
	public static $dir;

	/**
	 * WooCommerce directory url.
	 *
	 * @var string
	 */
	public static $url;

    /**
	 * Settings
	 *
	 * @var array
	 */
	private static $settings = array();

	/**
	 * Pages IDs
	 *
	 * @var array
	 */
	public static $pages_id = array();

	/**
	 * Option name.
	 *
	 * @var string
	 */
	private static $option_name = 'deep_woocommerce_dashboard';

    /**
	 * Single product page ID.
	 *
	 * @var string
	 */
	private static $single_page_id;

	/**
	 * My account page ID.
	 *
	 * @var string
	 */
	private static $my_account_page_id;

	/**
	 * Thumbnail Image Width
	 *
	 * @var string
	 */
	private static $thumbnail_image_width;

	/**
	 * Single Image Width
	 *
	 * @var string
	 */
	private static $single_image_width;

	/**
	 * Gallery Thumbnail Width
	 *
	 * @var string
	 */
	private static $gallery_thumbnail_width;

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
        if ( ! did_action( 'elementor/loaded' ) && ! class_exists( 'WooCommerce' ) ) {
			return;
		}
		$this->definition();
		$this->init_empty_settings();
        $this->hooks();
        $this->load_dependencies();
	}

	/**
	 * Definition.
	 *
	 * @since 2.0.0
	 * @access private
	 */
	private function definition() {
		self::$dir                = DEEP_COMPONENTS_DIR . 'woocommerce-builder/';
		self::$url                = DEEP_COMPONENTS_URL . 'woocommerce-builder/';
        self::$settings           = self::get_settings();
		self::$pages_id 		  = json_decode( self::$settings, true );
        self::$single_page_id          = isset( self::$pages_id['woo_pages']['single'] ) ? self::$pages_id['woo_pages']['single'] : '';
        self::$my_account_page_id      = isset( self::$pages_id['dashboard_pages']['myAccount'] ) ? self::$pages_id['dashboard_pages']['myAccount'] : '';
        self::$thumbnail_image_width = isset( self::$pages_id['general']['thumbnail_image_width'] ) ? self::$pages_id['general']['thumbnail_image_width'] : '';
        self::$single_image_width = isset( self::$pages_id['general']['woocommerce_single'] ) ? self::$pages_id['general']['woocommerce_single'] : '';
        self::$gallery_thumbnail_width = isset( self::$pages_id['general']['woocommerce_gallery_thumbnail'] ) ? self::$pages_id['general']['woocommerce_gallery_thumbnail'] : '';
	}

	/**
	 * Get custom WooCommerce Loop Settings.
	 *
	 * @since 2.0.0
	 * @access public
	 */
	public static function get_loop_template_id( string $title ) {

		$post = get_page_by_title( $title, '', 'deep_woo_loop_pages' );

		return $post ? $post->ID : 0;
	}

    /**
	 * Hooks.
	 *
	 * @since 2.0.0
	 * @access private
	 */
    private function hooks() {
        add_action( 'deep_woocommerce_custom_single', [$this, 'single_product_content'] );
        add_action( 'deep_woocommerce_custom_my_account', [$this, 'my_account_content'] );
		add_action( 'after_setup_theme', array( $this, 'add_support' ), 99 );
    }

	/**
	 * Load the dependencies.
	 *
	 * @since 2.0.0
	 * @access private
	 */
    private function load_dependencies() {
        require_once self::$dir . 'src/dashboard.php';
        require_once self::$dir . 'src/API/dashboard.php';
        require_once self::$dir . 'src/elementor.php';
        require_once self::$dir . 'src/templates.php';
        require_once self::$dir . 'src/woocommerce-swatches/woocommerce-swatches.php';
    }

    /**
	 * Returns Deep options.
	 *
	 * @since 2.0.0
	 * @access public
	 * @return array
	 */
    public static function get_settings() {
		return $settings = get_option( self::$option_name );
	}

	/**
	 * Register options.
	 *
	 * @since 2.0.0
	 * @access private
	 */
	private function init_empty_settings() {
		if ( ! self::$settings ) {
			$options = array(
				'woo_pages' => array(
					'single' 		=> '',
					'shop' 			=> '',
					'archive' 		=> '',
					'checkout' 		=> '',
					'cart' 			=> '',
					'emptyCart' 	=> '',
					'compare' 		=> '',
					'quickView' 	=> '',
					'wishlist' 		=> '',
					'thankYou' 		=> '',
				),
				'dashboard_pages' => array(
					'dashboard' 		=> '',
					'orders' 			=> '',
					'downloads' 		=> '',
					'addresses' 		=> '',
					'accountDetails' 	=> '',
					'myAccount' 		=> '',
				),
				'general' => array(
					'wishlistslug' => 'wishlist',
					'thumbnail_image_width' => '600',
					'woocommerce_single' => '560',
					'woocommerce_gallery_thumbnail' => '82',
					'catalog_mode' => false
				)
			);

			$options = json_encode($options);

			update_option( self::$option_name , $options );
		}
	}

    /**
	 * Check if single product builder is enabled.
	 *
	 * @since 2.0.0
	 * @access public
	 * @return bool
	 */
    public static function is_single_builder() {
        if ( ! empty( self::$pages_id['woo_pages']['single'] ) ) {
            return true;
        }
		return false;
    }

	/**
	 * Check if my account builder is enabled.
	 *
	 * @since 2.0.0
	 * @access public
	 * @return bool
	 */
    public static function is_my_account_builder() {
        if ( ! empty( self::$pages_id['dashboard_pages']['myAccount'] ) ) {
            return true;
        }
    }

    /**
	 * Returns the content of the page that has been selected as the single product page.
	 *
	 * @since 2.0.0
	 * @access public
	 */
    public function single_product_content() {
        if ( self::is_single_builder() ) {
            echo Plugin::instance()->frontend->get_builder_content_for_display( self::$single_page_id, false );
        }
    }

	/**
	 * Returns the content of the page that has been selected as the my account page.
	 *
	 * @since 2.0.0
	 * @access public
	 */
    public function my_account_content() {
        if ( self::is_my_account_builder() ) {
            echo Plugin::instance()->frontend->get_builder_content_for_display( self::$my_account_page_id, false );
        }
    }

	/**
	 * Add support.
	 *
	 * @since 2.0.0
	 * @access public
	 */
	public function add_support() {
		if ( self::is_single_builder() ) {
			add_theme_support( 'wc-product-gallery-lightbox' );
			add_theme_support( 'wc-product-gallery-slider' );

			update_option( 'woocommerce_single_image_width', self::$single_image_width );

			add_theme_support( 'woocommerce', array(
				'gallery_thumbnail_image_width' => self::$gallery_thumbnail_width,
			) );
		}

		update_option( 'woocommerce_thumbnail_image_width', self::$thumbnail_image_width );
	}
}

WooCommerce::get_instance();
