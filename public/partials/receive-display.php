<?php


/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://github.com/NathanKleekamp/Wordpress-RabbitMQ
 * @since      1.0.0
 
 
 * @package    Wordpress_Rabbitmq
 * @subpackage Wordpress_Rabbitmq/public/partials
*/

?>
<br>
<form method="post">
<textarea name="message"><?php echo isset( $message ) ? esc_attr( $message ) : "" ?></textarea>
<input type="submit" value="Receive">
<input type="hidden" name="receive-message" value"true">
</form>
<br>

<?php
	 
?>

