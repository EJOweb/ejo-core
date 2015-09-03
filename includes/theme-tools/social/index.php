<?php

//* 
add_shortcode( 'social_media', 'ejo_social_media_links' );

//* 
add_action( 'ejo_options', 'ejo_social_links' );

//* Add script
add_action( 'admin_enqueue_scripts', 'ejo_admin_social_script' );

//* 
function ejo_admin_social_script($hook)
{
    if ( 'settings_page_ejo-theme-options' != $hook ) {
        return;
    }

    wp_enqueue_script( 'ejo-admin-social', plugin_dir_url( __FILE__ ) . 'admin.js', array('jquery', 'jquery-ui-sortable') );
    wp_enqueue_style( 'ejo-admin-social', plugin_dir_url( __FILE__ ) . 'admin.css' );
}

//* 
function ejo_social_links()
{
    // Save Theme options
    if (isset($_POST['submit']) ) {

        //* Update header & footer scripts
        if ( isset($_POST['ejo_social_media']) ) {

            //* Get 
            $ejo_social_media = $_POST['ejo_social_media'];

            //* Store 
            update_option( '_ejo_social_media', $ejo_social_media );
        }
    }

    $default_social = array(
        'facebook' => array( 'name' => 'Facebook', 'link' => '' ),
        'twitter' => array( 'name' => 'Twitter', 'link' => '' ),
        'pinterest' => array( 'name' => 'Pinterest', 'link' => '' ),
        'instagram' => array( 'name' => 'Instagram', 'link' => '' ),
        'google_plus' => array( 'name' => 'Google+', 'link' => '' ),
    );

    //* Get
    $ejo_social_media = get_option( '_ejo_social_media', array() );

    //* Remove redundant keys
    $ejo_social_media = array_intersect_key($ejo_social_media, $default_social);

    ?>

    <div class="postbox">
        <h3 class="hndle">Social Media Links</h3>

        <div class="inside">

            <table class="form-table ejo-social-links">

                <?php foreach ($ejo_social_media as $social_id => $social_media) : ?>
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


function ejo_social_media_links($atts)
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
                        $text = "<i class='{$social_id}'></i>";
                        break;

                    case 'text':
                        $text = $social_media['name'];
                        break;
                    
                    case 'both':
                        $text = "<i class='{$social_id}'></i>{$social_media['name']}";
                        break;

                    default:
                        $text = $social_media['name'];
                        break;
                }

                $output .= sprintf(
                                '<a href="%s" title="%s" target="_blank">%s</a>',
                                $social_media['link'],
                                $social_media['name'],
                                $text
                           );

            $output .= '</li>';
        }

    $output .= '</ul>';

    return $output;
}