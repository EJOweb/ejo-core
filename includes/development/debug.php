<?php

add_action( 'wp_footer', 'ejo_debug' );

/**
 * Test results in footer 
 */
function ejo_debug()
{
	/* Only analyze if in debugging mode */
	if ( !WP_DEBUG )
		return;

	global $wp, $template;

	echo 'Request: ';
	echo empty($wp->request) ? 'None' : esc_html($wp->request);
	echo '<br/>';
	
	echo 'Template: ';
	echo basename($template);
	echo '<br/>';

	echo 'Rule: ';
	echo empty($wp->matched_rule) ? 'None' : esc_html($wp->matched_rule);
	echo '<br/>';

	echo 'Query: ';
	echo empty($wp->matched_query) ? 'None' : esc_html($wp->matched_query);
	echo '<br/>';

	global $wp_query;
	var_dump($wp_query);
}


