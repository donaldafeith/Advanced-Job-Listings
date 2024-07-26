<?php
/**
 * Renders the Manage Communications admin page.
 * 
 * This function creates a form for sending emails to users and displays
 * a list of previous communications.
 */
function ajl_manage_communications_page() {
    ?>
    <div class="wrap">
        <h1>Manage Communications</h1>
        <form method="post" action="">
            <?php wp_nonce_field('ajl_send_email', 'ajl_email_nonce'); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row"><label for="user_id">Select User</label></th>
                    <td>
                        <select name="user_id" id="user_id" required>
                            <?php
                            $users = get_users();
                            foreach ($users as $user) {
                                printf(
                                    '<option value="%s">%s (%s)</option>',
                                    esc_attr($user->ID),
                                    esc_html($user->display_name),
                                    esc_html($user->user_email)
                                );
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label for="subject">Subject</label></th>
                    <td><input type="text" name="subject" id="subject" required /></td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label for="message">Message</label></th>
                    <td><textarea name="message" id="message" required></textarea></td>
                </tr>
            </table>
            <?php submit_button('Send Email'); ?>
        </form>
        <?php ajl_view_communications(); ?>
    </div>
    <?php
    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && 
        !empty($_POST['user_id']) && 
        !empty($_POST['subject']) && 
        !empty($_POST['message']) &&
        check_admin_referer('ajl_send_email', 'ajl_email_nonce')) {
        ajl_send_email_to_user();
    }
}

/**
 * Logs sent emails to the database.
 * 
 * @param string $to The recipient email address.
 * @param string $subject The email subject.
 * @param string $message The email message.
 * @param string|array $headers The email headers.
 * @param array $attachments The email attachments.
 */
function ajl_log_email($to, $subject, $message, $headers, $attachments) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'email_log';

    $sender = wp_get_current_user()->user_email;

    // Handle array to string conversions
    $to_string = is_array($to) ? implode(', ', $to) : $to;
    $headers_string = is_array($headers) ? implode("\n", $headers) : $headers;
    $attachments_string = is_array($attachments) ? implode(', ', $attachments) : $attachments;

    $wpdb->insert(
        $table_name,
        array(
            'sender' => $sender,
            'recipient' => $to_string,
            'subject' => $subject,
            'message' => $message,
            'headers' => $headers_string,
            'attachments' => $attachments_string,
            'sent_at' => current_time('mysql')
        ),
        array('%s', '%s', '%s', '%s', '%s', '%s', '%s')
    );

    if ($wpdb->last_error) {
        error_log('Database error in ajl_log_email: ' . $wpdb->last_error);
    }
}

/**
 * Wrapper function to send emails and log them.
 * 
 * @param string|array $to The recipient email address.
 * @param string $subject The email subject.
 * @param string $message The email message.
 * @param string|array $headers The email headers.
 * @param array $attachments The email attachments.
 * @return bool Whether the email contents were sent successfully.
 */
function ajl_send_and_log_email($to, $subject, $message, $headers = '', $attachments = array()) {
    $sent = wp_mail($to, $subject, $message, $headers, $attachments);
    if ($sent) {
        ajl_log_email($to, $subject, $message, $headers, $attachments);
    }
    return $sent;
}

/**
 * Displays a list of previous communications.
 * 
 * This function retrieves and displays the email log from the database.
 */
function ajl_view_communications() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'email_log';
    $results = $wpdb->get_results("SELECT * FROM $table_name ORDER BY sent_at DESC LIMIT 50");

    echo '<h2>Communications Log (Last 50 Entries)</h2>';
    echo '<table class="widefat">';
    echo '<thead><tr><th>ID</th><th>Sender</th><th>Recipient</th><th>Subject</th><th>Message</th><th>Sent At</th></tr></thead>';
    echo '<tbody>';
    
    foreach ($results as $row) {
        echo '<tr>';
        echo '<td>' . esc_html($row->id) . '</td>';
        echo '<td>' . esc_html($row->sender) . '</td>';
        echo '<td>' . esc_html($row->recipient) . '</td>';
        echo '<td>' . esc_html($row->subject) . '</td>';
        echo '<td>' . wp_trim_words(esc_html($row->message), 20) . '</td>';
        echo '<td>' . esc_html($row->sent_at) . '</td>';
        echo '</tr>';
    }
    
    echo '</tbody></table>';
}

// Add this function to a specific admin page or shortcode
add_action('admin_menu', function() {
    add_menu_page('Manage Communications',  'manage_options', 'view-communications', 'ajl_manage_communications_page');
});

/**
 * Sends an email to a selected user.
 * 
 * This function processes the form data, sanitizes inputs, and sends an email
 * to the selected user using ajl_send_and_log_email().
 */
function ajl_send_email_to_user() {
    $user_id = intval($_POST['user_id']);
    $user_info = get_userdata($user_id);
    
    if (!$user_info) {
        wp_die('Invalid user ID');
    }
    
    $to = $user_info->user_email;
    $subject = sanitize_text_field($_POST['subject']);
    $message = wp_kses_post($_POST['message']);

    $headers = array('Content-Type: text/html; charset=UTF-8');
    $attachments = array();

    $sent = ajl_send_and_log_email($to, $subject, $message, $headers, $attachments);

    if ($sent) {
        printf(
            '<div class="notice notice-success is-dismissible"><p>Email sent to %s (%s).</p></div>',
            esc_html($user_info->display_name),
            esc_html($to)
        );
    } else {
        echo '<div class="notice notice-error is-dismissible"><p>Failed to send email. Please try again.</p></div>';
    }
}
?>
