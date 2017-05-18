<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://szamlahegy.hu
 * @since      1.0.0
 *
 * @package    Szamlahegy_Woocommerce
 * @subpackage Plugin_Name/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Szamlahegy_Woocommerce
 * @subpackage Plugin_Name/includes
 * @author     Számlahegy Kft. <info@szamlahegy.hu>
 */
class Szamlahegy_Woocommerce {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Szamlahegy_Woocommerce_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->plugin_name = 'szamlahegy-woocommerce';
		$this->version = '0.0.1';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Szamlahegy_Woocommerce_Loader. Orchestrates the hooks of the plugin.
	 * - Szamlahegy_Woocommerce_i18n. Defines internationalization functionality.
	 * - Szamlahegy_Woocommerce_Admin. Defines all hooks for the admin area.
	 * - Szamlahegy_Woocommerce_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-szamlahegy-woocommerce-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-szamlahegy-woocommerce-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-szamlahegy-woocommerce-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-szamlahegy-woocommerce-public.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'api/api.php';

		$this->loader = new Szamlahegy_Woocommerce_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Szamlahegy_Woocommerce_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Szamlahegy_Woocommerce_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Szamlahegy_Woocommerce_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		$this->loader->add_filter( 'woocommerce_general_settings', $plugin_admin, 'szamlahegy_woocommerce_settings');
		$this->loader->add_action( 'add_meta_boxes', $plugin_admin, 'szamlahegy_woocommerce_add_metabox' );
		$this->loader->add_action( 'wp_ajax_szamlahegy_wc_create_invoice', $plugin_admin, 'create_invoice' );

