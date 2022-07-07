<?php
/**
 * Deep WooCommerce API.
 *
 * Dashboard API.
 *
 * @package Deep
 */

namespace Deep\Components\WooCommerce;

defined( 'ABSPATH' ) || exit;

use Deep\Components\Helper;

/**
 * class API.
 */
class API {

	/**
	 * Option name.
	 *
	 * @var string
	 */
	protected $option_name = 'deep_woocommerce_dashboard';

	/**
	 * Endpoint namespace.
	 *
	 * @var string
	 */
	protected $namespace = 'deep-woo-dashboard';

	/**
	 * Options route base.
	 *
	 * @var string
	 */
	protected $options_base = 'options';

	/**
	 * Export route base.
	 *
	 * @var string
	 */
	protected $export_base = 'export';

	/**
	 * Pages base.
	 *
	 * @var string
	 */
	protected $pages_base = 'pages';

	/**
	 * Register routes.
	 *
	 * @since 2.0.0
	 */
	public function register_routes() {
		register_rest_route(
			$this->namespace,
			'/' . $this->options_base,
			array(
				array(
					'methods'             => \WP_REST_Server::READABLE,
					'callback'            => array( $this, 'get_options' ),
					'permission_callback' => array( $this, 'get_item_permissions_check' ),
				),
				'schema' => array( $this, 'get_item_schema' ),
			)
		);

		register_rest_route(
			$this->namespace,
			'/' . $this->options_base,
			array(
				array(
					'methods'             => \WP_REST_Server::EDITABLE,
					'callback'            => array( $this, 'update_options' ),
					'permission_callback' => array( $this, 'permissions_check' ),
				),
				'schema' => array( $this, 'get_item_schema' ),
			)
		);

		register_rest_route(
			$this->namespace,
			'/' . $this->export_base,
			array(
				array(
					'methods'             => \WP_REST_Server::EDITABLE,
					'callback'            => array( $this, 'export_content' ),
					'permission_callback' => array( $this, 'permissions_check' ),
				),
				'schema' => array( $this, 'get_item_schema' ),
			)
		);

		register_rest_route(
			$this->namespace,
			'/' . $this->pages_base,
			array(
				array(
					'methods'             => \WP_REST_Server::EDITABLE,
					'callback'            => array( $this, 'pages' ),
					'permission_callback' => array( $this, 'permissions_check' ),
				),
				'schema' => array( $this, 'get_item_schema' ),
			)
		);
	}

	/**
	 * Check if a given request has access to get options.
	 *
	 * @since 2.0.0
	 */
	public function get_item_permissions_check( $request ) {
		if ( ! $this->user_has_permission() ) {
			return new \WP_Error( __( 'Sorry, you cannot view this option.', 'deep' ), array( 'status' => rest_authorization_required_code() ) );
		}

		return true;
	}

	/**
	 * Check if the user has permission.
	 *
	 * @since 2.0.0
	 */
	public function user_has_permission() {
		return current_user_can( 'manage_options' );
	}

	/**
	 * Check if a given request has access to update options.
	 *
	 * @since 2.0.0
	 */
	public function permissions_check( $request ) {
		$params = $request->get_json_params();

		if ( ! is_array( $params ) ) {
			return new \WP_Error( __( 'You must supply an array of options and values.', 'deep' ), 500 );
		}

		if ( ! $this->user_has_permission() ) {
			return new \WP_Error( __( 'Sorry, you cannot manage these options.', 'deep' ), array( 'status' => rest_authorization_required_code() ) );
		}

		return true;
	}

	/**
	 * Gets deep_woo_dashboard option.
	 *
	 * @since 2.0.0
	 */
	public function get_options( $request ) {
		$options = get_option( $this->option_name );

		return wp_send_json( $options, 200 );
	}

	/**
	 * Updates deep_woo_dashboard option.
	 *
	 * @since 2.0.0
	 */
	public function update_options( $request ) {
		$params = $request->get_json_params();

		if ( ! is_array( $params ) ) {
			return array();
		}

		$return = update_option( $this->option_name, json_encode( $params ) );
		if ( is_wp_error( $return ) ) {
			return $return->get_error_message();
		} else {
			return wp_send_json( true, 201 );
		}
	}

