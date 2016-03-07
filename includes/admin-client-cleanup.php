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
	add_action( 'admin_init', 'ejo_remove_menus' );

	/* Remove admin bar menu's */
	add_action( 'admin_bar_menu', 'ejo_remove_admin_bar_menus', 999 );
}

/**
 * Global $menu, $submenu
 * 
 * 	Dashboard
 * 	[2][index.php]
 *		[0] Home
 *		[10] Updates
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
 * 	[edit-comments.php]
 *
 * 	Themes
 * 	[60][themes.php]
 *		[5] Themas
 *		[6] Customizer
 *		[7] Widgets
 *		[10] Menus
 *		[11] Thema Opties
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

/* Remove theme-editor */
function ejo_remove_menus()
{
	global $submenu;

	/* Dashboard */
	remove_submenu_page( 'index.php', 'update-core.php' );

	/* Appearance */
    unset($submenu['themes.php'][6]); // Customize
    remove_submenu_page( 'themes.php', 'themes.php' ); // Theme switcher    
    remove_submenu_page( 'themes.php', 'theme-editor.php' ); // Theme editor

	/* Plugin */
	remove_menu_page( 'plugins.php' );

	/* Tools */
	remove_menu_page( 'tools.php' );                

	/* Settings */
	remove_menu_page( 'options-general.php' );

	if ( current_theme_supports( 'ejo-admin-client-cleanup', 'blog' ) ) {
		/* Posts */
		remove_menu_page( 'edit.php' );
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

	if ( current_theme_supports( 'ejo-admin-client-cleanup', 'blog' ) ) {
		$wp_admin_bar->remove_node( 'new-post' );
	}
}