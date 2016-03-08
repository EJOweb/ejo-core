<?php

/**
 * Simplify admin screen for non-ejoweb users
 */

$non_ejoweb_user = false;

if (is_admin()) {
	$current_user = wp_get_current_user();

	if ( !strstr( $current_user->user_email, '@ejoweb.nl' ) ) {
	 	$non_ejoweb_user = true;
	}	
}

if ($non_ejoweb_user) {
	/* Remove menu's */
	add_action( 'admin_menu', 'ejo_remove_menus' );

	/* Remove some menu's at a later hook */
	add_action( 'admin_init', 'ejo_remove_menus_2' );

	/* Remove admin bar menu's */
	add_action( 'admin_bar_menu', 'ejo_remove_admin_bar_menus', 999 );

	/* Remove dashboard widgets */
	add_action( 'wp_dashboard_setup', 'ejo_remove_dashboard_widgets' );
}

/**
 * Global $menu, $submenu
 * 
 * 	Dashboard
 * 	[2][index.php]
 *		[0] Home
 *		[10] Updates
 *
 *	Seperator
 *	[4]
 *
 * 	Posts
 * 	[5][edit.php]
 *		[5] Alle berichten
 *		[10] Nieuw bericht
 *		[15] Categorieen
 *		[16] Tags
 *		[9] Reacties
 *
 * 	Media
 * 	[10][upload.php]
 *		[5] Bibliotheek
 *		[10] Nieuw bestand
 *		[11] WP Smush
 *
 * 	Pages
 * 	[20][edit.php?post_type=page]
 *		[5] Alle paginas
 *		[10] Nieuwe pagina
 *
 * 	Comments
 * 	[25][edit-comments.php]
 *
 *	Seperator
 *	[59]
 *
 * 	Themes
 * 	[60][themes.php]
 *		[5] Themas
 *		[6] Customizer
 *		[7] Widgets
 *		[10] Menus
 *		[11] Thema Opties
 *		[15] Header
 *
 * 	Plugins
 * 	[65][plugins.php]
 *		[5] Geinstalleerde plugins
 *		[10] Nieuwe plugin
 *		[15] Bewerker
 *
 * 	Users
 * 	[70][users.php]
 *		[5] Alle gebruikers
 *		[10] Nieuwe toevoegen
 *		[15] Je profiel
 *
 * 	Tools
 * 	[75][tools.php]
 *		[5] Beschikbare middelen
 *		[10] Importeren
 *		[15] Exporteren
 *		[16] Reset
 *		[17] Rebuild Thumbnails
 *
 * 	Settings
 * 	[80][options-general.php]
 *		[10] Algemeen
 *		[15] Schrijven
 *		[20] Lezen
 *		[25] Reacties
 *		[30] Media
 *		[40] Permalinks
 *		[41] Manual Image Crop
 *
 * 	??
 * 	[edit-tags.php?taxonomy=link_category]
 *		[15] Categorie
 *
 *  ADDITIONAL MENU
 *
 *  Genesis Seperator
 *  [58.995]
 *
 *  Genesis
 *  [58.996][genesis]
 *		[0] Theme Settings
 *		[1] Import/Export
 *		[2] Simple Edits
 *		[3] Slider Settings
 *
 *  Gravity Forms
 *  [16.9][gf_edit_forms]
 * 		[0] Formulieren
 * 		[1] Nieuw formulier
 * 		[2] Inzendingen
 * 		[3] Instellingen
 * 		[4] Import/Export
 * 		[5] Updates
 * 		[6] Add-ons
 * 		[7] Help
 *
 *	WP SEO
 * 	[99.5][wpseo_dashboard]
 *		[0] Algemeen
 *		[1] Titels en metas
 *		[2] Sociaal
 *		[3] XML sitemaps
 *		[4] Geavanceerd
 *		[5] Extra
 *		[6] Search Console
 *		[7] Extensies
 */

