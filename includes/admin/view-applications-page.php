<?php
/**
 * Displays the page for viewing job applications.
 * 
 * This function generates the HTML for the page that lists all job applications.
 * It wraps the content in a standard WordPress admin page structure.
 */
function ajl_view_applications_page() {
    ?>
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        <?php ajl_view_applications(); ?>
    </div>
    <?php
}

/**
 * Displays a list of all job applications.
 * 
 * This function retrieves all application posts and displays them in a table.
 * It includes applicant details, job information, and action links for each application.
 */
function ajl_view_applications() {
    $args = array(
        'post_type'      => 'application',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'orderby'        => 'date',
        'order'          => 'DESC',
    );

    $applications = new WP_Query($args);

    if ($applications->have_posts()) {
        ?>
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th><?php esc_html_e('Applicant Name', 'ajl-text-domain'); ?></th>
                    <th><?php esc_html_e('Email', 'ajl-text-domain'); ?></th>
                    <th><?php esc_html_e('Job ID', 'ajl-text-domain'); ?></th>
                    <th><?php esc_html_e('Cover Letter', 'ajl-text-domain'); ?></th>
                    <th><?php esc_html_e('Resume', 'ajl-text-domain'); ?></th>
                    <th><?php esc_html_e('Actions', 'ajl-text-domain'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($applications->have_posts()) {
                    $applications->the_post();
                    $application_id = get_the_ID();
                    $name = get_post_meta($application_id, '_ajl_applicant_name', true);
                    $email = get_post_meta($application_id, '_ajl_applicant_email', true);
                    $job_id = get_post_meta($application_id, '_ajl_job_id', true);
                    $cover_letter = get_post_meta($application_id, '_ajl_cover_letter', true);
                    $resume_url = get_post_meta($application_id, '_ajl_resume_url', true);
                    ?>
                    <tr>
                        <td><?php echo esc_html($name); ?></td>
                        <td><?php echo esc_html($email); ?></td>
                        <td><?php echo esc_html($job_id); ?></td>
                        <td><?php echo wp_kses_post(wp_trim_words($cover_letter, 20)); ?></td>
                        <td>
                            <?php if ($resume_url) : ?>
                                <a href="<?php echo esc_url($resume_url); ?>" target="_blank"><?php esc_html_e('Download', 'ajl-text-domain'); ?></a>
                            <?php else : ?>
                                <?php esc_html_e('No resume', 'ajl-text-domain'); ?>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="<?php echo esc_url(get_edit_post_link($application_id)); ?>"><?php esc_html_e('Edit', 'ajl-text-domain'); ?></a> | 
                            <a href="<?php echo esc_url(get_delete_post_link($application_id)); ?>" onclick="return confirm('<?php esc_attr_e('Are you sure you want to delete this application?', 'ajl-text-domain'); ?>');"><?php esc_html_e('Delete', 'ajl-text-domain'); ?></a>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
        <?php
    } else {
        echo '<p>' . esc_html__('No applications found', 'ajl-text-domain') . '</p>';
    }
    wp_reset_postdata();
}


?>