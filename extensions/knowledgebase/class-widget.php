<?php

/**
 * Class used to implement a Knowledgebase widget.
 */
final class EJO_Knowledgebase_Widget extends WP_Widget
{
	/**
	 * Sets up a new widget instance.
	 */
	function __construct() 
	{
		$widget_title = __('Knowledgebase Widget', 'ejo-core');

		$widget_info = array(
			'classname'   => 'knowledgebase-widget',
			'description' => __('Korte informatie met een button', 'ejo-core'),
		);

		parent::__construct( 'knowledgebase-widget', $widget_title, $widget_info );
	}

	/**
	 * Outputs the content for the current widget instance.
	 */
	public function widget( $args, $instance ) 
	{
		$title = isset( $instance['title'] ) ? $instance['title'] : '';
		$text = isset( $instance['text'] ) ? $instance['text'] : '';
		$text = apply_filters( 'widget_text', $text, $instance, $this );

		$url = get_post_type_archive_link( EJO_Knowledgebase::$post_type );
		$link_text = isset( $instance['link-text'] ) ? $instance['link-text'] : '';
		?>

		<?php echo $args['before_widget']; ?>

		<?php echo $args['before_title']; ?><a href="<?php echo $url; ?>"><?php echo $title; ?></a><?php echo $args['after_title']; ?>

		<div class="textwidget">
			<?php echo wpautop($text); ?>
		</div>

		<?php

		/* Get knowledgebase categories */
		$categories = get_terms( 
			'knowledgebase_category',
			array(
			    'orderby' => 'name',
			    'order'   => 'ASC',
			)
		);

		?>
	    
	    <div class="knowledgebase-categories">

		    <?php foreach( $categories as $category ) : // Loop through each knowledgebase category ?>

		    	<?php

				/* Get Knowledgebase ategory url */
				$category_url = esc_url( get_term_link( $category ) );

				/* Fabricate knowledgebase category link */
			    $category_link = sprintf( '<a href="%s" alt="%s">%s</a>',
			        $category_url,
			        esc_attr( sprintf( 'View all posts in %s', $category->name ) ),
			        esc_html( $category->name )
			    );

				?>

		    	<h4 <?php hybrid_attr( 'category-title' ); ?>><a href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>" title="<?php echo esc_attr( 'Bekijk alle '. $category->name .' artikelen' ); ?>" rel="bookmark" itemprop="url"><?php echo $category->name; ?></a></h4>


			<?php endforeach; // END foreach category loop ?>

		</div>

		<?php if (!empty($link_text)) : ?>

			<a href="<?php echo $url; ?>" class="read-more"><?php echo $link_text; ?></a>

		<?php endif; // URL check ?>
	
		<?php echo $args['after_widget']; ?>

		<?php
	}

	/**
	 * Outputs the widget settings form.
	 */
 	public function form( $instance ) 
 	{
		$title = isset( $instance['title'] ) ? $instance['title'] : '';
		$text = isset( $instance['text'] ) ? $instance['text'] : '';
		$link_text = isset( $instance['link-text'] ) ? $instance['link-text'] : '';

		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('text'); ?>"><?php _e('Text:') ?></label>
			<textarea class="widefat" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo $text; ?></textarea>
			<?php //wp_editor( $text, $this->get_field_id('text'), array(	'textarea_name' => $this->get_field_name('text') ) ); ?>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('link-text'); ?>"><?php _e('Link text:') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('link-text'); ?>" name="<?php echo $this->get_field_name('link-text'); ?>" value="<?php echo $link_text; ?>" />
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

		/* Store new title */
		$instance['title'] = strip_tags( $new_instance['title'] );

		/* Store text */
		$instance['text'] = stripslashes( wp_filter_post_kses( addslashes( $new_instance['text'] ) ) ); // wp_filter_post_kses() expects slashed

		/* Store url and link-text */
		$instance['link-text'] = strip_tags( $new_instance['link-text'] );

		/* Return updated instance */
		return $instance;
	}
}