<?php
/**
 * Renders the Manage Subscriptions admin page.
 * 
 * This function retrieves all job subscriptions from the database,
 * displays them in a table format, and provides an option to delete
 * individual subscriptions.
 */
function ajl_manage_subscriptions_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'job_subscriptions';

    // Process deletion action if requested
    if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
        ajl_delete_subscription();
    }

    // Fetch all subscriptions
    $subscriptions = $wpdb->get_results("SELECT * FROM $table_name ORDER BY id DESC");

    ?>
    <div class="wrap">
        <h1>Manage Subscriptions</h1>
        <?php
        if (!empty($subscriptions)) {
            ?>
            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($subscriptions as $subscription) {
                        ?>
                        <tr>
                            <td><?php echo esc_html($subscription->id); ?></td>
                            <td><?php echo esc_html($subscription->email); ?></td>
                            <td>
                                <a href="<?php echo wp_nonce_url(admin_url('admin.php?page=ajl-manage-subscriptions&action=delete&id=' . $subscription->id), 'delete_subscription_' . $subscription->id); ?>" 
                                   onclick="return confirm('Are you sure you want to delete this subscription?');">
                                    Delete
                                </a>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
            <?php
        } else {
            echo '<p>No subscriptions found.</p>';
        }
        ?>
    </div>
    <?php
}

/**
 * Deletes a subscription from the database.
 * 
 * This function is called when a delete action is requested. It verifies the nonce,
 * deletes the specified subscription, and redirects back to the subscriptions page.
 */
function ajl_delete_subscription() {
    if (!isset($_GET['id']) || !isset($_GET['_wpnonce'])) {
        return;
    }

    $id = intval($_GET['id']);
    
    // Verify the nonce
    if (!wp_verify_nonce($_GET['_wpnonce'], 'delete_subscription_' . $id)) {
        wp_die('Security check failed');
    }

    global $wpdb;
    $table_name = $wpdb->prefix . 'job_subscriptions';

    $wpdb->delete($table_name, array('id' => $id), array('%d'));

    wp_safe_redirect(admin_url('admin.php?page=ajl-manage-subscriptions'));
    exit;
}


?>