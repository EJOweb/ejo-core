<?php

/*
Add header & footer scripts to theme
*/

//* Add options to option page
add_action( 'ejo_options', 'ejo_options_scripts' );

//* Add scripts to header
add_action( 'wp_head', 'ejo_header_scripts' );

//* Add scripts to footer
add_action( 'wp_footer', 'ejo_footer_scripts' );


//* Add options to EJO options page
function ejo_options_scripts()
{
	// Save Theme options
	if (isset($_POST['submit']) ) {

		//* Update header & footer scripts
		if ( isset($_POST['ejo_header_script']) && isset($_POST['ejo_footer_script']) ) {

			//* Get header & footer scripts
			$ejo_header_scripts = $_POST['ejo_header_script'];
			$ejo_footer_scripts = $_POST['ejo_footer_script'];

			//* Store header & footer scripts
			update_option( 'ejo_header_scripts', $ejo_header_scripts );
			update_option( 'ejo_footer_scripts', $ejo_footer_scripts );
		}
	}

	//* Get header & footer scripts
	$ejo_header_scripts = stripslashes(get_option( 'ejo_header_scripts', '' ));
	$ejo_footer_scripts = stripslashes(get_option( 'ejo_footer_scripts', '' ));

	?>

	<div class="postbox">
		<h3 class="hndle">Header en Footer Scripts</h3>

		<div class="inside">
			<p>
				<label for="ejo_header_script">Enter scripts or code you would like output to <code>wp_head()</code>:</label>
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

//* Add scripts to header
function ejo_header_scripts() 
{
	echo stripslashes(get_option( 'ejo_header_scripts', '' ));
}

//* Add scripts to footer
function ejo_footer_scripts() 
{
	echo stripslashes(get_option( 'ejo_footer_scripts', '' ));
}