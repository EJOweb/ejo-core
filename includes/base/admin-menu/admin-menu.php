<?php 

/* Change menu order */
add_action( 'admin_menu', 'ejo_change_menu_order' );

/* Remove Tools submenu */
add_action( 'admin_menu', 'ejo_remove_tools_submenu', 99 );

/* Remove unnecesary menus */
function ejo_change_menu_order()
{
	global $menu;

	//* Try to remove posts-section from menu
    foreach ($menu as $index => $menu_item) {

        //* Posts menu
        if ($menu_item[2] == 'edit.php' )
        	$posts_index = $index;
        
        //* Pages menu
        elseif ($menu_item[2] == 'edit.php?post_type=page' )
        	$pages_index = $index;

        //* Appearance menu
        elseif ($menu_item[2] == 'themes.php' )
        	$appearance_index = $index;

        //* Wordpress Seo menu
        elseif ($menu_item[2] == 'wpseo_dashboard' )
        	$wpseo_index = $index;

        //* Last seperator
        elseif ($menu_item[2] == 'separator-last' )
        	$seperator_last_index = $index;
    }

    //* Move posts 1 place up
    $menu[$posts_index + 1] = $menu[$posts_index];

    //* Overwrite old posts location with pages
    $menu[$posts_index] = $menu[$pages_index];

    //* Remove previous pages location
    unset($menu[$pages_index]);


    //* Move wpseo after appearance
    $menu[$appearance_index + 1] = $menu[$wpseo_index];

    //* Remove previous wpseo location
    unset($menu[$wpseo_index]);


    //* Move seperator-last after wpseo
    $menu[$appearance_index + 2] = $menu[$seperator_last_index];

    //* Remove previous seperator_last location
    unset($menu[$seperator_last_index]);
}


/* Remove Tools Submenu */
function ejo_remove_tools_submenu()
{
    remove_submenu_page( 'tools.php', 'tools.php' );
}