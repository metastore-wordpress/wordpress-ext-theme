<?php

/**
 * Class WP_EXT_Theme_WooCommerce_Settings
 */
class WP_EXT_Theme_WooCommerce_Settings {

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
		add_action( 'wp_nav_menu_items', [ $this, 'wc_ext_menu_item_cart' ], 10, 2 );
		add_filter( 'woocommerce_add_to_cart_fragments', [ $this, 'wc_ext_menu_item_cart_update' ], 10, 1 );
	}

	/**
	 * Add cart to main menu.
	 *
	 * @param $menu
	 * @param $args
	 *
	 * @return string
	 */
	public function wc_ext_menu_item_cart( $menu, $args ) {
		if ( class_exists( 'WooCommerce' ) ) {
			$menu .= '<li class="menu-item menu-item-cart">';
			$menu .= '<a href="' . wc_get_cart_url() . '"><i class="fas fa-shopping-cart"></i>';
			$menu .= '<span class="cart cart-count">' . WC()->cart->cart_contents_count . '</span>';
			$menu .= '<span class="cart cart-total">' . WC()->cart->get_cart_total() . '</span>';
			$menu .= '</a>';
			$menu .= '</li>';
		}

		return $menu;
	}

	/**
	 * Update cart in main menu.
	 *
	 * @param $fragments
	 *
	 * @return array
	 */
	function wc_ext_menu_item_cart_update( $fragments ) {
		$fragments[] = '';

		if ( class_exists( 'WooCommerce' ) ) {
			$fragments['.menu-item-cart span.cart-count'] = '<span class="cart cart-count">' . WC()->cart->get_cart_contents_count() . '</span>';
			$fragments['.menu-item-cart span.cart-total'] = '<span class="cart cart-total">' . WC()->cart->get_cart_total() . '</span>';
		}

		return $fragments;
	}
}

/**
 * Helper function to retrieve the static object without using globals.
 *
 * @return WP_EXT_Theme_WooCommerce_Settings
 */
function WP_EXT_Theme_WooCommerce_Settings() {
	static $object;

	if ( null == $object ) {
		$object = new WP_EXT_Theme_WooCommerce_Settings;
	}

	return $object;
}

/**
 * Initialize the object on `plugins_loaded`.
 */
add_action( 'after_setup_theme', [ WP_EXT_Theme_WooCommerce_Settings(), 'run' ] );

