# EJO Base for Wordpress
The base for all my WordPress websites

**Golden Rule: Themes and plugins should also work without EJO Base**

# Usage
This plugin adds, removes and changes functionality by default. 

## Post Scripts
Adds a script-metabox to every public post-type. Use the ejo_post_scripts_post_types filter to change this behaviour.

## Development functions
* Debugging: Easily write to debug.log using `write_log( array or string )`

## Shortcodes
* EJOweb credits in footer: [footer_ejoweb]


## To Do
* Move Widget Template Loader to seperate plugin
  Respons: I will ship EJO Base with all my websites so not necessary to extract Widget Template Loader. 
  Respons2: Only interesting if I want to launch it as a official plugin
* Document theme-support
* Improve allround documentation
* Use Settings API for theme-options?
* Move theme options to customizer?
