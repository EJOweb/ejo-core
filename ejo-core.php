<?php
/**
 * Plugin Name:         EJO Core
 * Plugin URI:          http://github.com/ejoweb/ejo-core
 * Description:         EJOweb core functionalities for theme development. Including some nifty debug tools.
 * Version:             0.8.2
 * Author:              Erik Joling
 * Author URI:          http://www.ejoweb.nl/
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
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 *
 */
final class EJO_Core 
{
    //* Version number of this plugin
    public static $version = '0.8.2';

    //* Holds the instance of this class.
    protected static $_instance = null;

    //* Store the slug of this plugin
    public static $slug = 'ejo-core';

    //* Stores the directory path for this plugin.
    public static $dir;

    //* Stores the directory URI for this plugin.
    public static $uri;

    //* Returns the instance.
    public static function instance() 
    {
        if ( !self::$_instance )
            self::$_instance = new self;
        return self::$_instance;
    }

    //* Plugin setup.
    protected function __construct() 
    {
        //* Setup
        self::setup();

        //* Load Development Functions
        add_action( 'plugins_loaded', array( $this, 'add_development_functions' ), 1 );

        //* Theme support
        add_action( 'after_setup_theme', array( $this, 'includes' ) );

        //* Zou in een after_setup_theme functie kunnen
        //* Add EJOcore Option page to Wordpress Option menu
        add_action( 'admin_menu', array( $this, 'register_options_page' ) );
    }

    
    //* Defines the directory path and URI for the plugin.
    protected static function setup() 
    {
        //* Store directory path and url of this plugin
        self::$dir = plugin_dir_path( __FILE__ );
        self::$uri = plugin_dir_url(  __FILE__ );

        define( 'EJO_DIR', plugin_dir_path( __FILE__ ) );
        define( 'EJO_URI', plugin_dir_url( __FILE__ ) );

        //* Store if Genesis is active
        define( 'GENESIS_ACTIVE', 'genesis' == get_option( 'template' ) );
    }

  
    //* Add development functions
    public function add_development_functions() 
    {
        //* Helper Functions
        include_once( EJO_DIR . 'includes/dev-functions/helper-functions.php' );

        //* Write Log
        include_once( EJO_DIR . 'includes/dev-functions/write-log.php' );

        //* Analyze Query
        include_once( EJO_DIR . 'includes/dev-functions/analyze-query.php' );
    }

    //* Add Includes
    public function includes() 
    {
        //* Allow arguments to be passed for theme-support
        add_filter( 'current_theme_supports-ejo-tinymce', 'ejo_theme_support_arguments', 10, 3 );
        add_filter( 'current_theme_supports-ejo-social-links', 'ejo_theme_support_arguments', 10, 3 );
        add_filter( 'current_theme_supports-ejo-cleanup-frontend', 'ejo_theme_support_arguments', 10, 3 );
        add_filter( 'current_theme_supports-ejo-cleanup-backend', 'ejo_theme_support_arguments', 10, 3 );

        /** 
         * Script include functionality
         */
        require_if_theme_supports( 'ejo-scripts', EJO_DIR . 'includes/add-site-scripts.php' ); // Add scripts to site head or footer
        require_if_theme_supports( 'ejo-scripts', EJO_DIR . 'includes/add-inpost-scripts.php' ); // Add script to individual post head

        /**
         * Visual Editor Styles
         */
        require_if_theme_supports( 'ejo-tinymce', EJO_DIR . 'includes/visual-editor-styles.php' );

        /**
         * Social Media Links
         */
        require_if_theme_supports( 'ejo-social-links', EJO_DIR . 'includes/social-links.php' );

        /** 
         * Cleanup service
         */
        require_if_theme_supports( 'ejo-cleanup-frontend', EJO_DIR . 'includes/cleanup-head.php' ); // Remove unnecessary head links
        require_if_theme_supports( 'ejo-cleanup-frontend', EJO_DIR . 'includes/disable-xmlrpc.php' ); // Disable XML-RPC
        require_if_theme_supports( 'ejo-cleanup-frontend', EJO_DIR . 'includes/disable-pingback.php' ); //* Disable Pingback
        require_if_theme_supports( 'ejo-cleanup-backend', EJO_DIR . 'includes/unregister-widgets.php' ); //* Widget Unregistering
    }

    public function additions()
    {        
        //* Custom filter content for post-summaries
        include_once( EJO_DIR . 'includes/post-summary.php' );

        //* Change crop switch of default image size
        include_once( EJO_DIR . 'includes/image-size-crop.php' );

        //* Shortcodes
        include_once( EJO_DIR . 'includes/shortcodes.php' );
    }

    //* Register EJOcore Options Page
    public function register_options_page()
    {
        add_theme_page('Thema Opties', 'Thema Opties', 'edit_theme_options', 'ejo-theme-options', array( $this, 'add_theme_options_page' ) );
    }

    //* Add EJOcore Options Page
    public function add_theme_options_page()
    {
        //* Include theme options page
        include_once( EJO_DIR . 'includes/theme-options-page.php' );
    }
}

//* Call EJO Core
EJO_Core::instance();