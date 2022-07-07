<?php
/**
 * My Account Navigation Links
 *
 * @since    2.?.?
 * @version  3.17.5
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$current 		 = LLMS_Student_Dashboard::get_current_tab( 'slug' );
$current_user_id = get_current_user_id();
$user_avatar 	 = get_avatar( $current_user_id, 55 );
$user 			 = get_userdata( $current_user_id );
$user_name 		 = $user->display_name;
$author_position = get_user_meta( $current_user_id, 'author_position' );

?>
<nav class="llms-sd-nav">

	<div class="deep-llms-user-info">
		<div class="llms-user-avatar">
			<?php echo wp_kses_post( $user_avatar ); ?>
		</div>
		<div class="llms-user-name">
			<?php esc_html_e( $user_name ); ?>
			<div class="llms-user-position">
				<?php
					if ( $author_position[0] ) {
						esc_html_e( $author_position[0] );
					}
				?>
			</div>
		</div>
	</div>
	<?php do_action( 'lifterlms_before_my_account_navigation' ); ?>

	<ul class="llms-sd-items">
		<?php foreach ( LLMS_Student_Dashboard::get_tabs_for_nav() as $var => $data ) : ?>
			<li class="llms-sd-item <?php printf( '%1$s %2$s', $var, ( $var === $current ) ? ' current' : '' ); ?>">
				<a class="llms-sd-link" href="<?php echo esc_url( $data['url'] ); ?>"><?php echo $data['title']; ?></a>
			</li>
		<?php endforeach; ?>
	</ul>

	<?php do_action( 'lifterlms_after_my_account_navigation' ); ?>

</nav>
