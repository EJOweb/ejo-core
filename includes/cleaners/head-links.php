<?php

remove_action( 'wp_head', 'wlwmanifest_link' ); //* Remove unnecessary Window Live Writer link


// remove_action( 'wp_head', 'feed_links', 2 );
// remove_action( 'wp_head', 'feed_links_extra', 3 );

// function remove_comments_rss( $for_comments ) {
//     return;
// }
// add_filter('post_comments_feed_link','remove_comments_rss');