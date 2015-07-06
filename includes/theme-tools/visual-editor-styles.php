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
    $style_formats = array(
        array(
            'title' => 'Button',
            'selector' => 'a',
            'classes' => 'button'
        )
    );

    $settings['style_formats'] = json_encode( $style_formats );

    return $settings;
}