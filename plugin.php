<?php
/**
 * Plugin Name:     (WP-EXT) Theme
 * Plugin URI:      https://metastore.pro/
 *
 * Description:     Global settings for themes.
 *
 * Author:          Kitsune Solar
 * Author URI:      https://kitsune.solar/
 *
 * Version:         1.0.0
 *
 * Text Domain:     wp-ext-themes
 * Domain Path:     /languages
 *
 * License:         GPLv3
 * License URI:     https://www.gnu.org/licenses/gpl-3.0.html
 */

/**
 * Loading `WP_EXT_Theme`.
 */

function run_wp_ext_system_theme() {
	require_once( plugin_dir_path( __FILE__ ) . 'includes/WP_EXT_Theme.class.php' );
	require_once( plugin_dir_path( __FILE__ ) . 'includes/WP_EXT_Theme_Genesis.class.php' );
	require_once( plugin_dir_path( __FILE__ ) . 'includes/WP_EXT_Theme_Genesis_Settings.class.php' );
	require_once( plugin_dir_path( __FILE__ ) . 'includes/WP_EXT_Theme_WooCommerce_Settings.class.php' );
}

run_wp_ext_system_theme();
