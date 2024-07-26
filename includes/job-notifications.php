<?php

/**
 * Sends email notifications to subscribers when a new job is published.
 *
 * @param int $post_id The ID of the post being published.
 */
function ajl_send_job_notifications($post_id) {
    // Get the post object
    $post = get_post($post_id);

    // Check if this is a 'job' post type and it's being published
    if ($post->post_type == 'job' && $post->post_status == 'publish') {
        global $wpdb;
        $table_name = $wpdb->prefix . 'job_subscriptions';

        // Fetch all subscription emails from the database
        $subscriptions = $wpdb->get_results("SELECT email FROM $table_name");

        // Loop through each subscription and send an email
        foreach ($subscriptions as $subscription) {
            wp_mail(
                $subscription->email,
                'New Job Posted: ' . $post->post_title,
                'A new job has been posted. Check it out: ' . get_permalink($post_id)
            );
        }
    }
}

// Hook the function to the 'publish_job' action
add_action('publish_job', 'ajl_send_job_notifications');