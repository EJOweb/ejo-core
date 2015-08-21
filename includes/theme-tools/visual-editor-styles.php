<?php

// add style selector drop down 
add_filter( 'mce_buttons_2', 'ejo_mce_buttons_2' );

// add styles
add_filter( 'tiny_mce_before_init', 'ejo_mce_before_init' );

//* Reveal the hidden "Styles" dropdown
function ejo_mce_buttons_2( $buttons ) 
{
    //* Add style selector to the beginning of the toolbar
    array_unshift( $buttons, 'styleselect' );

    return $buttons;
}

//* Add custom styles to "Styles" dropdown
function ejo_mce_before_init( $settings ) 
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

    //* Combine new styles with current styles
    $style_formats = array_merge($style_formats, $new_style_formats);

    $settings['style_formats'] = json_encode( $style_formats );

    return $settings;
}