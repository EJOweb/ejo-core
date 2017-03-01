<?php
/**
 * Class used to implement a Text Widget widget.
 */
final class EJO_Footer_Line_Widget extends WP_Widget
{
	//* Slug of this widget
    const SLUG = EJO_Footer_Line_Widget_Wrapper::SLUG;

	/**
	 * Sets up a new widget instance.
	 */
	function __construct() 
	{
		$widget_title = __('Footer Line', self::SLUG);

		$widget_info = array(
			'classname'   => 'footer-line-widget',
			'description' => __('Widget for the Footer Line Widget Area', self::SLUG),
		);

		$widget_control = array( 'width' => 400 );

		parent::__construct( self::SLUG, $widget_title, $widget_info, $widget_control );

		add_filter( 'ejo_footer_line_widget_text', 'convert_smilies',               20 );
		add_filter( 'ejo_footer_line_widget_text', 'do_shortcode',                  11 );
	}

	/**
	 * Outputs the content for the current widget instance.
	 */
	public function widget( $args, $instance ) 
	{
		//* Combine $instance data with defaults
        $instance = wp_parse_args( $instance, array( 
            'text' => '',
        ));

        //* Filter the text (smilies, shortcodes)
        $instance['text'] = apply_filters( 'ejo_footer_line_widget_text', $instance['text'] );

		//* Check if Widget Template Loader exists and try to load template
		if ( class_exists( 'EJO_Widget_Template_Loader' ) && EJO_Widget_Template_Loader::load_template( $args, $instance, $this ) ) 
			return;

		//* Allow filtered widget-output
		$filtered_output = apply_filters( 'ejo_footer_line_widget_output', '', $args, $instance, $this );

		//* Print filtered_output
		echo $filtered_output;

		//* If no filtered output show default widget 
		if ( ! $filtered_output ) {
			$this->render_default_widget($args, $instance);
		}			
	}


	/**
	 * Render default widget
	 */
	public function render_default_widget($args, $instance)
	{
		echo $args['before_widget'];

		echo $instance['text'];

		echo $args['after_widget'];
	}

	/**
	 * Outputs the widget settings form.
	 */
 	public function form( $instance ) 
 	{
		//* Combine $instance data with defaults
        $instance = wp_parse_args( $instance, array( 
            'text' => '[copyright] | [ejoweb_credits]',
        ));

        ?>

		<p>
			<label for="<?php echo $this->get_field_id('text'); ?>"><?php _e('Footer Line:') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>" value="<?php echo $instance['text']; ?>" />
		</p>

		<?php
	}

	/**
	 * Handles updating settings for the current widget instance.
	 */
	public function update( $new_instance, $old_instance ) 
	{
		/* Store old instance as defaults */
		$instance = $old_instance;

		//* Add default footer-line if empty
		if ( empty($new_instance['text']) ) {
			$new_instance['text'] = '[copyright] | [ejoweb_credits]';
		}

		//* Add [ejoweb_credits] if it doesn't occur
		elseif (strpos($new_instance['text'], '[ejoweb_credits') === false) {
			$new_instance['text'] .= ' [ejoweb_credits]';
		}

		/* Store text */
		if ( current_user_can('unfiltered_html') )
			$instance['text'] =  $new_instance['text'];
		else
			$instance['text'] = stripslashes( wp_filter_post_kses( addslashes( $new_instance['text'] ) ) ); // wp_filter_post_kses() expects slashed

		/* Return updated instance */
		return $instance;
	}
}