	/**
	 * Export content.
	 *
	 * @since 2.0.0
	 */
	public function export_content( $request ) {
		$action  = $request->get_param( 'action' );
		$content = '';

		include_once ABSPATH . 'wp-admin/includes/export.php';

		if ( 'exportOptions' === $action ) {
			$content = get_option( $this->option_name );
		}

		if ( 'exportPages' === $action ) {
			$content = export_wp(
				array(
					'content' => 'deep_woo_pages',
				)
			);
		}

		if ( 'exportDashboard' === $action ) {
			$content = export_wp(
				array(
					'content' => 'deep_woo_dash_pages',
				)
			);
		}

		if ( 'exportLoop' === $action ) {
			$content = export_wp(
				array(
					'content' => 'deep_woo_loop_pages',
				)
			);
		}

		if ( 'importOptions' === $action ) {
			$content = $request->get_param( 'importOptions' );
			$options = json_decode( $content, true );
			update_option( $this->option_name, $options );
		}

		if ( 'importPages' === $action ) {
			$content = $request->get_param( 'importPages' );

			$tmpfname = tempnam( '/tmp', 'pages.xml' );

			$handle = fopen( $tmpfname, 'w' );
			fwrite( $handle, $content );
			fclose( $handle );

			if ( ! class_exists( 'OCDI_Plugin' ) ) {
				include_once DEEP_SRC_DIR . 'admin/importer/one-click-demo-import/one-click-demo-import.php';
				$logger       = new \OCDI\Logger();
				$import_pages = new \OCDI\Importer(
					array(
						'update_attachment_guids' => true,
						'fetch_attachments'       => true,
					),
					$logger
				);

				$woo_pages = get_posts(
					array(
						'post_type'   => 'deep_woo_pages',
						'numberposts' => -1,
					)
				);
				foreach ( $woo_pages as $page ) {
					wp_delete_post( $page->ID, true );
				}
			}
			$import_pages->import_content( $tmpfname );

			unlink( $tmpfname );
		}

		if ( 'importDashboardPages' === $action ) {
			$content = $request->get_param( 'importDashboardPages' );

			$tmpfname = tempnam( '/tmp', 'pages.xml' );

			$handle = fopen( $tmpfname, 'w' );
			fwrite( $handle, $content );
			fclose( $handle );

			if ( ! class_exists( 'OCDI_Plugin' ) ) {
				include_once DEEP_SRC_DIR . 'admin/importer/one-click-demo-import/one-click-demo-import.php';
				$logger       = new \OCDI\Logger();
				$import_pages = new \OCDI\Importer(
					array(
						'update_attachment_guids' => true,
						'fetch_attachments'       => true,
					),
					$logger
				);

				$dash_pages = get_posts(
					array(
						'post_type'   => 'deep_woo_dash_pages',
						'numberposts' => -1,
					)
				);
				foreach ( $dash_pages as $page ) {
					wp_delete_post( $page->ID, true );
				}
			}
			$import_pages->import_content( $tmpfname );

			unlink( $tmpfname );
		}

		if ( 'importLoopPages' === $action ) {
			$content = $request->get_param( 'importLoopPages' );

			$tmpfname = tempnam( '/tmp', 'pages.xml' );

			$handle = fopen( $tmpfname, 'w' );
			fwrite( $handle, $content );
			fclose( $handle );

			if ( ! class_exists( 'OCDI_Plugin' ) ) {
				include_once DEEP_SRC_DIR . 'admin/importer/one-click-demo-import/one-click-demo-import.php';
				$logger       = new \OCDI\Logger();
				$import_pages = new \OCDI\Importer(
					array(
						'update_attachment_guids' => true,
						'fetch_attachments'       => true,
					),
					$logger
				);

				$loop_pages = get_posts(
					array(
						'post_type'   => 'deep_woo_loop_pages',
						'numberposts' => -1,
					)
				);
				foreach ( $loop_pages as $page ) {
					wp_delete_post( $page->ID, true );
				}
			}
			$import_pages->import_content( $tmpfname );

			unlink( $tmpfname );
		}

		return wp_send_json( $content );
	}

	/**
	 * Create or delete pages.
	 *
	 * @since 2.0.0
	 */
	public function pages( $request ) {
		$action    = $request->get_param( 'action' );
		$name      = $request->get_param( 'name' );
		$page_id   = $request->get_param( 'ID' );
		$post_type = $request->get_param( 'type' );
		$option    = $request->get_param( 'option' );
		$page_type = $option['value'];
		$message   = '';
		$page_data = array( sanitize_text_field( $page_type ), 'custom_page' );

		if ( 'create' === $action ) {
			Helper::instance()->insert_post( $post_type, $name, '' );
			$page_id = get_page_by_title( $name, '', $post_type ) ? get_page_by_title( $name, '', $post_type )->ID : '';
			update_post_meta( $page_id, 'page_type', $page_data );
			$message = $page_id;
		}

		if ( 'delete' === $action ) {
			wp_delete_post( $page_id, true );
		}

		return wp_send_json( $message );
	}

	/**
	 * Get the schema.
	 *
	 * @since 2.0.0
	 */
	public function get_item_schema() {
		$schema = array(
			'$schema'    => 'http://json-schema.org/draft-04/schema#',
			'title'      => 'options',
			'type'       => 'object',
			'properties' => array(
				'options' => array(
					'type'        => 'array',
					'description' => __( 'Array of options with associated values.', 'deep' ),
					'context'     => array( 'view' ),
					'readonly'    => true,
				),
			),
		);

		return $this->add_additional_fields_schema( $schema );
	}
}

/**
 * Register dashboard routes
 *
 * @since 2.0.0
 */
function register_woo_dashboard_routes() {
	$controller = new API();
	$controller->register_routes();
}

add_action( 'rest_api_init', __NAMESPACE__ . '\register_woo_dashboard_routes' );
