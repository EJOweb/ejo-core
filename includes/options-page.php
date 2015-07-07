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

		<?php do_action('ejo_options'); ?>

	</form>

</div>
<?php		