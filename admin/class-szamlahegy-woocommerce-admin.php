<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://szamlahegy.hu
 * @since      1.0.0
 *
 * @package    Szamlahegy_Woocommerce
 * @subpackage Szamlahegy_Woocommerce/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Szamlahegy_Woocommerce
 * @subpackage Szamlahegy_Woocommerce/admin
 * @author     Számlahegy Kft. <info@szamlahegy.hu>
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
			'title'    => __( 'Számla automatikus létrehozása', 'szamlahegy-wc' ),
			'id'       => 'szamlahegy_wc_generate_auto',
			'type'     => 'checkbox',
			'desc'     => __( 'Ha a megrendelés <i>"teljesítve"</i> státuszba kerül, a számla automatikusan létrejön a megrendelés adatai alapján.', 'szamlahegy-wc' ),
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
				'e-szamla'  => __( 'Elektronikus számla', 'szamlahegy-wc' ),
				'nyomtatott' => __( 'Nyomtatott számla', 'szamlahegy-wc' )
			)
		);

		$settings[] = array(
			'title'    => __( 'Alapértelmezett termékazonosító vagy SZJ szám', 'szamlahegy-wc' ),
			'id'       => 'szamlahegy_wc_default_productnr',
			'type'     => 'text',
 			'desc'     => __( 'A számlán megjeleníthető a termék azonosító (SKU, SZJ, TEÁOR, VTSZ). Ha egy termékhez nincs SKU megadva, akkor az itt megadott érték fog megjelenni a számlán.', 'szamlahegy-wc' ),
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

	public function get_product_details($product) {
		// https://docs.woocommerce.com/wc-apidocs/class-WC_Product.html
		return array(
			'id' => $product->get_id(),
			'permalink' => $product->get_permalink(),
			'sku' => $product->get_sku(),
			'stock_quantity' => $product->get_stock_quantity(),
			'type' => $product->get_type(),
			'formatted_name' => $product->get_formatted_name(),
			'downloadable' => $product->is_downloadable(),
			'virtual' => $product->is_virtual(),
			'needs_shipping' => $product->needs_shipping(),
			'sold_individually' => $product->is_sold_individually(),
			'taxable' => $product->is_taxable(),
			'shipping_taxable' => $product->is_shipping_taxable(),
			'title' => $product->get_title(),
			'managing_stock' => $product->managing_stock(),
			'in_stock' => $product->is_in_stock(),
			'backorders_allowed' => $product->backorders_allowed(),
			'backorders_require_notification' => $product->backorders_require_notification(),
			'on_backorder' => $product->is_on_backorder(),
			'featured' => $product->is_featured(),
			'visible' => $product->is_visible(),
			'on_sale' => $product->is_on_sale(),
			'purchasable' => $product->is_purchasable(),
			'sale_price' => $product->get_sale_price(),
			'regular_price' => $product->get_regular_price(),
			'price' => $product->get_price(),
			'tax_class' => $product->get_tax_class(),
			'tax_status' => $product->get_tax_status(),
			'shipping_class' => $product->get_shipping_class(),
			'has_dimensions' => $product->has_dimensions(),
			'length' => $product->get_length(),
			'width' => $product->get_width(),
			'height' => $product->get_height(),
			'weight' => $product->get_weight(),
			'has_weight' => $product->has_weight(),
			'post_content' => $product->post->post_content
		);
	}
	public function get_product_object($product) {
		$p = new Product();
		$p->productnr = $product->get_sku();
	  $p->name = $product->get_title();
		$p->product_number = $product->get_sku(); // WTF???

	  $p->detail = $product->post->post_content;
	  $p->stock_management = $product->managing_stock();
	  $p->totalquantity = $product->get_stock_quantity();
	  $p->quantity_type = 'db';
	 	$p->price_slab = $product->get_price();
	  $p->tax = '???';
	  $p->foreign_id = $product->id;
	  $p->link = $product->get_permalink();
	  $p->visible = $product->is_visible();
	  $p->on_sale = $product->is_on_sale();
	  $p->price_sale = $product->get_sale_price();
	  $p->has_dimensions = $product->has_dimensions();
	  $p->dimension_unit = '???';
	  $p->length = $product->get_length();
	  $p->width = $product->get_width();
	  $p->height = $product->get_height();
	  $p->has_weight = $product->has_weight();
	  $p->weight_unit = '???';
	  $p->weight = $product->get_weight();
		$p->currency = '???';

		return $p;
	}

	public function export_all_product_to_szamlahegy() {
    $args = array( 'post_type' => 'product');
    $loop = new WP_Query( $args );

		echo "<pre>";
		$i = 0;
		$products = array();

    while ( $loop->have_posts() ) {
			$loop->the_post();
    	global $product;

			$products[] = $this->get_product_object($product);
			if ( $i++ > 10 ) {
				break;
			}
    }

		$szamlahegyApi = new SzamlahegyApi();
		$api_server = Szamlahegy_Woocommerce::get_server_url();
		$szamlahegyApi->openHTTPConnection('import_products', $api_server);
		$response = $szamlahegyApi->import_products($products, Szamlahegy_Woocommerce::get_api_key());
		$szamlahegyApi->closeHTTPConnection();
		var_dump($response);

    wp_reset_query();
		echo "</pre>";
	}

	public function create_invoice() {
		check_ajax_referer( 'wc_create_invoice', 'nonce' );
		$order_id =  intval($_POST['order']);
		if ( !$order_id ) wp_send_json_error( array('error' => true, 'error_text' => __( 'Hibás order azonosító!', 'szamlahegy-wc' )));
		$response = Szamlahegy_Woocommerce::create_invoice($order_id);

		if ($response['error'] === true) {
			wp_send_json_error($response);

		} else {
			$order = WC_Order_Factory::get_order($order_id);
			ob_start();
			$this->render_meta_box_content($order->post);
			$response['meta_box'] = ob_get_contents();
			ob_end_clean();

			wp_send_json_success($response);
		}
	}

	public function szamlahegy_plugin_menu() {
		add_management_page(__('Számlahegy eszközök'), __('Számlahegy'), 'read', 'szamlahegy-management', array( $this, 'szamlahegy_management_screen'));
	}

	public function szamlahegy_management_screen() {
		if (!current_user_can('manage_options'))  {
			wp_die( __('You do not have sufficient permissions to access this page.') );
		}
		include plugin_dir_path(  __FILE__ )  . 'partials/szamlahegy-woocommerce-admin-management.php';
		if ($_GET['func'] == 'import') {
			$this->export_all_product_to_szamlahegy();
		}
	}
}
