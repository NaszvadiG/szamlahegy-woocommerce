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

	public function create_invoice_ajax() {
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
}
