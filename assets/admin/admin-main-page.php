<?php
function ajl_admin_page_content() {
    ?>
    <div class="wrap">
        <h1>Jobs Admin</h1>
        <p>Welcome to the Jobs Admin dashboard. Use the buttons below to navigate:</p>
        <div class="ajl-buttons">
            <div class="ajl-button">
                <a href="<?php echo admin_url('admin.php?page=ajl-add-job'); ?>" class="button">Add Job</a>
                <p>Add new job listings to the site.</p>
            </div>
            <div class="ajl-button">
                <a href="<?php echo admin_url('admin.php?page=ajl-view-jobs'); ?>" class="button">Manage Jobs</a>
                <p>View and manage all job listings.</p>
            </div>
            <div class="ajl-button">
                <a href="<?php echo admin_url('admin.php?page=ajl-add-company'); ?>" class="button">Add Company</a>
                <p>Add new companies to the site.</p>
            </div>
            <div class="ajl-button">
                <a href="<?php echo admin_url('admin.php?page=ajl-manage-companies'); ?>" class="button">Manage Companies</a>
                <p>View and manage all companies.</p>
            </div>
            <div class="ajl-button">
                <a href="<?php echo admin_url('admin.php?page=ajl-view-applications'); ?>" class="button">Manage Applications</a>
                <p>View and manage job applications.</p>
            </div>
            <div class="ajl-button">
                <a href="<?php echo admin_url('edit.php?post_type=resume'); ?>" class="button">Manage Resumes</a>
                <p>View and manage resumes submitted by applicants.</p>
            </div>
            <div class="ajl-button">
                <a href="<?php echo admin_url('admin.php?page=ajl-manage-communications'); ?>" class="button">Email User</a>
                <p>View and manage communications with applicants and companies.</p>
            </div>
            <div class="ajl-button">
                <a href="<?php echo admin_url('admin.php?page=ajl-shortcode-tutorial'); ?>" class="button">ShortCode Tutorial</a>
                <p>How to implement the shortcodes in your site using pages/posts</p>
            </div>
        </div>
    </div>
    <?php
}
?>
