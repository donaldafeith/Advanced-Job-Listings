<?php
function ajl_manage_subscriptions_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'job_subscriptions';
    $subscriptions = $wpdb->get_results("SELECT * FROM $table_name");

    echo '<div class="wrap">';
    echo '<h1>Manage Subscriptions</h1>';
    echo '<table class="wp-list-table widefat fixed striped">';
    echo '<thead><tr><th>ID</th><th>Email</th><th>Actions</th></tr></thead>';
    echo '<tbody>';
    foreach ($subscriptions as $subscription) {
        echo '<tr>';
        echo '<td>' . esc_html($subscription->id) . '</td>';
        echo '<td>' . esc_html($subscription->email) . '</td>';
        echo '<td><a href="?page=ajl-manage-subscriptions&action=delete&id=' . esc_attr($subscription->id) . '">Delete</a></td>';
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
    echo '</div>';

    if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
        $id = intval($_GET['id']);
        $wpdb->delete($table_name, array('id' => $id));
        wp_redirect(admin_url('admin.php?page=ajl-manage-subscriptions'));
        exit;
    }
}
?>
