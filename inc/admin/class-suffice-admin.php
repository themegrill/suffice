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
			add_action( 'admin_menu', array( $this, 'admin_menu' ) );
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

		/**
		 * Add admin menu.
		 */
		public function admin_menu() {
			$theme = wp_get_theme( get_template() );

			$page = add_theme_page(
				esc_html__( 'About', 'suffice' ) . ' ' . $theme->display( 'Name' ),
				esc_html__( 'About', 'suffice' ) . ' ' . $theme->display( 'Name' ),
				'activate_plugins',
				'suffice-welcome',
				array(
					$this,
					'welcome_screen',
				)
			);
			add_action( 'admin_print_styles-' . $page, array( $this, 'enqueue_scripts' ) );
		}

		/**
		 * Intro text/links shown to all about pages.
		 *
		 * @access private
		 */
		private function intro() {
			$theme = wp_get_theme( get_template() );

			// Drop minor version if 0
			$major_version = substr( SUFFICE_THEME_VERSION, 0, 3 );
			?>
			<div class="suffice-theme-info">
				<h1>
					<?php esc_html_e( 'About', 'suffice' ); ?>
					<?php echo $theme->display( 'Name' ); ?>
					<?php printf( '%s', $major_version ); ?>
				</h1>

				<div class="welcome-description-wrap">
					<div class="about-text"><?php echo $theme->display( 'Description' ); ?></div>

					<div class="suffice-screenshot">
						<img src="<?php echo esc_url( get_template_directory_uri() ) . '/screenshot.jpg'; ?>" />
					</div>
				</div>
			</div>

			<p class="suffice-actions">
				<a href="<?php echo esc_url( 'https://themegrill.com/themes/suffice/?utm_source=suffice-about&utm_medium=theme-info-link&utm_campaign=theme-info' ); ?>" class="button button-secondary" target="_blank"><?php esc_html_e( 'Theme Info', 'suffice' ); ?></a>

				<a href="<?php echo esc_url( 'https://demo.themegrill.com/suffice/' ); ?>" class="button button-secondary docs" target="_blank"><?php esc_html_e( 'View Demo', 'suffice' ); ?></a>

				<a href="<?php echo esc_url( 'https://themegrill.com/themes/suffice/?utm_source=suffice-about&utm_medium=view-pro-link&utm_campaign=view-pro#free-vs-pro' ); ?>" class="button button-primary docs" target="_blank"><?php esc_html_e( 'View PRO version', 'suffice' ); ?></a>

				<a href="<?php echo esc_url( 'https://wordpress.org/support/theme/suffice/reviews?rate=5#new-post' ); ?>" class="button button-secondary docs" target="_blank"><?php esc_html_e( 'Rate this theme', 'suffice' ); ?></a>
			</p>

			<h2 class="nav-tab-wrapper">
				<a class="nav-tab 
				<?php
				if ( empty( $_GET['tab'] ) && $_GET['page'] == 'suffice-welcome' ) {
					echo 'nav-tab-active';
				}
				?>
				" href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'suffice-welcome' ), 'themes.php' ) ) ); ?>">
					<?php echo $theme->display( 'Name' ); ?>
				</a>
				<a class="nav-tab 
				<?php
				if ( isset( $_GET['tab'] ) && $_GET['tab'] == 'supported_plugins' ) {
					echo 'nav-tab-active';
				}
				?>
				" href="
				<?php
				echo esc_url(
					admin_url(
						add_query_arg(
							array(
								'page' => 'suffice-welcome',
								'tab'  => 'supported_plugins',
							),
							'themes.php'
						)
					)
				);
				?>
				">
					<?php esc_html_e( 'Supported Plugins', 'suffice' ); ?>
				</a>
				<a class="nav-tab 
				<?php
				if ( isset( $_GET['tab'] ) && $_GET['tab'] == 'free_vs_pro' ) {
					echo 'nav-tab-active';
				}
				?>
				" href="
				<?php
				echo esc_url(
					admin_url(
						add_query_arg(
							array(
								'page' => 'suffice-welcome',
								'tab'  => 'free_vs_pro',
							),
							'themes.php'
						)
					)
				);
				?>
				">
					<?php esc_html_e( 'Free Vs Pro', 'suffice' ); ?>
				</a>
				<a class="nav-tab 
				<?php
				if ( isset( $_GET['tab'] ) && $_GET['tab'] == 'changelog' ) {
					echo 'nav-tab-active';
				}
				?>
				" href="
				<?php
				echo esc_url(
					admin_url(
						add_query_arg(
							array(
								'page' => 'suffice-welcome',
								'tab'  => 'changelog',
							),
							'themes.php'
						)
					)
				);
				?>
				">
					<?php esc_html_e( 'Changelog', 'suffice' ); ?>
				</a>
			</h2>
			<?php
		}

		/**
		 * Welcome screen page.
		 */
		public function welcome_screen() {
			$current_tab = empty( $_GET['tab'] ) ? 'about' : sanitize_title( $_GET['tab'] );

			// Look for a {$current_tab}_screen method.
			if ( is_callable( array( $this, $current_tab . '_screen' ) ) ) {
				return $this->{$current_tab . '_screen'}();
			}

			// Fallback to about screen.
			return $this->about_screen();
		}

		/**
		 * Output the about screen.
		 */
		public function about_screen() {
			$theme = wp_get_theme( get_template() );
			?>
			<div class="wrap about-wrap">

				<?php $this->intro(); ?>

				<div class="changelog point-releases">
					<div class="under-the-hood two-col">
						<div class="col">
							<h3><?php esc_html_e( 'Theme Customizer', 'suffice' ); ?></h3>
							<p><?php esc_html_e( 'All Theme Options are available via Customize screen.', 'suffice' ); ?></p>
							<p>
								<a href="<?php echo admin_url( 'customize.php' ); ?>" class="button button-secondary"><?php esc_html_e( 'Customize', 'suffice' ); ?></a>
							</p>
						</div>

						<div class="col">
							<h3><?php esc_html_e( 'Documentation', 'suffice' ); ?></h3>
							<p><?php esc_html_e( 'Please view our documentation page to setup the theme.', 'suffice' ); ?></p>
							<p>
								<a href="<?php echo esc_url( 'https://docs.themegrill.com/suffice/?utm_source=suffice-about&utm_medium=documentation-link&utm_campaign=documentation' ); ?>" class="button button-secondary" target="_blank"><?php esc_html_e( 'Documentation', 'suffice' ); ?></a>
							</p>
						</div>

						<div class="col">
							<h3><?php esc_html_e( 'Got theme support question?', 'suffice' ); ?></h3>
							<p><?php esc_html_e( 'Please put it in our dedicated support forum.', 'suffice' ); ?></p>
							<p>
								<a href="<?php echo esc_url( 'https://themegrill.com/support-forum/?utm_source=suffice-about&utm_medium=support-forum-link&utm_campaign=support-forum' ); ?>" class="button button-secondary" target="_blank"><?php esc_html_e( 'Support Forum', 'suffice' ); ?></a>
							</p>
						</div>

						<div class="col">
							<h3>
								<?php
								esc_html_e( 'Translate', 'suffice' );
								echo ' ' . $theme->display( 'Name' );
								?>
							</h3>
							<p><?php esc_html_e( 'Click below to translate this theme into your own language.', 'suffice' ); ?></p>
							<p>
								<a href="<?php echo esc_url( 'http://translate.wordpress.org/projects/wp-themes/suffice' ); ?>" class="button button-secondary">
									<?php
									esc_html_e( 'Translate', 'suffice' );
									echo ' ' . $theme->display( 'Name' );
									?>
								</a>
							</p>
						</div>
					</div>
				</div>

				<div class="return-to-dashboard suffice">
					<?php if ( current_user_can( 'update_core' ) && isset( $_GET['updated'] ) ) : ?>
						<a href="<?php echo esc_url( self_admin_url( 'update-core.php' ) ); ?>">
							<?php is_multisite() ? esc_html_e( 'Return to Updates', 'suffice' ) : esc_html_e( 'Return to Dashboard &rarr; Updates', 'suffice' ); ?>
						</a> |
					<?php endif; ?>
					<a href="<?php echo esc_url( self_admin_url() ); ?>"><?php is_blog_admin() ? esc_html_e( 'Go to Dashboard &rarr; Home', 'suffice' ) : esc_html_e( 'Go to Dashboard', 'suffice' ); ?></a>
				</div>
			</div>
			<?php
		}

		/**
		 * Output the changelog screen.
		 */
		public function changelog_screen() {
			global $wp_filesystem;

			?>
			<div class="wrap about-wrap">

				<?php $this->intro(); ?>

				<p class="about-description"><?php esc_html_e( 'View changelog below:', 'suffice' ); ?></p>

				<?php
				$changelog_file = apply_filters( 'suffice_changelog_file', get_template_directory() . '/README.md' );

				// Check if the changelog file exists and is readable.
				if ( $changelog_file && is_readable( $changelog_file ) ) {
					WP_Filesystem();
					$changelog      = $wp_filesystem->get_contents( $changelog_file );
					$changelog_list = $this->parse_changelog( $changelog );

					echo wp_kses_post( $changelog_list );
				}
				?>
			</div>
			<?php
		}

		/**
		 * Parse changelog from readme file.
		 *
		 * @param  string $content
		 *
		 * @return string
		 */
		private function parse_changelog( $content ) {
			$matches   = null;
			$regexp    = '~##\s*Changelog\s*(.*)($)~Uis';
			$changelog = '';

			if ( preg_match( $regexp, $content, $matches ) ) {
				$changes = explode( '\r\n', trim( $matches[1] ) );

				$changelog .= '<pre class="changelog">';

				foreach ( $changes as $index => $line ) {
					$changelog .= wp_kses_post( preg_replace( '~(=\s*Version\s*(\d+(?:\.\d+)+)\s*=|$)~Uis', '<span class="title">${1}</span>', $line ) );
				}

				$changelog .= '</pre>';
			}

			return wp_kses_post( $changelog );
		}

		/**
		 * Output the supported plugins screen.
		 */
		public function supported_plugins_screen() {
			?>
			<div class="wrap about-wrap">

				<?php $this->intro(); ?>

				<p class="about-description"><?php esc_html_e( 'This theme recommends following plugins:', 'suffice' ); ?></p>
				<ol>
					<li>
						<a href="<?php echo esc_url( 'https://wordpress.org/plugins/suffice-toolkit/' ); ?>" target="_blank"><?php esc_html_e( 'Suffice Toolkit', 'suffice' ); ?></a>
						<?php esc_html_e( ' by ThemeGrill', 'suffice' ); ?>
					</li>
					<li>
						<a href="<?php echo esc_url( 'https://wordpress.org/plugins/social-icons/' ); ?>" target="_blank"><?php esc_html_e( 'Social Icons', 'suffice' ); ?></a>
						<?php esc_html_e( ' by ThemeGrill', 'suffice' ); ?>
					</li>
					<li>
						<a href="<?php echo esc_url( 'https://wordpress.org/plugins/easy-social-sharing/' ); ?>" target="_blank"><?php esc_html_e( 'Easy Social Sharing', 'suffice' ); ?></a>
						<?php esc_html_e( ' by ThemeGrill', 'suffice' ); ?>
					</li>
					<li>
						<a href="<?php echo esc_url( 'https://wordpress.org/plugins/everest-forms/' ); ?>" target="_blank"><?php esc_html_e( 'Everest Forms – Easy Contact Form and Form Builder', 'suffice' ); ?></a>
						<?php esc_html_e( ' by ThemeGrill', 'suffice' ); ?>
					</li>
					<li>
						<a href="<?php echo esc_url( 'https://wordpress.org/plugins/siteorigin-panels/' ); ?>" target="_blank"><?php esc_html_e( 'Page Builder by SiteOrigin', 'suffice' ); ?></a>
					</li>
					<li>
						<a href="<?php echo esc_url( 'https://wordpress.org/plugins/woocommerce/' ); ?>" target="_blank"><?php esc_html_e( 'WooCommerce', 'suffice' ); ?></a>
					</li>
				</ol>

			</div>
			<?php
		}

		/**
		 * Output the free vs pro screen.
		 */
		public function free_vs_pro_screen() {
			?>
			<div class="wrap about-wrap">

				<?php $this->intro(); ?>

				<p class="about-description"><?php esc_html_e( 'Upgrade to PRO version for more exciting features.', 'suffice' ); ?></p>

				<div class="btn-wrapper">
					<a href="<?php echo esc_url( apply_filters( 'suffice_pro_theme_url', 'https://themegrill.com/themes/suffice/?utm_source=suffice-free-vs-pro-table&utm_medium=view-pro-link&utm_campaign=view-pro#free-vs-pro' ) ); ?>" class="button button-primary docs" target="_blank"><?php esc_html_e( 'View Pro', 'suffice' ); ?></a>
				</div>

			</div>
			<?php
		}

	}

endif;

return new Suffice_Admin();
