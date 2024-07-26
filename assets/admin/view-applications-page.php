<?php

/**
 * Displays the page for viewing job applications.
 * This function generates the HTML for the page that lists all job applications.
 */
function ajl_view_applications_page() {
    ?>
    <div class="wrap">
        <h1>View Applications</h1>
        <?php ajl_view_applications(); ?>
    </div>
    <?php
}

/**
 * Displays a list of all job applications.
 * This function retrieves all application posts and displays them in a table.
 */
function ajl_view_applications() {
    $args = array(
        'post_type' => 'application',
        'post_status' => 'publish',
        'posts_per_page' => -1,
    );

    $applications = new WP_Query($args);

    if ($applications->have_posts()) {
        echo '<table class="wp-list-table widefat fixed striped">';
        echo '<thead><tr><th>Applicant Name</th><th>Email</th><th>Job ID</th><th>Cover Letter</th><th>Resume</th><th>Actions</th></tr></thead>';
        echo '<tbody>';
        while ($applications->have_posts()) {
            $applications->the_post();
            $application_id = get_the_ID();
            $name = get_post_meta($application_id, '_ajl_applicant_name', true);
            $email = get_post_meta($application_id, '_ajl_applicant_email', true);
            $job_id = get_post_meta($application_id, '_ajl_job_id', true);
            $cover_letter = get_post_meta($application_id, '_ajl_cover_letter', true);
            $resume_url = get_post_meta($application_id, '_ajl_resume_url', true);
            echo '<tr>';
            echo '<td>' . esc_html($name) . '</td>';
            echo '<td>' . esc_html($email) . '</td>';
            echo '<td>' . esc_html($job_id) . '</td>';
            echo '<td>' . esc_html($cover_letter) . '</td>';
            echo '<td><a href="' . esc_url($resume_url) . '">Download</a></td>';
            echo '<td><a href="' . get_edit_post_link($application_id) . '">Edit</a> | <a href="' . get_delete_post_link($application_id) . '">Delete</a></td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
    } else {
        echo '<p>No applications found</p>';
    }
    wp_reset_postdata();
}
?>
