<?php
/**
 * Renders the main Jobs Admin dashboard page.
 *
 * This function creates the main admin page for the Jobs plugin, providing
 * navigation buttons to various management sections of the plugin.
 *
 * @return void
 */
function ajl_admin_page_content() {
    ?>
    <div class="wrap">
        <h1>Jobs Admin</h1>
        <p>Welcome to the Jobs Admin dashboard. Use the buttons below to navigate:</p>
        <div class="ajl-buttons">
            <?php
            // Array of admin buttons with their details
            $admin_buttons = [
                [
                    'url' => 'admin.php?page=ajl-add-job',
                    'text' => 'Add Job',
                    'description' => 'Add new job listings to the site.'
                ],
                [
                    'url' => 'admin.php?page=ajl-view-jobs',
                    'text' => 'Manage Jobs',
                    'description' => 'View and manage all job listings.'
                ],
                [
                    'url' => 'admin.php?page=ajl-add-company',
                    'text' => 'Add Company',
                    'description' => 'Add new companies to the site.'
                ],
                [
                    'url' => 'admin.php?page=ajl-manage-companies',
                    'text' => 'Manage Companies',
                    'description' => 'View and manage all companies.'
                ],
                [
                    'url' => 'admin.php?page=ajl-view-applications',
                    'text' => 'Manage Applications',
                    'description' => 'View and manage job applications.'
                ],
                [
                    'url' => 'edit.php?post_type=resume',
                    'text' => 'Manage Resumes',
                    'description' => 'View and manage resumes submitted by applicants.'
                ],
                [
                    'url' => 'admin.php?page=ajl-manage-communications',
                    'text' => 'Email User',
                    'description' => 'View and manage communications with applicants and companies.'
                ],
                [
                    'url' => 'admin.php?page=ajl-shortcode-tutorial',
                    'text' => 'ShortCode Tutorial',
                    'description' => 'How to implement the shortcodes in your site using pages/posts'
                ]
            ];

            // Loop through the buttons and display them
            foreach ($admin_buttons as $button) {
                ?>
                <div class="ajl-button">
                    <a href="<?php echo esc_url(admin_url($button['url'])); ?>" class="button"><?php echo esc_html($button['text']); ?></a>
                    <p><?php echo esc_html($button['description']); ?></p>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
    <?php
}
?>