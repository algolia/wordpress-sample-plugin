<?php
function algolia_load_assets() {
    $clientPath = '/js/vendor/algoliasearch-lite.umd.js';
    $instantSearchPath = '/js/vendor/instantsearch.production.min.js';

    // Create a version number based on the last time the file was modified
    $clientVersion = date("ymd-Gis", filemtime( get_template_directory() . $clientPath));
    $instantSearchVersion = date("ymd-Gis", filemtime( get_template_directory() . $instantSearchPath));

    wp_enqueue_script('algolia-client', get_template_directory_uri() . $clientPath, array(), $clientVersion, true);
    wp_enqueue_script('algolia-instant-search', get_template_directory_uri() . $instantSearchPath, array('algolia-client'), $instantSearchVersion, true);
    wp_enqueue_style('algolia-theme', get_template_directory_uri() . '/satellite-min.css');
    $algoliaPath = '/js/algolia-search.js';
    $algoliaVersion = date("ymd-Gis", filemtime(get_template_directory() . $algoliaPath));
    wp_enqueue_script('algolia-search', get_template_directory_uri() . $algoliaPath, array('algolia-instant-search'), $algoliaVersion, true);
    
}
add_action('wp_enqueue_scripts', 'algolia_load_assets');