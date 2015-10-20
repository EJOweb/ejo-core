<?php 

//* TEST PINGBACK!

add_filter( 'xmlrpc_methods', 'ejo_block_xmlrpc_attacks' );
function ejo_block_xmlrpc_attacks( $methods ) {
   unset( $methods['pingback.ping'] );
   unset( $methods['pingback.extensions.getPingbacks'] );
   return $methods;
}

add_filter( 'wp_headers', 'ejo_remove_x_pingback_header' );
function ejo_remove_x_pingback_header( $headers ) {
   unset( $headers['X-Pingback'] );
   return $headers;
}

//* Doesn't seem to work
// add_filter('xmlrpc_enabled', 'ejo_disable_xmlrpc', 10, 1 );
// function ejo_disable_xmlrpc($enabled)
// {
//     return false;
// }

//* Hybrid remove pingback
add_action( 'after_setup_theme', 'ejo_remove_hybrid_pingback' );
function ejo_remove_hybrid_pingback()
{
    remove_action( 'wp_head', 'hybrid_link_pingback', 3 );
}