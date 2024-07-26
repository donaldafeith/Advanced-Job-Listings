<?php
/**
 * Displays a list of all jobs.
 * This function retrieves all job posts and displays them in a table.
 */
function ajl_view_jobs_page() {
    ?>
    <div class="wrap">
        <h1>All Jobs</h1>
        <?php ajl_view_jobs(); ?>
    </div>
    <?php
}

function ajl_view_jobs() {
    $args = array(
        'post_type' => 'job',
        'post_status' => 'publish',
        'posts_per_page' => -1,
    );

    $jobs = new WP_Query($args);

    if ($jobs->have_posts()) {
        echo '<table class="wp-list-table widefat fixed striped">';
        echo '<thead><tr><th>Title</th><th>Company</th><th>Location</th><th>Salary</th><th>Job ID</th><th>Actions</th></tr></thead>';
        echo '<tbody>';
        while ($jobs->have_posts()) {
            $jobs->the_post();
            $job_id = get_the_ID();
            echo '<tr>';
            echo '<td>' . get_the_title() . '</td>';
            echo '<td>' . get_post_meta($job_id, '_ajl_company_name', true) . '</td>';
            echo '<td>' . get_post_meta($job_id, '_ajl_job_location', true) . '</td>';
            echo '<td>' . get_post_meta($job_id, '_ajl_job_salary', true) . '</td>';
            echo '<td>' . get_post_meta($job_id, '_ajl_job_id', true) . '</td>';
            echo '<td><a href="' . get_edit_post_link($job_id) . '">Edit</a> | <a href="' . get_delete_post_link($job_id) . '">Delete</a></td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
    } else {
        echo '<p>No jobs found</p>';
    }
    wp_reset_postdata();
}
?>