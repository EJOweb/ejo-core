<?php

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
        'text' => 'Internetbureau Vsee',
    ), $atts );

    if (is_front_page()) :
        $output = '<a class="footer-credits" href="http://www.vsee.nl" title="Internetbureau Vsee - Google Adwords en SEO specialisten">' . $atts['text'] . '</a>';
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
        $output = '<a class="footer-credits" href="http://www.ejoweb.nl" title="EJOweb - Wordpress Developer">' . $atts['text'] . '</a>';
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