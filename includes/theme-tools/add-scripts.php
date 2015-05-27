<?php

/*
Add header & footer scripts to theme
*/

//* Add scripts to header
add_action( 'wp_head', 'ejo_header_scripts' );

function ejo_header_scripts() 
{
	echo get_option( 'ejo_header_scripts', '' );
}


//* Add scripts to footer
add_action( 'wp_footer', 'ejo_footer_scripts' );

function ejo_footer_scripts() 
{
	echo get_option( 'ejo_footer_scripts', '' );
}