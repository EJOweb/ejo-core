<?php

//* Change crop of default image size (thumbnail, medium, large)
function ejo_change_default_image_size_crop( $size = null, $crop = 1 )
{
	//* Check $size
	if ( !isset($size) )
		return;

	//* Check $crop
	if ( $crop != 0 && $crop != 1 )
		return;

	$size_crop = get_option( $size . '_crop' );

	//* Update crop switch for specified size 
	if( $size_crop != $crop)
		update_option( $size . '_crop', $crop );
}

//* Because of get_option it is connecting to database on every page

//* Maybe make a button out of it on media page. Then it is only fired at click

//* Delete option on uninstall