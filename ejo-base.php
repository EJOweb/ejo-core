<?php
/**
 * Plugin Name:         EJO Base
 * Plugin URI:          http://github.com/erikjoling/ejo-base
 * Description:         EJOweb base functionalities for theme development. Including some nifty debug tools.
 * Version:             1.1
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
    public static $version = '1.1';

    /* Store the slug of this plugin */
    public static $slug = 'ejo-base';

    /* Stores the directory path for this plugin. */
    public static $dir;

    /* Stores the directory URI for this plugin. */
    public static $uri;

    /* Stores activated modules */
    public static $activated_modules = array(
        // 'blog',
        // 'blog-comments',
        'testimonials',
        'contactads',
        // 'portfolio',
        // 'social-extra',
        // 'popup-box',
        // 'photo-gallery',
        // 'team',
        // 'social-media-extra',
        // 'FAQ',
    );

    /* Only instantiate once */
    public static function init() 
    {
        if ( !self::$_instance )
            self::$_instance = new self;
        return self::$_instance;
    }

    //* No cloning
    private function __clone() { /* No clones pleasssse! */ }

    /* Plugin setup. */
    private function __construct() 
    {
        /* Setup */
        add_action( 'plugins_loaded', array( 'EJO_Base', 'setup' ), 1 );

        /* Load Translations */
        add_action( 'plugins_loaded', array( 'EJO_Base', 'load_textdomain' ), 2 );

        /* Load Helper Functions */
        add_action( 'plugins_loaded', array( 'EJO_Base', 'helpers' ), 3 );

        /* Add Theme Features */
        add_action( 'after_setup_theme', array( 'EJO_Base', 'base' ), 1 );

        /* Zou in een after_setup_theme functie kunnen */
        /* Add EJObase Option page to Wordpress Option menu */
        add_action( 'admin_menu', array( 'EJO_Base', 'register_options_page' ) );
    }

    
    /* Defines the directory path and URI for the plugin. */
    public static function setup() 
    {
        EJO_Base::$dir = plugin_dir_path( __FILE__ );
        EJO_Base::$uri = plugin_dir_url( __FILE__ );
    }

    /* Load Translations */
    public static function load_textdomain() 
    {
        /* Load the translation for the plugin */
        load_plugin_textdomain( 'ejo-base', false, 'ejo-base/languages' );
    }
  
    /* Add helper functions */
    public static function helpers() 
    {
        /* Write Log */
        require_once( EJO_Base::$dir . 'includes/helpers/write-log.php' );

        /* Useful array functions */
        require_once( EJO_Base::$dir . 'includes/helpers/array-functions.php' );

        /* Base Module is active check */
        require_once( EJO_Base::$dir . 'includes/helpers/module-is-active-check.php' );

        /* Use this function to filter custom theme support with arguments */
        require_once( EJO_Base::$dir . 'includes/helpers/theme-support-arguments.php' );

        /* Function to get all image sizes */
        require_once( EJO_Base::$dir . 'includes/helpers/get-all-image-sizes.php' );

        /* Improved summary for posts */
        require_once( EJO_Base::$dir . 'includes/helpers/post-summary.php' );
    }
  
    /* Add Included Theme Features */
    public static function base() 
    {   
        /* Allow arguments to be passed for theme-support */
        add_filter( 'current_theme_supports-ejo-base', 'ejo_theme_support_arguments', 10, 3 );

        /**
         * Debugging 
         */

        //* Debugging
        // require_once( EJO_Base::$dir . 'includes/debugging.php' );


        /**
         * Admin
         */

        /* Admin Image Select Script */
        require_once( EJO_Base::$dir . 'includes/admin/admin-image-select.php' );

        /* Relocate page menu in admin */
        require_once( EJO_Base::$dir . 'includes/admin/admin-relocate-page-menu.php' );

        /* Cleanup Backend */
        require_once( EJO_Base::$dir . 'includes/admin/cleanup-default-widgets.php' ); // Widget Unregistering

        /* Improved Visual Editor */
        require_once( EJO_Base::$dir . 'includes/admin/visual-editor-styles.php' );

        /**
         * Other
         */

        /* Change crop switch of default image size */
        require_once( EJO_Base::$dir . 'includes/image-size-crop.php' );

        /* Shortcodes */
        require_once( EJO_Base::$dir . 'includes/shortcodes.php' );        

        /* Allow admin to add scripts to entire site */
        require_once( EJO_Base::$dir . 'includes/add-site-scripts.php' );

        /* Allow admin to add scripts to specific posts */
        require_once( EJO_Base::$dir . 'includes/add-post-scripts.php' ); 

        // /* Widgets */
        // require_once( EJO_Base::$dir . 'includes/widgets.php' );

        /* Cleanup Frontend */
        require_once( EJO_Base::$dir . 'includes/cleanup-head.php' ); // Remove unnecessary head links
        require_once( EJO_Base::$dir . 'includes/disable-xmlrpc.php' ); // Disable XML-RPC
        require_once( EJO_Base::$dir . 'includes/disable-pingback.php' ); // Disable Pingback
    }

    /* Register EJObase Options Menu Page */
    public static function register_options_page()
    {
        add_menu_page( __('EJO Base Options'), __('EJO Base'), 'manage_options', 'ejo-base-options', array( 'EJO_Base', 'add_menu_page' ) );
    }

    /* Add EJObase Options Menu Page */
    public static function add_menu_page()
    {
        /* Include theme options page */
        require_once( EJO_Base::$dir . 'includes/admin/options-page.php' );
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
