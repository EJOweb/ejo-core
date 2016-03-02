<?php

//* Customize the icons on the tinyMCE rows
add_filter( 'mce_buttons', 'ejo_mce_buttons' );
add_filter( 'mce_buttons_2', 'ejo_mce_buttons_2' );

//* Customize block format possibilities
add_filter( 'tiny_mce_before_init', 'ejo_tinymce_formats' );

//* Add Style Select dropdown with custom styles
add_filter( 'tiny_mce_before_init', 'ejo_tinymce_style_formats', 5 );

/** 
 * TinyMCE custom row 1
 * 
 * WordPress Defaults:
 * bold, italic, strikethrough, bullist, numlist, 
 * blockquote, hr, alignleft, aligncenter, alignright, 
 * link, unlink, wp_more, spellchecker, dfw, wp_adv, 
 */
function ejo_mce_buttons( $buttons ) 
{
    // Customize icons in the first row
    return array(
        'formatselect', 'bold', 'italic', 'sub', 'sup', 
        'bullist', 'numlist', 'blockquote', 'link', 'unlink',
        'styleselect', '|', 'charmap', 'wp_more', '|', 
        'removeformat', 'spellchecker', 'fullscreen', 'wp_help'
    );
}

/** 
 * TinyMCE custom row 2
 *
 * WordPress Defaults:
 * formatselect, underline, alignjustify, forecolor, 
 * pastetext, removeformat, charmap, outdent, indent, 
 * undo, redo, wp_help, 
 */
function ejo_mce_buttons_2($buttons) 
{
    // Empty second row of icons
    return array();
}

/** 
 * TinyMCE custom block formats
 */
function ejo_tinymce_formats($init) 
{
    $init['block_formats'] = 'Paragraph=p;Heading 2=h2;Heading 3=h3;Heading 4=h4;Pre=pre';

    return $init;
}

/** 
 * Add custom styles to "Styles" dropdown
 */
function ejo_tinymce_style_formats( $settings ) 
{
    //* Get current styles or empty array
    $style_formats = !empty($settings['style_formats']) ? json_decode( $settings['style_formats'] ) : array();
  
    //* Button
    if ( current_theme_supports( 'ejo-tinymce', 'button' ) ) {
        $style_formats[] =  array(
            'title' => 'Button',
            'selector' => 'a',
            'classes' => 'button'
        );
    }
    
    //* Button-2
    if ( current_theme_supports( 'ejo-tinymce', 'button-2' ) ) {
        $style_formats[] =  array(
            'title' => 'Button-2',
            'selector' => 'a',
            'classes' => 'button-2'
        );
    }

    //* Intro paragraph
    if ( current_theme_supports( 'ejo-tinymce', 'intro' ) ) {
        $style_formats[] =  array(
            'title' => 'Intro paragraaf',
            'selector' => 'p',
            'classes' => 'intro'
        );
    }

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

