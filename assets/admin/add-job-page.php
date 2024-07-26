<?php

/**
 * Displays the page for adding a new job.
 * This function generates the HTML form for adding a new job listing.
 */
function ajl_add_job_page() {
    ?>
    <div class="wrap">
        <h1>Add New Job</h1>
        <form method="post" action="<?php echo admin_url('admin-post.php?action=save_job_listing'); ?>" enctype="multipart/form-data">
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Job Title</th>
                    <td><input type="text" name="ajl_job_title" required /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Company Name</th>
                    <td><input type="text" name="ajl_company_name" required /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Location</th>
                    <td><input type="text" name="ajl_job_location" required /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Job Link</th>
                    <td><input type="url" name="ajl_job_link" required /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Salary</th>
                    <td><input type="text" name="ajl_job_salary" required /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Date</th>
                    <td><input type="date" name="ajl_job_date" required /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Company Logo</th>
                    <td><input type="file" name="ajl_company_logo" /></td>
                </tr>
            </table>
            <?php submit_button('Add Job'); ?>
        </form>
    </div>
    <?php
}
?>