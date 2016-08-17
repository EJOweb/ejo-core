<?php 

//* Add options to option page
add_action( 'ejo_base_options', 'ejo_module_handler', 1 );

//* Add options to EJO options page
function ejo_module_handler()
{
	// Save Theme options
	if (isset($_POST['submit']) ) {

		//* Update ejo_base_active_modules
		if ( isset($_POST['ejo_base_active_modules']) ) {

			//* Store ejo_base_active_modules
			update_option( 'ejo_base_active_modules', $_POST['ejo_base_active_modules'] );
		}
	}

	//* Get EJO Base Modules
	$ejo_base_active_modules = get_option( 'ejo_base_active_modules', array() );

	?>

	<div class="postbox">
		<h3 class="hndle">EJO Base Modules</h3>

		<div class="inside">
			<p>
				<label for="ejo_header_script"></label>
			</p>

			<textarea name="ejo_header_script" class="large-text" id="ejo_header_script" cols="78" rows="8"><?php echo $ejo_header_scripts; ?></textarea>

			<p><span class="description">The <code>wp_head()</code>code> hook executes immediately before the closing </head> tag in the document source.</span></p>

			<hr class="div" />

			<p>
				<label for="ejo_footer_script">Enter scripts or code you would like output to <code>wp_footer()</code>:</label>
			</p>

			<textarea name="ejo_footer_script" class="large-text" id="ejo_footer_script" cols="78" rows="8"><?php echo $ejo_footer_scripts; ?></textarea>

			<p><span class="description">The <code>wp_footer()</code>code> hook executes immediately before the closing </body> tag in the document source.</span></p>
		</div><!-- END inside -->
	
	</div><!-- END postbox -->

<?php
}
?>