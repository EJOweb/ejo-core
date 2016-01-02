<?php 

//* Clean pingback references if pingback-option is disabled
include_once( EJO_DIR . 'includes/cleaners/pingback.php' );

//* Disable XML-RPC
include_once( EJO_DIR . 'includes/cleaners/disable-xmlrpc.php' );

//* Clean <head> links
include_once( EJO_DIR . 'includes/cleaners/head-links.php' );
