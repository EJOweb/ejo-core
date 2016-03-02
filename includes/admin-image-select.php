<?php 

//* Just register... not only when using widget... ?
add_action( 'admin_enqueue_scripts', 'register_ejo_image_select_script' );

/**
 * Registers and enqueues admin-specific JavaScript and CSS only on widgets page.
 */ 
function register_ejo_image_select_script($hook) 
{
	wp_enqueue_style( 'ejo-image-select', EJO_URI . 'includes/css/admin-image-select.css' );
 
    // Image Widget
    wp_enqueue_media();     
    wp_enqueue_script( 'ejo-image-select', EJO_URI . 'includes/js/admin-image-select.js', array('jquery'), false, true );
}