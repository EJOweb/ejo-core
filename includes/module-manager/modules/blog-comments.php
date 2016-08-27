<?php

/**
 * Blog Comments
 */
if ( EJO_Base_Module::is_inactive('blog-comments') ) {

    //* Remove widget 
    add_filter( 'ejo_base_unregister_widgets', function($widgets_to_unregister) {

        if (! current_user_can( 'manage_options' ) )
            $widgets_to_unregister[] = 'WP_Widget_Recent_Comments';

        return $widgets_to_unregister;
    });
}