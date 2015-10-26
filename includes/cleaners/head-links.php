<?php

add_action( 'after_setup_theme', 'ejo_cleanup_head' );
function ejo_cleanup_head()
{
	remove_action( 'wp_head', 'wlwmanifest_link' ); //* Remove unnecessary Window Live Writer link
	remove_action( 'wp_head', 'hybrid_meta_generator', 1 ); //* Remove unnecessary Theme version
}
