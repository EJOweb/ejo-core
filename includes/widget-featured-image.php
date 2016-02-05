<?php

final class EJO_Featured_Image_Widget extends WP_Widget
{
	//* Constructor. Set the default widget options and create widget.
	function __construct() 
	{
		$widget_title = 'EJO Featured Image';

		$widget_info = array(
			'classname'   => 'featured-image-widget',
			'description' => 'Toont de uitgelichte afbeelding van de huidige pagina',
		);

		parent::__construct( 'ejo-featured-image-widget', $widget_title, $widget_info );
	}

	public function widget( $args, $instance ) 
	{
		$title = isset( $instance['title'] ) ? $instance['title'] : '';
		$image_size = isset( $instance['image-size'] ) ? $instance['image-size'] : null;

		echo $args['before_widget'];
		?>

		<?php if (has_post_thumbnail()) : // If post has thumbnail. ?>

			<?php the_post_thumbnail( $image_size ); ?>

 		<?php endif; // End Post Thumbnail check. ?>

 		<?php
		echo $args['after_widget'];
	}

 	public function form( $instance ) 
 	{
		$title = isset( $instance['title'] ) ? $instance['title'] : '';
		$selected_image_size = isset( $instance['image-size'] ) ? $instance['image-size'] : null;

		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" />
		</p>

		<?php
			/* Default Image Sizes */
			$image_sizes = array( 'thumbnail', 'medium', 'large' );

			/* Additional Image Sizes */
			global $_wp_additional_image_sizes;
			$additional_image_sizes = (!empty($_wp_additional_image_sizes)) ? array_keys($_wp_additional_image_sizes) : array();

			/* Merge all Image Sizes */
			$image_sizes = array_merge($image_sizes, $additional_image_sizes);
		?>
		<p>
			<label>Afmeting:</label>
			<select name="<?php echo $this->get_field_name('image-size'); ?>">
				<?php
				foreach ($image_sizes as $image_size) {
					$selected = selected($selected_image_size, $image_size, false);
					echo "<option value='".$image_size."' ".$selected.">".$image_size."</option>";
				}
				?>
			</select>
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) 
	{
		//* Store old instance as defaults
		$instance = $old_instance;

		//* Store new title
		$instance['title'] = strip_tags( $new_instance['title'] );

		//* Store pages
		$instance['image-size'] = $new_instance['image-size'];
		
		return $instance;
	}
}