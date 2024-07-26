<?php
function ajl_manage_communications_page() {
    ?>
    <div class="wrap">
        <h1>Manage Communications</h1>
        <form method="post" action="">
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Select User</th>
                    <td>
                        <select name="user_id" required>
                            <?php
                            $users = get_users();
                            foreach ($users as $user) {
                                echo '<option value="' . esc_attr($user->ID) . '">' . esc_html($user->display_name) . ' (' . esc_html($user->user_email) . ')</option>';
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">Subject</th>
                    <td><input type="text" name="subject" required /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Message</th>
                    <td><textarea name="message" required></textarea></td>
                </tr>
            </table>
            <?php submit_button('Send Email'); ?>
        </form>
        <?php ajl_view_communications(); ?>
    </div>
    <?php
    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['user_id']) && !empty($_POST['subject']) && !empty($_POST['message'])) {
        ajl_send_email_to_user();
    }
}

function ajl_view_communications() {
    // Your existing code to view communications
}

function ajl_send_email_to_user() {
    $user_id = intval($_POST['user_id']);
    $user_info = get_userdata($user_id);
    $email = $user_info->user_email;
    $subject = sanitize_text_field($_POST['subject']);
    $message = wp_kses_post($_POST['message']);

    wp_mail($email, $subject, $message);

    echo '<div class="notice notice-success is-dismissible"><p>Email sent to ' . esc_html($user_info->display_name) . ' (' . esc_html($email) . ').</p></div>';
}
?>
