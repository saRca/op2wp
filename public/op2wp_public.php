<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    op2wp
 * @subpackage op2wp/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package    op2wp
 * @subpackage op2wp/public
 * @author     Your Name <alexander.rios@gmail.com>
 */
class op2wp_public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $op2wp    The ID of this plugin.
	 */
	private $op2wp;

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
	 * @var      string    $op2wp       The name of the plugin.
	 * @var      string    $version    The version of this plugin.
	 */
	public function __construct( $op2wp, $version ) {

		$this->op2wp = $op2wp;
		$this->version = $version;

		// add_action('init', array($this, 'get_opencart_data'));

	}

	/**
	 * Return array with user data
	 */
	public function get_opencart_data(){
		if ( !defined('ABSPATH') )
			define('ABSPATH', dirname(__FILE__) . '/');

		require_once(ABSPATH . 'opencart/config.php');
		//require_once(DIR_SYSTEM . 'startup.php');
		require_once(ABSPATH . 'opencart/system/engine/registry.php');
		require_once(ABSPATH . 'opencart/system/library/session.php');
		require_once(ABSPATH . 'opencart/system/library/request.php');
		require_once(ABSPATH . 'opencart/system/library/db.php');
		require_once(ABSPATH . 'opencart/system/library/customer.php');
		require_once(ABSPATH . 'opencart/system/library/cart.php');

		// Session
		$registry= new Registry();
		$session = new Session();
		$cart=new Cart($registry);

		$registry->set('session', $session);

		// Request
		$request = new Request();
		$registry->set('request', $request);

		// Database 
		$db = new DB(DB_DRIVER, DB_HOSTNAME, DB_USERNAME, 'your-db-password', DB_DATABASE);
		
		$registry->set('db', $db);

		$customer = new Customer($registry);

		$logged = $customer->isLogged();
		$cart = $this->get_cart_data($logged);
		if($logged != null){
			$userData=array();
			$userData['firstName']=$customer->getFirstName();
			$userData['cart']=$cart;
			return $userData;
		}

		return false;
		
	}


	function get_cart_data($ocUserId){
		$conn=$this->get_oc_db();
		if($conn){
			$query="SELECT cart FROM oc_customer WHERE customer_id = '".(int)$ocUserId."'";
			$result = $conn->query($query);
			$resultado=array();
			$result->data_seek(0);
			while ($fila = $result->fetch_assoc()) {
			    $resultado[]=$fila;
			}
			$cartData=unserialize($resultado[0]['cart']);
			return count($cartData);
		}
	}

	function get_oc_db(){
		$username= 'db-user';
		$passwd='db-user';
		$database='db-name';
		
		
		$mysqli = new mysqli("localhost", $username, $passwd, $database);
		if ($mysqli->connect_errno) {
			die( "Fail to connect with MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
		}else{
			return $mysqli;
		}

		return false;
	}


	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in op2wp_Public_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The op2wp_Public_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->op2wp, plugin_dir_url( __FILE__ ) . 'css/plugin-name-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in op2wp_Public_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The op2wp_Public_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->op2wp, plugin_dir_url( __FILE__ ) . 'js/plugin-name-public.js', array( 'jquery' ), $this->version, false );

	}

}
