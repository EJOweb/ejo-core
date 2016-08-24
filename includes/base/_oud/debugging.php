<?php

add_action( 'wp_footer', 'ejo_debug', 99);

/**
 * Test results in footer 
 */
function ejo_debug()
{
	/* Only analyze if in debugging mode */
	if ( !WP_DEBUG )
		return;	
	
	ejo_show_debug_query();
	ejo_show_debug_misc();
}

//* Print query debug data
function ejo_show_debug_query()
{
	//* Show number of queries and execution time 
	write_log( get_num_queries() . ' queries in ' . timer_stop(0) . ' seconds' );

	//* Check if savequeries debug option is enabled 
	if ( defined('SAVEQUERIES') && SAVEQUERIES ) {
		global $wpdb;

		write_log($wpdb->queries);
	}
}

//* Print misc debug data
function ejo_show_debug_misc()
{
	global $wp, $template;

	write_log( empty($wp->request) ? 'Request: None' : 'Request: ' . esc_html($wp->request) );

	write_log( 'Template: ' . basename($template) );

	write_log( empty($wp->matched_rule) ? 'Rule: None' : 'Rule: ' . esc_html($wp->matched_rule) );

	write_log( empty($wp->matched_query) ? 'Query: None' : 'Query: ' . esc_html($wp->matched_query) );

	global $wp_query;
	write_log($wp_query);
}
