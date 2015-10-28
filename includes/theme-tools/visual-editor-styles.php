<?php

// add style selector drop down 
add_filter( 'mce_buttons_2', 'ejo_mce_buttons_2' );

// add styles
add_filter( 'tiny_mce_before_init', 'ejo_add_tinymce_style_formats', 5 );

//* Reveal the hidden "Styles" dropdown
function ejo_mce_buttons_2( $buttons ) 
{
    //* Add style selector to the beginning of the toolbar
    array_unshift( $buttons, 'styleselect' );

    return $buttons;
}

//* Add custom styles to "Styles" dropdown
function ejo_add_tinymce_style_formats( $settings ) 
{
    //* Get current styles or empty array
    $style_formats = !empty($settings['style_formats']) ? json_decode( $settings['style_formats'] ) : array();

    //* Make new styles
    $new_style_formats = array(
        array(
            'title' => 'Button',
            'selector' => 'a',
            'classes' => 'button'
        ),
        array(
            'title' => 'Intro',
            'selector' => 'p',
            'classes' => 'intro'
        )
    );

    //* Add Filters for developers 
    $filtered_new_style_formats = apply_filters( 'ejo_visual_editor_styles', $new_style_formats ); //* To be deprecated

    //* Check if filter deprecated filter is used
    if ($filtered_new_style_formats != $new_style_formats) {
        _deprecated_function( __FUNCTION__, '0.7.1', 'ejo_tinymce_style_formats' );
    }
    else {
        $filtered_new_style_formats = apply_filters( 'ejo_tinymce_style_formats', $new_style_formats ); // New filtername
    }

    //* Combine new styles with current styles
    $style_formats = array_merge($style_formats, $filtered_new_style_formats);

    $settings['style_formats'] = json_encode( $style_formats );

    return $settings;
}