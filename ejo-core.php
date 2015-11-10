<?php
/**
 * Plugin Name:         EJO Core
 * Plugin URI:          http://github.com/ejoweb/ejo-core
 * Description:         EJOweb core functionalities for theme development. Including some nifty debug tools.
 * Version:             0.7.4
 * Author:              Erik Joling
 * Author URI:          http://www.ejoweb.nl/
 * GitHub Plugin URI:   https://github.com/EJOweb/ejo-core
 * GitHub Branch:       master
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
    public static $version = '0.7.4';

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

        //* Load Theme Tools
        add_action( 'plugins_loaded', array( $this, 'add_theme_tools' ) );

        //* Add shortcodes
        add_action( 'plugins_loaded', array( $this, 'add_shortcodes' ) );

        //* Load Cleaners
        // add_action( 'plugins_loaded', array( $this, 'add_cleaners' ) );
        add_action( 'after_setup_theme', array( $this, 'add_cleaners' ), 1 );

        //* Add EJOcore Option page to Wordpress Option menu
        add_action( 'admin_menu', array( $this, 'register_options_page' ) );

        //* Hook query analyze function to footer
        add_action( 'wp_footer', 'ejo_analyze_query', 99 );
    }

    
    //* Defines the directory path and URI for the plugin.
    protected static function setup() 
    {
        //* Store directory path and url of this plugin
        self::$dir = plugin_dir_path( __FILE__ );
        self::$uri = plugin_dir_url(  __FILE__ );

        //* Store if Genesis is active
        define( 'GENESIS_ACTIVE', 'genesis' == get_option( 'template' ) );
    }

  
    //* Add development functions
    public function add_development_functions() 
    {
        //* Helper Functions
        include_once( self::$dir . 'includes/dev-functions/helper-functions.php' );

        //* Write Log
        include_once( self::$dir . 'includes/dev-functions/write-log.php' );

        //* Analyze Query
        include_once( self::$dir . 'includes/dev-functions/analyze-query.php' );

        //* Change crop switch of default image size
        include_once( self::$dir . 'includes/dev-functions/image-size-crop.php' );
    }

    //* Add Cleaner Functions
    public function add_cleaners() 
    {
        //* Clean pingback references if pingback-option is disabled
        include_once( self::$dir . 'includes/cleaners/pingback.php' );

        //* Disable XML-RPC
        include_once( self::$dir . 'includes/cleaners/disable-xmlrpc.php' );

        //* Clean <head> links
        include_once( self::$dir . 'includes/cleaners/head-links.php' );

    }    
  
    //* Add Theme Support Tools
    public function add_theme_tools() 
    {
        //* Possibility to add scripts for whole website to header or footer via options
        include_once( self::$dir . 'includes/theme-tools/add-site-scripts.php' );

        //* Possibility to add scripts for individual posts to header via post-edit
        include_once( self::$dir . 'includes/theme-tools/add-inpost-scripts.php' );

        //* Visual Editor Styles
        include_once( self::$dir . 'includes/theme-tools/visual-editor-styles.php' );

        //* Widget Unregistering
        include_once( self::$dir . 'includes/theme-tools/unregister-widgets.php' );

        //* Social Media Links
        include_once( self::$dir . 'includes/theme-tools/social/index.php' );
    }

    //* Add Shortcodes
    public function add_shortcodes() 
    {   
        //* Footer Credits
        include_once( self::$dir . 'includes/shortcodes/footer-credits.php' );

        /**
         * Don't auto-p wrap shortcodes that stand alone
         * Ensures that shortcodes are not wrapped in `<p>...</p>`.
         * See wp-includes/formatting.php
         */
        add_filter( 'widget_text', 'shortcode_unautop', 9 );
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
        include_once( self::$dir . 'includes/theme-options-page.php' );
    }
}

//* Call EJO Core
EJO_Core::instance();