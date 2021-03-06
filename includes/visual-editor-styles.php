<?php

//* Customize the icons on the tinyMCE rows
add_filter( 'mce_buttons', 'ejo_mce_buttons' );
add_filter( 'mce_buttons_2', 'ejo_mce_buttons_2' );

//* Customize block format possibilities
add_filter( 'tiny_mce_before_init', 'ejo_tinymce_formats' );

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
