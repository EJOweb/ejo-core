<?php

//* Query analysis
function analyze_query()
{
	if ( WP_DEBUG === true ) {
		echo '<div class="timer">';
		echo get_num_queries() . ' queries in ' . timer_stop(0) . ' seconds';
		echo '</div>';
	}
}

?>