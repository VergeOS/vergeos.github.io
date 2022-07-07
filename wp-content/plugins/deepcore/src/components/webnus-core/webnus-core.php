<?php
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

// define some const
define( 'WEBNUS_CORE_DIR', DEEP_COMPONENTS_DIR . 'webnus-core/');
define( 'WEBNUS_CORE_URL', DEEP_COMPONENTS_URL . 'webnus-core/');

/*********************/
/*	    LOGIN
/*********************/
if ( ! function_exists('deep_login') ) {
	function deep_login($args = '') {
		$deep_options = deep_options();
		$color_skin_class = ( isset( $deep_options['deep_webnus_custom_color_skin'] ) || isset( $deep_options['deep_webnus_color_skin'] ) && $deep_options['deep_webnus_color_skin'] != 'e3e3e3' ) ? 'colorskin-custom' : '' ;
		global $user_ID, $user_identity, $user_role;

		$args = !empty($args) ? $args : array('label_username' => esc_html__( 'Username','deep' ),'label_password' => esc_html__( 'Password','deep' ),'label_remember' => esc_html__( 'Remember Me','deep' ),'label_log_in'   => esc_html__( 'Log In','deep' ),);
		if ( $user_ID ) :
			$user = wp_get_current_user();
			$roles = ( array ) $user->roles;
			$user_role = $roles[0];
		?>
			<div class="login-dropdown-arrow-wrap"></div>
			<div class="user-logged <?php echo $color_skin_class; ?>">
				<span class="author-avatar"><?php echo get_avatar( $user_ID, $size = '100'); ?></span>
				<div class="user-name"><?php echo esc_html($user_identity) ?></div>
				<div class="user-role"><?php echo esc_html($user_role) ?></div>
				<ul class="logged-links colorf">
					<?php if ( is_plugin_active( 'buddypress/bp-loader.php' ) ) { ?>
						<li class="profile-link"><a href="<?php echo bp_loggedin_user_domain(); ?>"><?php esc_html_e('Profile','deep'); ?> </a></li>
						<li class="logout-link"><a href="<?php echo esc_url(wp_logout_url(get_permalink())); ?>"><?php esc_html_e('Logout','deep'); ?> </a></li>
					<?php } else { ?>
						<li class="profile-link"><a href="<?php echo esc_url(home_url('/wp-admin/profile.php')); ?>"><?php esc_html_e('My Profile','deep'); ?> </a></li>
						<li class="logout-link"><a href="<?php echo esc_url(wp_logout_url(get_permalink())); ?>"><?php esc_html_e('Logout','deep'); ?> </a></li>
					<?php } ?>
				</ul>
				<div class="clear"></div>
			</div>
		<?php else: ?>
			<div class="login-dropdown-arrow-wrap"></div>
				<?php if ( is_plugin_active('super-socializer/super_socializer.php') ) { ?>
					<!-- social login -->
					<div class="wn-social-login">
						<?php echo do_shortcode('[TheChamp-Login]'); ?>
						<div class="wn-or-divider">
							<span><?php _e( 'or', 'deep' ); ?></span>
						</div>
					</div>
				<?php } ?>
			<h3 class="user-login-title"><?php esc_html_e( 'Account Login', 'deep' ); ?></h3>
			<div class="user-login">
			<?php wp_login_form($args);?>
				<ul class="login-links">
					<?php if ( get_option('users_can_register') ) : ?><?php echo wp_register() ?><?php endif; ?>
					<li><a href="<?php echo esc_url(wp_lostpassword_url(get_permalink()))?>"><?php esc_html_e('Forget Password?','deep'); ?></a></li>
				</ul>
			</div>
		<?php endif;
	}
}