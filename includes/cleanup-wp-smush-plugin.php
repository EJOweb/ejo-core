<?php 

if ( current_theme_supports( 'ejo-cleanup-backend', 'wp-smush' ) ) {
	
	/* Hide smush pro features */
	add_filter( 'smush_pro_features', '__return_false' );


	//* Just register... not only when using widget... ?
	add_action( 'admin_enqueue_scripts', 'register_ejo_wp_smush_style' );

	/**
	 * Registers and enqueues admin-specific JavaScript and CSS only on widgets page.
	 */ 
	function register_ejo_wp_smush_style($hook) 
	{
		//* Only hook on ejo settings page
	    if ( 'media_page_wp-smush-bulk' != $hook )
	        return;

		wp_enqueue_style( 'ejo-hide-wp-smush', EJO_URI . 'includes/css/admin-hide-wp-smush.css' );
	}
}
