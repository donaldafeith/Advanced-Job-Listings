<?php
/**
 * Enqueues admin-specific styles for the Jobs plugin.
 *
 * This function checks if the 'ajl_enqueue_admin_styles' function doesn't already exist
 * to avoid conflicts with other plugins or themes. It then enqueues the admin-specific
 * CSS file for styling the plugin's admin pages.
 *
 * @return void
 */
if (!function_exists('ajl_enqueue_admin_styles')) {
    function ajl_enqueue_admin_styles() {
        // Enqueue the admin-specific CSS file
        wp_enqueue_style(
            'ajl-admin-styles',                           // Handle
            plugin_dir_url(__FILE__) . '../assets/css/admin-styles.css', // Source
            array(),                                      // Dependencies
            null,                                         // Version (null for no version)
            'all'                                         // Media
        );
    }
}

// Hook the function to the WordPress admin_enqueue_scripts action
add_action('admin_enqueue_scripts', 'ajl_enqueue_admin_styles');
?>