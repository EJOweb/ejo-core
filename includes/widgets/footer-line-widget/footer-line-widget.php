<?php
/**
 * Name: EJO Featured Widget
 * Description: A widget to show title, image or icon, text and a button
 *
 * Author: 		EJOweb
 * Author URI: 	https://www.ejoweb.nl/
 */

/**
 *
 */
final class EJO_Footer_Line_Widget_Wrapper
{
	//* Slug of this plugin
    const SLUG = 'ejo-footer-line-widget';

    //* Stores the directory path for this plugin.
    public static $dir;

    //* Stores the directory URI for this plugin.
    public static $uri;

    //* Holds the instance of this class.
    protected static $_instance = null;

    //* Only instantiate once
    public static function init() 
    {
        if ( !self::$_instance )
            self::$_instance = new self;
        return self::$_instance;
    }

    //* No clones please!
    protected function __clone() {}

    //* Plugin setup.
    protected function __construct() 
    {
		$this->setup();

        //* Register widget
        add_action( 'widgets_init', array( $this, 'widgets_init' ) );
    }

    //* Defines the directory path and URI for the plugin.
    public function setup() 
    {
    	//* Set plugin dir and uri
        self::$dir = trailingslashit( dirname( __FILE__ ) ); // with trailing slash

        //* Dynamicly get this folder url
        self::$uri = EJO_Base::$uri . str_replace(EJO_Base::$dir, '', self::$dir);

        // Include required files
        include_once( self::$dir . 'class-widget.php' );
    }

    //* Register widgets
    public function widgets_init() 
    {
		register_widget( 'EJO_Footer_Line_Widget' );
	}
}

/* Call the wrapper class */
EJO_Footer_Line_Widget_Wrapper::init();
