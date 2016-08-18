<?php
if ( !current_user_can( 'manage_options' ) )  {
	wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
}
?>

<style type="text/css">
	.wrap div.error, .wrap div.updated {
	    clear: both;
	    font-weight: bold;
	}
	.bottom-buttons { clear: both; }
	.ejo-base-module.unavailable td{
		
	}
</style>

<div class="wrap">
	<h1><?php echo esc_html( get_admin_page_title() ); ?></h1> 
	
	<form action="<?php echo esc_attr( wp_unslash( $_SERVER['REQUEST_URI'] ) ); ?>" method="post">

		<?php
		$ejo_base_active_modules = get_option( 'ejo_base_active_modules', array() );

		if ( isset($_GET['action']) && isset($_GET['module']) ) {
			
			if ($_GET['action'] == 'activate') {
				
				//* Store module if it doesn't already exist
				if ( ! in_array(esc_attr($_GET['module']), $ejo_base_active_modules) ) {

					if ( ejo_base_module_is_available( esc_attr($_GET['module']) ) ) {

						$ejo_base_active_modules[] = esc_attr($_GET['module']);

						//* Store altered modules
						update_option( 'ejo_base_active_modules', $ejo_base_active_modules );
					}
				}
			}

			elseif ($_GET['action'] == 'deactivate') {

				if ( in_array(esc_attr($_GET['module']), $ejo_base_active_modules) ) {

					//* Make sure all values occur once
					$ejo_base_active_modules = array_unique($ejo_base_active_modules);

					//* Remove module from modules
					$ejo_base_active_modules = array_remove_value( esc_attr($_GET['module']), $ejo_base_active_modules );

					//* Store altered modules
					update_option( 'ejo_base_active_modules', $ejo_base_active_modules );
				}
			}
		}

		// Save Theme options
		if (isset($_POST['submit']) ) {

			//* Update ejo_base_active_modules
			if ( isset($_POST['ejo_base_active_modules']) ) {

				//* Store ejo_base_active_modules
				update_option( 'ejo_base_active_modules', $_POST['ejo_base_active_modules'] );

				echo '<div class="updated"><p>De instellingen zijn opgeslagen.</p></div>';
			}
		}
		?>

		<table class="wp-list-table widefat plugins">
			<thead>
				<tr>
					<td id="cb" class="manage-column column-cb check-column"><?php /* <label class="screen-reader-text" for="cb-select-all-1">Alles selecteren</label><input id="cb-select-all-1" type="checkbox">*/ ?></td>
					<th scope="col" id="name" class="manage-column column-name column-primary">EJO Base Module</th>
					<th scope="col" id="description" class="manage-column column-description">Beschrijving</th>	
				</tr>
			</thead>

			<tbody id="the-list">

			<?php foreach (self::$modules as $module): ?>

				<?php show_module_row($module); ?>		

			<?php endforeach ?>

			</tbody>

			<tfoot>
				<tr>
					<td class="manage-column column-cb check-column">
						<?php /* <label class="screen-reader-text" for="cb-select-all-2">Alles selecteren</label>
						<input id="cb-select-all-2" type="checkbox"> */ ?>
					</td>
					<th scope="col" class="manage-column column-name column-primary">Plugin</th><th scope="col" class="manage-column column-description">Beschrijving</th>
				</tr>
			</tfoot>

		</table>

    	<p class="bottom-buttons">
			<?php //submit_button( 'Bewaar Instellingen', 'primary', 'submit', false ); ?>
		</p>

	</form>

</div><!-- END .wrap -->
<?php

function show_module_row($module)
{
	$is_available = ejo_base_module_is_available( $module['id'] );
	$has_theme_support = ejo_base_module_has_theme_support( $module['id'] );
	$is_active = ejo_base_module_is_active( $module['id'] );

	$classes = ($has_theme_support) ? ' supported' : ' not-supported';
	$active = ($is_active) ? 'active' : 'inactive';
	$available = ($is_available) ? 'available' : 'unavailable';

	?>

	<tr class="<?php echo $active; ?> <?php echo $available; ?> ejo-base-module" data-slug="<?php echo $module['id']; ?>">
		<th scope="row" class="check-column">
			<label class="screen-reader-text" for="checkbox_<?php echo $module['id']; ?>"><?php echo $module['name']; ?> selecteren</label>
			<?php /* <input name="checked[]" value="<?php echo $module['id']; ?>" id="checkbox_<?php echo $module['id']; ?>" type="checkbox"> */ ?>
		</th>
		<td class="plugin-title column-primary">
			<strong><?php echo $module['name']; ?></strong>
			<div class="row-actions visible">
				<?php if ($is_available) : ?>
					<?php if ($is_active) : ?>
						<span class="deactivate">
							<a href="admin.php?page=<?php echo EJO_Base_Module_Manager::$menu_page; ?>&amp;action=deactivate&amp;module=<?php echo $module['id']; ?>" aria-label="<?php echo __('Deactivate') . ' ' . $module['name']; ?>"><?php _e('Deactivate'); ?></a>
						</span>
					<?php else : ?>
						<span class="activate">
							<a href="admin.php?page=<?php echo EJO_Base_Module_Manager::$menu_page; ?>&amp;action=activate&amp;module=<?php echo $module['id']; ?>" aria-label="<?php echo __('Activate') . ' ' . $module['name']; ?>"><?php _e('Activate'); ?></a>
						</span>
					<?php endif; // END active check ?>
				<?php else : ?>
					<span><?php _e('Module not available'); ?></span>
				<?php endif; // END availability check ?>

			</div>
			<button type="button" class="toggle-row">
				<span class="screen-reader-text"><?php _e('Show more details'); ?></span>
			</button>
		</td>
		<td class="column-description desc">
			<div class="plugin-description">
				<p><?php echo $module['description']; ?></p>
			</div>
			<div class="<?php echo $active; ?> second plugin-version-author-uri">
				<?php 
				echo (!$has_theme_support) ? 'Not supported by theme <br/>' : ''; 
				ejo_base_module_show_dependancies($module);
				?>
			</div>
		</td>
	</tr>
	<?php
}

function show_module_card($module)
{
	$has_theme_support = ejo_base_module_has_theme_support( $module['id'] );
	$is_active = ejo_base_module_is_active( $module['id'] );

	$classes = ($has_theme_support) ? ' supported' : ' not-supported';
	$classes .= ($is_active) ? ' active' : ' inactive';

	?>
	<div class="plugin-card <?php echo $classes; ?>">
		<div class="plugin-card-top">
			<h3><?php echo $module['name']; ?></h3>
			<p><?php echo $module['description']; ?></p>
		</div>
		<div class="plugin-card-bottom">

		<?php 
			echo (!$has_theme_support) ? 'Not supported by theme <br/>' : ''; 
			ejo_base_module_show_dependancies($module);
		?>
		</div>
	</div>
	<?php
}
