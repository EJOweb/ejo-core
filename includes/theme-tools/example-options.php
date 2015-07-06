<?php 
//* Add function to EJO Core Options page
add_filter( 'ejo_core_options', 'ejo_core_add_options_example', 10, 1 );

//* Add function to EJO Core Options page
function ejo_core_add_options_example($options)
{
	$options[] = 'ejo_core_options_example';

	return $options;
}

//* Example options section on EJO Core Options page
function ejo_core_options_example() 
{
	//* Save data
	if (isset($_POST['submit']) )
		ejo_core_options_example_save();

	?><h3>example options</h3><?php
}

function ejo_core_options_example_save()
{
	// Verify where the data originated
	if ( !isset($_POST['ejo-core-options-nonce']) || !wp_verify_nonce( $_POST['ejo-core-options-nonce'], 'ejo-core-options') ) {
		echo "<div class='error'><p>No nonce in Example Options.</p></div>";
		return;
	}

	echo '<pre>'; print_r($_POST['ejo_core_widget_management']); echo '</pre>';

	$option_name = '';
	// if (!empty($_POST[''])) {
	// 	update_option( $option_name, $_POST[''] ); 
	// }

	echo "<div class='updated'><p>Example Options updated successfully.</p></div>";
}