<?php
/**
 * Description: 		Knowledgebase, the EJOweb way.
 * Author: 				Erik Joling
 * Author URI: 			http://www.ejoweb.nl/
 */

// Store directory path of this plugin
define( 'EJO_KNOWLEDGEBASE_PLUGIN_DIR', trailingslashit( EJO_DIR . 'extensions/knowledgebase' ) );
define( 'EJO_KNOWLEDGEBASE_PLUGIN_URL', trailingslashit( EJO_URI . 'extensions/knowledgebase' ) );

/* Load classes */
require_once( EJO_KNOWLEDGEBASE_PLUGIN_DIR . 'class-settings.php' );
require_once( EJO_KNOWLEDGEBASE_PLUGIN_DIR . 'class-widget.php' );

/* Knowledgebase */
EJO_Knowledgebase::init();

/**
 *
 */
final class EJO_Knowledgebase 
{
	/* Holds the instance of this class. */
	private static $_instance = null;

	/* Return the class instance. */
	public static function init() {
		if ( !self::$_instance )
			self::$_instance = new self;
		return self::$_instance;
	}

	/* Store post type */
	public static $post_type = 'knowledgebase_post';

	/* Post type plural name */
	public static $post_type_plural = 'knowledgebase_posts';

	/* Post type archive */
	public static $post_type_archive = 'knowledgebase';

	/* Post type category */
	public static $post_type_category = 'knowledgebase_category';

	/**
	 * Class is initiated at 'after_setup_theme' hook inside ejo-core.php
	 */
	protected function __construct() 
	{
		/* Register Post Type */
		add_action( 'init', array( $this, 'register_post_type' ) );

		/* Register Widget */
		add_action( 'widgets_init', array( $this, 'register_widget' ) );

		/* Settings */
		EJO_Knowledgebase_Settings::init();

		/* Allow arguments to be passed for theme-support */
		add_filter( 'current_theme_supports-ejo-knowledgebase', 'ejo_theme_support_arguments', 10, 3 );

		/* Rewrite knowledgebase post permalink */
		add_filter( 'post_type_link', array( $this, 'knowledgebase_permalink' ), 10, 4 );

		/* Manage columns */
		add_filter( 'manage_edit-'.self::$post_type.'_columns', array( $this, 'edit_knowledgebase_columns' ) );

		/* Manage columns */
		add_action( 'manage_'.self::$post_type.'_posts_custom_column', array( $this, 'manage_knowledgebase_columns' ), 10, 2 );
	}

	/* Register Post Type */
	public function register_post_type() 
	{
		/* Get knowledgebase settings */
		$knowledgebase_settings = get_option( 'knowledgebase_settings', array() );

		/* Archive title */
		$title = (isset($knowledgebase_settings['title'])) ? $knowledgebase_settings['title'] : self::$post_type_archive;

		/* Archive description */
		$description = (isset($knowledgebase_settings['description'])) ? $knowledgebase_settings['description'] : '';

		/* Archive slug */
		$archive_slug = (isset($knowledgebase_settings['archive-slug'])) ? $knowledgebase_settings['archive-slug'] : self::$post_type_archive;

		/* Category archive slug */
		$category_archive_slug = 'kennisbank-categorie';

		/* Register the Knowledgebase Article post type. */
		register_post_type(
			self::$post_type,
			array(
				'description'         => $description,
				'menu_position'       => 24,
				'menu_icon'           => 'dashicons-archive',
				'public'              => true,
				'has_archive'         => $archive_slug,

				/* The rewrite handles the URL structure. */
				'rewrite' => array(
					'slug'       => $archive_slug . '/%' . self::$post_type_category . '%',
					'with_front' => false,
				),

				/* What features the post type supports. */
				'supports' => array(
					'title',
					'editor',
					'excerpt',
					'author',
					'thumbnail',
					'custom-header'
				),

				/* Labels used when displaying the posts. */
				'labels' => array(
					'name'               => $title,
					'singular_name'      => __( 'Article',                    'ejo-core' ),
					'menu_name'          => __( 'Knowledgebase',              'ejo-core' ),
					'name_admin_bar'     => __( 'Knowledgebase Article',      'ejo-core' ),
					'add_new'            => __( 'Add New',                    'ejo-core' ),
					'add_new_item'       => __( 'Add New Article',            'ejo-core' ),
					'edit_item'          => __( 'Edit Article',               'ejo-core' ),
					'new_item'           => __( 'New Article',                'ejo-core' ),
					'view_item'          => __( 'View Article',               'ejo-core' ),
					'search_items'       => __( 'Search Articles',            'ejo-core' ),
					'not_found'          => __( 'No articles found',          'ejo-core' ),
					'not_found_in_trash' => __( 'No articles found in trash', 'ejo-core' ),
					'all_items'          => __( 'All Articles',               'ejo-core' ),
				)
			)
		);

		/* Register Category Taxonomy */
		register_taxonomy( 
			self::$post_type_category, 
			null,
			array( 
				'hierarchical'  => true,

				/* The rewrite handles the URL structure. */
				'rewrite' => array( 
					'slug'       => $archive_slug,
					'with_front' => false,
				),

				/* Labels used when displaying the posts. */
				'labels'        => array(
					'name'              => __( 'Knowledgebase Categories',	'ejo-core' ),
					'singular_name'     => __( 'Category', 				 	'ejo-core' ),
					'menu_name'         => __( 'Categories', 			 	'ejo-core' ),
					'search_items'      => __( 'Search Categories',      	'ejo-core' ),
					'all_items'         => __( 'All Categories',         	'ejo-core' ),
					'parent_item'       => __( 'Parent Category',        	'ejo-core' ),
					'parent_item_colon' => __( 'Parent Category:',       	'ejo-core' ),
					'edit_item'         => __( 'Edit Category',          	'ejo-core' ),
					'update_item'       => __( 'Update Category',        	'ejo-core' ),
					'add_new_item'      => __( 'Add New Category',       	'ejo-core' ),
					'new_item_name'     => __( 'New Category ',          	'ejo-core' ),
					'popular_items'     => __( 'Popular Categories',     	'ejo-core' ),
					'not_found'			=> __( 'Category not found', 	 	'ejo-core' )
				),
			)
		);

		/* Connect Taxonomy with Post type */
		register_taxonomy_for_object_type( self::$post_type_category, self::$post_type );
	}

