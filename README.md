# EJO Core for Wordpress
Extra functionalities and utilities for theme development. 

Use theme-support to include certain features...

## Description
Theme supports
--- ejo-site-scripts
--- ejo-post-scripts
	args: post_types
--- ejo-tinymce
	args: style_formats
--- ejo-social-links
	args: social-links
--- ejo-cleanup-frontend
	args: head, xmlrpc, pingback
--- ejo-cleanup-backend
	args: widgets

### Cleanup
* Disable XMLRPC when ping-option is disabled
* Disable pingback-traces when ping is disabled
* By default cleanup head-links

### Development functions
* Helper functions
  - Delete array-record based on value
* Easy writing to log
* Analyze number of queries
* Change crop for default image sizes

### Theme Tools
* Add scripts to whole website
* Add scripts to one page
* Default visual editor style-options
* Default unregister widgets I don't use
* Social media links

### Shortcodes
* EJOweb credits in footer
* Vsee credits in footer

## To Do
* EJO Testimonials, EJO Dynamic Sidebars, EJO Menu Marquee (?), EJO Simple Testimonials opnemen in EJO core?
* Document theme-support
* Improve allround documentation
* Use Settings API for theme-options?
* Move theme options to customizer?
