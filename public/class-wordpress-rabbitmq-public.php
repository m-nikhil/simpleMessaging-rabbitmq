<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/NathanKleekamp/Wordpress-RabbitMQ
 * @since      1.0.0
 *
 * @package    Wordpress_Rabbitmq
 * @subpackage Wordpress_Rabbitmq/public
 */




/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wordpress_Rabbitmq
 * @subpackage Wordpress_Rabbitmq/public
 * @author     Nathan Kleekamp <nkleekamp@gmail.com>
 */

/** rabbitMQ lib **/
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class Wordpress_Rabbitmq_Public {

  /**
   * The ID of this plugin.
   *
   * @since    1.0.0
   * @access   private
   * @var      string    $plugin_name The ID of this plugin.
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
   * @param      string    $plugin_name   The name of the plugin.
   * @param      string    $version    The version of this plugin.
   */

  public function __construct( $plugin_name , $version ) {
    $this->plugin_name = $plugin_name;
    $this->version = $version;
  }

  /**
   * Register the stylesheets for the public-facing side of the site.
   *
   * @since    1.0.0
   */

  public function enqueue_styles() {
    wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wordpress-rabbitmq-public.css', array(), $this->version, 'all' );
  }

  /**
   * Register the JavaScript for the public-facing side of the site.
   *
   * @since    1.0.0
   */

  public function enqueue_scripts() {
    wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wordpress-rabbitmq-public.js', array( 'jquery' ), $this->version, false );
  }
 

 public function send_display() {
   function display() {
    require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/send-display.php';

   if(  isset( $_POST['send-message'] )) {

	$options = get_option('wordpress_rabbitmq_options');

	$connection = new AMQPStreamConnection($options['host'],intval($options['port']),$options['username'],$options['password']);
	$channel = $connection->channel();
	$channel->queue_declare('message-pipe', false, false, false, false);
	$msg = new AMQPMessage($_POST['message']);
	$channel->basic_publish($msg, '', 'message-pipe');
	echo "sent<br>";
	$channel->close();
	$connection->close();
 
    }
   
   }

  add_shortcode('send','display'); 
 }

 public function receive_display() {
   function display2() {
    

   if(  isset( $_POST['receive-message'] )) {

        $options = get_option('wordpress_rabbitmq_options');

	    
	$connection = new AMQPStreamConnection($options['host'],intval($options['port']),$options['username'],$options['password']);
	$channel = $connection->channel();
	$channel->queue_declare('message-pipe', false, false, false, false);
	$message = '';
	while($mess = $channel->basic_get('message-pipe', true)) {
       	    $message .= ($mess->body."\n");
	}
		  
	require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/receive-display.php';
	echo "Received<br>";

	$channel->close();
	$connection->close();


   }
   else
   {
	 require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/receive-display.php';
   }

 }
  add_shortcode('receive','display2');
 }



}
