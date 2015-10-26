<?php 

// if ( apply_filters('ejo_xmlrpc_disabled', true) ) {
if (get_option( 'default_ping_status' ) !== 'open') {

	/** 
	 * Disable XML-RPC
	 * Misschien beter koppelen aan een EJOweb option
	 * Want XML-RPC wordt voor meer gebruikt dan Pingback en trackback,
	 * zoals Remote login
	 */
	add_filter( 'xmlrpc_enabled', 'ejo_disable_xmlrpc' );	
	
	//* Remove unnecesary <head> xmlrpc element (not related to pingback I think)
	remove_action( 'wp_head', 'rsd_link' );
}

//* Disable XML-RPC via the xmlrpc_enabledFound in wp_xmlrpc_server::login()
function ejo_disable_xmlrpc()
{
	return false;

	/**
	 * Test: 
	 * When I browse to your xmlrpc URL, it returns "XML-RPC server accepts POST requests only" - which is what it should do regardless of if the plugin is enabled or not.
	 * When I test your site with the XML-RPC tester at http://xmlrpc.eritreo.it/, it returns that it cannot access the XML-RPC service, which is what is expected when the plugin is enabled.
	 */
}