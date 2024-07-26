<?php
/**
 * Advanced Job Listing Plugin Uninstall Script
 *
 * This script runs when the plugin is uninstalled via the WordPress admin.
 * It removes all plugin-related data from the database.
 */

// If uninstall is not called from WordPress, exit
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

// Delete all job listings
function ajl_delete_all_jobs() {
    $args = array(
        'post_type'      => 'job',
        'post_status'    => 'any',
        'posts_per_page' => -1,
        'fields'         => 'ids',
    );

    $job_ids = get_posts($args);

    foreach ($job_ids as $job_id) {
        wp_delete_post($job_id, true);
    }
}

ajl_delete_all_jobs();

// Delete all job applications
function ajl_delete_all_applications() {
    $args = array(
        'post_type'      => 'application',
        'post_status'    => 'any',
        'posts_per_page' => -1,
        'fields'         => 'ids',
    );

    $application_ids = get_posts($args);

    foreach ($application_ids as $application_id) {
        wp_delete_post($application_id, true);
    }
}

ajl_delete_all_applications();

// Clean up options from the wp_options table
$options_to_delete = array(
    'ajl_job_options',
    'ajl_version',
    'ajl_db_version',
    // Add any other options your plugin might have created
);

foreach ($options_to_delete as $option) {
    delete_option($option);
}

// Remove custom database tables
global $wpdb;
$tables_to_delete = array(
    $wpdb->prefix . 'job_subscriptions',
    $wpdb->prefix . 'email_log',
    // Add any other custom tables your plugin might have created
);

foreach ($tables_to_delete as $table) {
    $wpdb->query("DROP TABLE IF EXISTS $table");
}

// Clear any cached data that may have been stored
wp_cache_flush();
