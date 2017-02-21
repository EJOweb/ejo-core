<?php

//* Custom EJOweb shortcodes [ejoweb] [ejoweb_credits]
add_shortcode( 'ejoweb', 'show_ejoweb_link' );
add_shortcode( 'ejoweb_credits', 'show_ejoweb_credits' );


/** 
 * Link to EJOweb website
 */
function show_ejoweb_link( $atts ) 
{
    $atts = shortcode_atts( array(
        'text' => 'EJOweb',
        'title' => 'EJOweb - Professionele website laten maken'
    ), $atts );

    return '<a href="https://www.ejoweb.nl" title="' . $atts['title'] . '">' . $atts['text'] . '</a>';
}

/** 
 * Show EJOweb credits
 *
 * Show it as a link on the home-page and as plain text on other pages
 */
function show_ejoweb_credits( $atts ) 
{
    $atts = shortcode_atts( array(
        'text' => 'Webdesign door EJOweb',
        'title' => 'Website gemaakt door EJOweb'
    ), $atts );

    if (is_front_page()) :
        $output = show_ejoweb_link( $atts );
    else :
        $output = $atts['text'];
    endif;

    return '<span class="site-credits">' . $output . '</span>';
}