<?php

/**
 * Class WP_EXT_Theme_Genesis
 */
class WP_EXT_Theme_Genesis {

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->run();
	}

	/**
	 * Plugin: `initialize`.
	 */
	public function run() {
		add_action( 'wp_enqueue_scripts', [ $this, 'style_disable' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'script_disable' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'style_enable' ] );
		add_action( 'genesis_after_footer', [ $this, 'script_enable' ] );
	}

	/**
	 * Disable style.
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
	 * Disable script.
	 */
	public function script_disable() {
		if ( ! is_admin() ) {
			$scripts = [];

			foreach ( $scripts as $script ) {
				wp_deregister_script( $script );
			}
		}
	}

	/**
	 * Enable style.
	 */
	public function style_enable() {
	}

	/**
	 * Enable script.
	 */
	public function script_enable() {
	}
}

/**
 * Helper function to retrieve the static object without using globals.
 *
 * @return WP_EXT_Theme_Genesis
 */
function WP_EXT_Theme_Genesis() {
	static $object;

	if ( null == $object ) {
		$object = new WP_EXT_Theme_Genesis;
	}

	return $object;
}

/**
 * Initialize the object on `plugins_loaded`.
 */
if ( WP_EXT_Theme()->theme_info( 'Name' ) === 'Genesis' ) {
	add_action( 'after_setup_theme', [ WP_EXT_Theme_Genesis(), 'run' ] );
}
