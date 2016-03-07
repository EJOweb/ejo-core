<?php 

/* Change menu order */
add_action( 'admin_menu', 'ejo_change_menu_order' );

/* Remove unnecesary menus */
function ejo_change_menu_order()
{
	global $menu;

	/* Relocate Pages menu [20] just before Posts menu [5] */
	$menu[6] = $menu[5]; 
	$menu[5] = $menu[20];
	unset($menu[20]);
}