/* Remove menus */
function ejo_remove_menus()
{
	global $submenu;

	if ( current_theme_supports( 'ejo-admin-client-cleanup', 'updates' ) ) {
		/* Dashboard */
		remove_submenu_page( 'index.php', 'update-core.php' );
	}

	/* Appearance */
    remove_submenu_page( 'themes.php', 'themes.php' ); // Theme switcher

    if ( current_theme_supports( 'ejo-admin-client-cleanup', 'customizer' ) ) {
    	unset($submenu['themes.php'][6]); // Customize
    	unset($submenu['themes.php'][15]); // Customize Header
    }

	/* Plugin */
	remove_menu_page( 'plugins.php' );

	/* Tools */
	remove_menu_page( 'tools.php' );                

	/* Settings */
	// remove_menu_page( 'options-general.php' );
	// remove_submenu_page( 'options-general.php', 'options-general.php' );
	remove_submenu_page( 'options-general.php', 'options-writing.php' );
	remove_submenu_page( 'options-general.php', 'options-reading.php' );
	remove_submenu_page( 'options-general.php', 'options-discussion.php' );
	remove_submenu_page( 'options-general.php', 'options-media.php' );
	remove_submenu_page( 'options-general.php', 'options-permalink.php' );
	remove_submenu_page( 'options-general.php', 'Mic-setting-admin' );
	
	// [80][options-general.php]
 // *		[10] Algemeen
 // *		[15] Schrijven
 // *		[20] Lezen
 // *		[25] Reacties
 // *		[30] Media
 // *		[40] Permalinks
 // *		[41] Manual Image Crop

	/* Remove posts menu */
	if ( current_theme_supports( 'ejo-admin-client-cleanup', 'blog' ) ) {
		remove_menu_page( 'edit.php' ); // Posts
	}

	/* Remove genesis menu */
	if ( current_theme_supports( 'ejo-admin-client-cleanup', 'genesis' ) ) {
		remove_menu_page( 'genesis' );
	}

	/* Remove Reactions */
	if ( current_theme_supports( 'ejo-admin-client-cleanup', 'comments' ) ) {
		remove_menu_page( 'edit-comments.php' );
		remove_submenu_page( 'edit.php', 'edit-comments.php' ); // In case comment menu is transfered to posts menu
	}
}

/**
 * Remove some menu items at a later hook
 *
 * Some menu items must be called at admin_init hook for some reason
 */
function ejo_remove_menus_2()
{
	/* Theme editor */
	remove_submenu_page( 'themes.php', 'theme-editor.php' ); 

	/* Font awesome */
	remove_submenu_page( 'options-general.php', 'better-font-awesome' ); 

	if ( current_theme_supports( 'ejo-admin-client-cleanup', 'updates' ) ) {
		/* Github Updater */
		remove_submenu_page( 'options-general.php', 'github-updater' ); 
	}
}

/* Remove admin bar menu's */
function ejo_remove_admin_bar_menus( $wp_admin_bar ) 
{
	/**
	 * WP_Admin_Bar Nodes
	 * [user-actions]
	 * [user-info]
	 * [edit-profile]
	 * [logout]
	 * [menu-toggle]
	 * [my-account]
	 * [wp-logo]
	 * [about]
	 * [wporg]
	 * [documentation]
	 * [support-forums]
	 * [feedback]
	 * [site-name]
	 * [view-site]
	 * [updates]
	 * [comments]
	 * [new-content]
	 * [new-post]
	 * [new-media]
	 * [new-page]
	 * [new-knowledgebase_post]
	 * [new-user]
	 * [wpseo-menu]
	 * [wpseo-kwresearch]
	 * [wpseo-adwordsexternal]
	 * [wpseo-googleinsights]
	 * [wpseo-wordtracker]
	 * [wpseo-settings]
	 * [wpseo-general]
	 * [wpseo-titles]
	 * [wpseo-social]
	 * [wpseo-xml]
	 * [wpseo-wpseo-advanced]
	 * [wpseo-tools]
	 * [wpseo-search-console]
	 * [wpseo-licenses]
	 * [top-secondary]
	 * [wp-logo-external]
	 */

	/* Comments */
	if ( current_theme_supports( 'ejo-admin-client-cleanup', 'comments' ) ) {
		$wp_admin_bar->remove_node( 'comments' );
	}

	/* Updates */
	if ( current_theme_supports( 'ejo-admin-client-cleanup', 'updates' ) ) {
		$wp_admin_bar->remove_node( 'updates' );
	}

	/* Blog */
	if ( current_theme_supports( 'ejo-admin-client-cleanup', 'blog' ) ) {
		$wp_admin_bar->remove_node( 'new-post' );
	}
}

/* Remove dashboard widgets */
function ejo_remove_dashboard_widgets()
{
	global $wp_meta_boxes;

	/* Remove Quick post and Activity dashboard widget if no blog */
	if ( current_theme_supports( 'ejo-admin-client-cleanup', 'blog' ) ) {
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']);
	}

	/* Remove Wordpress news */
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
}