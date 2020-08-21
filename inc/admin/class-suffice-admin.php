<?php
/**
 * Suffice Admin Class.
 *
 * @author  ThemeGrill
 * @package suffice
 * @since   1.2.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Suffice_Admin' ) ) :

	/**
	 * Suffice_Admin Class.
	 */
	class Suffice_Admin {

		/**
		 * Constructor.
		 */
		public function __construct() {
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		}

		/**
		 * Localize array for import button AJAX request.
		 */
		public function enqueue_scripts() {
			wp_enqueue_style( 'suffice-admin-style', get_template_directory_uri() . '/inc/admin/css/admin.css', array(), SUFFICE_THEME_VERSION );

			wp_enqueue_script( 'suffice-plugin-install-helper', get_template_directory_uri() . '/inc/admin/js/plugin-handle.js', array( 'jquery' ), SUFFICE_THEME_VERSION, true );

			$welcome_data = array(
				'uri'      => esc_url( admin_url( '/themes.php?page=demo-importer&browse=all&suffice-hide-notice=welcome' ) ),
				'btn_text' => esc_html__( 'Processing...', 'suffice' ),
				'nonce'    => wp_create_nonce( 'suffice_demo_import_nonce' ),
			);

			wp_localize_script( 'suffice-plugin-install-helper', 'sufficeRedirectDemoPage', $welcome_data );
		}
	}

endif;

return new Suffice_Admin();
