<?php
if (!function_exists('ajl_enqueue_admin_styles')) {
    function ajl_enqueue_admin_styles() {
        wp_enqueue_style('ajl-admin-styles', plugin_dir_url(__FILE__) . '../assets/css/admin-styles.css');
    }
}
add_action('admin_enqueue_scripts', 'ajl_enqueue_admin_styles');
?>
