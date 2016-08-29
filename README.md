# EJO Base for Wordpress
Base Framework for EJOweb basiswebsites themes

# What's inside?

## Helper functions
* array_remove_value( $value, $array ) 
* array_insert_before( $key, $array, $new_key, $new_value ) 
* array_insert_after( $key, $array, $new_key, $new_value )

### Golden Rule: Theme may depent on EJO Base being present, other plugins not

## Development functions
* Debugging: Easily write to debug.log using `write_log( array or string )`

## Theme Functions
* ejo_the_post_summary( optional $post_id )
* ejo_get_post_summary( optional $post_id )

## Shortcodes
* EJOweb credits in footer: [footer_ejoweb]

## Modules Management



## To Do
* Move Widget Template Loader to seperate plugin
* Modules
  * dynamic menupage (now admin.php is hardcoded in optionspage)
* Document theme-support
* Improve allround documentation
* Use Settings API for theme-options?
* Move theme options to customizer?
