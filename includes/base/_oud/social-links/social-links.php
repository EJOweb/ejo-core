<?php

//* 
add_shortcode( 'social_media', 'ejo_social_links_shortcode' );

//* 
add_action( 'ejo_theme_options', 'ejo_social_links_options' );

//* Add script
add_action( 'admin_enqueue_scripts', 'ejo_admin_social_script' );

//* 
function ejo_admin_social_script($hook)
{
    //* Only hook on ejo settings page
    if ( 'appearance_page_ejo-theme-options' != $hook )
        return;

    wp_enqueue_script( 'ejo-admin-social', EJO_URI . '/includes/js/admin-social-links.js', array('jquery', 'jquery-ui-sortable') );
    wp_enqueue_style( 'ejo-admin-social', EJO_URI . '/includes/css/admin-social-links.css' );
}

//* 
function ejo_social_links_options()
{
    // Save Theme options
    if (isset($_POST['submit']) ) {

        //* Update header & footer scripts
        if ( isset($_POST['ejo_social_media']) ) {

            //* Get 
            $social_links = $_POST['ejo_social_media'];

            //* Store 
            update_option( '_ejo_social_media', $social_links );
        }
    }

    //* Default social media links
    $social_links_defaults = array();

    if ( current_theme_supports( 'ejo-social-links', 'facebook' ) ) 
        $social_links_defaults['facebook'] = array( 'name' => 'Facebook', 'link' => '' );
    
    if ( current_theme_supports( 'ejo-social-links', 'twitter' ) ) 
        $social_links_defaults['twitter'] = array( 'name' => 'Twitter', 'link' => '' );

    if ( current_theme_supports( 'ejo-social-links', 'linkedin' ) ) 
        $social_links_defaults['linkedin'] = array( 'name' => 'Linkedin', 'link' => '' );
    
    if ( current_theme_supports( 'ejo-social-links', 'pinterest' ) ) 
        $social_links_defaults['pinterest'] = array( 'name' => 'Pinterest', 'link' => '' );

    if ( current_theme_supports( 'ejo-social-links', 'instagram' ) ) 
        $social_links_defaults['instagram'] = array( 'name' => 'Instagram', 'link' => '' );

    if ( current_theme_supports( 'ejo-social-links', 'googleplus' ) ) 
        $social_links_defaults['googleplus'] = array( 'name' => 'Google+', 'link' => '' );

    if ( current_theme_supports( 'ejo-social-links', 'whatsapp' ) ) 
        $social_links_defaults['whatsapp'] = array( 'name' => 'Whatsapp', 'link' => '' );

    //* Get stored social media links
    $social_links = get_option( '_ejo_social_media', array() );

    //* Add extra social links from $social_links_defaults
    $social_links = $social_links + $social_links_defaults;

    ?>

    <div class="postbox">
        <h3 class="hndle">Social Media Links</h3>

        <div class="inside">

            <table class="form-table ejo-social-links">

                <?php foreach ($social_links as $social_id => $social_media) : ?>
                    <tr>
                        <th>
                            <label class="move-item dashicons-before dashicons-sort"><?php echo $social_media['name']; ?></label>
                            <input type="hidden" name="ejo_social_media[<?php echo $social_id; ?>][name]" value="<?php echo $social_media['name']; ?>">
                        </th>
                        <td>
                            <input type="text" class="large-text" name="ejo_social_media[<?php echo $social_id; ?>][link]" value="<?php echo esc_url($social_media['link']); ?>">
                        </td>
                    </tr>
                <?php endforeach; ?>

            </table>

        </div><!-- END inside -->
    
    </div><!-- END postbox -->

        
<?php
}


function ejo_social_links_shortcode($atts)
{
    $social_media_links = get_option( '_ejo_social_media', array() );


    if (empty($social_media_links))
        return '';

    $atts = shortcode_atts( array(
        'type' => 'icon',
    ), $atts );

    $output = '<ul class="social-media">';

        foreach ($social_media_links as $social_id => $social_media) {
            
            if (empty($social_media['link']))
                continue;

            $output .= '<li>';

                switch ($atts['type']) {
                    case 'icon':
                        $text = "<i></i>";
                        break;

                    case 'text':
                        $text = $social_media['name'];
                        break;
                    
                    case 'both':
                        $text = "<i></i>{$social_media['name']}";
                        break;

                    default:
                        $text = $social_media['name'];
                        break;
                }

                //* Wrap a link around the social-profile
                $output .= sprintf(
                                '<a href="%s" class="%s" title="%s" target="_blank">%s</a>',
                                $social_media['link'],
                                $social_id,
                                $social_media['name'],
                                $text
                           );

            $output .= '</li>';
        }

    $output .= '</ul>';

    return $output;
}