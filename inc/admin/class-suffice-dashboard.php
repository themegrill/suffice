<?php
/**
 * Suffice Dashboard Class.
 *
 * @author  ThemeGrill
 * @package Suffice
 * @since   Suffice 1.2.3
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Class Suffice_Dashboard
 */
class Suffice_Dashboard {
	private static $instance;

	public static function instance() {

		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	private function __construct() {
		$this->setup_hooks();
	}

	private function setup_hooks() {
		add_action( 'admin_menu', array( $this, 'create_menu' ) );
	}

	public function create_menu() {
		if ( is_child_theme() ) {
			$theme = wp_get_theme()->parent();
		} else {
			$theme = wp_get_theme();
		}

		/* translators: %s: Theme Name. */
		$theme_page_name = sprintf( esc_html__( '%s Options', 'suffice' ), $theme->Name );

		$page = add_theme_page(
			$theme_page_name,
			$theme_page_name,
			'edit_theme_options',
			'suffice-options',
			array(
				$this,
				'option_page',
			)
		);

	}

	public function option_page() {
		if ( is_child_theme() ) {
			$theme = wp_get_theme()->parent();
		} else {
			$theme = wp_get_theme();
		}

		?>
		<div class="wrap">
		<div class="suffice-header">
			<h1>
				<?php
				/* translators: %s: Theme version. */
				echo sprintf( esc_html__( 'Suffice %s', 'suffice' ), $theme->Version );
				?>
			</h1>
		</div>
		<div class="welcome-panel">
			<div class="welcome-panel-content">
				<h2>
					<?php
					/* translators: %s: Theme Name. */
					echo sprintf( esc_html__( 'Welcome to %s!', 'suffice' ), $theme->Name );
					?>
				</h2>
				<p class="about-description">
					<?php
					/* translators: %s: Theme Name. */
					echo sprintf( esc_html__( 'Important links to get you started with %s', 'suffice' ), $theme->Name );
					?>
				</p>

				<div class="welcome-panel-column-container">
					<div class="welcome-panel-column">
						<h3><?php esc_html_e( 'Get Started', 'suffice' ); ?></h3>
						<a class="button button-primary button-hero"
						   href="<?php echo esc_url( 'https://docs.themegrill.com/suffice/#section-1' ); ?>"
						   target="_blank"><?php esc_html_e( 'Learn Basics', 'suffice' ); ?>
						</a>
					</div>

					<div class="welcome-panel-column">
						<h3><?php esc_html_e( 'Next Steps', 'suffice' ); ?></h3>
						<ul>
							<li><?php printf( '<a target="_blank" href="%s" class="welcome-icon dashicons-media-text">' . esc_html__( 'Documentation', 'suffice' ) . '</a>', esc_url( 'https://docs.themegrill.com/suffice' ) ); ?></li>
							<li><?php printf( '<a target="_blank" href="%s" class="welcome-icon dashicons-layout">' . esc_html__( 'Starter Demos', 'suffice' ) . '</a>', esc_url( 'https://demo.themegrill.com/suffice-demos' ) ); ?></li>
							<li><?php printf( '<a target="_blank" href="%s" class="welcome-icon dashicons-migrate">' . esc_html__( 'Premium Version', 'suffice' ) . '</a>', esc_url( 'https://themegrill.com/themes/suffice' ) ); ?></li>
						</ul>
					</div>

					<div class="welcome-panel-column">
						<h3><?php esc_html_e( 'Further Actions', 'suffice' ); ?></h3>
						<ul>
							<li><?php printf( '<a target="_blank" href="%s" class="welcome-icon dashicons-businesswoman">' . esc_html__( 'Got theme support question?', '' ) . '</a>', esc_url( 'https://wordpress.org/support/theme//' ) ); ?></li>
							<li><?php printf( '<a target="_blank" href="%s" class="welcome-icon dashicons-thumbs-up">' . esc_html__( 'Leave a review', 'suffice' ) . '</a>', esc_url( 'https://wordpress.org/support/theme/suffice/reviews/' ) ); ?></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
}

Suffice_Dashboard::instance();
