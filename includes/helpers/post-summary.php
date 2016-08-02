<?php

/**
 * @param int|object $post
 * @return mixed  String of post-summary on success or false on failure.
 */
function ejo_the_post_summary( $post = null ) 
{
	echo ejo_get_post_summary( $post );
}

/**
 * @param int|object $post
 * @return mixed  String of post-summary on success or false on failure.
 */
function ejo_get_post_summary( $post = null ) 
{
	// if integer or null, get post object
	if ( is_int($post) || is_null($post) ) {
		$post = get_post( $post );
	}

	// if $post is not object, return
	if ( !is_object($post) )
		return false;

	// Check if post_excerpt exists, otherwise process post_content
	if ( !empty($post->post_excerpt) ) {
		return apply_filters( 'ejo_the_excerpt', $post->post_excerpt );
	}
	else {
		return apply_filters( 'ejo_the_content', $post->post_content );
	}
}

// EJO content filters
add_filter( 'ejo_the_content', 'wptexturize'       );
add_filter( 'ejo_the_content', 'convert_smilies'   );
add_filter( 'ejo_the_content', 'convert_chars'     );
add_filter( 'ejo_the_content', 'shortcode_unautop' );
add_filter( 'ejo_the_content', 'do_shortcode'      );
add_filter( 'ejo_the_content', 'wp_trim_words'     );
add_filter( 'ejo_the_content', 'wpautop'           );

// EJO excerpt filters
add_filter( 'ejo_the_excerpt', 'wptexturize'       );
add_filter( 'ejo_the_excerpt', 'convert_smilies'   );
add_filter( 'ejo_the_excerpt', 'convert_chars'     );
add_filter( 'ejo_the_excerpt', 'wpautop'           );
add_filter( 'ejo_the_excerpt', 'shortcode_unautop' );
add_filter( 'ejo_the_excerpt', 'do_shortcode'      );















/**
 * NOT IN USE
 */
function ejo_trim_words( $text = '' ) 
{
	/** This filter is documented in wp-includes/post-template.php */
	$text = apply_filters( 'the_content', $text );
	$text = str_replace(']]>', ']]&gt;', $text);

	/**
	 * Filter the number of words in an excerpt.
	 *
	 * @since 2.7.0
	 *
	 * @param int $number The number of words. Default 55.
	 */
	$excerpt_length = apply_filters( 'excerpt_length', 55 );
	/**
	 * Filter the string in the "more" link displayed after a trimmed excerpt.
	 *
	 * @since 2.9.0
	 *
	 * @param string $more_string The string shown within the more link.
	 */
	$excerpt_more = apply_filters( 'excerpt_more', ' ' . '[&hellip;]' );
	$text = wp_trim_words( $text, $excerpt_length, $excerpt_more );

	return $text;
}