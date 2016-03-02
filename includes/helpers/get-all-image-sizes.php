<?php

/**
 * Get all image sizes
 */
function get_all_image_sizes()
{
	/* Default Image Sizes */
	$image_sizes = array( 'thumbnail', 'medium', 'large' );

	/* Additional Image Sizes */
	global $_wp_additional_image_sizes;
	$additional_image_sizes = (!empty($_wp_additional_image_sizes)) ? array_keys($_wp_additional_image_sizes) : array();

	/* Merge all Image Sizes */
	return array_merge($image_sizes, $additional_image_sizes);
}