<?php

class EJO_Knowledgebase_Settings 
{
	/* Holds the instance of this class. */
	private static $_instance;

	/* Plugin setup. */
	public function __construct() 
	{
		/* Add Settings Page */
		add_action( 'admin_menu', array( $this, 'add_knowledgebase_setting_menu' ) );

		/* Register Settings for Settings Page */
		add_action( 'admin_init', array( $this, 'initialize_knowledgebase_settings' ) );

		/* Save settings (before init, because post type registers on init) */
		/* I probably should be using Settings API.. */
		add_action( 'init', array( $this, 'save_knowledgebase_settings' ), 1 );

		/* Add scripts to settings page */
		add_action( 'admin_enqueue_scripts', array( $this, 'add_scripts_and_styles' ) ); 
	}

	/***********************
	 * Settings Page
	 ***********************/

	/* */
	public function add_knowledgebase_setting_menu()
	{
		add_submenu_page( 
			"edit.php?post_type=".EJO_KNOWLEDGEBASE::$post_type, 
			'Knowledgebase Instellingen', 
			'Instellingen', 
			'edit_theme_options', 
			'knowledgebase-settings', 
			array( $this, 'knowledgebase_settings_page' ) 
		);
	}

	/* Register settings */
	public function initialize_knowledgebase_settings() 
	{
		// Add option if not already available
		if( false == get_option( 'knowledgebase_settings' ) ) {  
			add_option( 'knowledgebase_settings' );
		} 
	}

	/* Save Knowledgebase settings */
	public function save_knowledgebase_settings()
	{
		if (isset($_POST['submit']) && !empty($_POST['knowledgebase-settings']) ) :

			/* Escape slug */
			$_POST['knowledgebase-settings']['archive-slug'] = sanitize_title( $_POST['knowledgebase-settings']['archive-slug'] );

			/* Strip slashes */
			$_POST['knowledgebase-settings']['description'] = stripslashes( $_POST['knowledgebase-settings']['description'] );

			/* Update settings */
			update_option( "knowledgebase_settings", $_POST['knowledgebase-settings'] ); 

		endif;
	}

	/* */
	public function knowledgebase_settings_page()
	{
	?>
		<div class='wrap' style="max-width:960px;">
			<h2>Knowledgebase Instellingen</h2>

			<?php 
			/* Let user know the settings are saved */
			if (isset($_POST['submit']) && !empty($_POST['knowledgebase-settings']) ) {

				flush_rewrite_rules(); /* Flush rewrite rules because archive slug could have changed */

				echo "<div class='updated'><p>Knowledgebase settings updated successfully.</p></div>";
			}
			?>

			<form action="<?php echo esc_attr( wp_unslash( $_SERVER['REQUEST_URI'] ) ); ?>" method="post">
				<?php wp_nonce_field('knowledgebase-settings', 'knowledgebase-settings-nonce'); ?>

				<?php self::show_knowledgebase_settings(); ?>

				<?php submit_button( 'Wijzigingen opslaan' ); ?>
				<?php // submit_button( 'Standaard Instellingen', 'secondary', 'reset' ); ?>

			</form>

		</div>
	<?php
	}


    public function show_knowledgebase_settings() 
    {	
    	/* Get post type object */
    	$knowledgebase_project_post_type = get_post_type_object( EJO_KNOWLEDGEBASE::$post_type );

    	/* Load settings */
    	$knowledgebase_settings = get_option('knowledgebase_settings', array());

		/* Archive title */
		$title = (isset($knowledgebase_settings['title'])) ? $knowledgebase_settings['title'] : $knowledgebase_project_post_type->labels->name;

		/* Archive description */
		$description = (isset($knowledgebase_settings['description'])) ? $knowledgebase_settings['description'] : $knowledgebase_project_post_type->description;

		/* Archive slug */
		$archive_slug = (isset($knowledgebase_settings['archive-slug'])) ? $knowledgebase_settings['archive-slug'] : $knowledgebase_project_post_type->has_archive;
		
    	?>
    	<table class="form-table">
			<tbody>

				<tr>					
					<th scope="row">
						<label for="knowledgebase-title">Title</label>
					</th>
					<td>
						<input
							id="knowledgebase-title"
							value="<?php echo $title; ?>"
							type="text"
							name="knowledgebase-settings[title]"
							class="text"
							style="width"
						>
						<p class="description">Wordt getoond op de archiefpagina, breadcrumbs en meta's tenzij anders aangegeven</p>
					</td>
				</tr>

				<tr>					
					<th scope="row">
						<label for="knowledgebase-description">Beschrijving</label>
					</th>
					<td>
						<textarea
							id="knowledgebase-description"
							name="knowledgebase-settings[description]"
							class="text"
						><?php echo $description; ?></textarea>
						<p class="description">De beschrijving kan getoond worden op de archiefpagina (afhankelijk van het thema)</p>
					</td>
				</tr>

				<tr>					
					<th scope="row">
						<label for="knowledgebase-slug">Archive Slug</label>
					</th>
					<td>
						<input
							id="knowledgebase-slug"
							value="<?php echo $archive_slug; ?>"
							type="text"
							name="knowledgebase-settings[archive-slug]"
							class="text"
							style="width"
						>
						<p class="description">Bepaalt de <i>slug</i> van de archiefpagina</p>
					</td>
				</tr>
				
			</tbody>
		</table>
		<?php
    }

	/* Manage admin scripts and stylesheets */
	public function add_scripts_and_styles()
	{
		/* Settings Page */
		if (isset($_GET['page']) && $_GET['page'] == 'knowledgebase-settings') :

			/* Settings page javascript */
			wp_enqueue_script( 'knowledgebase-admin-settings-page-js', EJO_KNOWLEDGEBASE_PLUGIN_URL . 'assets/js/admin-settings-page.js', array('jquery'));

			/* Settings page stylesheet */
			wp_enqueue_style( 'knowledgebase-admin-settings-page-css', EJO_KNOWLEDGEBASE_PLUGIN_URL . 'assets/css/admin-settings-page.css' );

		endif;
	}

	/* Returns the instance. */
	public static function init() 
	{
		if ( !self::$_instance )
			self::$_instance = new self;
		return self::$_instance;
	}
}