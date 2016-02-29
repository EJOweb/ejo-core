<?php
/**
 * Plugin Name:         EJO Core
 * Plugin URI:          http://github.com/ejoweb/ejo-core
 * Description:         EJOweb core functionalities for theme development. Including some nifty debug tools.
 * Version:             0.9.3
 * Author:              Erik Joling
 * Author URI:          http://www.ejoweb.nl/
 * Text Domain:         ejo-core
 * Domain Path:         /languages
 *
 * GitHub Plugin URI:   https://github.com/EJOweb/ejo-core
 * GitHub Branch:       theme-support
 *
 * Minimum PHP version: 5.3.0
 *
 * @package   EJO Core
 * @version   0.1.0
 * @since     0.1.0
 * @author    Erik Joling <erik@ejoweb.nl>
 * @copyright Copyright (c) 2015, Erik Joling
 * @link      http://github.com/ejoweb
 */

/**
 *
 */
final class EJO_Core 
{
    /* Version number of this plugin */
    public static $version = '0.9.3';

    /* Holds the instance of this class. */
    protected static $_instance = null;

    /* Store the slug of this plugin */
    public static $slug = 'ejo-core';

    /* Stores the directory path for this plugin. */
    public static $dir;

    /* Stores the directory URI for this plugin. */
    public static $uri;

    /* Returns the instance. */
    public static function instance() 
    {
        if ( !self::$_instance )
            self::$_instance = new self;
        return self::$_instance;
    }

    /* Plugin setup. */
    protected function __construct() 
    {
        /* Setup */
        add_action( 'plugins_loaded', array( $this, 'setup' ), 1 );

        /* Load Translations */
        add_action( 'plugins_loaded', array( $this, 'load_textdomain' ), 2 );

        /* Load Helper Functions */
        add_action( 'plugins_loaded', array( $this, 'helper_functions' ), 3 );

        /* Load Development Functions */
        add_action( 'plugins_loaded', array( $this, 'development_features' ), 4 );

        /* Add Theme Features */
        add_action( 'after_setup_theme', array( $this, 'theme_features' ) );

        /* Zou in een after_setup_theme functie kunnen */
        /* Add EJOcore Option page to Wordpress Option menu */
        add_action( 'admin_menu', array( $this, 'register_options_page' ) );
    }

    
    /* Defines the directory path and URI for the plugin. */
    public function setup() 
    {
        define( 'EJO_DIR', plugin_dir_path( __FILE__ ) );
        define( 'EJO_URI', plugin_dir_url( __FILE__ ) );

        /* Store if Genesis is active */
        define( 'GENESIS_ACTIVE', 'genesis' == get_option( 'template' ) );
    }

    /* Load Translations */
    public function load_textdomain() 
    {
        /* Load the translation for the plugin */
        load_plugin_textdomain('ejo-core', false, 'ejo-core/languages' );
    }
  
    /* Add helper functions */
    public function helper_functions() 
    {
        /* Remove entry from array based on value */
        include_once( EJO_DIR . 'includes/helpers/array-functions.php' );

        /* Use this function to filter custom theme support with arguments */
        include_once( EJO_DIR . 'includes/helpers/theme-support-arguments.php' );
    }
  
    /* Add development functions */
    public function development_features() 
    {
        /* Write Log */
        include_once( EJO_DIR . 'includes/development/write-log.php' );

        /* Analyze Query */
        include_once( EJO_DIR . 'includes/development/analyze-query.php' );
    }

    /* Add Features */
    public function theme_features() 
    {
        /* Allow arguments to be passed for theme-support */
        add_filter( 'current_theme_supports-ejo-post-scripts', 'ejo_theme_support_arguments', 10, 3 );
        add_filter( 'current_theme_supports-ejo-tinymce', 'ejo_theme_support_arguments', 10, 3 );
        add_filter( 'current_theme_supports-ejo-social-links', 'ejo_theme_support_arguments', 10, 3 );
        add_filter( 'current_theme_supports-ejo-cleanup-frontend', 'ejo_theme_support_arguments', 10, 3 );
        add_filter( 'current_theme_supports-ejo-cleanup-backend', 'ejo_theme_support_arguments', 10, 3 );
        add_filter( 'current_theme_supports-ejo-widgets', 'ejo_theme_support_arguments', 10, 3 );

        /* ----------------------------------- */

        /* Knowledgebase */
        require_if_theme_supports( 'ejo-knowledgebase', EJO_DIR . 'extensions/knowledgebase/knowledgebase.php' );

        /* Improved summary for posts */
        require_once( EJO_DIR . 'includes/post-summary.php' );

        /* Change crop switch of default image size */
        require_once( EJO_DIR . 'includes/image-size-crop.php' );

        /* Shortcodes */
        require_once( EJO_DIR . 'includes/shortcodes.php' );
        
        /* Widgets */
        require_once( EJO_DIR . 'includes/widgets.php' );

        /* Allow admin to add scripts to entire site */
        require_if_theme_supports( 'ejo-site-scripts', EJO_DIR . 'includes/add-site-scripts.php' );

        /* Allow admin to add scripts to specific posts */
        require_if_theme_supports( 'ejo-post-scripts', EJO_DIR . 'includes/add-post-scripts.php' ); 

        /* Improved Visual Editor */
        require_if_theme_supports( 'ejo-tinymce', EJO_DIR . 'includes/visual-editor-styles.php' );

        /* Social Media Links */
        require_if_theme_supports( 'ejo-social-links', EJO_DIR . 'includes/social-links.php' );

        /* Cleanup Frontend */
        require_if_theme_supports( 'ejo-cleanup-frontend', EJO_DIR . 'includes/cleanup-head.php' ); // Remove unnecessary head links
        require_if_theme_supports( 'ejo-cleanup-frontend', EJO_DIR . 'includes/disable-xmlrpc.php' ); // Disable XML-RPC
        require_if_theme_supports( 'ejo-cleanup-frontend', EJO_DIR . 'includes/disable-pingback.php' ); // Disable Pingback

        /* Cleanup Backend */
        require_if_theme_supports( 'ejo-cleanup-backend', EJO_DIR . 'includes/unregister-widgets.php' ); // Widget Unregistering
         require_if_theme_supports( 'ejo-cleanup-backend', EJO_DIR . 'includes/cleanup-wp-smush-plugin.php' ); // Hide notices to smush-it pro

        /* Admin Image Select Script */
        require_if_theme_supports( 'ejo-admin-image-select', EJO_DIR . 'includes/admin-image-select.php' );
     
    }

    /* Register EJOcore Options Page */
    public function register_options_page()
    {
        add_theme_page('Thema Opties', 'Thema Opties', 'edit_theme_options', 'ejo-theme-options', array( $this, 'add_theme_options_page' ) );
    }

    /* Add EJOcore Options Page */
    public function add_theme_options_page()
    {
        /* Include theme options page */
        include_once( EJO_DIR . 'includes/theme-options-page.php' );
    }

    /* Uninstall */
    public function uninstall()
    {
        /**
         * Stored data in options table
         * - ejo_header_scripts
         * - ejo_footer_scripts
         * - medium_crop
         * - large_crop
         * - _ejo_social_media
         */
    }
}

/* Call EJO Core */
EJO_Core::instance();