<?php 

//* Check if pingback-option is disabled
if (get_option( 'default_ping_status' ) !== 'open') {

	//* Prevent pingback being sent to XMLRPC server
	//* (Probably not necessary if XML-RPC disabled)
	add_filter( 'xmlrpc_methods', 'ejo_prevent_pingback_xmlrpc' );

	//* Remove unnecesary HTTP Header response item
	add_filter( 'wp_headers', 'ejo_remove_x_pingback_header' );
}

//* Prevent pingback being sent to XMLRPC server
function ejo_prevent_pingback_xmlrpc( $methods ) 
{
	unset( $methods['pingback.ping'] );
	unset( $methods['pingback.extensions.getPingbacks'] );

	return $methods;
}

//* Remove from HTTP Header response
function ejo_remove_x_pingback_header( $headers ) 
{
	unset( $headers['X-Pingback'] );
}