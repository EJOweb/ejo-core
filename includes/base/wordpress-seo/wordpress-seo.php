<?php

/* Better integration of Yoast Wordpress SEO */
add_action( 'after_setup_theme', 'ejo_wordpress_seo', 99 );

/* Improve Yoast Wordpress SEO support */
function ejo_wordpress_seo()
{
    //* Edit main SEO capability
    add_filter( 'wpseo_manage_options_capability',                          'ejo_wordpress_seo_capability' );

    //* Change capability necessary to save options
    add_filter( 'option_page_capability_yoast_wpseo_permalinks_options',    'ejo_wordpress_seo_capability' );
    add_filter( 'option_page_capability_yoast_wpseo_internallinks_options', 'ejo_wordpress_seo_capability' );
    add_filter( 'option_page_capability_yoast_wpseo_permalinks_options',    'ejo_wordpress_seo_capability' );
    add_filter( 'option_page_capability_yoast_wpseo_rss_options',           'ejo_wordpress_seo_capability' );
    add_filter( 'option_page_capability_yoast_wpseo_xml_sitemap_options',   'ejo_wordpress_seo_capability' );
    add_filter( 'option_page_capability_yoast_wpseo_social_options',        'ejo_wordpress_seo_capability' );
    add_filter( 'option_page_capability_yoast_wpseo_options',               'ejo_wordpress_seo_capability' );

    //* Remove Go Premium and Search Console from menu
    add_filter( 'wpseo_submenu_pages', function($submenu_pages) {

        foreach ($submenu_pages as $index => $submenu_page) {

            //* Remove Search Console and Go Premium 
            if ($submenu_page[4] == 'wpseo_search_console' || $submenu_page[4] == 'wpseo_licenses')
                unset($submenu_pages[$index]);
        }

        return $submenu_pages;
    });
}

/* Wordpress SEO capability */
function ejo_wordpress_seo_capability( $capability )
{
    //* Downgrade capability from manage_options to edit_theme_options to support ejo-client
    $capability = 'edit_theme_options';        

    return $capability;
}