<?php

/**
 *
 */
final class EJO_Base_Module_Manager
{
    /* Store the slug of this plugin */
    const SLUG = 'module-manager';

    /* Stores the directory path for this plugin. */
    public static $dir;

    //* Menu page
    public static $menu_page = 'ejo-base-modules';

    /* Stores activated modules */
    public static $modules = array();

    /* Holds the instance of this class. */
    private static $_instance = null;

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
        //* Setup
        self::setup();

        /* Load Extensions */
        //add_action( 'plugins_loaded', array( 'EJO_Base_Module_Manager', function() {
            /* Allow arguments to be passed for theme-support */
          //  add_filter( 'current_theme_supports-ejo-base-modules', 'ejo_theme_support_arguments', 10, 3 );
//        } ), 3 );

        /* Base Module is active check */
        require_once( self::$dir . 'module-helpers.php' );

        /* Add EJObase Option page to Wordpress Option menu */
        add_action( 'admin_menu', array( 'EJO_Base_Module_Manager', 'register_ejo_base_modules_menu' ) );
    }
    
    /* Defines the directory path and URI for the plugin. */
    public static function setup() 
    {
        self::$dir = trailingslashit( dirname( __FILE__ ) );

        self::$modules = array(
            array(
                'id'           => 'blog',
                'name'         => __( 'Blog', EJO_Base::$slug ),
                'description'  => __( 'Overzichtspagina, artikelpagina en widget met laatste artikelen. Voor bloggen of nieuws.', EJO_Base::$slug ),
                'dependancies' => array(),
            ),
            array(
                'id'           => 'blog-comments',
                'name'         => __( 'Blog Comments', EJO_Base::$slug ),
                'description'  => __( 'Mogelijkheid voor bezoekers om reacties achter te laten onder uw blogartikelen', EJO_Base::$slug ),
                'dependancies' => array(
                    'ejo-base-module' => 'blog',
                ),
            ),
            array(
                'id'           => 'testimonials',
                'name'         => __( 'Testimonials', EJO_Base::$slug ),
                'description'  => __( 'Overzichtspagina met referenties en widget met laatste referenties', EJO_Base::$slug ),
                'dependancies' => array(
                    'plugin' => 'ejo-simple-testimonials',
                ),
            ),
            array(
                'id'           => 'contactads',
                'name'         => __( 'Contact Advertenties', EJO_Base::$slug ),
                'description'  => __( '', EJO_Base::$slug ),
                'dependancies' => array(),
            ),
            array(
                'id'           => 'portfolio',
                'name'         => __( 'Portfolio', EJO_Base::$slug ),
                'description'  => __( 'Overzichtspagina met projecten en widget met laatste projecten', EJO_Base::$slug ),
                'dependancies' => array(),
            ),
            array(
                'id'           => 'popup-box',
                'name'         => __( 'Popup Box', EJO_Base::$slug ),
                'description'  => __( '', EJO_Base::$slug ),
                'dependancies' => array(),
            ),
            array(
                'id'           => 'photo-gallery',
                'name'         => __( 'Photo Gallery', EJO_Base::$slug ),
                'description'  => __( '', EJO_Base::$slug ),
                'dependancies' => array(),
            ),
            array(
                'id'           => 'team',
                'name'         => __( 'Team', EJO_Base::$slug ),
                'description'  => __( '', EJO_Base::$slug ),
                'dependancies' => array(),
            ),
            array(
                'id'           => 'social-media-extra',
                'name'         => __( 'Social Media Extra', EJO_Base::$slug ),
                'description'  => __( '', EJO_Base::$slug ),
                'dependancies' => array(),
            ),
            array(
                'id'           => 'FAQ',
                'name'         => __( 'FAQ', EJO_Base::$slug ),
                'description'  => __( '', EJO_Base::$slug ),
                'dependancies' => array(),
            ),
        );

        /* Allow array-arguments to be passed for theme-support:ejo-base-modules */
        add_filter( 'current_theme_supports-ejo-base-modules', 'ejo_theme_support_arguments', 10, 3 );        
    }

        /* Register EJObase Options Menu Page */
    public static function register_ejo_base_modules_menu()
    {
        add_menu_page( __('EJO Base Modules'), __('EJO Base'), 'manage_options', self::$menu_page, array( 'EJO_Base_Module_Manager', 'add_menu_page' ) );
    }

    /* Add EJObase Options Menu Page */
    public static function add_menu_page()
    {
        /* Include theme options page */
        require_once( self::$dir . 'ejo-base-options-page.php' );
    }
}

EJO_Base_Module_Manager::init();