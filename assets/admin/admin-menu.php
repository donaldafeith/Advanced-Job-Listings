<?php
/**
 * Adds the main admin menu and its submenus for the Jobs plugin.
 * This function creates the main 'Jobs Admin' menu in the WordPress admin area
 * and adds various submenus for different functionalities of the plugin.
 */
function ajl_add_admin_menu() {
    add_menu_page(
        'Jobs Admin Menu',
        'Jobs Admin Menu',
        'manage_options',
        'ajl-jobs-admin',
        'ajl_admin_page_content',
        'dashicons-businessperson',
        6
    );

    add_submenu_page(
        'ajl-jobs-admin',
        'Add Job',
        'Add Job',
        'manage_options',
        'ajl-add-job',
        'ajl_add_job_page'
    );

    add_submenu_page(
        'ajl-jobs-admin',
        'View Jobs',
        'View Jobs',
        'manage_options',
        'ajl-view-jobs',
        'ajl_view_jobs_page'
    );

    add_submenu_page(
        'ajl-jobs-admin',
        'Manage Companies',
        'Manage Companies',
        'manage_options',
        'ajl-manage-companies',
        'ajl_manage_companies_page'
    );

    add_submenu_page(
        'ajl-jobs-admin',
        'View Applications',
        'View Applications',
        'manage_options',
        'ajl-view-applications',
        'ajl_view_applications_page'
    );

    add_submenu_page(
        'ajl-jobs-admin',
        'Add Company',
        'Add Company',
        'manage_options',
        'ajl-add-company',
        'ajl_add_company_page'
    );

    add_submenu_page(
        'ajl-jobs-admin',
        'Email User',
        'Email User',
        'manage_options',
        'ajl-manage-communications',
        'ajl_manage_communications_page'
    );

    add_submenu_page(
        'ajl-jobs-admin',
        'Manage Subscriptions',
        'Manage Subscriptions',
        'manage_options',
        'ajl-manage-subscriptions',
        'ajl_manage_subscriptions_page'
    );
        add_submenu_page(
        'ajl-jobs-admin',
        'Shortcode Tutorial',
        'Shortcode Tutorial',
        'manage_options',
        'ajl-shortcode-tutorial',
        'ajl_shortcode_tutorial_page'
    );
}

add_action('admin_menu', 'ajl_add_admin_menu');
?>
