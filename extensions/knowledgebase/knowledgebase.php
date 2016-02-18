<?php
/**
 * Description: 		Knowledgebase, the EJOweb way.
 * Version: 			0.1
 * Author: 				Erik Joling
 * Author URI: 			http://www.ejoweb.nl/
 */

// Store directory path of this plugin
define( 'EJO_KNOWLEDGEBASE_PLUGIN_DIR', trailingslashit( EJO_DIR . 'extensions/knowledgebase' ) );
define( 'EJO_KNOWLEDGEBASE_PLUGIN_URL', trailingslashit( EJO_URI . 'extensions/knowledgebase' ) );

/* Load classes */
require_once( EJO_KNOWLEDGEBASE_PLUGIN_DIR . 'settings-class.php' );

/* Knowledgebase */
EJO_Knowledgebase::init();

/* Settings */
EJO_Knowledgebase_Settings::init();

/**
 *
 */
final class EJO_Knowledgebase 
{
	/* Version number of this plugin */
	public static $version = '0.1';

	/* Holds the instance of this class. */
	private static $_instance = null;

	/* Store post type */
	public static $post_type = 'knowledgebase_post';

	/* Post type plural name */
	public static $post_type_plural = 'knowledgebase_posts';

	/* Post type archive */
	public static $post_type_archive = 'knowledgebase';

	/* Post type category */
	public static $post_type_category = 'knowledgebase_category';

	/* Plugin setup. */
	protected function __construct() 
	{
		/* Add Theme Features */
        add_action( 'after_setup_theme', array( $this, 'theme_features' ) );

		/* Register Post Type */
		add_action( 'init', array( $this, 'register_knowledgebase_post_type' ) );

		//* Rewrite knowledgebase post permalink
		add_filter( 'post_type_link', array( $this, 'knowledgebase_permalink' ), 10, 4 );
	}

    /* Add Features */
    public function theme_features() 
    {	
		/* Allow arguments to be passed for theme-support */
		add_filter( 'current_theme_supports-ejo-knowledgebase', 'ejo_theme_support_arguments', 10, 3 );
	}

	/* Register Post Type */
	public function register_knowledgebase_post_type() 
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
					'singular_name'      => __( 'Article',                    'ejo-knowledgebase' ),
					'menu_name'          => __( 'Knowledgebase',              'ejo-knowledgebase' ),
					'name_admin_bar'     => __( 'Knowledgebase Article',      'ejo-knowledgebase' ),
					'add_new'            => __( 'Add New',                    'ejo-knowledgebase' ),
					'add_new_item'       => __( 'Add New Article',            'ejo-knowledgebase' ),
					'edit_item'          => __( 'Edit Article',               'ejo-knowledgebase' ),
					'new_item'           => __( 'New Article',                'ejo-knowledgebase' ),
					'view_item'          => __( 'View Article',               'ejo-knowledgebase' ),
					'search_items'       => __( 'Search Articles',            'ejo-knowledgebase' ),
					'not_found'          => __( 'No articles found',          'ejo-knowledgebase' ),
					'not_found_in_trash' => __( 'No articles found in trash', 'ejo-knowledgebase' ),
					'all_items'          => __( 'All Articles',               'ejo-knowledgebase' ),
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
					'name'              => __( 'Knowledgebase Categories',	'ejo-knowledgebase' ),
					'singular_name'     => __( 'Category', 				 	'ejo-knowledgebase' ),
					'menu_name'         => __( 'Categories', 			 	'ejo-knowledgebase' ),
					'search_items'      => __( 'Search Categories',      	'ejo-knowledgebase' ),
					'all_items'         => __( 'All Categories',         	'ejo-knowledgebase' ),
					'parent_item'       => __( 'Parent Category',        	'ejo-knowledgebase' ),
					'parent_item_colon' => __( 'Parent Category:',       	'ejo-knowledgebase' ),
					'edit_item'         => __( 'Edit Category',          	'ejo-knowledgebase' ),
					'update_item'       => __( 'Update Category',        	'ejo-knowledgebase' ),
					'add_new_item'      => __( 'Add New Category',       	'ejo-knowledgebase' ),
					'new_item_name'     => __( 'New Category ',          	'ejo-knowledgebase' ),
					'popular_items'     => __( 'Popular Categories',     	'ejo-knowledgebase' ),
					'not_found'			=> __( 'Category not found', 	 	'ejo-knowledgebase' )
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

	/* Returns the instance. */
	public static function init() 
	{
		if ( !self::$_instance )
			self::$_instance = new self;
		return self::$_instance;
	}
}
