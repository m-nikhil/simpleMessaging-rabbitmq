<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Wordpress_Rabbitmq
 * @subpackage Wordpress_Rabbitmq/admin/partials
 */

$options = get_option('wordpress_rabbitmq_options');

?>

<div class="wrap">
  <h2>
    <?php echo esc_html( get_admin_page_title() ); ?>
  </h2>

  <?php if ( isset( $_GET['settings-updated'] ) && $_GET['settings-updated'] == 'success' ) : ?>
    <div class="notice notice-success">
      <p><?php _e( 'Settings successfully updated!', 'wordpress-rabbitmq' ); ?></p>
    </div>
  <?php endif; ?>

  <form action="?save-settings=true" method="post" id="wordpress-rabbitmq-settings" class="wordpress-rabbitmq-form">
    <fieldset class="wordpress-rabbitmq-fieldset">
      <h3>RabbitMQ Server Settings</h3>
      <p>To connect to a RabbitMQ server with a password, you'll need to to define it in your <code>wp-config.php</code>:<br><code>define('WP_RABBITMQ_PASSWORD', 'password');</code></p>
      <label for="wordpress_rabbitmq_options[host]"><?php echo __( 'Host' ) ?>:
        <input type="text" name="wordpress_rabbitmq_options[host]" id="wordpress_rabbitmq_options[host]" autocomplete="off" placeholder="localhost" class="wordpress-rabbitmq-textfield" value="<?php echo isset( $options['host'] ) ? esc_attr( $options['host'] ) : "" ?>">
      </label>
      <label for="wordpress_rabbitmq_options[port]"><?php echo __( 'Port' ) ?>:
        <input type="number" min=0 name="wordpress_rabbitmq_options[port]" id="wordpress_rabbitmq_options[port]" autocomplete="off" placeholder="5672" class="wordpress-rabbitmq-textfield" value="<?php echo isset( $options['port'] ) ? esc_attr( $options['port'] ) : 5672 ?>">
      </label>
      <label for="wordpress_rabbitmq_options[username]"><?php echo __( 'Username' ) ?>:
        <input type="text" name="wordpress_rabbitmq_options[username]" id="wordpress_rabbitmq_options[username]" autocomplete="off" placeholder="rabbitmq" class="wordpress-rabbitmq-textfield" value="<?php echo isset( $options['username'] ) ? esc_attr( $options['username'] ) : "" ?>">
      </label>
      <label for="wordpress_rabbitmq_options[password]"><?php echo __( 'Password' ) ?>:
        <input type="text" name="wordpress_rabbitmq_options[password]" id="wordpress_rabbitmq_options[password]" autocomplete="off" placeholder="password" class="wordpress-rabbitmq-textfield" value="<?php echo isset( $options['password'] ) ? esc_attr( $options['password'] ) : "" ?>">
      </label>
    </fieldset>
    <?php wp_nonce_field( 'wordpress_rabbitmq_nonce', 'wordpress_rabbitmq_nonce' ); ?>
    <input type="button" name="reset" id="reset" class="button button-secondary" value="Reset Fields">
    <?php submit_button(); ?>
  </form>
</div>
