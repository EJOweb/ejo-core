<?php 

add_action( 'widgets_init', 'ejo_register_widgets' );

//* Register Widget
function ejo_register_widgets() 
{ 
	/* Widgets */
	if ( current_theme_supports( 'ejo-widgets', 'featured-image' ) ) {

		/* Load Widget Class */
		require_once( EJO_DIR . 'includes/widget-featured-image.php' );

		/* Register Widget */
    	register_widget( 'EJO_Featured_Image_Widget' ); 
	}
}
