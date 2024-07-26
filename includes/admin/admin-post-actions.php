<?php
/**
 * Handles the submission of a new job listing.
 * 
 * This function processes the form data, creates a new job post,
 * and generates an associated application page.
 */
/**
 * Handles the submission of a new job listing.
 * 
 * This function processes the form data, creates a new job post,
 * and generates an associated application page.
 */
function ajl_handle_save_job_listing() {
    // Check if required fields are set
    if (isset($_POST['ajl_job_title']) && isset($_POST['ajl_company_name']) && isset($_POST['ajl_job_description'])) {
        // Sanitize and collect form data
        $job_title = sanitize_text_field($_POST['ajl_job_title']);
        $company_name = sanitize_text_field($_POST['ajl_company_name']);
        $job_location = sanitize_text_field($_POST['ajl_job_location']);
        $job_link = esc_url_raw($_POST['ajl_job_link']);
        $job_salary = sanitize_text_field($_POST['ajl_job_salary']);
        $job_date = sanitize_text_field($_POST['ajl_job_date']);
        $job_description = wp_kses_post($_POST['ajl_job_description']); // Allow some HTML tags

        // Generate a unique Job ID
        $job_id = uniqid('job_');

        // Handle file upload for company logo
        if (!function_exists('wp_handle_upload')) {
            require_once(ABSPATH . 'wp-admin/includes/file.php');
        }
        $uploadedfile = $_FILES['ajl_company_logo'];
        $upload_overrides = array('test_form' => false);
        $movefile = wp_handle_upload($uploadedfile, $upload_overrides);

        $company_logo = ($movefile && !isset($movefile['error'])) ? $movefile['url'] : '';

        // Prepare job listing data
        $post_data = array(
            'post_title' => $job_title,
            'post_type' => 'job',
            'post_status' => 'publish',
            'post_content' => $job_description, // Save the job description as the post content
            'meta_input' => array(
                '_ajl_company_name' => $company_name,
                '_ajl_job_location' => $job_location,
                '_ajl_job_link' => $job_link,
                '_ajl_job_salary' => $job_salary,
                '_ajl_job_date' => $job_date,
                '_ajl_company_logo' => $company_logo,
                '_ajl_job_id' => $job_id,
            ),
        );

        // Insert the job listing
        $job_post_id = wp_insert_post($post_data);

        if ($job_post_id) {
            // Create a page for the job application
            $application_page_content = '[job_details id="' . $job_post_id . '"] [application_form job_id="' . $job_id . '"]';
            $application_page_data = array(
                'post_title' => $job_title . ' - Apply',
                'post_type' => 'page',
                'post_status' => 'publish',
                'post_content' => $application_page_content,
            );
            $application_page_id = wp_insert_post($application_page_data);

            // Save the application page ID and URL as post meta
            update_post_meta($job_post_id, '_ajl_application_page_id', $application_page_id);
            update_post_meta($job_post_id, '_ajl_application_page_link', get_permalink($application_page_id));

            wp_redirect(admin_url('admin.php?page=ajl-view-jobs&message=success'));
            exit;
        }
    }
    
    // Redirect to add job page if there's an error
    wp_redirect(admin_url('admin.php?page=ajl-add-job&message=error'));
    exit;
}

// Hook the job listing save function to WordPress actions
add_action('admin_post_save_job_listing', 'ajl_handle_save_job_listing');
add_action('admin_post_nopriv_save_job_listing', 'ajl_handle_save_job_listing');

/**
 * Handles the deletion of a job post and its associated application page.
 *
 * @param int $post_id The ID of the post being deleted.
 */
function ajl_handle_delete_job($post_id) {
    // Check if the post being deleted is a job
    if (get_post_type($post_id) !== 'job') {
        return;
    }

    // Get the application page ID associated with this job
    $application_page_id = get_post_meta($post_id, '_ajl_application_page_id', true);

    if ($application_page_id) {
        // Force delete the application page
        wp_delete_post($application_page_id, true);
    }
}

// Hook the job deletion function to various WordPress actions
add_action('before_delete_post', 'ajl_handle_delete_job');
add_action('wp_trash_post', 'ajl_handle_delete_job');
add_action('delete_post', 'ajl_handle_delete_job');

/**
 * Disables post revisions for 'page' post type.
 *
 * @param int $num The number of revisions to keep.
 * @param WP_Post $post The post object.
 * @return int The number of revisions to keep (0 for pages).
 */
add_filter('wp_revisions_to_keep', function($num, $post) {
    if ('page' === $post->post_type) {
        return 0;
    }
    return $num;
}, 10, 2);

/**
 * Forces deletion of pages instead of moving them to trash.
 *
 * @param bool $trash Whether to trash the post.
 * @param WP_Post $post The post object.
 * @return bool Whether to proceed with trashing.
 */
add_filter('pre_trash_post', function($trash, $post) {
    if ('page' === $post->post_type) {
        wp_delete_post($post->ID, true);
        return true;
    }
    return $trash;
}, 10, 2);