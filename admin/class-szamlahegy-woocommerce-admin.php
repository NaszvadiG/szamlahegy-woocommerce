<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/admin
 * @author     Your Name <email@example.com>
 */
class Szamlahegy_Woocommerce_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/szamlahegy-woocommerce-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/szamlahegy-woocommerce-admin.js', array( 'jquery' ), $this->version, false );
		wp_localize_script( $this->plugin_name, 'szamlahegy_wc_params',
			array( 'loading' => plugins_url( '/images/ajax-loadin.gif', __FILE__ ))
	 	);
	}

	public function szamlahegy_woocommerce_settings( $settings ) {
		$settings[] = array(
			'type' => 'title',
			'title' => __( 'Számlahegy.hu beállítások', 'szamlahegy-wc' ),
			'id' => 'szamlahegy_woocommerce_options'
		);

		$settings[] = array(
			'title'    => __( 'API kulcs', 'szamlahegy-wc' ),
			'id'       => 'szamlahegy_wc_api_key',
			'type'     => 'text',
			'css'      => 'min-width:300px;'
		);

		$settings[] = array(
			'title'    => __( 'Teszt üzemmód', 'szamlahegy-wc' ),
			'id'       => 'szamlahegy_wc_test',
			'type'     => 'checkbox',
			'desc'     => __( 'Ha be van kapcsolva, akkor a csak Teszt számlák kerülnek kiállításra. Ezeket a Számlhegy csak a kiállítónak küldi el!', 'szamlahegy-wc' ),
		);

		$settings[] = array(
			'title'    => __( 'Számla típusa', 'szamlahegy-wc' ),
			'id'       => 'szamlahegy_wc_invoice_type',
			'class'    => 'chosen_select',
			'css'      => 'min-width:300px;',
			'type'     => 'select',
			'options'     => array(
				'e-szamla'  => __( 'Elektronuikus számla', 'szamlahegy-wc' ),
				'nyomtatott' => __( 'Nyomtatott számla', 'szamlahegy-wc' )
			)
		);

		$settings[] = array(
			'title'    => __( 'Alapértelmezett termékazonosító vagy SZJ szám', 'szamlahegy-wc' ),
			'id'       => 'szamlahegy_wc_default_productnr',
			'type'     => 'text',
			'default'  => 'SZJ-11.11.11',
 			'desc'     => __( 'A számlán kötelező elem a termék ezonosító vagy SZJ szám, amihez a Woocommerce-ben tárolt SKU-t küldjük át. Ha egy termékhez nincs SKU megadva, akkor az itt megadott érték lesz átküldve.', 'szamlahegy-wc' ),
		);

		$settings[] = array(
			'title'    => __( 'Számlahegy szerver URL', 'szamlahegy-wc' ),
			'id'       => 'szamlahegy_wc_server_url',
			'type'     => 'text',
			'default'  => 'https://ugyfel.szamlahegy.hu',
			'css'      => 'min-width:300px;',
 			'desc'     => __( 'A Számlahegy szerver elérése. Ide küldi a Woocommerce a számlakészítéssel kapcsolatos adatokat. A https://ugyfel.szamlahegy.hu címet csak akkor változtasd meg, ha pontosan tudod mit csinálsz!', 'szamlahegy-wc' ),
		);

		$settings[] = array(
			'id'       => 'szamlahegy_woocommerce_options',
			'type'     => 'sectionend'
		);

		return $settings;
	}

	public function szamlahegy_woocommerce_add_metabox( $post_type ) {
		add_meta_box('szamlahegy_order_option', 'Számlahegy számla', array( $this, 'render_meta_box_content' ), 'shop_order', 'side');
	}

	public function render_meta_box_content($post) {
		include plugin_dir_path(  __FILE__ )  . 'partials/szamlahegy-woocommerce-admin-metabox.php';
	}

	public function create_invoice() {
		check_ajax_referer( 'wc_create_invoice', 'nonce' );

		$orderId = $_POST['order'];
		$order = WC_Order_Factory::get_order($orderId);
		$order_items = $order->get_items();

		if ($order->order_total == 0) wp_send_json_error( array('error_text' => __( 'A számla végösszege nulla, azért nem készítem el.', 'szamlahegy-wc' )));

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
		//$invoice->footer = get_option('szamlahegy_wc_test');
		$invoice->customer_zip = $order->billing_postcode;

		if (get_option('szamlahegy_wc_test') == 'yes') {
			$invoice->kind = 'T';
			$invoice->signed = false;
		} elseif ( get_option('szamlahegy_wc_invoice_type') == 'e-szamla' ) {
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

		$invoice_items = array();
		foreach( $order_items as $item ) {
			$product_id = $item['product_id'];
			if ($item['variation_id']) $product_id = $item['variation_id'];
			$product = new WC_Product($product_id);

			$invoice_items[] = array(
				'productnr' => $product->get_sku() == null ? get_option('szamlahegy_wc_default_productnr') : $product->get_sku(),
				'name' => $item["name"],
				'detail' => wc_get_formatted_variation( $product->variation_data, true ),
				'quantity' => $item["qty"],
				'quantity_type' => 'db',
				'price_slab' => round($item["line_total"] / $item["qty"], 2),
				'tax' => round($item["line_tax"] / $item["line_total"] * 100, 2)
			);
		}
		$invoice->invoice_rows_attributes = $invoice_items;

		$szamlahegyApi = new SzamlahegyApi();

		$api_server = get_option('szamlahegy_wc_server_url');
		$api_url = $api_server . '/api/v1/invoices';

  	$szamlahegyApi->openHTTPConnection($api_url);
		$response = $szamlahegyApi->sendNewInvoice($invoice, get_option('szamlahegy_wc_api_key'));
		$szamlahegyApi->closeHTTPConnection();

    if ($response['error'] === true) {
			wp_send_json_error($response);
    } else {
			$result_object = json_decode($response['result'], true);

			$result_object['server_url'] = $api_server;
			$result_object['invoice_url'] = $api_server . '/user/invoices/' . $result_object['id'];
			$result_object['pdf_url'] = $api_server . '/user/invoices/download/' . $result_object['guid'] . "?inline=true";

			update_post_meta( $orderId, '_szamlahegy_wc_response', $result_object);

			ob_start();
			$this->render_meta_box_content($order->post);
			$response['meta_box'] = ob_get_contents();
			ob_end_clean();

			wp_send_json_success($response);
    }
	}
}
