<?php
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

class Suffice_Upgrade_Notice extends Suffice_Notice {

	public function __construct() {
		if ( ! current_user_can( 'publish_posts' ) ) {
			return;
		}

		$dismiss_url = wp_nonce_url(
			add_query_arg( 'suffice_notice_dismiss', 'upgrade', admin_url() ),
			'suffice_upgrade_notice_dismiss_nonce',
			'_suffice_upgrade_notice_dismiss_nonce'
		);

		$temporary_dismiss_url = wp_nonce_url(
			add_query_arg( 'suffice_notice_dismiss_temporary', 'upgrade', admin_url() ),
			'suffice_upgrade_notice_dismiss_temporary_nonce',
			'_suffice_upgrade_notice_dismiss_temporary_nonce'
		);

		parent::__construct( 'upgrade', 'info', $dismiss_url, $temporary_dismiss_url );

		$this->set_notice_time();

		$this->set_temporary_dismiss_notice_time();

		$this->set_dismiss_notice();
	}

	private function set_notice_time() {
		if ( ! get_option( 'suffice_upgrade_notice_start_time' ) ) {
			update_option( 'suffice_upgrade_notice_start_time', time() );
		}
	}

	private function set_temporary_dismiss_notice_time() {
		if ( isset( $_GET['suffice_notice_dismiss_temporary'] ) && 'upgrade' === $_GET['suffice_notice_dismiss_temporary'] ) {
			update_user_meta( $this->current_user_id, 'suffice_upgrade_notice_dismiss_temporary_start_time', time() );
		}
	}

	public function set_dismiss_notice() {

		/**
		 * Do not show notice if:
		 *
		 * 1. It has not been 5 days since the theme is activated.
		 * 2. If the user has ignored the message partially for 2 days.
		 * 3. Dismiss always if clicked on 'Dismiss' button.
		 */
		if ( get_option( 'suffice_upgrade_notice_start_time' ) > strtotime( '-5 day' )
			|| get_user_meta( get_current_user_id(), 'suffice_upgrade_notice_dismiss', true )
			|| get_user_meta( get_current_user_id(), 'suffice_upgrade_notice_dismiss_temporary_start_time', true ) > strtotime( '-2 day' )
		) {
			add_filter( 'suffice_upgrade_notice_dismiss', '__return_true' );
		} else {
			add_filter( 'suffice_upgrade_notice_dismiss', '__return_false' );
		}
	}

	public function notice_markup() {
		?>
		<div class="notice notice-success suffice-notice">
			<a class="suffice-notice-dismiss notice-dismiss" href="<?php echo esc_url( $this->dismiss_url ); ?>"></a>

			<p class="notice-text">
				<?php
				$current_user = wp_get_current_user();

				printf(
					esc_html__(
					    /* Translators: %1$s current user display name., %2$s this theme name., %3$s discount coupon code., %4$s discount percentage. */
						'Howdy, %1$s! You\'ve been using %2$s theme for a while now, and we hope you\'re happy with it. To access more premium features you can always upgrade to pro. All contents and settings will remain as it is after upgrading to pro, you basically start from where you left. Also, you can use the coupon code %3$s to get %4$s discount (limited time offer) while making the purchase. Enjoy! ',
						'suffice'
					),
					'<strong>' . esc_html( $current_user->display_name ) . '</strong>',
					'Suffice',
					'<code class="coupon-code">upgrade15</code>',
					'15%'
				);
				?>
			</p>

			<div class="links">
				<a href="<?php echo esc_url( $this->pricing_url ); ?>" class="button button-primary" target="_blank">
					<span class="dashicons dashicons-thumbs-up"></span>
					<span><?php esc_html_e( 'Upgrade to pro', 'suffice' ); ?></span>
				</a>

				<a href="<?php echo esc_url( $this->temporary_dismiss_url ); ?>" class="button button-secondary">
					<span class="dashicons dashicons-calendar"></span>
					<span><?php esc_html_e( 'Maybe later', 'suffice' ); ?></span>
				</a>

				<a href="https://themegrill.com/contact/?utm_source=suffice-dashboard-message&utm_medium=button-link&utm_campaign=pre-sales" class="button button-secondary" target="_blank">
					<span class="dashicons dashicons-info"></span>
					<span><?php esc_html_e( 'Got pre sales queries?', 'suffice' ); ?></span>
				</a>
			</div>
		</div> <!-- /suffice-notice -->
		<?php
	}
}

new Suffice_Upgrade_Notice();
