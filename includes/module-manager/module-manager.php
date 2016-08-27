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

        /* Allow array-arguments to be passed for theme-support:ejo-base-modules */
        add_filter( 'current_theme_supports-ejo-base-modules', 'ejo_theme_support_arguments', 10, 3 );
        
        /* Add EJObase Option page to Wordpress Option menu */
        add_action( 'admin_menu', array( 'EJO_Base_Module_Manager', 'register_menu' ) );

        //* Save Activate/Deactivate actions of options page
        add_action( 'after_setup_theme', array( 'EJO_Base_Module_Manager', 'save_module_activations' ), 98 );

        //* Hook to module activation and deactivation
        add_action( 'ejo_base_module_activation', array( 'EJO_Base_Module_Manager', 'reset_caps_on_module_activation' ) ); 
        add_action( 'ejo_base_module_deactivation', array( 'EJO_Base_Module_Manager', 'reset_caps_on_module_activation' ) );

        //* Check modules after plugin (de)activations
        add_action( 'after_setup_theme', array( 'EJO_Base_Module_Manager', 'check_modules_on_every_plugin_activation' ), 98 );

        //* Code to activate when some modules are (in)active (hook after `save_module_activations`)
        add_action( 'after_setup_theme', array( 'EJO_Base_Module_Manager', 'module_manipulations' ), 99 );
    }

    /**
     * Process the actions of the EJO Base Modules Options Page
     */
    public static function save_module_activations()
    {
        //* Perform action if set
        if ( isset($_GET['action']) && isset($_GET['module']) ) {

            $module_id = esc_attr($_GET['module']);

            if ($_GET['action'] == 'activate') {

                if ( EJO_Base_Module::activate( $module_id ) ) {
                    add_action( 'admin_notices', array( 'EJO_Base_Module_Manager', 'show_activation_message' ) );
                }
            } 

            elseif ($_GET['action'] == 'deactivate') {

                if ( EJO_Base_Module::deactivate( $module_id ) ) {
                    add_action( 'admin_notices', array( 'EJO_Base_Module_Manager', 'show_deactivation_message' ) );
                }
            }
        }
    }

    public static function show_activation_message()
    {
        $class = 'notice updated is-dismissible';
        $message = 'Module <strong>' . __('activated') . '</strong>';

        printf( '<div class="%1$s"><p>%2$s</p></div>', $class, $message ); 
    }

    public static function show_deactivation_message()
    {
        $class = 'notice updated is-dismissible';
        $message = 'Module <strong>' . __('deactivated') . '</strong>';

        printf( '<div class="%1$s"><p>%2$s</p></div>', $class, $message ); 
    }

    /* Defines the directory path and URI for the plugin. */
    public static function setup() 
    {
        self::$dir = trailingslashit( dirname( __FILE__ ) );

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
                        'type'  => 'plugin',
                        'name'  => 'EJO Simple Testimonials',
                        'class' => 'EJO_Simple_Testimonials',
                    ),
                ),
            ),
            'contactads' => array(
                'id'           => 'contactads',
                'name'         => __( 'Contact Advertenties', EJO_Base::$slug ),
                'description'  => __( '', EJO_Base::$slug ),
                'dependancies' => array(
                    array(
                        'type'  => 'plugin',
                        'name'  => 'EJO Contactadvertenties',
                        'class' => 'EJO_Contactads',
                    ),
                ),
            ),
            'portfolio' => array(
                'id'           => 'portfolio',
                'name'         => __( 'Portfolio', EJO_Base::$slug ),
                'description'  => __( 'Overzichtspagina met projecten en widget met laatste projecten', EJO_Base::$slug ),
                'dependancies' => array(
                    array(
                        'type'  => 'plugin',
                        'name'  => 'EJO Portfolio',
                        'class' => 'EJO_Portfolio',
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

    /* Register EJObase Options Menu Page */
    public static function register_menu()
    {
        add_menu_page( __('EJO Base Modules'), __('EJO Base'), 'manage_options', self::$menu_page, array( 'EJO_Base_Module_Manager', 'add_menu_page' ) );
    }

    /* Add EJObase Options Menu Page */
    public static function add_menu_page()
    {
        /* Include theme options page */
        require_once( self::$dir . 'options-page.php' );
    }

    /** 
     * Module Manipulations 
     *
     * Must be hooked after `manage_module_activations`
     * Because it needs to check if modules are active
     * And `manage_module_activations` impacts that
     */
    public static function module_manipulations()
    {
        //* Modules
        require_once( self::$dir . 'modules/blog.php' ); // Blog
        require_once( self::$dir . 'modules/blog-comments.php' ); // Blog Comments
        require_once( self::$dir . 'modules/contactads.php' ); // EJO Contactadvertenties
        require_once( self::$dir . 'modules/testimonials.php' ); // EJO Simple testimonials
        // require_once( self::$dir . 'modules/portfolio.php' ); // EJO Portfolio
        // require_once( self::$dir . 'modules/popup-box.php' ); // EJO Popup-box
        // require_once( self::$dir . 'modules/photo-gallery.php' ); // EJO Photo Gallery
        // require_once( self::$dir . 'modules/team.php' ); // EJO Team
        // require_once( self::$dir . 'modules/social-media-extra.php' ); // EJO Social Media Pack
        // require_once( self::$dir . 'modules/faq.php' ); // FAQ
    }

    /* On module activation */
    public static function reset_caps_on_module_activation( $module_id )
    {
        //* Hook to end of admin init to ensure all module manipulations and checks are done
        add_action( 'admin_init', array( 'EJO_Base_Module_Manager', 'reset_client_caps') );
    }

    /* On module activation */
    public static function check_modules_on_every_plugin_activation()
    {
        global $pagenow;

        if ($pagenow == 'plugins.php') {

            if ( isset($_GET['activate']) || isset($_GET['deactivate']) || isset($_GET['activate-multi']) || isset($_GET['deactivate-multi']) ) {
                EJO_Base_Module::check_activated_modules();
            }
        }
    }

    /* Reset the caps of the client-role */
    public static function reset_client_caps()
    {
        if ( class_exists('EJO_Client') ) {

            EJO_Client::reset_client_caps();

            /**
             * Remove double client-cap-reset
             *
             * Situation: 
             * - EJO_Client reset caps on every plugin (de)activation
             * - When a plugin is deactivated which causes a module to deactivate this class will run a EJO_Client reset cap
             * - No need to run two client cap resets
             */
            remove_action( 'admin_init', array( 'EJO_Client', 'reset_on_every_plugin_activation'), 99);
        }
    }
}

EJO_Base_Module_Manager::init();