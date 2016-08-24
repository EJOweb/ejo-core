# EJO Base for Wordpress
Framework for EJO basewebsites

# What's inside?

## Helper functions
* array_remove_value( $value, $array ) 
* array_insert_before( $key, $array, $new_key, $new_value ) 
* array_insert_after( $key, $array, $new_key, $new_value )

## Development functions
* Debugging: Easily write to debug.log using `write_log( array or string )`

## Theme Functions
* ejo_the_post_summary( optional $post_id )
* ejo_get_post_summary( optional $post_id )

## Shortcodes
* EJOweb credits in footer: [footer_ejoweb]

## Modules Management



## To Do
* Modules
  * dynamic menupage (now admin.php is hardcoded in optionspage)
* Move EJO-inline-post to separate plugin?
* Move EJO-widget-cleanup to separate plugin?
* Document theme-support
* Improve allround documentation
* Use Settings API for theme-options?
* Move theme options to customizer?
