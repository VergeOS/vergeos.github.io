<?php
/**
 * Deep Admin.
 *
 * @package Deep
 */

defined( 'ABSPATH' ) || exit;

class Deep_Admin {
	/**
	 * Deep options.
	 *
	 * @var array
	 */
	private static $deep_options;

	public function __construct() {
		$this->definition();
		add_action( 'admin_menu', array( $this, 'admin_menus' ) );
		add_action( 'admin_menu', array( $this, 'edit_admin_menus' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_filter( 'tgmpa_load', array( $this, 'tgmpa_load' ), 10 );
		add_filter( 'deep_dashboard_header', array( $this, 'dashboard_header' ), 10 );
		add_action( 'wp_ajax_deep_install_plugin', array( $this, 'install_plugin' ) );
		add_action( 'wp_ajax_deep_activate_plugin', array( $this, 'activate_plugin' ) );
		add_action( 'wp_ajax_deep_deactivate_plugin', array( $this, 'deactivate_plugin' ) );
		add_action( 'wp_ajax_deep_update_plugin', array( $this, 'update_plugin' ) );
		add_action( 'admin_footer', array( $this, 'quick_access' ) );
		add_action( 'deep_admin_dashboard', array( $this, 'deep_dashboard_tabs' ) );
		add_action( 'deep_dashboard_tabs_end', array( $this, 'deep_dashboard_tabs_end' ) );
		add_action( 'redux/deep_options/panel/before', array( $this, 'deep_dashboard_tabs' ) );
		add_action( 'redux/deep_options/panel/after', array( $this, 'deep_dashboard_tabs_end' ) );
		add_action( 'in_admin_header', array( $this, 'deep_remove_notices' ), 99 );
	}

	/**
	 * Definition.
	 *
	 * @since 4.5.8
	 *
	 * @access private
	 */
	private function definition() {
		self::$deep_options = get_option( 'deep_options' );
	}

	/**
	 * Remove notices.
	 *
	 * @since  5.0.0
	 *
	 * @access public
	 */
	public function deep_remove_notices() {
		if ( isset( $_GET['page'] ) && strpos( sanitize_text_field( $_GET['page'] ), 'wn-admin' ) !== false ) {
			remove_all_actions( 'admin_notices' );
			remove_all_actions( 'all_admin_notices' );
		}
	}

	public static function dashboard_menu() {
		global $submenu;

		$menus       = $submenu['wn-admin-welcome'];
		$menu_size   = sizeof( $menus );
		$menu        = '';
		$crt_pg_name = get_admin_page_title();
		// $base			= str_replace( 'deep_page_', '', get_current_screen()->base ) ;
		$base = explode( '_wn', get_current_screen()->base );
		$base = 'wn' . $base[1];
		$ignore_menu_items = array( 'Footer Builder', 'Mega Menu', 'Wizard' );

		foreach ( $menus as $sub_menu ) {
			if ( in_array( $sub_menu[0], $ignore_menu_items ) ) {
				continue;
			}
			$acive_page = ( $base == $sub_menu[2] ) ? ' nav-tab-active' : '';
			$menu      .= '<a class="nav-tab' . $acive_page . '" href="' . esc_url( self_admin_url( 'admin.php?page=' . $sub_menu[2] ) ) . '">' . esc_html( $sub_menu[0], 'deep' ) . '</a>';
		}
		echo $menu;
	}

	public function tgmpa_load( $load ) {
		return true;
	}

	public function install_plugin() {
		if ( current_user_can( 'manage_options' ) ) {

			check_admin_referer( 'tgmpa-install', 'tgmpa-nonce' );

			global $tgmpa;

			$tgmpa->install_plugins_page();

			$url = wp_nonce_url(
				add_query_arg(
					array(
						'plugin'           => urlencode( $_GET['plugin'] ),
						'tgmpa-deactivate' => 'deactivate-plugin',
					),
					$tgmpa->get_tgmpa_url()
				),
				'tgmpa-deactivate',
				'tgmpa-nonce'
			);

			echo htmlspecialchars_decode( $url );

		}

		wp_die();
	}

	public function activate_plugin() {
		if ( current_user_can( 'edit_theme_options' ) ) {

			check_admin_referer( 'tgmpa-activate', 'tgmpa-nonce' );

			global $tgmpa;

			$plugins = $tgmpa->plugins;

			foreach ( $plugins as $plugin ) {

				if ( isset( $_GET['plugin'] ) && $plugin['slug'] === $_GET['plugin'] ) {

					activate_plugin( $plugin['file_path'] );

					$url = wp_nonce_url(
						add_query_arg(
							array(
								'plugin'           => urlencode( $_GET['plugin'] ),
								'tgmpa-deactivate' => 'deactivate-plugin',
							),
							$tgmpa->get_tgmpa_url()
						),
						'tgmpa-deactivate',
						'tgmpa-nonce'
					);

					echo htmlspecialchars_decode( $url );

				}
			} // foreach

		}

		wp_die();
	}

	public function deactivate_plugin() {
		if ( current_user_can( 'edit_theme_options' ) ) {

			check_admin_referer( 'tgmpa-deactivate', 'tgmpa-nonce' );

			global $tgmpa;

			$plugins = $tgmpa->plugins;

			foreach ( $plugins as $plugin ) {

				if ( isset( $_GET['plugin'] ) && $plugin['slug'] === $_GET['plugin'] ) {

					deactivate_plugins( $plugin['file_path'] );

					$url = wp_nonce_url(
						add_query_arg(
							array(
								'plugin'         => urlencode( $_GET['plugin'] ),
								'tgmpa-activate' => 'activate-plugin',
							),
							$tgmpa->get_tgmpa_url()
						),
						'tgmpa-activate',
						'tgmpa-nonce'
					);

					echo htmlspecialchars_decode( $url );

				}
			} // foreach

		}

		wp_die();
	}

	public function update_plugin() {
		if ( current_user_can( 'manage_options' ) ) {
			check_admin_referer( 'tgmpa-update', 'tgmpa-nonce' );
			global $tgmpa;
			$tgmpa->install_plugins_page();

			$url = wp_nonce_url(
				add_query_arg(
					array(
						'plugin'           => urlencode( $_GET['plugin'] ),
						'tgmpa-deactivate' => 'deactivate-plugin',
					),
					$tgmpa->get_tgmpa_url()
				),
				'tgmpa-deactivate',
				'tgmpa-nonce'
			);

			echo htmlspecialchars_decode( $url );
		}

		wp_die();
	}

	public function enqueue_scripts() {
		if ( isset( $_GET['page'] ) ) :

			if ( substr( $_GET['page'], 0, 9 ) == 'wn-admin-' ) :

				wp_dequeue_style( 'webnus_js_composer' );

				// admin pages style
				wp_enqueue_style( 'deep-admin-styles', DEEP_ASSETS_URL . '/css/backend/admin-pages.css', 99 );

				// install plugins scripts
				if ( $_GET['page'] == 'wn-admin-demo-importer' || $_GET['page'] == 'wn-admin-plugins' ) :

					wp_enqueue_script( 'deep-admin-plugins', DEEP_ASSETS_URL . '/js/backend/wn-plugins.js', array( 'jquery' ), DEEP_VERSION, true );

				endif;

				if ( $_GET['page'] == 'wn-admin-plugins' ) :

					wp_enqueue_script( 'wn-load-isotop', DEEP_ASSETS_URL . 'js/libraries/isotope.pkgd.min.js', array( 'jquery' ), null, true );
					wp_enqueue_script( 'wn-plugins-iso-config', DEEP_ASSETS_URL . '/js/backend/install-plugins-iso.js', array( 'jquery' ), null, true );

				endif;

			endif; // substr

		endif; // isset

		wp_enqueue_style( 'webnus_js_composer', DEEP_ASSETS_URL . 'css/backend/admin-backend.css', false, false, false );
		wp_deregister_style( 'font-awesome' );
		wp_enqueue_style( 'font-awesome' );

	}

	public function admin_menus() {
		$menu_visiblity        = array(
			'importer'    => ! empty( self::$deep_options['deep_theme_menus']['importer'] ) ? self::$deep_options['deep_theme_menus']['importer'] : '0',
			'plugins'     => ! empty( self::$deep_options['deep_theme_menus']['plugins'] ) ? self::$deep_options['deep_theme_menus']['plugins'] : '0',
			'help'        => ! empty( self::$deep_options['deep_theme_menus']['help'] ) ? self::$deep_options['deep_theme_menus']['help'] : '0',
			'performance' => ! empty( self::$deep_options['deep_theme_menus']['performance'] ) ? self::$deep_options['deep_theme_menus']['performance'] : '0',
		);
		$deep_theme_admin_logo = ! empty( self::$deep_options['deep_theme_admin_logo']['url'] ) ? self::$deep_options['deep_theme_admin_logo']['url'] : DEEP_ASSETS_URL . '/images/dashboard/wn-admin-menu.png';

		// Welcome page
		call_user_func_array(
			'add' . '_menu_' . 'page',
			array(
				self::theme( 'name' ),
				self::theme( 'name' ),
				'manage_options',
				'wn-admin-welcome',
				array( $this, 'screen_welcome' ),
				$deep_theme_admin_logo,
				'2',
			)
		);

		// Demo Importer page
		call_user_func_array(
			'add' . '_sub' . 'menu_' . 'page',
			array(
				'wn-admin-welcome',
				esc_html__( 'Demo Importer', 'deep' ),
				esc_html__( 'Demo Importer', 'deep' ),
				'manage_options',
				'wn-admin-demo-importer',
				array( $this, 'screen_demo_importer' ),
			)
		);

		// Header Builder
		call_user_func_array(
			'add' . '_sub' . 'menu_' . 'page',
			array(
				'wn-admin-welcome',
				esc_html__( 'Header Builder', 'deep' ),
				esc_html__( 'Header Builder', 'deep' ),
				'manage_options',
				'webnus_header_builder',
				array( $this, 'screen_header_builder' ),
			)
		);

		// Footer Builder
		add_submenu_page(
			'wn-admin-welcome',
			__( 'Footer Builder', 'deep' ),
			__( 'Footer Builder', 'deep' ),
			'manage_options',
			'edit.php?post_type=wbf_footer',
			array()
		);

		// Mega Menu
		add_submenu_page(
			'wn-admin-welcome',
			__( 'Mega Menu', 'deep' ),
			__( 'Mega Menu', 'deep' ),
			'manage_options',
			'edit.php?post_type=mega_menu',
			array()
		);

		// Performance
		call_user_func_array(
			'add' . '_sub' . 'menu_' . 'page',
			array(
				'wn-admin-welcome',
				esc_html__( 'Performance', 'deep' ),
				esc_html__( 'Performance', 'deep' ),
				'manage_options',
				'wn-admin-performance',
				array( $this, 'screen_performance' ),
			)
		);

		// Plugins page
		call_user_func_array(
			'add' . '_sub' . 'menu_' . 'page',
			array(
				'wn-admin-welcome',
				esc_html__( 'Plugins', 'deep' ),
				esc_html__( 'Plugins', 'deep' ),
				'manage_options',
				'wn-admin-plugins',
				array( $this, 'screen_plugins' ),
			)
		);

		// Woo Builder
		if ( class_exists( 'WooCommerce' ) ) {
			call_user_func_array(
				'add' . '_sub' . 'menu_' . 'page',
				array(
					'wn-admin-welcome',
					esc_html__( 'Woo Builder', 'deep' ),
					esc_html__( 'Woo Builder', 'deep' ),
					'manage_options',
					'wn-admin-woo-dashboard',
					array( $this, 'screen_woo_builder' ),
				)
			);
		}

		// Help
		call_user_func_array(
			'add' . '_sub' . 'menu_' . 'page',
			array(
				'wn-admin-welcome',
				esc_html__( 'Help', 'deep' ),
				esc_html__( 'Help', 'deep' ),
				'manage_options',
				'wn-admin-help',
				array( $this, 'screen_video_tutorial' ),
			)
		);

		// Wizard
		add_submenu_page(
			'wn-admin-welcome',
			__( 'Wizard', 'deep' ),
			__( 'Wizard', 'deep' ),
			'manage_options',
			'index.php?page=webnus-setup-wizard',
			array()
		);

		// Disable Deep Dashboard Pages
		if ( $menu_visiblity['importer'] == '1' ) {
			remove_submenu_page( 'wn-admin-welcome', 'wn-admin-demo-importer' );
		}
		if ( $menu_visiblity['plugins'] == '1' ) {
			remove_submenu_page( 'wn-admin-welcome', 'wn-admin-plugins' );
		}
		if ( $menu_visiblity['help'] == '1' ) {
			remove_submenu_page( 'wn-admin-welcome', 'wn-admin-help' );
		}
		if ( $menu_visiblity['performance'] == '1' ) {
			remove_submenu_page( 'wn-admin-welcome', 'wn-admin-performance' );
		}
	}

	public function edit_admin_menus() {
		global $submenu;

		if ( current_user_can( 'manage_options' ) ) {
			$submenu['wn-admin-welcome'][0][0] = esc_html__( 'Dashboard', 'deep' );
		}
	}

	public function screen_welcome() {
		echo '<div class="wrap" style="height:0;overflow:hidden;"><h2></h2></div>';
		include_once '_partials/welcome.php';
	}

	public function screen_plugins() {
		echo '<div class="wrap" style="height:0;overflow:hidden;"><h2></h2></div>';
		include_once '_partials/plugins.php';
	}

	public function screen_demo_importer() {
		echo '<div class="wrap" style="height:0;overflow:hidden;"><h2></h2></div>';
		include_once '_partials/demo-listings.php';
	}

	public function screen_video_tutorial() {
		echo '<div class="wrap" style="height:0;overflow:hidden;"><h2></h2></div>';
		include_once '_partials/help.php';
	}

	public function screen_performance() {
		echo '<div class="wrap" style="height:0;overflow:hidden;"><h2></h2></div>';
		include_once '_partials/performance.php';
	}

	public function screen_woo_builder() {
		echo '<div class="wrap" style="height:0;overflow:hidden;"><h2></h2></div>';
		include_once '_partials/woo-dashboard.php';
	}

	public function screen_header_builder() { }

	static function theme( $property = '' ) {
		// Gets a WP_Theme object for a theme
		$theme_data     = wp_get_theme();
		$custom_name    = isset( self::$deep_options['deep_theme_lbl_name'] ) ? self::$deep_options['deep_theme_lbl_name'] : '';
		$custom_version = isset( self::$deep_options['deep_theme_version'] ) ? self::$deep_options['deep_theme_version'] : '';

		if ( $theme_data->parent_theme ) {
			$theme_data = wp_get_theme( basename( get_template_directory() ) );
		}

		switch ( $property ) :

			case 'name':
				$data = ( isset( $custom_name ) && $custom_name != null ) ? $custom_name : 'Deep';
				break;

			case 'version':
				$data = ( isset( $custom_version ) && $custom_version != null ) ? $custom_version : $theme_data->Version;
				break;

			default:
				$data = '';
				break;

		endswitch;

		return $data;
	}

	public function quick_access() {
		$quick_access = isset( self::$deep_options['deep_quick_acess'] ) ? self::$deep_options['deep_quick_acess'] : '';
		if ( $quick_access == '1' ) {
			$current_scr  = get_current_screen();
			$current_page = $current_scr->id;
			$protocol     = is_ssl() ? 'https://' : 'http://';
			$update_btns  = '
			<li class="wn-admin-qacs-item preview-btn">
				<a href="#">
					' . esc_html__( 'Preview page', 'deep' ) . '
				</a>
			</li>
			<li class="wn-admin-qacs-item update-btn">
				<a href="#">
					' . esc_html__( 'Update page', 'deep' ) . '
				</a>
			</li>
			';
			?>

			<div class="wn-admin-qacs-wrap">

				<div class="hamburger hamburger--spring-r">
					<div class="hamburger-box">
						<div class="hamburger-inner"></div>
					</div>
				</div>

				<ul class="wn-admin-qacs">
					<?php

					switch ( $current_page ) {

						case 'post':
							?>
							<?php echo $update_btns; ?>
							<li class="wn-admin-qacs-item">
								<a href="#webnus-post-options">
									<?php esc_html_e( 'Post options', 'deep' ); ?>
								</a>
							</li>
							<li class="wn-admin-qacs-item">
								<a href="<?php echo self_admin_url( 'admin.php?page=wn-admin-options' ); ?>" target="_blank" >
									<?php esc_html_e( 'Options', 'deep' ); ?>
								</a>
							</li>
							<li class="wn-admin-qacs-item">
								<a href="<?php echo $protocol . 'deeptem.com/documentation/'; ?>" target="_blank" >
									<?php esc_html_e( 'Documentation', 'deep' ); ?>
								</a>
							</li>
							<?php
							break;

						case 'page':
							?>
							<?php echo $update_btns; ?>
							<li class="wn-admin-qacs-item">
								<a href="#webnus-page-options">
									<?php esc_html_e( 'Page options', 'deep' ); ?>
								</a>
							</li>
							<li class="wn-admin-qacs-item">
								<a href="<?php echo self_admin_url( 'admin.php?page=wn-admin-options' ); ?>" target="_blank" >
									<?php esc_html_e( 'Options', 'deep' ); ?>
								</a>
							</li>
							<li class="wn-admin-qacs-item">
								<a href="<?php echo $protocol . 'deeptem.com/documentation/'; ?>" target="_blank" >
									<?php esc_html_e( 'Documentation', 'deep' ); ?>
								</a>
							</li>
							<?php
							break;

						case 'cause':
							?>
							<?php echo $update_btns; ?>
							<li class="wn-admin-qacs-item">
								<a href="#webnus-cause-options">
									<?php esc_html_e( 'Cause options', 'deep' ); ?>
								</a>
							</li>
							<li class="wn-admin-qacs-item">
								<a href="<?php echo self_admin_url( 'admin.php?page=wn-admin-options' ); ?>" target="_blank" >
									<?php esc_html_e( 'Options', 'deep' ); ?>
								</a>
							</li>
							<li class="wn-admin-qacs-item">
								<a href="<?php echo $protocol . 'deeptem.com/documentation/'; ?>" target="_blank" >
									<?php esc_html_e( 'Documentation', 'deep' ); ?>
								</a>
							</li>
							<?php
							break;

						case 'gallery':
							?>
							<?php echo $update_btns; ?>
							<li class="wn-admin-qacs-item">
								<a href="<?php echo self_admin_url( 'admin.php?page=wn-admin-options' ); ?>" target="_blank" >
									<?php esc_html_e( 'Options', 'deep' ); ?>
								</a>
							</li>
							<li class="wn-admin-qacs-item">
								<a href="<?php echo $protocol . 'deeptem.com/documentation/'; ?>" target="_blank" >
									<?php esc_html_e( 'Documentation', 'deep' ); ?>
								</a>
							</li>
							<?php
							break;

						case 'wbf_footer':
							?>
							<?php echo $update_btns; ?>
							<li class="wn-admin-qacs-item">
								<a href="<?php echo self_admin_url( 'admin.php?page=wn-admin-options' ); ?>" target="_blank" >
									<?php esc_html_e( 'Options', 'deep' ); ?>
								</a>
							</li>
							<li class="wn-admin-qacs-item">
								<a href="<?php echo $protocol . 'deeptem.com/documentation/'; ?>" target="_blank" >
									<?php esc_html_e( 'Documentation', 'deep' ); ?>
								</a>
							</li>
							<?php
							break;

						case 'portfolio':
							?>
							<?php echo $update_btns; ?>
							<li class="wn-admin-qacs-item">
								<a href="#webnus-portfolio-options">
									<?php esc_html_e( 'Portfolio options', 'deep' ); ?>
								</a>
							</li>
							<li class="wn-admin-qacs-item">
								<a href="<?php echo self_admin_url( 'admin.php?page=wn-admin-options' ); ?>" target="_blank" >
									<?php esc_html_e( 'Options', 'deep' ); ?>
								</a>
							</li>
							<li class="wn-admin-qacs-item">
								<a href="<?php echo $protocol . 'deeptem.com/documentation/'; ?>" target="_blank" >
									<?php esc_html_e( 'Documentation', 'deep' ); ?>
								</a>
							</li>
							<?php
							break;

						case 'sermon':
							?>
							<?php echo $update_btns; ?>
							<li class="wn-admin-qacs-item">
								<a href="#webnus-sermon-options">
									<?php esc_html_e( 'Sermon options', 'deep' ); ?>
								</a>
							</li>
							<li class="wn-admin-qacs-item">
								<a href="<?php echo self_admin_url( 'admin.php?page=wn-admin-options' ); ?>" target="_blank" >
									<?php esc_html_e( 'Options', 'deep' ); ?>
								</a>
							</li>
							<li class="wn-admin-qacs-item">
								<a href="<?php echo $protocol . 'deeptem.com/documentation/'; ?>" target="_blank" >
									<?php esc_html_e( 'Documentation', 'deep' ); ?>
								</a>
							</li>
							<?php
							break;

						case 'mega_menu':
							?>
							<?php echo $update_btns; ?>
							<li class="wn-admin-qacs-item">
								<a href="<?php echo self_admin_url( 'admin.php?page=wn-admin-options' ); ?>" target="_blank" >
									<?php esc_html_e( 'Options', 'deep' ); ?>
								</a>
							</li>
							<li class="wn-admin-qacs-item">
								<a href="<?php echo $protocol . 'deeptem.com/documentation/'; ?>" target="_blank" >
									<?php esc_html_e( 'Documentation', 'deep' ); ?>
								</a>
							</li>
							<?php
							break;

						case 'mec-events':
							?>
							<?php echo $update_btns; ?>
							<li class="wn-admin-qacs-item">
								<a href="#mec_metabox_details">
									<?php esc_html_e( 'Event options', 'deep' ); ?>
								</a>
							</li>
							<li class="wn-admin-qacs-item">
								<a href="<?php echo self_admin_url( 'admin.php?page=MEC-settings' ); ?>" target="_blank" >
									<?php esc_html_e( 'M.E. Calendar settings', 'deep' ); ?>
								</a>
							</li>
							<li class="wn-admin-qacs-item">
								<a href="<?php echo self_admin_url( 'admin.php?page=wn-admin-options' ); ?>" target="_blank" >
									<?php esc_html_e( 'Options', 'deep' ); ?>
								</a>
							</li>
							<li class="wn-admin-qacs-item">
								<a href="<?php echo $protocol . 'deeptem.com/documentation/'; ?>" target="_blank" >
									<?php esc_html_e( 'Documentation', 'deep' ); ?>
								</a>
							</li>
							<?php
							break;

						default:
							?>

							<li class="wn-admin-qacs-item">
								<a href="<?php echo self_admin_url( 'post-new.php' ); ?>" target="_blank" >
									<?php esc_html_e( 'Add new post', 'deep' ); ?>
								</a>
							</li>

							<li class="wn-admin-qacs-item">
								<a href="<?php echo self_admin_url( 'post-new.php?post_type=page' ); ?>" target="_blank" >
									<?php esc_html_e( 'Add new page', 'deep' ); ?>
								</a>
							</li>

							<?php if ( defined( 'GALLERY_DIR' ) ) : ?>
							<li class="wn-admin-qacs-item">
								<a href="<?php echo self_admin_url( 'post-new.php?post_type=gallery' ); ?>" target="_blank" >
									<?php esc_html_e( 'Add new gallery', 'deep' ); ?>
								</a>
							</li>
							<?php endif; ?>

							<li class="wn-admin-qacs-item">
								<a href="<?php echo self_admin_url( 'post-new.php?post_type=wbf_footer' ); ?>" target="_blank" >
									<?php esc_html_e( 'Add new footer', 'deep' ); ?>
								</a>
							</li>

							<li class="wn-admin-qacs-item">
								<a href="<?php echo self_admin_url( 'post-new.php?post_type=mega_menu' ); ?>" target="_blank" >
									<?php esc_html_e( 'Add new mega menu', 'deep' ); ?>
								</a>
							</li>

							<?php if ( defined( 'PORTFOLIO_DIR' ) ) : ?>
							<li class="wn-admin-qacs-item">
								<a href="<?php echo self_admin_url( 'post-new.php?post_type=portfolio' ); ?>" target="_blank" >
									<?php esc_html_e( 'Add new portfolio', 'deep' ); ?>
								</a>
							</li>
							<?php endif; ?>

							<?php if ( is_plugin_active( 'modern-events-calendar-lite/modern-events-calendar-lite.php' ) || is_plugin_active( 'modern-events-calendar/mec.php' ) ) : ?>
							<li class="wn-admin-qacs-item">
								<a href="<?php echo self_admin_url( 'post-new.php?post_type=mec-events' ); ?>" target="_blank" >
									<?php esc_html_e( 'Add new event', 'deep' ); ?>
								</a>
							</li>
							<?php endif; ?>

							<?php if ( defined( 'CAUSES_DIR' ) ) : ?>
							<li class="wn-admin-qacs-item">
								<a href="<?php echo self_admin_url( 'post-new.php?post_type=cause' ); ?>" target="_blank" >
									<?php esc_html_e( 'Add new cause', 'deep' ); ?>
								</a>
							</li>
							<?php endif; ?>

							<?php if ( defined( 'SERMONS_DIR' ) ) : ?>
							<li class="wn-admin-qacs-item">
								<a href="<?php echo self_admin_url( 'post-new.php?post_type=sermon' ); ?>" target="_blank" >
									<?php esc_html_e( 'Add new sermon', 'deep' ); ?>
								</a>
							</li>
							<?php endif; ?>

							<li class="wn-admin-qacs-item">
								<a href="<?php echo self_admin_url( 'admin.php?page=wn-admin-options' ); ?>" target="_blank" >
									<?php esc_html_e( 'Options', 'deep' ); ?>
								</a>
							</li>

							<li class="wn-admin-qacs-item">
								<a href="<?php echo $protocol . 'deeptem.com/documentation/'; ?>" target="_blank" >
									<?php esc_html_e( 'Documentation', 'deep' ); ?>
								</a>
							</li>

							<?php
							break;

					}
					?>
				</ul>
			</div>
			<?php
		}
	}

	/**
	 * Dashboard tabs.
	 *
	 * @since 5.1.0
	 *
	 * @access public
	 */
	public function deep_dashboard_tabs() {

		$woo_class = ( class_exists( 'WooCommerce' ) ) ? 'woo-class' : '';

		?>
		<div class="wrap about-wrap wn-admin-wrap">
			<h1><?php esc_html_e( 'Deep Theme', 'deep' ); ?></h1>
		<div class="wp-badge">
			<?php printf( esc_html__( 'Version %s', 'deep' ), DEEP_VERSION ); ?>
		</div>
		<?php do_action( 'deep_before_start_dashboard' ); ?>
		<h2 class="nav-tab-wrapper wp-clearfix <?php esc_attr_e( $woo_class ); ?>">
			<?php
			// Dashboard Menu
			self::dashboard_menu();
			?>
		</h2>
		<?php
	}

	/**
	 * Dashboard tabs end.
	 *
	 * @since 5.1.0
	 *
	 * @access public
	 */
	public function deep_dashboard_tabs_end() {
		?>
		</div>
		<?php
	}
}

new Deep_Admin();
