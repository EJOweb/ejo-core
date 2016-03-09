# EJO Core for Wordpress
Extra functionalities and utilities for theme development. 

## Included additions

### Helper functions
* array_remove_value( $value, $array ) 
* array_insert_before( $key, $array, $new_key, $new_value ) 
* array_insert_after( $key, $array, $new_key, $new_value )

### Development
* Debugging: Easily write to debug.log using `write_log( array or string )`
* Small popup which informs you of the number of queries when debugging is activated in wp-config
* Easily change crop-settings for medium and large imagesize

### Shortcodes
* EJOweb credits in footer: [footer_ejoweb]
* Vsee credits in footer [footer_vsee]

### Theme Functions
* ejo_the_post_summary( optional $post_id )
* ejo_get_post_summary( optional $post_id )

## Optional additions
Below are the functionalities theme-authors can add to their themes using `add_theme_support`

### Social Media Links
add_theme_support( 'ejo-social-links', array( 'facebook', 'twitter', 'linkedin', 'pinterest', 'instagram', 'googleplus', 'whatsapp'	) );

### Improved Visual Editor
add_theme_support( 'ejo-tinymce', array( 'button', 'button-2', 'intro' ) );

### Allow admin to add scripts to entire site
add_theme_support( 'ejo-site-scripts' );

### Allow admin to add scripts to specific posts
add_theme_support( 'ejo-post-scripts' );

### Knowledgebase
add_theme_support( 'ejo-knowledgebase' );

### Widgets
add_theme_support( 'ejo-widgets', array( 'featured-image' ) );

### Cleanup Backend
add_theme_support( 'ejo-cleanup-backend', array( 'widgets', 'wp-smush' ) );

### Cleanup Frontend
add_theme_support( 'ejo-cleanup-frontend', array( 'head', 'xmlrpc', 'pingback' ) );

### Admin Image Select
add_theme_support( 'ejo-admin-image-select' );

### Admin Client Cleanup
add_theme_support( 'ejo-admin-client-cleanup', array( 'blog', 'genesis', 'updates', 'comments', 'customizer' ) );


## To Do
* EJO Testimonials, EJO Dynamic Sidebars, EJO Menu Marquee (?), EJO Simple Testimonials opnemen in EJO core?
* Document theme-support
* Improve allround documentation
* Use Settings API for theme-options?
* Move theme options to customizer?
