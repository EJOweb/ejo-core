<?php
/**
 * Handles the custom colors feature for the theme.  This feature allows the theme or child theme author to
 * set a custom color by default.  However the user can overwrite this default color via the theme customizer
 * to a color of their choosing.
 *
 * @package    Stargazer
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2013 - 2016, Justin Tadlock
 * @link       http://themehybrid.com/themes/stargazer
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * Handles custom theme color options via the WordPress theme customizer.
 *
 * @since  1.0.0
 * @access public
 */
final class Stargazer_Custom_Colors {

	/**
	 * Holds the instance of this class.
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    object
	 */
	private static $instance;

	/**
	 * Sets up the Custom Colors Palette feature.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function __construct() {

		// Output CSS into <head>.
		add_action( 'wp_head', array( $this, 'wp_head_callback' ) );
		add_action( 'embed_head', array( $this, 'wp_head_callback' ), 25 );

		// Add a '.custom-colors' <body> class.
		add_filter( 'body_class', array( $this, 'body_class' ) );

		// Add options to the theme customizer.
		add_action( 'customize_register', array( $this, 'customize_register' ) );

		// Filter the default primary color late.
		add_filter( 'theme_mod_color_primary', array( $this, 'color_primary_default' ), 95 );

		// Delete the cached data for this feature.
		add_action( 'update_option_theme_mods_' . get_stylesheet(), array( $this, 'cache_delete' ) );
	}

	/**
	 * Returns a default primary color if there is none set.  We use this instead of setting a default
	 * so that child themes can overwrite the default early.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  string  $hex
	 * @return string
	 */
	public function color_primary_default( $hex ) {
		return $hex ? $hex : 'cc4a00';
	}

	/**
	 * Adds the 'custom-colors' class to the <body> element.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  array  $classes
	 * @return array
	 */
	public function body_class( $classes ) {

		$classes[] = 'custom-colors';

		return $classes;
	}

	/**
	 * Callback for 'wp_head' that outputs the CSS for this feature.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function wp_head_callback() {

		$stylesheet = get_stylesheet();

		// Get the cached style.
		$style = wp_cache_get( "{$stylesheet}_custom_colors" );

		// If the style is available, output it and return.
		if ( ! empty( $style ) ) {
			echo $style;
			return;
		}

		$style = $this->get_primary_styles();

		// Put the final style output together.
		$style = "\n" . '<style type="text/css" id="custom-colors-css">' . trim( $style ) . '</style>' . "\n";

		// Cache the style, so we don't have to process this on each page load.
		wp_cache_set( "{$stylesheet}_custom_colors", $style );

		// Output the custom style.
		echo $style;
	}

	/**
	 * Formats the primary styles for output.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string
	 */
	public function get_primary_styles() {

		$style = '';

		$hex = get_theme_mod( 'color_primary', '' );
		$rgb = join( ', ', hybrid_hex_to_rgb( $hex ) );

		// color
		// $style .= "
		// 		{ color: #{$hex}; } ";

		// background-color
		$style .= ".page-header
				{ background-color: #{$hex}; } ";

		// Header image
		$style .= ".header-image .overlay
				{ background-image: linear-gradient(to right, #{$hex} 0%, rgba({$rgb}, 0.9) 25%, rgba({$rgb}, 0.9) 75%, #{$hex} 100%); } ";

		// Firefox chokes on this rule and drops the rule set, so we're separating it.
		$style .= "::selection { background-color: #{$hex}; } ";

		// border-color

		// border-top-color

		// border-bottom-color

		// border-color

		// outline-color

		return str_replace( array( "\r", "\n", "\t" ), '', $style );
	}

	/**
	 * Registers the customize settings and controls.  We're tagging along on WordPress' built-in
	 * 'Colors' section.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  object $wp_customize
	 * @return void
	 */
	public function customize_register( $wp_customize ) {

		// Add a new setting for this color.
		$wp_customize->add_setting(
			'color_primary',
			array(
				'default'              => apply_filters( 'theme_mod_color_primary', '' ),
				'type'                 => 'theme_mod',
				'capability'           => 'edit_theme_options',
				'sanitize_callback'    => 'sanitize_hex_color_no_hash',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
				'transport'            => 'postMessage',
			)
		);

		// Add a control for this color.
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'custom-colors-primary',
				array(
					'label'    => esc_html__( 'Primary Color', 'stargazer' ),
					'section'  => 'colors',
					'settings' => 'color_primary',
					'priority' => 10,
				)
			)
		);
	}

	/**
	 * Deletes the cached style CSS that's output into the header.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function cache_delete() {
		wp_cache_delete( get_stylesheet() . '_custom_colors' );
	}

	/**
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {

		if ( ! self::$instance )
			self::$instance = new self;

		return self::$instance;
	}
}

Stargazer_Custom_Colors::get_instance();
