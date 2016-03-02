<?php 

if ( current_theme_supports( 'ejo-cleanup-frontend', 'pingback' ) ) {

	//* Prevent pingback being sent to XMLRPC server
	//* (Probably not necessary if XML-RPC disabled)
	add_filter( 'xmlrpc_methods', 'ejo_prevent_pingback_xmlrpc' );

	//* Remove unnecesary HTTP Header response item
	add_filter( 'wp_headers', 'ejo_remove_x_pingback_header' );

	//* Remove Hybrid pingback link
	remove_action( 'wp_head', 'hybrid_link_pingback',  3 );


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
}