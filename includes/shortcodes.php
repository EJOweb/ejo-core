<?php 

/**
 * Don't auto-p wrap shortcodes that stand alone
 * Ensures that shortcodes are not wrapped in `<p>...</p>`.
 * See wp-includes/formatting.php
 */
add_filter( 'widget_text', 'shortcode_unautop', 9 );

//* EJOweb link
add_shortcode( 'ejoweb', 'show_ejoweb_link' );

//* EJOweb credits
add_shortcode( 'ejoweb_credits', 'show_ejoweb_credits' );

// Simple current year shortcode
add_shortcode('year', 'ejo_year_shortcode');

// Simple author shortcode
add_shortcode('author', 'ejo_author_shortcode');

/** 
 * Show EJOweb credits
 *
 * Show it as a link on the home-page and as plain text on other pages
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
        'text' => 'EJOweb',
        'title' => 'EJOweb - Professionele website laten maken'
    ), $atts );

    if (is_front_page()) :
        $output = show_ejoweb_link( $atts );
    else :
        $output = '<span>' . $atts['text'] . '</span>';
    endif;

    return $output;
}

/**
 * Get current year from php and return it
 */
function ejo_year_shortcode() 
{
    $year = date('Y');
    return $year;
}

function ejo_author_shortcode( $atts ) 
{
    $output = '';
    $link_open = '';
    $link_close = '';

    if ( ! post_type_supports( get_post_type(), 'author' ) ) {
        return '';
    }

    $atts = shortcode_atts( array(
        'link' => false
    ), $atts );

    $author = get_the_author();

    if ( ! $author ) {
        return '';
    }

    if ( $atts['link'] ) {
        global $authordata;

        if ( ! is_object( $authordata ) ) {
                return;
        }

        //* Get url of author page
        $url = esc_url( get_author_posts_url( $authordata->ID, $authordata->user_nicename ) );

        $link_open = ($url) ? '<a href="' . $url . '" itemprop="url" rel="author">' : '';
        $link_close = ($url) ? '</a>' : '';
    }

    $output .= '<span itemscope itemtype="http://schema.org/Person" itemprop="author">';
    $output .=     $link_open . '<span itemprop="name">' . $author . '</span>' . $link_close;
    $output .= '</span>';

    return $output;
}