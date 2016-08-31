<?php
/**
 * EJO Custom Colors
 *
 * Inspired by the Stargazer theme (Justin Tadlock)
 */

/**
 * Handles custom theme color options via the WordPress theme customizer.
 *
 * @since  1.0.0
 * @access public
 */
final class EJO_Custom_Colors {

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

		// Filter the defaults color late.
		add_filter( 'theme_mod_color_primary', array( $this, 'color_primary_default' ), 95 );
		add_filter( 'theme_mod_color_primary', array( $this, 'color_secondary_default' ), 95 );

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

	public function color_secondary_default( $hex ) {
		return $hex ? $hex : '000000';
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

		$primary_color = get_theme_mod( 'color_primary' );
		$secondary_color = get_theme_mod( 'color_secondary' );

		if ( $primary_color ) {

			//* Get primary color contrast
			$primary_color_contrast = $this->get_perceived_lightness( $primary_color );

			$classes[] = 'primary-color-' . $primary_color_contrast;
		}

		if ( $secondary_color ) {

			//* Get secondary color contrast
			$secondary_color_contrast = $this->get_perceived_lightness( $secondary_color );

			$classes[] = 'secondary-color-' . $secondary_color_contrast;
		}


		// write_log( $classes );

		// write_log( '---------------------' );
		// write_log( 'Contrast voor ' . $primary_color . ': ' . $primary_color_contrast );

		// write_log( 'Contrast voor 000000: ' . $this->get_perceived_lightness( '000000' ) );
		// write_log( 'Contrast voor ffffff: ' . $this->get_perceived_lightness( 'ffffff' ) );
		// write_log( 'Contrast voor 777777: ' . $this->get_perceived_lightness( '777777' ) );
		// write_log( 'Contrast voor f2912d: ' . $this->get_perceived_lightness( 'f2912d' ) );
		// write_log( 'Contrast voor a9c857: ' . $this->get_perceived_lightness( 'a9c857' ) );

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

		// Get the cached style.
		$style = wp_cache_get( "ejo_base_custom_colors" );

		// If the style is available, output it and return.
		if ( ! empty( $style ) ) {
			echo $style;
			return;
		}

		$style = $this->get_primary_styles();

		//* Don't output empty
		if (!empty($style)) {

			// Put the final style output together.
			$style = "\n" . '<style type="text/css" id="custom-colors-css">' . trim( $style ) . '</style>' . "\n";
		}

		// Cache the style, so we don't have to process this on each page load.
		wp_cache_set( "ejo_base_custom_colors", $style );

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

		$hex1 = get_theme_mod( 'color_primary', '' );
		$rgb1 = join( ', ', hybrid_hex_to_rgb( $hex1 ) );

		$hex2 = get_theme_mod( 'color_secondary', '' );
		$rgb2 = join( ', ', hybrid_hex_to_rgb( $hex2 ) );

		// color
		// $style .= "
		// 		{ color: #{$hex}; } ";

		$style = apply_filters( 'ejo_custom_color_style', '', $hex1, $rgb1, $hex2, $rgb2 );

		// // background-color
		// $style .= ".page-header
		// 		{ background-color: #{$hex}; } ";

		// // Header image
		// $style .= ".header-image .overlay
		// 		{ background-image: linear-gradient(to right, #{$hex} 0%, rgba({$rgb}, 0.9) 25%, rgba({$rgb}, 0.9) 75%, #{$hex} 100%); } ";

		// // Firefox chokes on this rule and drops the rule set, so we're separating it.
		// $style .= "::selection { background-color: #{$hex}; } ";

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
					'label'    => esc_html__( 'Primary Color', EJO_Base::$slug ),
					'section'  => 'colors',
					'settings' => 'color_primary',
					'priority' => 10,
				)
			)
		);

		// Add a new setting for this color.
		$wp_customize->add_setting(
			'color_secondary',
			array(
				'default'              => apply_filters( 'theme_mod_color_secondary', '' ),
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
				'custom-colors-secondary',
				array(
					'label'    => esc_html__( 'Secondary Color', EJO_Base::$slug ),
					'section'  => 'colors',
					'settings' => 'color_secondary',
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
		wp_cache_delete( 'ejo_base_custom_colors' );
	}

	/** 
	 * Get perceived (YIQ) dark or light
	 * https://24ways.org/2010/calculating-color-contrast/
	 * https://en.wikipedia.org/wiki/YIQ
	 */
	public function get_perceived_lightness( $hexcolor ) {

		$r = hexdec(substr($hexcolor,0,2));
		$g = hexdec(substr($hexcolor,2,2));
		$b = hexdec(substr($hexcolor,4,2));

		// $yiq = (($r*299)+($g*587)+($b*114))/1000;

		$yiq = (($r * 299) +
				($g * 587) +
				($b * 114)) / 1000;

		// return ($yiq >= 128) ? 'light' : 'dark';
		return ($yiq >= 180) ? 'light' : 'dark';
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

EJO_Custom_Colors::get_instance();
