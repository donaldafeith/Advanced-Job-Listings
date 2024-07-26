<?php
/**
 * Plugin File Inclusions
 *
 * This file is responsible for including all necessary admin and functionality files
 * for the Advanced Job Listing plugin.
 *
 * @package AdvancedJobListing
 * @since 1.0.0
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Include admin files
 */

// Enqueue admin scripts and styles
include_once plugin_dir_path(__FILE__) . 'admin/enqueue-scripts.php';

// Set up admin menu structure
include_once plugin_dir_path(__FILE__) . 'admin/admin-menu.php';

// Admin page files
$admin_pages = array(
    'admin-main-page.php'          => 'Main dashboard for the plugin',
    'view-jobs-page.php'           => 'Page to view and manage job listings',
    'manage-companies-page.php'    => 'Page to manage companies',
    'view-applications-page.php'   => 'Page to view and manage job applications',
    'manage-subscriptions-page.php'=> 'Page to manage email subscriptions',
    'add-job-page.php'             => 'Page to add new job listings',
    'add-company-page.php'         => 'Page to add new companies',
    'manage-communications-page.php'=> 'Page to manage communications with applicants',
    'shortcodes-tutorial.php'      => 'Tutorial page for using plugin shortcodes',
);

foreach ($admin_pages as $file => $description) {
    $full_path = plugin_dir_path(__FILE__) . 'admin/' . $file;
    if (file_exists($full_path)) {
        include_once $full_path;
    } else {
        error_log("Advanced Job Listing: Admin file not found: $file - $description");
    }
}

// Include admin post action handlers
include_once plugin_dir_path(__FILE__) . 'admin/admin-post-actions.php';

/**
 * Include front-end functionality
 */

// Shortcodes for displaying jobs, application forms, etc.
include_once plugin_dir_path(__FILE__) . '../includes/job-shortcodes.php';

?>
