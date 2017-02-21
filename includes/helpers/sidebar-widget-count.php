<?php

//* Get number of widgets in a given sidebar
function ejo_get_sidebar_widget_count( $sidebar_id ) {
	
	global $sidebars_widgets;

	if ( empty($sidebars_widgets[$sidebar_id]) )
		return 0;

	return count($sidebars_widgets[$sidebar_id]);
}

//* Get class for amount of widgets in sidebar
function ejo_get_sidebar_widget_count_class( $sidebar_id ) {

	$widget_count = ejo_get_sidebar_widget_count( $sidebar_id );

	return ($widget_count == 0) ? 'no-widgets' : 'widgets-' . $widget_count;
}