<?php
/**
 * Plugin Name: Integration of Insightly with caldera forms
 * Plugin URI:  https://zetamatic.com?utm_src=integration-of-insightly-with-caldera-forms/
 * Description: The Insightly and Caldera Forms Integration plugin lets you add a new Insightly Processor to Caldera form. It automatically syncs data from your Caldera form to your Insightly CRM when the form is submitted.
 * Version: 1.0.0
 * Author: ZetaMatic
 * Author URI: https://zetamatic.com?utm_src=integration-of-insightly-with-caldera-forms/
 * License:     GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: integration-insightly-calderaforms
 * Domain Path: /languages
 * Tested up to: 5.6.1
 *
 * @package integration-insightly-calderaforms
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! defined( 'IICF_PLUGIN_FILE' ) ) {
	define( 'IICF_PLUGIN_FILE', __FILE__ );
}

// Define plugin version
define( 'IICF_VERSION', '1.0.0' );
define( 'IICF_PLUGIN_PATH', dirname(__FILE__) );

if ( ! version_compare( PHP_VERSION, '5.6', '>=' ) ) {
	add_action( 'admin_notices', 'iicf_fail_php_version' );
} else {
	// Include the IICF class.
	require_once dirname( __FILE__ ) . '/inc/class-integration-insightly-calderaforms.php';
}

/**
 * Admin notice for minimum PHP version.
 *
 * Warning when the site doesn't have the minimum required PHP version.
 *
 * @since 1.0.0
 *
 * @return void
 */
function iicf_fail_php_version() {

	if ( isset( $_GET['activate'] ) ) {
		unset( $_GET['activate'] );
	}

	/* translators: %s: PHP version */
	$message      = sprintf( esc_html__( 'Integration of Insightly and Caldera Forms requires PHP version %s+, plugin is currently NOT RUNNING.', 'integration-insightly-calderaforms' ), '5.6' );
	$html_message = sprintf( '<div class="error">%s</div>', wpautop( $message ) );
	echo wp_kses_post( $html_message );
}
if(!function_exists('iicf_activate')) {
  function iicf_activate() {
    if(function_exists('iicf_fail_php_version_pro')) {
      require(IICF_PLUGIN_PATH . "/inc/plugin-activation-error.php");
      exit;
    }
  }
  register_activation_hook( __FILE__, 'iicf_activate' );
}

if(get_option("iicf_disable_pro_notice") != "YES"){
	add_action( 'admin_notices', 'iicf_download_pro_plugin' );
}
add_action( 'wp_ajax_iicf_hide_pro_notice', 'iicf_hide_pro_notice' );

define( 'IICF_PLUGIN_NAME', 'Integration of Insightly and Caldera Forms' );
function iicf_download_pro_plugin() {
	$class = 'notice notice-warning is-dismissible iicf-notice-buy-pro';
	$plugin_url = 'https://zetamatic.com/downloads/caldera-forms-insightly-integration-pro/';
	$message = __( 'Glad to know that you are already using our '.IICF_PLUGIN_NAME.'. Do you want send data from your Caldera form dynamically to Insightly? Then please visit <a href="'.$plugin_url.'?utm_src='.IICF_PLUGIN_NAME.'" target="_blank">here</a>.', 'integration-insightly-calderaforms' );
	$dont_show = __( "Don't show this message again!", 'integration-insightly-calderaforms' );
	printf( '<div class="%1$s"><p>%2$s</p><p><a href="javascript:void(0);" class="iicf-hide-pro-notice">%3$s</a></p></div>
	<script type="text/javascript">
		(function () {
			jQuery(function () {
				jQuery("body").on("click", ".iicf-hide-pro-notice", function () {
					jQuery(".iicf-notice-buy-pro").hide();
					jQuery.ajax({
						"type": "post",
						"dataType": "json",
						"url": ajaxurl,
						"data": {
							"action": "iicf_hide_pro_notice"
						},
						"success": function(response){
						}
					});
				});
			});
		})();
		</script>', esc_attr( $class ), $message, $dont_show );
}

function iicf_hide_pro_notice() {
  update_option("iicf_disable_pro_notice", "YES");
  echo json_encode(["status" => "success"]);
  wp_die();
}
