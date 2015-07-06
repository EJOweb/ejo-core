<?php

add_action( 'widgets_init', 'ejo_core_unregister_widgets', 99 );

//* Unregister Widgets that I don't use often
function ejo_core_unregister_widgets()
{
	/* 
	 * If you want widgets to show use ejo_core_unregister_widgets filter in theme
	 */

	$widgets_to_unregister = array(
		'WP_Widget_Pages',
		'WP_Widget_Calendar',
		'WP_Widget_Archives',
		'WP_Widget_Meta',
		'WP_Widget_Search',
		'WP_Widget_Categories',
		'WP_Widget_Recent_Posts',
		'WP_Widget_Recent_Comments',
		'WP_Widget_RSS',
		'WP_Widget_Tag_Cloud',
		// 'WP_Nav_Menu_Widget', // Don't default unregister nav_menu widget
	);

	global $wp_widget_factory;

	//* Remove 'default text widget' if Black Studio TinyMCE widget is available
	if ( isset($wp_widget_factory->widgets['WP_Widget_Black_Studio_TinyMCE']) )
		$widgets_to_unregister[] = 'WP_Widget_Text';

	//* Filter $widgets_to_unregister
	$widgets_to_unregister = apply_filters( 'ejo_core_unregister_widgets', $widgets_to_unregister );

	//* Unregister each widget in array $widgets_to_unregister
	foreach ($widgets_to_unregister as $widget) {

		//* Don't unregister if widget is active
		if ( isset($wp_widget_factory->widgets[$widget]) && is_active_widget(false, false, $wp_widget_factory->widgets[$widget]->id_base))
			continue;

		//* Unregister widget
		unregister_widget( $widget );
	}
}