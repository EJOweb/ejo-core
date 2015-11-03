<?php

//* Query analysis
function ejo_analyze_query()
{
	if ( WP_DEBUG ) : // Only analyze if in debugging mode ?>

		<style>
			.analyze-query {
				position: fixed; 
				top: 0;
				right: 0;
				background-color: rgba(255,255,255,0.8);
				border: 1px dashed #CCC;
				padding:10px;	
			}			
		</style>
		<div class="analyze-query">

			<?php echo get_num_queries(); ?> queries in <?php echo timer_stop(0); ?> seconds

			<?php if ( defined(SAVEQUERIES) && SAVEQUERIES ) : // Check if savequeries debug option is enabled ?>

				<?php global $wpdb; ?>
				<?php write_log($wpdb->queries); ?>

			<?php endif; // End savequeries check ?>

		</div>

	<?php endif; // End debug check
}

?>