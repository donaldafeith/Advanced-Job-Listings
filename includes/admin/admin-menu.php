<?php
/**
 * Adds the main admin menu and its submenus for the Jobs plugin.
 *
 * This function creates the main 'Jobs Admin' menu in the WordPress admin area
 * and adds various submenus for different functionalities of the plugin.
 *
 * @return void
 */
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

// Hook the menu creation function to the admin_menu action
add_action('admin_menu', 'ajl_add_admin_menu');
?>