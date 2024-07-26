<?php
/*
Plugin Name: Advanced Job Listing
Description: A plugin to manage job listings and applications.
Version: 1.2A
Author: Donalda Feith
*/

// Prevent direct access to the file
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Include necessary files
 * 
 * This array contains the paths to the files required by the plugin.
 * Each file is included using a loop to ensure all necessary functionality is loaded.
 */
$files_to_include = array(
    'includes/job-post-type.php',       // File for registering custom post type 'job'
    'includes/job-metaboxes.php',       // File for adding metaboxes to the 'job' post type
    'includes/job-shortcodes.php',      // File for defining shortcodes used by the plugin
    'includes/admin-page.php',          // File for creating admin pages
    'includes/job-subscriptions.php',   // File for managing job subscriptions
    'includes/job-notifications.php',   // File for sending job notifications
    'includes/admin/manage-companies-page.php', // Ensure this file is included correctly
);

foreach ($files_to_include as $file) {
    include_once plugin_dir_path(__FILE__) . $file;
}

// Activation and Deactivation hooks
register_activation_hook(__FILE__, 'ajl_activate_plugin');
register_deactivation_hook(__FILE__, 'ajl_deactivate_plugin');

/**
 * Enqueue frontend scripts and styles
 * 
 * This function enqueues CSS and JS files required for the frontend.
 */
function ajl_enqueue_scripts() {
    wp_enqueue_style('ajl-styles', plugin_dir_url(__FILE__) . 'assets/css/styles.css', array(), '1.2A');
    wp_enqueue_script('ajl-scripts', plugin_dir_url(__FILE__) . 'assets/js/scripts.js', array('jquery'), '1.2A', true);
}
add_action('wp_enqueue_scripts', 'ajl_enqueue_scripts');

/**
 * Enqueue admin styles
 * 
 * This function enqueues CSS files required for the admin interface.
 */
function ajl_enqueue_admin_styles() {
    wp_enqueue_style('ajl-admin-styles', plugin_dir_url(__FILE__) . 'assets/css/admin-styles.css', array(), '1.2A');
}
add_action('admin_enqueue_scripts', 'ajl_enqueue_admin_styles');

/**
 * Add Admin Menu
 * 
 * This function creates the admin menu and submenu pages for the plugin.
 */
if (!function_exists('ajl_add_admin_menu')) {
    function ajl_add_admin_menu() {
        // Add the main menu page
        add_menu_page(
            'Jobs Admin Menu',       // Page title
            'Jobs Admin Menu',       // Menu title
            'manage_options',        // Capability required to access
            'ajl-jobs-admin',        // Menu slug
            'ajl_admin_page_content', // Callback function to display the page
            'dashicons-businessperson', // Icon
            6                        // Position in the menu
        );

        // Array of submenu pages
        $submenu_pages = [
            [
                'parent_slug' => 'ajl-jobs-admin',
                'page_title' => 'Add Job',
                'menu_title' => 'Add Job',
                'capability' => 'manage_options',
                'menu_slug' => 'ajl-add-job',
                'function' => 'ajl_add_job_page'
            ],
            [
                'parent_slug' => 'ajl-jobs-admin',
                'page_title' => 'View Jobs',
                'menu_title' => 'View Jobs',
                'capability' => 'manage_options',
                'menu_slug' => 'ajl-view-jobs',
                'function' => 'ajl_view_jobs_page'
            ],
            [
                'parent_slug' => 'ajl-jobs-admin',
                'page_title' => 'Manage Companies',
                'menu_title' => 'Manage Companies',
                'capability' => 'manage_options',
                'menu_slug' => 'ajl-manage-companies',
                'function' => 'ajl_manage_companies_page'
            ],
            [
                'parent_slug' => 'ajl-jobs-admin',
                'page_title' => 'View Applications',
                'menu_title' => 'View Applications',
                'capability' => 'manage_options',
                'menu_slug' => 'ajl-view-applications',
                'function' => 'ajl_view_applications_page'
            ],
            [
                'parent_slug' => 'ajl-jobs-admin',
                'page_title' => 'Add Company',
                'menu_title' => 'Add Company',
                'capability' => 'manage_options',
                'menu_slug' => 'ajl-add-company',
                'function' => 'ajl_add_company_page'
            ],
            [
                'parent_slug' => 'ajl-jobs-admin',
                'page_title' => 'Email User',
                'menu_title' => 'Email User',
                'capability' => 'manage_options',
                'menu_slug' => 'ajl-manage-communications',
                'function' => 'ajl_manage_communications_page'
            ],
            [
                'parent_slug' => 'ajl-jobs-admin',
                'page_title' => 'Manage Subscriptions',
                'menu_title' => 'Manage Subscriptions',
                'capability' => 'manage_options',
                'menu_slug' => 'ajl-manage-subscriptions',
                'function' => 'ajl_manage_subscriptions_page'
            ],
            [
                'parent_slug' => 'ajl-jobs-admin',
                'page_title' => 'Shortcode Tutorial',
                'menu_title' => 'Shortcode Tutorial',
                'capability' => 'manage_options',
                'menu_slug' => 'ajl-shortcode-tutorial',
                'function' => 'ajl_shortcode_tutorial_page'
            ]
        ];

        // Add submenu pages
        foreach ($submenu_pages as $submenu) {
            add_submenu_page(
                $submenu['parent_slug'],
                $submenu['page_title'],
                $submenu['menu_title'],
                $submenu['capability'],
                $submenu['menu_slug'],
                $submenu['function']
            );
        }
    }
}
add_action('admin_menu', 'ajl_add_admin_menu');

