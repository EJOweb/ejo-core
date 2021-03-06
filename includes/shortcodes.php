<?php 

/**
 * Don't auto-p wrap shortcodes that stand alone
 * Ensures that shortcodes are not wrapped in `<p>...</p>`.
 * See wp-includes/formatting.php
 */
add_filter( 'widget_text', 'shortcode_unautop', 9 );

//* Vsee link in footer
add_shortcode( 'footer_vsee', 'show_vsee_credits' );

//* EJOweb link in footer
add_shortcode( 'footer_ejoweb', 'show_ejoweb_credits' );

// Simple current year shortcode
add_shortcode('year', 'year_shortcode');


/** 
 * Show Vsee credits
 *
 * Show it as a link on the home-page and as plain text on other pages
 */
function show_vsee_credits( $atts ) 
{
    $atts = shortcode_atts( array(
        'text' => 'Vsee Search Marketing',
    ), $atts );

    if (is_front_page()) :
        $output = '<a class="footer-credits" href="https://www.vsee.nl" title="Vsee Search Marketing: Online Marketing Bureau, sinds 2009">' . $atts['text'] . '</a>';
    else :
        $output = '<span class="footer-credits">' . $atts['text'] . '</span>';
    endif;

    return $output;
}

/** 
 * Show EJOweb credits
 *
 * Show it as a link on the home-page and as plain text on other pages
 */
function show_ejoweb_credits( $atts ) 
{
    $atts = shortcode_atts( array(
        'text' => 'EJOweb',
    ), $atts );

    if (is_front_page()) :
        $output = '<a class="footer-credits" href="https://www.ejoweb.nl" title="EJOweb - Professionele website laten maken">' . $atts['text'] . '</a>';
    else :
        $output = '<span class="footer-credits">' . $atts['text'] . '</span>';
    endif;

    return $output;
}

/**
 * Get current year from php and return it
 */
function year_shortcode() 
{
    $year = date('Y');
    return $year;
}