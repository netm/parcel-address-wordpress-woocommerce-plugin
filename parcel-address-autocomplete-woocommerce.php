<?php
/*
Plugin Name:     Parcel Address Checkout Autocomplete for WooCommerce Redux
Plugin URI:      https://github.com/netm/parcel-address-wordpress-woocommerce-plugin
Description:     Allows your customers to autocomplete billing and shipping addresses on the checkout page using the NZpost ParcelAddress API. Forked from the great work of Picwa.
Author:          GwilymGJ
Author URI:      https://github.com/netm
Version:         1.0.0
License: 		GPLv3
License URI: http://www.gnu.org/licenses/quick-guide-gplv3.html
*/


/* DEFINE GLOBAL VARIABLE OF PLUGIN */
define('PACAW_PLUGIN_URL', plugins_url('',__FILE__));
define('PACAW_API_DOMAIN', 'https://api.nzpost.co.nz/parceladdress/2.0/domestic/addresses');
define('PACAW_AUTH_URL', 'https://oauth.nzpost.co.nz/as/token.oauth2');
/* DEFINE GLOBAL VARIABLE OF PLUGIN */

include('settings-api.php');

/* START - TO GET AUTHENTICATION TOKEN */
if (!function_exists('parcel_address_checkout_access_token')) {
function parcel_address_checkout_access_token(){
		$pacaw_auth = get_option('parcel_api_settings');
		$pacaw_client_id = $pacaw_auth['parcel_client_id'];
		$pacaw_client_secret = $pacaw_auth['parcel_client_secret'];
		$pacaw_api_username = $pacaw_auth['parcel_api_username'];
		$pacaw_api_password = $pacaw_auth['parcel_api_password'];
		$pacaw_body = array(
			'client_id' => $pacaw_client_id,
			'client_secret' => $pacaw_client_secret,
			'grant_type' => 'client_credentials',
			'password' => $pacaw_api_password,
			'username' => $pacaw_api_username, 
		);
		
		$pacaw_args = array('body' => $pacaw_body,'timeout' => '30');
		$pacaw_response = wp_remote_post(PACAW_AUTH_URL, $pacaw_args );
		if ( is_wp_error( $pacaw_response ) ) {
			return $pacaw_response->get_error_message();
		} else {
		$response_token = json_decode(wp_remote_retrieve_body($pacaw_response), true);
		}
	 	return $response_token['access_token'];
	}
}
/* START - TO GET AUTHENTICATION TOKEN  */


/* INCLUDE CSS AND JS HOOK - START(KKD) */
function pacaw_address_api_js(){
	
	if (function_exists('parcel_address_checkout_access_token')) {
		$get_token = parcel_address_checkout_access_token();
	}
	
	if (is_checkout()){	  
		wp_enqueue_script('pacaw_api_js',PACAW_PLUGIN_URL.'/js/parcel_address_plugin.js');
		$image_url = plugins_url( 'images/pa_process.gif', __FILE__ );
   		$getJsData = array('imageURL' => $image_url,'getToken' => $get_token,'getApiDomain' => PACAW_API_DOMAIN);
   		wp_localize_script( 'pacaw_api_js', 'gatJsVars', $getJsData );
 		wp_enqueue_script( 'jquery-ui-autocomplete' );
	}
}
add_action('wp_footer','pacaw_address_api_js');

function pacaw_enqueue_scripts(){
 if (is_checkout()){	 
		wp_enqueue_style('pacaw_api_css',PACAW_PLUGIN_URL.'/css/pacaw_style.css');
	}
}
add_action( 'wp_enqueue_scripts', 'pacaw_enqueue_scripts' );

/* INCLUDE CSS AND JS HOOK - END(KKD) */
