// Select taxonomy term in widget
<?php
	//* Get term_id from widget instance
    extract( wp_parse_args( $instance, array( 
        'term_id' => '',
    )));
	
 	//* Get taxonomy terms
    $terms = get_terms( array(
		'taxonomy' => 'the_taxonomy_name',
	));

	write_log( $term_id );
	write_log( $terms );
?>

<p>
	<label for="<?php echo $this->get_field_id('term_id'); ?>"><?php _e('Taxonomy Term:') ?></label>
	<select id="<?php echo $this->get_field_id('term_id'); ?>" name="<?php echo $this->get_field_name('term_id'); ?>" class="widefat">

		<?php 			

		foreach ($terms as $term) {
			echo '<option value="'.$term->term_id.'" '.selected($term_id, $term->term_id, false).'>'.$term->name.'</option>';
		}

		?>
	</select>
</p>


// Select post
<?php
	//* Get post_id from widget instance
    extract( wp_parse_args( $instance, array( 
        'post_id' => '',
    )));
	
 	//* Get posts
    $posts = get_posts( array(
		'post_type' => 'post',
		'posts_per_page' => -1,
	));

	write_log( $post_id );
	write_log( $posts );
?>

<p>
	<label for="<?php echo $this->get_field_id('post_id'); ?>"><?php _e('Post:') ?></label>
	<select id="<?php echo $this->get_field_id('post_id'); ?>" name="<?php echo $this->get_field_name('post_id'); ?>" class="widefat">

		<?php 			

		foreach ($posts as $post) {
			echo '<option value="'.$post->ID.'" '.selected($post_id, $post->ID, false).'>'.$post->post_title.'</option>';
		}

		?>
	</select>
</p>