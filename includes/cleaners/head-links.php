<?php

// <link rel="alternate" type="application/rss+xml" title="Plugin Development &raquo; Home Reactiesfeed" href="http://localhost/wp_dev/home/feed/" />
// <link rel="EditURI" type="application/rsd+xml" title="RSD" href="http://localhost/wp_dev/xmlrpc.php?rsd" />
// <link rel="wlwmanifest" type="application/wlwmanifest+xml" href="http://localhost/wp_dev/wp-includes/wlwmanifest.xml" /> 
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'feed_links', 2 );
remove_action( 'wp_head', 'feed_links_extra', 3 );

// function remove_comments_rss( $for_comments ) {
//     return;
// }
// add_filter('post_comments_feed_link','remove_comments_rss');