<?php

/**
 * Számlahegy Woocommerce plugin
 *
 * @link              https://szamlahegy.hu
 * @since             1.0.0
 * @package           Szamlahegy_Woocommerce
 *
 * @wordpress-plugin
 * Plugin Name: A Számlahegy Woocommerce bővítménye
 * Plugin URI:  https://szamlahegy.hu
 * Description: Woocommerce összekapcsolása Számlaheggyel
 * Version:     1.2.4
 * Author:      Számlahegy Kft
 * Author URI:  https://github.com/Szamlahegy
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-szamlahegy-woocommerce-activator.php
 */
function activate_szamlahegy_woocommerce() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-szamlahegy-woocommerce-activator.php';
	Szamlahegy_Woocommerce_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-szamlahegy-woocommerce-deactivator.php
 */
function deactivate_szamlahegy_woocommerce() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-szamlahegy-woocommerce-deactivator.php';
	Szamlahegy_Woocommerce_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_szamlahegy_woocommerce' );
register_deactivation_hook( __FILE__, 'deactivate_szamlahegy_woocommerce' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-szamlahegy-woocommerce.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_szamlahegy_woocommerce() {

	$plugin = new Szamlahegy_Woocommerce();
	$plugin->run();

}
run_szamlahegy_woocommerce();
