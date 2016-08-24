<?php

/**
 *
 */
final class EJO_Base_Module_Manager
{
    /* Stores the directory path for this plugin. */
    public static $dir;

    //* Menu page
    public static $menu_page = 'ejo-base-modules';

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

        //* Set modules
        self::set_modules();
        
        /* Add EJObase Option page to Wordpress Option menu */
        add_action( 'admin_menu', array( 'EJO_Base_Module_Manager', 'register_ejo_base_modules_menu' ) );
    }
    
    /* Defines the directory path and URI for the plugin. */
    public static function setup() 
    {
        self::$dir = trailingslashit( dirname( __FILE__ ) );

        /* Allow array-arguments to be passed for theme-support:ejo-base-modules */
        add_filter( 'current_theme_supports-ejo-base-modules', 'ejo_theme_support_arguments', 10, 3 );

        /* Include class module */
        require_once( self::$dir . 'class-module.php' );
    }

    private static function set_modules()
    {
        EJO_Base::$modules = array(
            'blog' => array(
                'id'           => 'blog',
                'name'         => __( 'Blog', EJO_Base::$slug ),
                'description'  => __( 'Overzichtspagina, artikelpagina en widget met laatste artikelen. Voor bloggen of nieuws.', EJO_Base::$slug ),
                'dependancies' => array(),
            ),
            'blog-comments' => array(
                'id'           => 'blog-comments',
                'name'         => __( 'Blog Comments', EJO_Base::$slug ),
                'description'  => __( 'Mogelijkheid voor bezoekers om reacties achter te laten onder uw blogartikelen', EJO_Base::$slug ),
                'dependancies' => array(
                    array(
                        'type' => 'ejo-base-module',
                        'id'   => 'blog',
                    ),
                ),
            ),
            'testimonials' => array(
                'id'           => 'testimonials',
                'name'         => __( 'Testimonials', EJO_Base::$slug ),
                'description'  => __( 'Overzichtspagina met referenties en widget met laatste referenties', EJO_Base::$slug ),
                'dependancies' => array(
                    array(
                        'type' => 'plugin',
                        'name' => 'EJO Simple Testimonials',
                        'path' => 'ejo-simple-testimonials/ejo-simple-testimonials.php',
                    ),
                ),
            ),
            'contactads' => array(
                'id'           => 'contactads',
                'name'         => __( 'Contact Advertenties', EJO_Base::$slug ),
                'description'  => __( '', EJO_Base::$slug ),
                'dependancies' => array(
                    array(
                        'type' => 'plugin',
                        'name' => 'EJO Contactadvertenties',
                        'path' => 'ejo-contactadvertenties/ejo-contactadvertenties.php',
                    ),
                ),
            ),
            'portfolio' => array(
                'id'           => 'portfolio',
                'name'         => __( 'Portfolio', EJO_Base::$slug ),
                'description'  => __( 'Overzichtspagina met projecten en widget met laatste projecten', EJO_Base::$slug ),
                'dependancies' => array(
                    array(
                        'type' => 'plugin',
                        'name' => 'EJO Portfolio',
                        'path' => 'ejo-portfolio/ejo-portfolio.php',
                    ),
                ),
            ),
            'popup-box' => array(
                'id'           => 'popup-box',
                'name'         => __( 'Popup Box', EJO_Base::$slug ),
                'description'  => __( '', EJO_Base::$slug ),
                'dependancies' => array(),
            ),
            'photo-gallery' => array(
                'id'           => 'photo-gallery',
                'name'         => __( 'Photo Gallery', EJO_Base::$slug ),
                'description'  => __( '', EJO_Base::$slug ),
                'dependancies' => array(),
            ),
            'team' => array(
                'id'           => 'team',
                'name'         => __( 'Team', EJO_Base::$slug ),
                'description'  => __( '', EJO_Base::$slug ),
                'dependancies' => array(),
            ),
            'social-media-extra' => array(
                'id'           => 'social-media-extra',
                'name'         => __( 'Social Media Extra', EJO_Base::$slug ),
                'description'  => __( '', EJO_Base::$slug ),
                'dependancies' => array(),
            ),
            'faq' => array(
                'id'           => 'faq',
                'name'         => __( 'FAQ', EJO_Base::$slug ),
                'description'  => __( '', EJO_Base::$slug ),
                'dependancies' => array(),
            ),
        );
    }

    public static function get_modules()
    {
        return EJO_Base::$modules;
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
        require_once( self::$dir . 'options-page.php' );
    }
}

EJO_Base_Module_Manager::init();