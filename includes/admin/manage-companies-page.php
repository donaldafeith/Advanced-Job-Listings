<?php
if (!function_exists('ajl_manage_companies_page')) {
    /**
     * Renders the Manage Companies admin page.
     * 
     * This function creates the main structure for the Manage Companies page
     * and calls the function to display the list of companies.
     */
    function ajl_manage_companies_page() {
        ?>
        <div class="wrap">
            <h1>Manage Companies</h1>
            <?php ajl_view_companies(); ?>
        </div>
        <?php
    }
}

if (!function_exists('ajl_view_companies')) {
    /**
     * Displays a list of all companies.
     * 
     * This function retrieves all company posts and displays them in a table format
     * with options to edit or delete each company.
     */
    function ajl_view_companies() {
        $args = array(
            'post_type'      => 'company',
            'post_status'    => 'publish',
            'posts_per_page' => -1,
            'orderby'        => 'title',
            'order'          => 'ASC',
        );

        $companies = new WP_Query($args);

        if ($companies->have_posts()) {
            ?>
            <h2>All Companies</h2>
            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Logo</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($companies->have_posts()) {
                        $companies->the_post();
                        $company_id = get_the_ID();
                        ?>
                        <tr>
                            <td><?php echo esc_html(get_the_title()); ?></td>
                            <td><?php echo wp_kses_post(wp_trim_words(get_the_content(), 20)); ?></td>
                            <td>
                                <?php
                                $company_logo = get_post_meta($company_id, 'company_logo', true);
                                if ($company_logo) {
                                    $thumbnail_url = wp_get_attachment_image_url($company_logo, 'thumbnail');
                                    if ($thumbnail_url) {
                                        echo '<img src="' . esc_url($thumbnail_url) . '" alt="Company Logo" width="50" height="50" />';
                                    } else {
                                        echo 'No logo';
                                    }
                                } else {
                                    echo 'No logo';
                                }
                                ?>
                            </td>
                            <td>
                                <a href="<?php echo esc_url(get_edit_post_link($company_id)); ?>">Edit</a> | 
                                <a href="<?php echo esc_url(get_delete_post_link($company_id)); ?>" onclick="return confirm('Are you sure you want to delete this company?');">Delete</a>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
            <?php
        } else {
            echo '<p>No companies found</p>';
        }
        wp_reset_postdata();
    }
}

?>
