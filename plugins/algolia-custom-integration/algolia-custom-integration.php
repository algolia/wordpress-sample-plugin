<?php

/**
 * Plugin Name:     Algolia Custom Integration
 * Description:     Add Algolia Search feature
 * Text Domain:     algolia-custom-integration
 * Version:         1.0.0
 *
 * @package         Algolia_Custom_Integration
 */

// Your code starts here.
require_once __DIR__ . '/api-client/autoload.php';
// If you're using Composer, require the Composer autoload
// require_once __DIR__ . '/vendor/autoload.php';

global $algolia;

$algolia = \Algolia\AlgoliaSearch\SearchClient::create("yourAppId", "yourAdminAPIkey");

function algolia_update_post($id, WP_Post $post, $update) {
    if (wp_is_post_revision($id) || wp_is_post_autosave($id)) {
        return $post;
    }

    global $algolia;

    $record = (array) apply_filters($post->post_type.'_to_record', $post);

    if (!isset($record['objectID'])) {
        $record['objectID'] = implode('#', [$post->post_type, $post->ID]);
    }

    $index = $algolia->initIndex(
        apply_filters('algolia_index_name', $post->post_type)
    );

    if ('trash' == $post->post_status) {
        $index->deleteObject($record['objectID']);
    } else {
        $index->saveObject($record);
    }

    return $post;
}

add_action('save_post', 'algolia_update_post', 10, 3);

if ( ! function_exists('write_log')) {
    function write_log ( $log )  {
       if ( is_array( $log ) || is_object( $log ) ) {
          error_log( print_r( $log, true ) );
       } else {
          error_log( $log );
       }
    }
 }

require_once __DIR__ . '/wp-cli.php';

