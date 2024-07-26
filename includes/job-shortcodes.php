<?php
/**
 * Advanced Job Listings Shortcodes and Form Handling
 *
 * This file contains shortcodes and functions for displaying job details,
 * job listings, application forms, and handling job applications and subscriptions.
 */

/**
 * Shortcode to display details of a specific job.
 *
 * @param array $atts Shortcode attributes.
 * @return string HTML output of job details or error message if job not found.
 */
function ajl_job_details_shortcode($atts) {
    $atts = shortcode_atts(array(
        'id' => 0,
    ), $atts, 'job_details');

    $job_id = intval($atts['id']);
    if ($job_id > 0) {
        $post = get_post($job_id);
        if ($post && $post->post_type == 'job') {
            ob_start();
            ?>
            <div class="ajl-job">
                <h2><?php echo esc_html($post->post_title); ?></h2>
                <p><?php echo wp_kses_post($post->post_content); ?></p>
                <p><strong>Location:</strong> <?php echo esc_html(get_post_meta($job_id, '_ajl_job_location', true)); ?></p>
                <p><strong>Salary:</strong> <?php echo esc_html(get_post_meta($job_id, '_ajl_job_salary', true)); ?></p>
            </div>
            <?php
            return ob_get_clean();
        }
    }
    return '<p>Job not found</p>';
}
add_shortcode('job_details', 'ajl_job_details_shortcode');

/**
 * Shortcode to display a list of jobs.
 *
 * @param array $atts Shortcode attributes.
 * @return string HTML output of job listings or message if no jobs found.
 */
function ajl_jobs_shortcode($atts) {
    $atts = shortcode_atts(array(
        'count' => 10,
    ), $atts, 'jobs');

    $args = array(
        'post_type' => 'job',
        'posts_per_page' => intval($atts['count']),
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        ob_start();
        ?>
        <div class="ajl-jobs">
            <?php while ($query->have_posts()) : $query->the_post(); ?>
                <div class="ajl-job">
                    <?php
                    $application_page_id = get_post_meta(get_the_ID(), '_ajl_application_page_id', true);
                    ?>
                    <h2>
                        <?php if ($application_page_id): ?>
                            <a href="<?php echo esc_url(get_permalink($application_page_id)); ?>"><?php the_title(); ?></a>
                        <?php else: ?>
                            <?php the_title(); ?>
                        <?php endif; ?>
                    </h2>
                    <p><?php the_content(); ?></p>
                    <p><strong>Location:</strong> <?php echo esc_html(get_post_meta(get_the_ID(), '_ajl_job_location', true)); ?></p>
                    <p><strong>Salary:</strong> <?php echo esc_html(get_post_meta(get_the_ID(), '_ajl_job_salary', true)); ?></p>
                </div>
            <?php endwhile; ?>
        </div>
        <?php
        wp_reset_postdata();
        return ob_get_clean();
    } else {
        return '<p>No jobs found</p>';
    }
}
add_shortcode('jobs', 'ajl_jobs_shortcode');

/**
 * Shortcode to display the job application form.
 *
 * @param array $atts Shortcode attributes.
 * @return string HTML output of the application form.
 */
function ajl_application_form_shortcode($atts) {
    $atts = shortcode_atts(array(
        'job_id' => '',
    ), $atts, 'application_form');

    $job_id = sanitize_text_field($atts['job_id']);
    ob_start();
    ?>
    <form action="" method="post" enctype="multipart/form-data">
        <p>
            <label for="applicant_name">Name:</label>
            <input type="text" id="applicant_name" name="applicant_name" required>
        </p>
        <p>
            <label for="applicant_email">Email:</label>
            <input type="email" id="applicant_email" name="applicant_email" required>
        </p>
        <p>
            <label for="job_id">Job ID:</label>
            <input type="text" id="job_id" name="job_id" value="<?php echo esc_attr($job_id); ?>" readonly>
        </p>
        <p>
            <label for="cover_letter">Cover Letter:</label>
            <textarea id="cover_letter" name="cover_letter" required></textarea>
        </p>
        <p>
            <label for="resume">Resume:</label>
            <input type="file" id="resume" name="resume" required>
        </p>
        <input type="hidden" name="action" value="submit_application">
        <p>
            <input type="submit" value="Submit Application">
        </p>
    </form>
    <?php
    return ob_get_clean();
}
add_shortcode('application_form', 'ajl_application_form_shortcode');

/**
 * Handles the submission of job applications.
 * This function is hooked to 'wp' action to process form submissions.
 */
function ajl_handle_application_submission() {
    if (isset($_POST['action']) && $_POST['action'] == 'submit_application') {
        $name = sanitize_text_field($_POST['applicant_name']);
        $email = sanitize_email($_POST['applicant_email']);
        $job_id = sanitize_text_field($_POST['job_id']);
        $cover_letter = sanitize_textarea_field($_POST['cover_letter']);

        // Handle file upload
        if (!function_exists('wp_handle_upload')) {
            require_once(ABSPATH . 'wp-admin/includes/file.php');
        }
        $uploadedfile = $_FILES['resume'];
        $upload_overrides = array('test_form' => false);
        $movefile = wp_handle_upload($uploadedfile, $upload_overrides);

        if ($movefile && !isset($movefile['error'])) {
            $resume_url = $movefile['url'];

            // Create a new application post
            $application_data = array(
                'post_title' => $name . ' - Application for Job ID ' . $job_id,
                'post_type' => 'application',
                'post_status' => 'publish',
                'meta_input' => array(
                    '_ajl_applicant_name' => $name,
                    '_ajl_applicant_email' => $email,
                    '_ajl_job_id' => $job_id,
                    '_ajl_cover_letter' => $cover_letter,
                    '_ajl_resume_url' => $resume_url,
                ),
            );

            wp_insert_post($application_data);

            echo '<p>Thank you for your application!</p>';
        } else {
            echo '<p>There was an error uploading your resume. Please try again.</p>';
        }
    }
}
add_action('wp', 'ajl_handle_application_submission');

/**
 * Shortcode to display the job subscription form.
 *
 * @return string HTML output of the subscription form.
 */
function ajl_job_subscription_form() {
    ob_start();
    ?>
    <form method="post" action="">
        <label for="ajl_subscription_email">Sign up for job notifications:</label>
        <input type="email" name="ajl_subscription_email" id="ajl_subscription_email" required />
        <input type="submit" name="ajl_subscription_submit" value="Subscribe" />
    </form>
    <?php
    return ob_get_clean();
}
add_shortcode('job_subscription_form', 'ajl_job_subscription_form');