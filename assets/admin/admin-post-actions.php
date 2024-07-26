<?php
function ajl_handle_save_job_listing() {
    if (isset($_POST['ajl_job_title']) && isset($_POST['ajl_company_name'])) {
        $job_title = sanitize_text_field($_POST['ajl_job_title']);
        $company_name = sanitize_text_field($_POST['ajl_company_name']);
        $job_location = sanitize_text_field($_POST['ajl_job_location']);
        $job_link = esc_url_raw($_POST['ajl_job_link']);
        $job_salary = sanitize_text_field($_POST['ajl_job_salary']);
        $job_date = sanitize_text_field($_POST['ajl_job_date']);

        // Generate a unique Job ID
        $job_id = uniqid('job_');

        // Handle file upload
        if (!function_exists('wp_handle_upload')) {
            require_once(ABSPATH . 'wp-admin/includes/file.php');
        }
        $uploadedfile = $_FILES['ajl_company_logo'];
        $upload_overrides = array('test_form' => false);
        $movefile = wp_handle_upload($uploadedfile, $upload_overrides);

        if ($movefile && !isset($movefile['error'])) {
            $company_logo = $movefile['url'];
        } else {
            $company_logo = '';
        }

        // Insert the job listing
        $post_data = array(
            'post_title' => $job_title,
            'post_type' => 'job',
            'post_status' => 'publish',
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

            // Save the application page ID as post meta
            update_post_meta($job_post_id, '_ajl_application_page_id', $application_page_id);

            // Debug: Log the application page ID
            error_log("Application Page ID: " . $application_page_id);
            error_log("Application Page Permalink: " . get_permalink($application_page_id));

            wp_redirect(admin_url('admin.php?page=ajl-view-jobs&message=success'));
            exit;
        } else {
            wp_redirect(admin_url('admin.php?page=ajl-add-job&message=error'));
            exit;
        }
    } else {
        wp_redirect(admin_url('admin.php?page=ajl-add-job&message=error'));
        exit;
    }
}
add_action('admin_post_save_job_listing', 'ajl_handle_save_job_listing');
add_action('admin_post_nopriv_save_job_listing', 'ajl_handle_save_job_listing');
?>
