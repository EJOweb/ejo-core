<?php
/**
 * Plugin Name:         EJO Base
 * Plugin URI:          http://github.com/erikjoling/ejo-base
 * Description:         EJOweb base functionalities for theme development. Including some nifty debug tools.
 * Version:             1.8.3
 * Author:              Erik Joling
 * Author URI:          http://www.ejoweb.nl/
 * Text Domain:         ejo-base
 * Domain Path:         /languages
 *
 * GitHub Plugin URI:   https://github.com/erikjoling/ejo-base
 * GitHub Branch:       master
 *
 * Minimum PHP version: 5.3.0
 *
 * @package   EJO Base
 * @version   0.1.0
 * @since     0.1.0
 * @author    Erik Joling <erik@ejoweb.nl>
 * @copyright Copyright (c) 2015, Erik Joling
 * @link      http://github.com/erikjoling
 */

/**c
 *
 */
final class EJO_Base 
{
    /* Holds the instance of this class. */
    private static $_instance = null;

    /* Version number of this plugin */
    public static $version = '1.8.3';

    /* Store the slug of this plugin */
    public static $slug = 'ejo-base';

    /* Stores the directory path for this plugin. */
    public static $dir;

    /* Stores the directory URI for this plugin. */
    public static $uri;

    /* Stores activated modules */
    public static $modules = array();

    /* Only instantiate once */
    public static function init() 
    {
        if ( !self::$_instance )
            self::$_instance = new self;
        return self::$_instance;
    }

    //* No cloning
    private function __clone() {}

    /* Plugin setup. */
    private function __construct() 
    {
        //* Setup common plugin stuff
        self::setup();

        //* Immediatly include helpers
        add_action( 'plugins_loaded', array( 'EJO_Base', 'helpers' ), 4 );

        //* Load Base
        add_action( 'plugins_loaded', array( 'EJO_Base', 'base' ), 5 );

        //* Load Plugin Integrations
        add_action( 'plugins_loaded', array( 'EJO_Base', 'plugin_integrations' ), 6 );
    }

    
    /* Defines the directory path and URI for the plugin. */
    public static function setup() 
    {
        self::$dir = plugin_dir_path( __FILE__ );
        self::$uri = plugin_dir_url( __FILE__ );

        /* Load the translation for the plugin */
        load_plugin_textdomain( 'ejo-base', false, 'ejo-base/languages' );
    }

    /* Add helper functions */
    public static function helpers() 
    {
        /* Write Log */
        require_once( self::$dir . 'includes/helpers/write-log.php' );

        /* Useful array functions */
        require_once( self::$dir . 'includes/helpers/array-functions.php' );

        /* Use this function to filter custom theme support with arguments */
        require_once( self::$dir . 'includes/helpers/theme-support-extended.php' );

        /* Admin image select */
        require_once( self::$dir . 'includes/helpers/admin-image-select/admin-image-select.php' );

        /* Post Summary */
        require_once( self::$dir . 'includes/helpers/post-summary.php' );  

        /* Sidebar Widget Count */
        require_once( self::$dir . 'includes/helpers/sidebar-widget-count.php' );  
    }
    
    /* Base */
    public static function base() 
    {
        //* Setup Module Management
        require_once( self::$dir . 'includes/module-manager/module-manager.php' );

        /* Cleanup Frontend (Head and XMLRPC) */
        require_once( self::$dir . 'includes/cleanup-frontend/cleanup-frontend.php' );

        /* Manage Custom Scripts (Site and individual Posts) */
        require_once( self::$dir . 'includes/custom-scripts/custom-scripts.php' );

        /* Manage Widget Stuff */
        require_once( self::$dir . 'includes/widgets/widgets.php' );

        /* Editor stuff */
        require_once( self::$dir . 'includes/editor/editor.php' ); 

        /* Mold the admin menu to my liking */
        require_once( self::$dir . 'includes/admin-menu/admin-menu.php' );

        /* Shortcodes */
        require_once( self::$dir . 'includes/shortcodes/shortcodes.php' );

        /* Social Media */
        require_once( self::$dir . 'includes/social-media/social-media.php');

        /* Manage Dashboard */
        require_once( self::$dir . 'includes/dashboard/dashboard.php');

        /* Custom Colors for theme */
        require_once( self::$dir . 'includes/custom-colors/custom-colors.php');
    }

    /* Plugin Integrations */
    public static function plugin_integrations() 
    {
        /* Manage EJO Client access */
        require_once( self::$dir . 'includes/plugins/ejo-client/ejo-client.php');    
    }

    /* Uninstall */
    private static function uninstall()
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

/* Call EJO Base */
EJO_Base::init();
