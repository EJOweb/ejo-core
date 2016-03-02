<?php

if ( current_theme_supports( 'ejo-cleanup-frontend', 'head' ) ) {
	remove_action( 'wp_head', 'wlwmanifest_link' ); //* Remove unnecessary Window Live Writer link
	remove_action( 'wp_head', 'hybrid_meta_generator', 1 ); //* Remove unnecessary Theme version
	remove_action( 'wp_head', 'wp_generator' ); //* Remove Wordpress version
}