		$this->loader->add_action( 'admin_menu', $plugin_admin, 'szamlahegy_plugin_menu' );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Szamlahegy_Woocommerce_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->add_action( 'woocommerce_order_status_completed', $plugin_public, 'action_woocommerce_order_status_completed' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Szamlahegy_Woocommerce_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

	public static function get_api_key() {
		return get_option('szamlahegy_wc_api_key');
	}

	public static function get_default_productnr() {
		return get_option('szamlahegy_wc_default_productnr');
	}

	public static function is_test_mode() {
		return get_option('szamlahegy_wc_test') == 'yes';
	}

	public static function get_generate_invoice_type() {
		return get_option('szamlahegy_wc_invoice_type');
	}

	public static function is_invoice_created($order_id) {
		if ( Szamlahegy_Woocommerce::get_api_response($order_id) ) return true;
		return false;
	}

	public static function get_server_url() {
		return get_option('szamlahegy_wc_server_url');
	}

	public static function get_api_response($order_id) {
		return get_post_meta( $order_id, '_szamlahegy_wc_response', true );
	}

	public static function is_invoice_generate_auto() {
		return get_option('szamlahegy_wc_generate_auto') == 'yes';
	}

	public static function woocommerce_version_check( $version = '3.0' ) {
		if ( class_exists( 'WooCommerce' ) ) {
			global $woocommerce;
			if ( version_compare( $woocommerce->version, $version, ">=" ) ) {
				return true;
			}
		}
		return false;
	}

	public static function create_invoice($order_id) {
		$order = WC_Order_Factory::get_order($order_id);

		if ($order->order_total == 0) return array('error' => true, 'error_text' => __( 'A számla végösszege nulla, azért nem készítem el.', 'szamlahegy-wc' ));

		$order_items = $order->get_items();
		$date_now = date('Y-m-d');
		$invoice = new Invoice();

		$invoice->customer_name = $order->billing_company ? $order->billing_company : $order->billing_first_name . ' ' . $order->billing_last_name;
		// $invoice->customer_detail =
		$invoice->customer_city = $order->billing_city;
		$invoice->customer_address = $order->billing_address_1;
		if ($order->billing_address_2) $invoice->customer_address .= ' ' . $order->billing_address_2;
		$invoice->customer_country = $order->billing_country;
		//$invoice->customer_vatnr = ???
		$invoice->payment_method = $order->payment_method == 'cod' ? 'C' : 'B';
		$invoice->payment_date = $date_now;
		$invoice->perform_date = $date_now;
		//$invoice->header =
		//$invoice->footer =
		$invoice->customer_zip = $order->billing_postcode;

		if (Szamlahegy_Woocommerce::is_test_mode()) {
			$invoice->kind = 'T';
			$invoice->signed = false;
		} elseif ( Szamlahegy_Woocommerce::get_generate_invoice_type() == 'e-szamla' ) {
			$invoice->kind = 'N';
			$invoice->signed = true;
		} else {
			$invoice->kind = 'N';
			$invoice->signed = false;
		}

		$invoice->tag = 'woocommerce';
		if ($order->is_paid()) $invoice->paid_at = $date_now;
		$invoice->customer_email = $order->billing_email;
		$invoice->foreign_id = "wc". $order->get_order_number();
		$invoice->customer_contact_name = $order->billing_first_name . ' ' . $order->billing_last_name;

		$lang = '';
		#if (is_plugin_active( 'woocommerce-qtranslate-x/woocommerce-qtranslate-x.php' )) {
		#	$lang = get_post_meta( $order_id, '_user_language', true);
		#	if ($lang === '' || $lang == nil) {
		#		$lang = $GLOBALS['q_config']['language'];
		#	}
		#}

		if ($lang === '' || $lang == nil) $lang = $order->billing_country;
		$lang = strtolower($lang);
		$langs = array("hu", "en", "de", "fr");
		if (in_array($lang, $langs)) {
			$invoice->language = $lang;
		} else {
			$invoice->language = 'en';
		}

		$invoice->currency = $order->get_order_currency();

		$invoice_items = array();
		foreach( $order_items as $item ) {
			$product_id = $item['product_id'];
			if ($item['variation_id']) {
				$product_id = $item['variation_id'];
				if (Szamlahegy_Woocommerce::woocommerce_version_check('3.0')) {
					$product = new WC_Product_Variation($product_id);
				} else {
					$product = new WC_Product($product_id);
				}
			} else {
				$product = new WC_Product($product_id);
			}

			$invoice_items[] = array(
				'productnr' => $product->get_sku() == null ? Szamlahegy_Woocommerce::get_default_productnr() : $product->get_sku(),
				// TODO Ezt Rails-ben kellene megoldani (issue 337)
				'name' => str_replace('&ndash;', '', __($item["name"])),
				'detail' => wc_get_formatted_variation( $product->variation_data, true ),
				'quantity' => $item["qty"],
				'quantity_type' => 'db',
				'price_slab' => round($item["line_total"] / $item["qty"], 2),
				'tax' => round($item["line_tax"] / $item["line_total"] * 100, 2)
			);
		}

		// Shipping
		if ($order->get_total_shipping() != 0) {
			$invoice_items[] = array(
				'name' => __( 'Szállítási díj', 'szamlahegy-wc' ),
				'quantity' => 1,
				'quantity_type' => 'db',
				'price_slab' => round($order->get_total_shipping(), 2),
				'tax' => round($order->get_shipping_tax() / $order->get_total_shipping() * 100, 2)
			);
		}

		$invoice->invoice_rows_attributes = $invoice_items;
		$szamlahegyApi = new SzamlahegyApi();
		$api_server = Szamlahegy_Woocommerce::get_server_url();

  	$szamlahegyApi->openHTTPConnection('send_invoice', $api_server);
		$response = $szamlahegyApi->sendNewInvoice($invoice, Szamlahegy_Woocommerce::get_api_key());
		$szamlahegyApi->closeHTTPConnection();

    if ($response['error'] === true) {
			return $response;
    } else {
			$result_object = json_decode($response['result'], true);

			$result_object['server_url'] = $api_server;
			$result_object['invoice_url'] = $api_server . '/user/invoices/' . $result_object['id'];
			$result_object['pdf_url'] = $api_server . '/user/invoices/download/' . $result_object['guid'] . "?inline=true";

			update_post_meta( $order_id, '_szamlahegy_wc_response', $result_object);

			return $response;
    }
	}
}
