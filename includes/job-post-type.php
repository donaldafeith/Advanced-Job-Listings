<?php

/**
 * Registers the 'job' custom post type.
 */
function ajl_register_job_post_type() {
    $labels = array(
        'name' => 'Jobs',
        'singular_name' => 'Job',
        'menu_name' => 'Jobs',
        'name_admin_bar' => 'Job',
        'add_new' => 'Add New',
        'add_new_item' => 'Add New Job',
        'new_item' => 'New Job',
        'edit_item' => 'Edit Job',
        'view_item' => 'View Job',
        'all_items' => 'All Jobs',
        'search_items' => 'Search Jobs',
        'parent_item_colon' => 'Parent Jobs:',
        'not_found' => 'No jobs found.',
        'not_found_in_trash' => 'No jobs found in Trash.',
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'custom-fields'),
        'show_in_rest' => true,
    );

    register_post_type('job', $args);
}

add_action('init', 'ajl_register_job_post_type');

/**
 * Registers the 'company' custom post type.
 */
function ajl_register_company_post_type() {
    $labels = array(
        'name' => 'Companies',
        'singular_name' => 'Company',
        'menu_name' => 'Companies',
        'name_admin_bar' => 'Company',
        'add_new' => 'Add New',
        'add_new_item' => 'Add New Company',
        'new_item' => 'New Company',
        'edit_item' => 'Edit Company',
        'view_item' => 'View Company',
        'all_items' => 'All Companies',
        'search_items' => 'Search Companies',
        'parent_item_colon' => 'Parent Companies:',
        'not_found' => 'No companies found.',
        'not_found_in_trash' => 'No companies found in Trash.',
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail'),
        'show_in_rest' => true,
    );

    register_post_type('company', $args);
}

add_action('init', 'ajl_register_company_post_type');


/**
 * Registers all custom post types for the plugin.
 */
