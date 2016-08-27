<?php
if ( EJO_Base_Module::is_inactive('blog') ) {

    //* Disable caps
    add_filter( 'ejo_client_blog_enabled', function() {
        return false;                
    });

    //* Remove widget 
    add_filter( 'ejo_base_unregister_widgets', function($widgets_to_unregister) {

        if (! current_user_can( 'manage_options' ) )
            $widgets_to_unregister[] = 'WP_Widget_Recent_Posts';

        return $widgets_to_unregister;
    });
}
