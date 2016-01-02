<?php 

/** 
 * Disable XML-RPC
 * XML-RPC wordt voor meer gebruikt dan Pingback en trackback, zoals voor  Remote login
 *
 * Test: 
 * - When I browse to your xmlrpc URL, it returns "XML-RPC server accepts POST requests only" - 
 *   which is what it should do regardless of if the plugin is enabled or not.
 *
 * - When I test your site with the XML-RPC tester at http://xmlrpc.eritreo.it/, it returns that 
 *   it cannot access the XML-RPC service, which is what is expected when the plugin is enabled.
 */
add_filter( 'xmlrpc_enabled', '__return_false' );	
