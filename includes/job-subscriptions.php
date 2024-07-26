<?php

/**
 * Handle Job Subscription Form Submission
 *
 * This function processes the job subscription form submission,
 * validates the email, and stores it in the database.
 */
function ajl_handle_subscription_form() {
    // Check if the subscription form was submitted
    if (isset($_POST['ajl_subscription_submit'])) {
        // Validate the email address
        if (!empty($_POST['ajl_subscription_email']) && is_email($_POST['ajl_subscription_email'])) {
            global $wpdb;
            $table_name = $wpdb->prefix . 'job_subscriptions';
            
            // Sanitize the email address
            $email = sanitize_email($_POST['ajl_subscription_email']);
            
            // Insert the email into the database
            $result = $wpdb->insert(
                $table_name,
                array('email' => $email),
                array('%s')
            );
            
            // Check if the insertion was successful
            if ($result !== false) {
                // Display success message
                echo '<p class="ajl-success-message">Thank you for subscribing to job notifications!</p>';
            } else {
                // Display error message if insertion failed
                echo '<p class="ajl-error-message">An error occurred. Please try again later.</p>';
            }
        } else {
            // Display error message for invalid email
            echo '<p class="ajl-error-message">Please enter a valid email address.</p>';
        }
    }
}

// Hook the function to the 'init' action
add_action('init', 'ajl_handle_subscription_form');