/**
 * Plugin activation function
 * 
 * This function is called when the plugin is activated. It registers
 * the 'job' custom post type, creates necessary database tables, and
 * flushes rewrite rules to ensure custom post types work correctly.
 */
function ajl_activate_plugin() {
    ajl_register_job_post_type();   // Register 'job' post type
    ajl_create_subscription_table(); // Create custom table for job subscriptions
    ajl_create_email_log_table();    // Create custom table for email logs
    flush_rewrite_rules();           // Flush rewrite rules
}

/**
 * Plugin deactivation function
 * 
 * This function is called when the plugin is deactivated. It deletes
 * all 'job' posts, 'application' posts, and custom database tables,
 * then flushes rewrite rules to clean up after the plugin.
 */
function ajl_deactivate_plugin() {
    ajl_delete_all_jobs();           // Delete all 'job' posts
    ajl_delete_all_applications();   // Delete all 'application' posts

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

    flush_rewrite_rules();           // Flush rewrite rules
}

/**
 * Delete all job posts on plugin deactivation
 * 
 * This function retrieves all 'job' posts and deletes them.
 */
function ajl_delete_all_jobs() {
    $args = array(
        'post_type' => 'job',
        'post_status' => 'any',
        'numberposts' => -1,
        'fields' => 'ids',
    );

    $all_jobs = get_posts($args);

    foreach ($all_jobs as $job_id) {
        wp_delete_post($job_id, true); // Force delete each 'job' post
    }
}

/**
 * Delete all application posts on plugin deactivation
 * 
 * This function retrieves all 'application' posts and deletes them.
 */
function ajl_delete_all_applications() {
    $args = array(
        'post_type' => 'application',
        'post_status' => 'any',
        'numberposts' => -1,
        'fields' => 'ids',
    );

    $all_applications = get_posts($args);

    foreach ($all_applications as $application_id) {
        wp_delete_post($application_id, true); // Force delete each 'application' post
    }
}

/**
 * Create custom table for job subscriptions
 * 
 * This function creates a custom table to store job subscriptions
 * with unique email addresses.
 */
function ajl_create_subscription_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'job_subscriptions';

    $charset_collate = $wpdb->get_charset_collate();

    // SQL statement to create the job subscriptions table
    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        email varchar(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        UNIQUE KEY email (email)
    ) $charset_collate;";

    // Include the WordPress upgrade script to handle the table creation
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

/**
 * Create custom table for email logs
 * 
 * This function creates a custom table to store email logs.
 */
function ajl_create_email_log_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'email_log';

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        sender varchar(100) NOT NULL,
        recipient text NOT NULL,
        subject text NOT NULL,
        message text NOT NULL,
        headers text DEFAULT '',
        attachments text DEFAULT '',
        sent_at datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

/**
 * Form handler for adding a company
 */
add_action('admin_post_add_company', 'ajl_handle_add_company');
function ajl_handle_add_company() {
    // Verify nonce for security
    if (!isset($_POST['_wpnonce']) || !wp_verify_nonce($_POST['_wpnonce'], 'add_company')) {
        wp_die(__('Invalid nonce specified', 'textdomain'), __('Error', 'textdomain'), array(
            'response' => 403,
        ));
    }

    // Check required fields
    if (empty($_POST['company_name']) || empty($_POST['company_description'])) {
        wp_die(__('Please fill out all required fields.', 'textdomain'), __('Error', 'textdomain'), array(
            'response' => 400,
        ));
    }

    // Sanitize input
    $company_name = sanitize_text_field($_POST['company_name']);
    $company_description = sanitize_textarea_field($_POST['company_description']);

    // Handle file upload
    $company_logo = '';
    if (!empty($_FILES['company_logo']['name'])) {
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        require_once(ABSPATH . 'wp-admin/includes/media.php');
        require_once(ABSPATH . 'wp-admin/includes/image.php');

        $uploaded = media_handle_upload('company_logo', 0);
        if (is_wp_error($uploaded)) {
            wp_die(__('Error uploading file.', 'textdomain'), __('Error', 'textdomain'), array(
                'response' => 400,
            ));
        }
        $company_logo = $uploaded;
    }

    // Create new post
    $company_id = wp_insert_post(array(
        'post_title'   => $company_name,
        'post_content' => $company_description,
        'post_status'  => 'publish',
        'post_type'    => 'company',
        'meta_input'   => array(
            'company_logo' => $company_logo,
        ),
    ));

    if (is_wp_error($company_id)) {
        wp_die(__('Error creating company.', 'textdomain'), __('Error', 'textdomain'), array(
            'response' => 400,
        ));
    }

    // Redirect on success
    wp_redirect(admin_url('admin.php?page=ajl-manage-companies&success=1'));
    exit;
}

?>