function ajl_register_custom_post_types() {
    // Register Job Post Type
    $job_labels = array(
        'name' => 'Jobs',
        'singular_name' => 'Job',
        'menu_name' => 'Jobs',
        'name_admin_bar' => 'Job',
        'add_new' => 'Add New',
        'add_new_item' => 'Add New Job',
        'new_item' => 'New Job',
        'edit_item' => 'Edit Job',
        'view_item' => 'View Job',
        'all_items' => 'All Jobs',
        'search_items' => 'Search Jobs',
        'parent_item_colon' => 'Parent Jobs:',
        'not_found' => 'No jobs found.',
        'not_found_in_trash' => 'No jobs found in Trash.',
    );

    $job_args = array(
        'labels' => $job_labels,
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'custom-fields'),
        'show_ui' => true,
        'show_in_menu' => false, // Do not show in menu
        'show_in_rest' => true,
    );

    register_post_type('job', $job_args);

    // Register Company Post Type
    $company_labels = array(
        'name' => 'Companies',
        'singular_name' => 'Company',
        'menu_name' => 'Companies',
        'name_admin_bar' => 'Company',
        'add_new' => 'Add New',
        'add_new_item' => 'Add New Company',
        'new_item' => 'New Company',
        'edit_item' => 'Edit Company',
        'view_item' => 'View Company',
        'all_items' => 'All Companies',
        'search_items' => 'Search Companies',
        'parent_item_colon' => 'Parent Companies:',
        'not_found' => 'No companies found.',
        'not_found_in_trash' => 'No companies found in Trash.',
    );

    $company_args = array(
        'labels' => $company_labels,
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail'),
        'show_ui' => true,
        'show_in_menu' => false, // Do not show in menu
        'show_in_rest' => true,
    );

    register_post_type('company', $company_args);

    // Register Application Post Type
    $application_labels = array(
        'name' => 'Applications',
        'singular_name' => 'Application',
        'menu_name' => 'Applications',
        'name_admin_bar' => 'Application',
        'add_new' => 'Add New',
        'add_new_item' => 'Add New Application',
        'new_item' => 'New Application',
        'edit_item' => 'Edit Application',
        'view_item' => 'View Application',
        'all_items' => 'All Applications',
        'search_items' => 'Search Applications',
        'parent_item_colon' => 'Parent Applications:',
        'not_found' => 'No applications found.',
        'not_found_in_trash' => 'No applications found in Trash.',
    );

    $application_args = array(
        'labels' => $application_labels,
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'custom-fields'),
        'show_ui' => false,
        'show_in_menu' => false, // Do not show in menu
        'show_in_rest' => true,
    );

    register_post_type('application', $application_args);

    // Register Resume Post Type
    $resume_labels = array(
        'name' => 'Resumes',
        'singular_name' => 'Resume',
        'menu_name' => 'Resumes',
        'name_admin_bar' => 'Resume',
        'add_new' => 'Add New',
        'add_new_item' => 'Add New Resume',
        'new_item' => 'New Resume',
        'edit_item' => 'Edit Resume',
        'view_item' => 'View Resume',
        'all_items' => 'All Resumes',
        'search_items' => 'Search Resumes',
        'parent_item_colon' => 'Parent Resumes:',
        'not_found' => 'No resumes found.',
        'not_found_in_trash' => 'No resumes found in Trash.',
    );

    $resume_args = array(
        'labels' => $resume_labels,
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'custom-fields'),
        'show_ui' => true,
        'show_in_menu' => false, // Do not show in menu
        'show_in_rest' => true,
    );

    register_post_type('resume', $resume_args);

    // Register Communication Post Type
    $communication_labels = array(
        'name' => 'Communications',
        'singular_name' => 'Communication',
        'menu_name' => 'Communications',
        'name_admin_bar' => 'Communication',
        'add_new' => 'Add New',
        'add_new_item' => 'Add New Communication',
        'new_item' => 'New Communication',
        'edit_item' => 'Edit Communication',
        'view_item' => 'View Communication',
        'all_items' => 'All Communications',
        'search_items' => 'Search Communications',
        'parent_item_colon' => 'Parent Communications:',
        'not_found' => 'No communications found.',
        'not_found_in_trash' => 'No communications found in Trash.',
    );

    $communication_args = array(
        'labels' => $communication_labels,
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'custom-fields'),
        'show_ui' => false,
        'show_in_menu' => false, // Do not show in menu
        'show_in_rest' => false,
    );

    register_post_type('communication', $communication_args);

    // Register Message Post Type
    $message_labels = array(
        'name' => 'Messages',
        'singular_name' => 'Message',
        'menu_name' => 'Messages',
        'name_admin_bar' => 'Message',
        'add_new' => 'Add New',
        'add_new_item' => 'Add New Message',
        'new_item' => 'New Message',
        'edit_item' => 'Edit Message',
        'view_item' => 'View Message',
        'all_items' => 'All Messages',
        'search_items' => 'Search Messages',
        'parent_item_colon' => 'Parent Messages:',
        'not_found' => 'No messages found.',
        'not_found_in_trash' => 'No messages found in Trash.',
    );

    $message_args = array(
        'labels' => $message_labels,
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'custom-fields'),
        'show_ui' => true,
        'show_in_menu' => false, // Do not show in menu
        'show_in_rest' => true,
    );

    register_post_type('message', $message_args);
}

add_action('init', 'ajl_register_custom_post_types');

/**
 * Registers the 'communication' custom post type.
 */
function ajl_register_communication_post_type() {
    $labels = array(
        'name'               => 'Communications',
        'singular_name'      => 'Communication',
        'menu_name'          => 'Communications',
        'name_admin_bar'     => 'Communication',
        'add_new'            => 'Add New',
        'add_new_item'       => 'Add New Communication',
        'new_item'           => 'New Communication',
        'edit_item'          => 'Edit Communication',
        'view_item'          => 'View Communication',
        'all_items'          => 'All Communications',
        'search_items'       => 'Search Communications',
        'parent_item_colon'  => 'Parent Communications:',
        'not_found'          => 'No communications found.',
        'not_found_in_trash' => 'No communications found in Trash.'
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => false,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'communication' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
    );

    register_post_type( 'communication', $args );
}

add_action( 'init', 'ajl_register_communication_post_type' );