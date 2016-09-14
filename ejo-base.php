<?php
/**
 * Plugin Name:         EJO Base
 * Plugin URI:          http://github.com/erikjoling/ejo-base
 * Description:         EJOweb base functionalities for theme development. Including some nifty debug tools.
 * Version:             1.8
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

/**
 *
 */
final class EJO_Base 
{
    /* Holds the instance of this class. */
    private static $_instance = null;

    /* Version number of this plugin */
    public static $version = '1.8';

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
        self::helpers();

        //* Load Module Management
        add_action( 'plugins_loaded', array( 'EJO_Base', 'module_management' ), 3 );

        //* Load Module Management
        add_action( 'plugins_loaded', array( 'EJO_Base', 'widget_template_loader' ), 4 );

        //* Load Module Management
        add_action( 'plugins_loaded', array( 'EJO_Base', 'custom_colors' ), 5 );

        //* Load Base
        add_action( 'plugins_loaded', array( 'EJO_Base', 'base' ), 5 );
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

        /* Useful image functions */
        require_once( self::$dir . 'includes/helpers/image-functions.php' );        

        /* Use this function to filter custom theme support with arguments */
        require_once( self::$dir . 'includes/helpers/theme-support-arguments.php' );
    }

    /* Module Manager */
    public static function module_management() 
    {
        //* Setup Module Management
        require_once( self::$dir . 'includes/module-manager/module-manager.php' );
    }

    /* Widget Template Loader */
    public static function widget_template_loader() 
    {
        //* Setup Widget Template Loader
        require_once( self::$dir . 'includes/widget-template-loader/widget-template-loader.php' );
    }

    /* Custom Colors */
    public static function custom_colors() 
    {
        //* Setup Module Management
        require_once( self::$dir . 'includes/custom-colors/custom-colors.php' );
    }

    /* Base */
    public static function base() 
    {
        /* cleanup default widgets */
        require_once( self::$dir . 'includes/base/cleanup-widgets/cleanup-widgets.php' );

        /* Admin Image Select Script */
        // require_once( self::$dir . 'includes/base/admin-image-select/admin-image-select.php' );

        /* Allow admin to add scripts to entire site */
        require_once( self::$dir . 'includes/base/add-site-scripts/add-site-scripts.php' );

        /* Allow admin to add scripts to specific posts */
        require_once( self::$dir . 'includes/base/add-post-scripts/add-post-scripts.php' ); 

        /* Improved Visual Editor */
        require_once( self::$dir . 'includes/base/tinymce-improvement/tinymce-improvement.php' ); 

        /* Change crop switch of default image size */
        require_once( self::$dir . 'includes/base/image-crop-settings/image-crop-settings.php' );

        //* Relocate page menu in admin
        require_once( self::$dir . 'includes/base/admin-menu/admin-menu.php' );

        /* Disable XMLRPC and Pingback */
        require_once( self::$dir . 'includes/base/disable-xmlrpc-and-pingback/disable-xmlrpc-and-pingback.php' );

        /* Cleanup Head */
        require_once( self::$dir . 'includes/base/cleanup-head/cleanup-head.php' ); // Remove unnecessary head links

        /* Shortcodes */
        require_once( self::$dir . 'includes/base/shortcodes/shortcodes.php' );  

        /* Footer Line Widget */
        require_once( self::$dir . 'includes/base/footer-line-widget/footer-line-widget.php');

        /* Social Media Links */
        require_once( self::$dir . 'includes/base/social-media-links/social-media-links.php');

        /* Manage Dashboard Widgets */
        require_once( self::$dir . 'includes/base/dashboard-widgets/dashboard-widgets.php');

        /* Manage WordPress SEO plugin */
        require_once( self::$dir . 'includes/base/wordpress-seo/wordpress-seo.php');

        /* Theme Functions */
        require_once( self::$dir . 'includes/base/theme-functions/post-summary.php' );  
        require_once( self::$dir . 'includes/base/theme-functions/sidebar-widget-count.php' );  
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
