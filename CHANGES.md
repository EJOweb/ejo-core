- Added social-media-links functionality

1.5
- Added [client_copyright] shortcode
- Updated [ejoweb_credits] shortcode
- Added Footer Line Widget
- Added helper function ejo_get_image_dimensions
- Fixed secondary custom color bug

1.4
- Added Custom Colors functionality

1.3.3
- Fixed bug in Module Manager

1.3.2
- Decommented contactads from ejo-base (unique extension)
- Added good example for custom-colors
- Added theme functions: post-summary and sidebar-widget-count

1.3.1
- Removed unwanted helpers
- Small fix for widget-template-loader

1.3
- Relocated EJO_Widget_Template_Loader and slightly improved it
- Improved handling with plugin (deactivations)
- Improved integration with EJO_Client plugin
- Improved module manipulations on activation/deactivation of modules
- Added function `is_inactive` (module)
- Replaced occurences of `is_plugin_active` by `class_exists`
- Added specific module actions (hide widgets while blog not active)
- Added activation and deactivation hook for modules
- Restructured files and folders
- Start of module manager functions
- Restructured site-scripts and moved to appearance menu
- Added [author] shortcode
- Added EJO_Widget_Template_Loader so themes can have their own widget-templates
- Small improvement on code structuring

1.2
- Improved admin image select organization
- Fixed tinyMCE styleselect
- Added snippets

1.1
- Rename to EJO Base
- Code restructuring
- Made a start for enabling/disabling modules
- Removed all theme support checks. Included most functionalities by default, removed others
- Improved widget-cleanup

1.0.1
- Fixed bug/notice when posts menu is hidden

1.0 
- Fork from EJO core
- Removed knowledgebase. It's in a seperate plugin now
- Removed client cleanup. It's in a seperate plugin now

0.9.10
- Added functionality to remove category base when using `front` in permalink-structure
- Minor update to knowledgebase rewrite-rule

0.9.9
- Changed shortcode EJOweb link to https-protocol
- Updated WP smushit Cleanup to support 2.2

0.9.8
- Removed ejo-base's tinymce styleformats. This is theme domain  
  * add_theme_support( 'ejo-tinymce' ) no longer supports array of styles
  * include function to simply add tinymce style-formats by default

0.9.7
- Admin Client Cleanup improvements

0.9.6
- Admin Client Cleanup improvements
- Admin Client Cleanup dashboard widgets removal

0.9.5
- Admin Client Cleanup theme feature
- Relocate admin pages menu just before posts menu

0.9.4 Master merge
- Improved Readme
- Improved Code organization
- Removed references to Genesis, because theme-authors can choose to include features using add_theme_support
- Added get_all_image_sizes() helper function

theme-support branch
0.9.3
- Hide WP Smush upgrade notices

0.9.2
- Added Image Select Script for admin
- improved knowledgebase widget

0.9.1
- Bugfix @ knowledgebase_category pagination

0.9
- Knowledgebase translations
- Knowledgebase ready for live

0.8.8
- Knowledgebase extension

0.8.7
- Added array_insert_before and array_insert_after function
- Rename remove_array_value function to array_remove_value

0.8.6
- check if theme-support-arguments functionality already exists
- featured image widget nog shown on archives
- changed undersbases in couple of filenames to hyphens

0.8.5
- Added foundation for adding widgets using theme-support
- Added Featured Image Widget

theme-support branch
- added theme-support for
--- ejo-site-scripts
--- ejo-post-scripts
--- ejo-tinymce
--- ejo-social-links
--- ejo-cleanup-frontend
--- ejo-cleanup-backend
- social-links array-key 'googleplus' instead of 'google-plus'
- improved option for cropping 'medium' and 'large' image size

0.8
- Helper function ejo_get_post_summary($post) to easier get excerpt with content fallback
- Added Whatsapp to social-media options

0.7.6
-  Added current year shortcode [year] and changed filename of footer-shortcodes to footer.php

0.7.5
- Fixed wrong use of defined() in ejo_analyze_query

0.7.4
- Style fix for ejo_analyze_query

0.7.3
- Hooked ejo_analyze_query to wp_footer
- Minor changes ejo_analyze_query function

0.7.2
- Removed redundant bit of test code
- Added todo idea
- Improved ejo_analyze_query function
- Reverted changelog order

0.7.1
- Renamed function and renamed filter (and warned for deprecation old filter name)

0.7
- Removed paragraph wrap from shortcodes in text-widgets (black studio tinymnce widget)
- Moved social media classname to parent link instead of <i>

0.6.1
- Better code organization of head cleaner
- Removed unnecessary hybrid theme version in head

0.6
- Better disabling of XML-RPC.
- Remove pingback references when it is disabled
- Remove WLW (Windows live writer) manifest link in head

0.5.4
- Also remove pingback link for Genesis

0.5.3
- Added cleaner functions section
- Attempt to remove XML-RPC by default
- Remove unwanted <head> links

0.5.2
- Relocated EJO Theme Options to Appearance menu and renamed ejo_options hook to ejo_theme_options

0.5.1
- Fixed social media google-plus name

0.5
- Check for Genesis when adding scripts options to site and posts
- Fixed bug in Social Links Tool

0.4.5
Added filter to easily add classes to the styles-dropdown visual editor

0.4.4 
Support for Social Media links

0.4.2 op 9-7-2015
Fixed slashes bug in add-inpost-scripts

0.4.1 op 8-7-2015
Fixed slashes bug in add-site-scripts

0.4.0 op 7-7-2015
Added inpost scripts functionality
Action to hook into options page

0.3.2 - 6-7-2015
Re-added theme-tools 'unregister widget' and 'visual-editor-styles'

0.3.1 - 6-7-2015
Add option to add text to footer_vsee shortcode
