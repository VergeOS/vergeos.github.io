<?php
/**
 * Deep Performance.
 *
 * Settings API.
 *
 * @package Deep
 */

namespace Deep\Admin\Performance\API;

defined( 'ABSPATH' ) || exit;

/**
 * Settings Controller.
 *
 * @extends WP_REST_Controller
 */
class Settings extends \WP_REST_Controller {
	/**
	 * Option name.
	 *
	 * @var string
	 */
	protected $option_name = 'deep_performance';

	/**
	 * Endpoint namespace.
	 *
	 * @var string
	 */
	protected $namespace = 'deep-performance';

	/**
	 * Route base.
	 *
	 * @var string
	 */
	protected $rest_base = 'settings';

	/**
	 * Register routes.
	 *
	 * @since 2.1.0
	 */
	public function register_routes() {
		register_rest_route(
			$this->namespace,
			'/' . $this->rest_base,
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
			'/' . $this->rest_base,
			array(
				array(
					'methods'             => \WP_REST_Server::EDITABLE,
					'callback'            => array( $this, 'update_options' ),
					'permission_callback' => array( $this, 'update_item_permissions_check' ),
				),
				'schema' => array( $this, 'get_item_schema' ),
			)
		);
	}

	/**
	 * Check if a given request has access to get options.
	 *
	 * @since 2.1.0
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
	 * @since 2.1.0
	 */
	public function user_has_permission() {
		return current_user_can( 'manage_options' );
	}

	/**
	 * Check if a given request has access to update options.
	 *
	 * @since 2.1.0
	 */
	public function update_item_permissions_check( $request ) {
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
	 * Gets Deep_Performance option.
	 *
	 * @since 2.1.0
	 */
	public function get_options( $request ) {
		$options = get_option( $this->option_name );

		return $options;
	}

	/**
	 * Updates Deep_Performance option.
	 *
	 * @since 2.1.0
	 */
	public function update_options( $request ) {
		$params            = $request->get_json_params();
		$sanitize_settings = array();

		if ( ! is_array( $params ) ) {
			return array();
		}

		// Disable for now
		// foreach ( $params as $key => $value ) {
		// $sanitize_settings[$key] = sanitize_text_field( $value );
		// }

		return update_option( $this->option_name, $params );
	}

	/**
	 * Get the schema.
	 *
	 * @since 2.1.0
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
 * Register performance routes
 *
 * @since 2.1.0
 */
function deep_register_performance_routes() {
	$controller = new Settings();
	$controller->register_routes();
}

add_action( 'rest_api_init', __NAMESPACE__ . '\deep_register_performance_routes' );
