<?php 

/* Change menu order */
add_action( 'admin_menu', 'ejo_change_menu_order' );

/* Change Appearance submenu order */
add_action( 'admin_menu', 'ejo_change_appearance_menu_order', 99 );

/* Remove Tools submenu */
add_action( 'admin_menu', 'ejo_remove_tools_submenu', 99 );

/* Remove unnecesary menus */
function ejo_change_menu_order()
{
	global $menu;

	//* Get index of needed menu-items
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

    if ( isset($posts_index) && isset($pages_index) ) {
	 
	    //* Move posts 1 place up
	    $menu[$posts_index + 1] = $menu[$posts_index];

	    //* Overwrite old posts location with pages
	    $menu[$posts_index] = $menu[$pages_index];

	    //* Remove previous pages location
	    unset($menu[$pages_index]);
	}

	if ( isset($appearance_index) && isset($wpseo_index) ) {

	    //* Move wpseo after appearance
	    $menu[$appearance_index + 1] = $menu[$wpseo_index];

	    //* Remove previous wpseo location
	    unset($menu[$wpseo_index]);
	}

	if ( isset($appearance_index) && isset($seperator_last_index) ) {

	    //* Move seperator-last after wpseo
	    $menu[$appearance_index + 2] = $menu[$seperator_last_index];

	    //* Remove previous seperator_last location
	    unset($menu[$seperator_last_index]);
	}

	ksort($menu);
}

function ejo_change_appearance_menu_order() 
{
	global $submenu;

	// write_log($submenu['themes.php']);

	//* Get index of needed menu-items
    foreach ($submenu['themes.php'] as $index => $menu_item) {

    	//* Themes menu
        if ($menu_item[2] == 'themes.php' )
        	$themes_index = $index;
        
        //* Menu's menu
        elseif ($menu_item[2] == 'nav-menus.php' )
        	$menus_index = $index;

        //* Customizer menu
        elseif ($menu_item[2] == 'customize.php?return=%2Fwp-admin%2F' )
        	$customizer_index = $index;
    }

    if ( isset($themes_index) ) {

		//* Change capability of theme_switcher to 
		$submenu['themes.php'][$themes_index][1] = 'manage_options';
	}

	if ( isset($menus_index) && isset($customizer_index) ) {

		//* Move Customizer to after menus
	    $submenu['themes.php'][$menus_index + 1] = $submenu['themes.php'][$customizer_index];

	    //* Remove previous customizer location
	    unset($submenu['themes.php'][$customizer_index]);
	}

	ksort($submenu['themes.php']);
}


/* Remove Tools Submenu */
function ejo_remove_tools_submenu()
{
    remove_submenu_page( 'tools.php', 'tools.php' );
}