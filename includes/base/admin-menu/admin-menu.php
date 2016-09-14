<?php 

/* Change menu order */
add_action( 'admin_menu', 'ejo_change_menu_order' );

/* Remove Tools submenu */
add_action( 'admin_menu', 'ejo_remove_tools_submenu', 99 );

/* Remove unnecesary menus */
function ejo_change_menu_order()
{
	global $menu;

	/* Relocate Pages menu [20] just before Posts menu [5] */
	// if (isset($menu[5]))
		$menu[6] = $menu[5]; 
	$menu[5] = $menu[20];
	unset($menu[20]);
}


/* Remove Tools Submenu */
function ejo_remove_tools_submenu()
{
    remove_submenu_page( 'tools.php', 'tools.php' );
}