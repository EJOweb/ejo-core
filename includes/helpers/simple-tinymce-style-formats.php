<?php 

//* Hook function to tinymce for simple adding of style-formats to tinymce
add_filter( 'tiny_mce_before_init', 'ejo_tinymce_style_formats', 5 );

/** 
 * Easily add custom styles to "Styles Format" dropdown
 * This handles the json encoding for you
 *
 * Usage 
 * add_filter( 'ejo_tinymce_style_formats', function( $style_formats = array() ) {
 *    $style_formats[] =  array(
 *       'title' => 'Button',
 *       'selector' => 'a',
 *       'classes' => 'button'
 *    );
 *
 *    return $style_formats;
 * }, 10 );
 * 
 */
function ejo_tinymce_style_formats( $settings ) 
{
    //* Get current styles or empty array
    $style_formats = !empty($settings['style_formats']) ? json_decode( $settings['style_formats'] ) : array();

    //* Add Filters for developers 
    $filtered_style_formats = apply_filters( 'ejo_visual_editor_styles', $style_formats ); //* To be deprecated

    //* Check if filter deprecated filter is used
    if ($filtered_style_formats != $style_formats) {
        _deprecated_function( __FUNCTION__, '0.7.1', 'ejo_tinymce_style_formats' );
    }
    else {
        $filtered_style_formats = apply_filters( 'ejo_tinymce_style_formats', $style_formats ); // New filtername
    }

    $settings['style_formats'] = json_encode( $filtered_style_formats );

    return $settings;
}