	/**
	 * Process permalink of knowledgebase posts
	 */
	public function knowledgebase_permalink($post_link, $post, $leavename, $sample) 
	{
		/* Check if %knowledgebase_category% is in url */
	    if ( false !== strpos( $post_link, '%'.self::$post_type_category.'%' ) ) {
	        
	    	/* Get the knowledgebase category of the post */
	        $knowledgebase_category = get_the_terms( $post->ID, self::$post_type_category );

	        /* Get the slug of the first knowledgebase category or fallback to specified string */
        	$knowledgebase_category_slug = (is_array($knowledgebase_category)) ? array_pop( $knowledgebase_category )->slug : 'no-' . self::$post_type_category;

        	/* Replace the placeholder with knowledgebase-category-slug */
			$post_link = str_replace( '%'.self::$post_type_category.'%', $knowledgebase_category_slug, $post_link );
	    }
		return $post_link;
	}

	/**
	 * Edit the columns of the knowledgebase post overview (admin area)
	 */
	public function edit_knowledgebase_columns( $columns ) 
	{
		$columns = array(
			'cb' => '<input type="checkbox" />',
			'title' => __( 'Title' ),
			'author' => __( 'Author' ),
			'knowledgebase_category' => __( 'Category', 'ejo-core' ),
			'date' => __( 'Date' ),
		);

		/* If Wordpress SEO plugin is activated add wpseo-score column */
		if ( is_plugin_active( 'wordpress-seo/wp-seo.php' ) ) 
			$columns['wpseo-score'] = __( 'SEO', 'ejo-core' );

		return $columns;
	}

	/**
	 * Process the value of the custom columns in the knowledgebase post overview (admin area)
	 */
	function manage_knowledgebase_columns( $column, $post_id ) 
	{
		global $post;

		switch( $column ) {

			/* If displaying the 'knowledgebase_category' column. */
			case 'knowledgebase_category' :

				/* Get the knowledgebase_categorys for the post. */
				$terms = get_the_terms( $post_id, 'knowledgebase_category' );

				/* If terms were found. */
				if ( !empty( $terms ) ) {

					$out = array();

					/* Loop through each term, linking to the 'edit posts' page for the specific term. */
					foreach ( $terms as $term ) {
						$out[] = sprintf( '<a href="%s">%s</a>',
							esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'knowledgebase_category' => $term->slug ), 'edit.php' ) ),
							esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'knowledgebase_category', 'display' ) )
						);
					}

					/* Join the terms, separating them with a comma. */
					echo join( ', ', $out );
				}

				/* If no terms were found, output a default message. */
				else {
					_e( 'No categories', 'ejo-core' );
				}

				break;

			/* Just break out of the switch statement for everything else. */
			default :
				break;
		}
	}

	/* Register Widget */
	public function register_widget() 
	{ 
	    register_widget( 'EJO_Knowledgebase_Widget' ); 
	}
}
