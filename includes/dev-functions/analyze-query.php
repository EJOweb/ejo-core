<?php

//* Query analysis
function ejo_analyze_query()
{
	if ( WP_DEBUG ) : // Only analyze if in debugging mode ?>

		<style>
			.analyze-query {
				position: fixed; 
				bottom: 0;
				right: 0;
				z-index: 99;
				background-color: rgba(255,255,255,0.8);
				border: 1px dashed #CCC;
				padding:10px;	
			}			
		</style>
		<div class="analyze-query">
			<?php 
			//* Show number of queries and execution time 
			echo get_num_queries() . ' queries in ' . timer_stop(0) . ' seconds';

			//* Check if savequeries debug option is enabled 
			if ( defined('SAVEQUERIES') && SAVEQUERIES ) {
				global $wpdb;

				write_log($wpdb->queries);
			}
			?>
		</div>

	<?php endif; // End debug check
}

?>