<style type="text/css">
	.wrap { max-width: 690px; }
	.wrap div.error, .wrap div.updated {
	    clear: both;
	    font-weight: bold;
	}
	.metabox-holder { clear: both; }
</style>

<div class="wrap">
	<form action="<?php echo esc_attr( wp_unslash( $_SERVER['REQUEST_URI'] ) ); ?>" method="post">

		<?php /*wp_nonce_field('testimonials-settings', 'testimonials-settings-nonce');*/ ?>
		<h2 style="float:left;">Thema instellingen</h2>

		<p class="top-buttons" style="float:right;">
			<?php submit_button( 'Bewaar Instellingen', 'primary', 'submit', false ); ?>
		</p>

		<?php if (isset($_POST['submit']) ) : ?>
			<div class='updated'><p>De instellingen zijn opgeslagen.</p></div>
		<?php endif; ?>

		<div class="metabox-holder">
        	<div class="postbox-container">

				<?php do_action('ejo_options'); // Will be deprecated ?>
				<?php do_action('ejo_theme_options'); ?>

			</div><!-- END postbox-container -->
    	</div><!-- END metabox-holder -->

    	<p class="bottom-buttons" style="text-align:right;">
			<?php submit_button( 'Bewaar Instellingen', 'primary', 'submit', false ); ?>
		</p>

	</form>

</div>
<?php		