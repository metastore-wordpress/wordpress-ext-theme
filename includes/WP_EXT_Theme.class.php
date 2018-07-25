<?php

/**
 * Class WP_EXT_Theme
 */
class WP_EXT_Theme {

	protected $font_version_fa;
	protected $font_family_google;

	/**
	 * Constructor.
	 */
	public function __construct() {
		// Settings.
		$this->font_version_fa    = '5.1.1';
		$this->font_family_google = 'Roboto+Condensed:400,400i,700,700i|Roboto:400,400i,700,700i|Fira+Mono:400,700';

		// Languages.
		self::languages();

		// Initialize.
		$this->run();
	}

	/**
	 * Plugin: `initialize`.
	 */
	public function run() {
		// Remove styles & scripts.
		add_action( 'wp_enqueue_scripts', [ $this, 'style_disable' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'script_disable' ] );

		// Add styles.
		add_action( 'wp_enqueue_scripts', [ $this, 'style_font_awesome' ], 90 );
		add_action( 'wp_enqueue_scripts', [ $this, 'style_font_google' ], 90 );
		add_action( 'wp_enqueue_scripts', [ $this, 'style_fancybox' ], 90 );
		add_action( 'wp_enqueue_scripts', [ $this, 'style_enable' ], 99 );

		// Add scripts.
		add_action( 'wp_enqueue_scripts', [ $this, 'script_enable' ] );

		// Post formats support.
		add_theme_support( 'post-formats', [
			'aside',
			'audio',
			'chat',
			'gallery',
			'image',
			'link',
			'quote',
			'status',
			'video'
		] );
	}

	/**
	 * Plugin: `languages`.
	 */
	public function languages() {
		load_plugin_textdomain(
			'wp-ext-themes',
			false,
			dirname( plugin_basename( __FILE__ ) ) . '/languages/'
		);
	}

	/**
	 * Theme information.
	 *
	 * @param $info
	 *
	 * @return false|string
	 */
	public function theme_info( $info ) {
		$parentTheme = wp_get_theme( get_template() );
		$themeName   = $parentTheme->get( $info );

		return $themeName;
	}

	/**
	 * Remove styles.
	 */
	public function style_disable() {
		if ( ! is_admin() ) {
			$styles = [];

			foreach ( $styles as $style ) {
				wp_deregister_style( $style );
			}
		}
	}

	/**
	 * Remove scripts.
	 */
	public function script_disable() {
		if ( ! is_admin() ) {
			$scripts = [
				'jquery',
				'jquery-migrate',
			];

			foreach ( $scripts as $script ) {
				wp_deregister_script( $script );
			}
		}
	}

	/**
	 * Add style: `Font Awesome`.
	 */
	public function style_font_awesome() {
		if ( ! is_admin() ) {
			wp_enqueue_style( 'ext-theme-font-awesome', 'https://use.fontawesome.com/releases/v' . $this->font_version_fa . '/css/all.css', [], '' );
		}
	}

	/**
	 * Add style: `Google Font`.
	 */
	public function style_font_google() {
		if ( ! is_admin() ) {
			wp_enqueue_style( 'ext-theme-font-google', 'https://fonts.googleapis.com/css?family=' . $this->font_family_google . '&amp;subset=cyrillic', [], '' );
		}
	}

	/**
	 * Add style: `fancyBox`.
	 */
	public function style_fancybox() {
		if ( ! is_admin() ) {
			wp_enqueue_style( 'ext-theme-fancybox', 'https://cdn.jsdelivr.net/npm/@fancyapps/fancybox/dist/jquery.fancybox.min.css', [], '' );
		}
	}

	/**
	 * Add style: `Theme`.
	 */
	public function style_enable() {
		if ( ! is_admin() ) {
			wp_enqueue_style( 'ext-theme', get_stylesheet_directory_uri() . '/ext-themes/styles/theme.css', [], '' );
		}
	}

	/**
	 * Add common scripts.
	 */
	public function script_enable() {
		if ( ! is_admin() ) {
			$scripts = [
				'jquery'               => 'https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js',
				'ext-theme-fancybox'   => 'https://cdn.jsdelivr.net/npm/@fancyapps/fancybox/dist/jquery.fancybox.min.js',
				'ext-theme-customizer' => get_stylesheet_directory_uri() . '/ext-themes/scripts/customizer.min.js',
				'ext-theme'            => get_stylesheet_directory_uri() . '/ext-themes/scripts/theme.min.js',
			];

			foreach ( $scripts as $key => $value ) {
				wp_enqueue_script( $key, $value, '', '', true );
			}
		}
	}
}

/**
 * Helper function to retrieve the static object without using globals.
 *
 * @return WP_EXT_Theme
 */
function WP_EXT_Theme() {
	static $object;

	if ( null == $object ) {
		$object = new WP_EXT_Theme;
	}

	return $object;
}

/**
 * Initialize the object on `plugins_loaded`.
 */
add_action( 'after_setup_theme', [ WP_EXT_Theme(), 'run' ] );
