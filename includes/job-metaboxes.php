<?php

/**
 * Adds custom metaboxes to the 'job' post type edit screen.
 */
function ajl_add_job_metaboxes() {
    add_meta_box(
        'ajl_job_details',  // Unique ID
        'Job Details',      // Box title
        'ajl_job_details_callback',  // Content callback function
        'job',              // Post type
        'normal',           // Context
        'high'              // Priority
    );
}

// Hook the function to add metaboxes
add_action('add_meta_boxes', 'ajl_add_job_metaboxes');

/**
 * Callback function to display the contents of the Job Details metabox.
 *
 * @param WP_Post $post The post object.
 */
function ajl_job_details_callback($post) {
    // Retrieve current values if they exist
    $location = get_post_meta($post->ID, '_ajl_job_location', true);
    $salary = get_post_meta($post->ID, '_ajl_job_salary', true);
    
    // Add a nonce field for security
    wp_nonce_field('ajl_save_job_metaboxes', 'ajl_job_metabox_nonce');
    ?>
    <p>
        <label for="ajl_job_location">Location:</label>
        <input type="text" id="ajl_job_location" name="ajl_job_location" value="<?php echo esc_attr($location); ?>" />
    </p>
    <p>
        <label for="ajl_job_salary">Salary:</label>
        <input type="text" id="ajl_job_salary" name="ajl_job_salary" value="<?php echo esc_attr($salary); ?>" />
    </p>
    <?php
}

/**
 * Saves the custom metabox data.
 *
 * @param int $post_id The ID of the post being saved.
 */
function ajl_save_job_metaboxes($post_id) {
    // Check if our nonce is set and verify it
    if (!isset($_POST['ajl_job_metabox_nonce']) || !wp_verify_nonce($_POST['ajl_job_metabox_nonce'], 'ajl_save_job_metaboxes')) {
        return $post_id;
    }

    // Check if this is an autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }

    // Check the user's permissions
    if ('job' == $_POST['post_type']) {
        if (!current_user_can('edit_post', $post_id)) {
            return $post_id;
        }
    } else {
        if (!current_user_can('edit_page', $post_id)) {
            return $post_id;
        }
    }

    // Sanitize user input
    $location = sanitize_text_field($_POST['ajl_job_location']);
    $salary = sanitize_text_field($_POST['ajl_job_salary']);

    // Update the meta fields in the database
    update_post_meta($post_id, '_ajl_job_location', $location);
    update_post_meta($post_id, '_ajl_job_salary', $salary);
}

// Hook the save function to the save_post action
add_action('save_post', 'ajl_save_job_metaboxes');