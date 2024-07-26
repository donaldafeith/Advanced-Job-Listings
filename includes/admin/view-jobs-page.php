<?php
/**
 * Displays a list of all jobs.
 * 
 * This function creates the main container for the jobs list page
 * and calls the function to display the actual jobs table.
 */
function ajl_view_jobs_page() {
    ?>
    <div class="wrap">
        <h1>All Jobs</h1>
        <?php ajl_view_jobs(); ?>
    </div>
    <?php
}

/**
 * Retrieves and displays all job posts in a table format.
 * 
 * This function queries the database for all published job posts,
 * then displays them in a structured HTML table with relevant details.
 */
function ajl_view_jobs() {
    // Set up the query arguments for retrieving job posts
    $args = array(
        'post_type' => 'job',
        'post_status' => 'publish',
        'posts_per_page' => -1, // Retrieve all posts
    );

    // Create a new WP_Query instance
    $jobs = new WP_Query($args);

    if ($jobs->have_posts()) {
        // Start outputting the jobs table
        echo '<h2>All Jobs</h2>';
        echo '<table class="wp-list-table widefat fixed striped">';
        echo '<thead><tr><th>Title</th><th>Company</th><th>Location</th><th>Salary</th><th>Job ID</th><th>Description</th><th>Link</th><th>Actions</th></tr></thead>';
        echo '<tbody>';
        
        // Loop through each job post
        while ($jobs->have_posts()) {
            $jobs->the_post();
            $job_id = get_the_ID();
            $application_page_link = get_post_meta($job_id, '_ajl_application_page_link', true);
            
            // Output each job's details in a table row
            echo '<tr>';
            echo '<td>' . get_the_title() . '</td>';
            echo '<td>' . esc_html(get_post_meta($job_id, '_ajl_company_name', true)) . '</td>';
            echo '<td>' . esc_html(get_post_meta($job_id, '_ajl_job_location', true)) . '</td>';
            echo '<td>' . esc_html(get_post_meta($job_id, '_ajl_job_salary', true)) . '</td>';
            echo '<td>' . esc_html(get_post_meta($job_id, '_ajl_job_id', true)) . '</td>';
            echo '<td>' . wp_trim_words(get_the_content(), 20, '...') . '</td>';
            echo '<td><a href="' . esc_url($application_page_link) . '" target="_blank">Application Page</a></td>';
            echo '<td><a href="' . get_edit_post_link($job_id) . '">Edit</a> | <a href="' . get_delete_post_link($job_id) . '">Delete</a></td>';
            echo '</tr>';
        }
        
        // Close the table structure
        echo '</tbody>';
        echo '</table>';
    } else {
        // Display a message if no jobs are found
        echo '<p>No jobs found</p>';
    }
    
    // Reset the global post data
    wp_reset_postdata();
}