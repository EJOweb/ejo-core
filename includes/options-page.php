<style type="text/css">
	.wrap { max-width: 690px; }
	.wrap div.error, .wrap div.updated {
	    clear: both;
	    font-weight: bold;
	}
</style>

<div class="wrap">
	<form action="<?php echo esc_attr( wp_unslash( $_SERVER['REQUEST_URI'] ) ); ?>" method="post">

		<?php /*wp_nonce_field('testimonials-settings', 'testimonials-settings-nonce');*/ ?>
		<h2 style="float:left;">Thema instellingen</h2>

		<p class="top-buttons" style="float:right;">
			<?php submit_button( 'Bewaar Instellingen', 'primary', 'submit', false ); ?>
		</p>

		<?php 
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

			?><div class='updated'><p>De instellingen zijn opgeslagen.</p></div><?php
			// echo "<pre>";print_r($_POST['testimonials-single-settings']);echo "</pre>";
		}

		//* Get header & footer scripts
		$ejo_header_scripts = get_option( 'ejo_header_scripts', '' );
		$ejo_footer_scripts = get_option( 'ejo_footer_scripts', '' );

		?>

		<div class="metabox-holder">
			<div class="postbox-container">

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

			</div><!-- END postbox-container -->
		</div><!-- END metabox-holder -->

	</form>

</div>
<?php		