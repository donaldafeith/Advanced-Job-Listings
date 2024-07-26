<?php
/**
 * Renders the "Add New Job" admin page.
 *
 * This function creates a form for adding a new job listing to the system.
 * It includes fields for job details such as title, company name, location,
 * link, salary, date, and company logo upload.
 *
 * @return void
 */
function ajl_add_job_page() {
    ?>
    <div class="wrap">
        <h1>Add New Job</h1>
        <!-- Job listing addition form -->
        <form method="post" action="<?php echo esc_url(admin_url('admin-post.php?action=save_job_listing')); ?>" enctype="multipart/form-data">
            <table class="form-table">
                <!-- Job Title field -->
                <tr valign="top">
                    <th scope="row"><label for="ajl_job_title">Job Title</label></th>
                    <td><input type="text" id="ajl_job_title" name="ajl_job_title" required /></td>
                </tr>
                <!-- Company Name field -->
                <tr valign="top">
                    <th scope="row"><label for="ajl_company_name">Company Name</label></th>
                    <td><input type="text" id="ajl_company_name" name="ajl_company_name" required /></td>
                </tr>
                <!-- Job Location field -->
                <tr valign="top">
                    <th scope="row"><label for="ajl_job_location">Location</label></th>
                    <td><input type="text" id="ajl_job_location" name="ajl_job_location" required /></td>
                </tr>
                <!-- Job Link field -->
                <tr valign="top">
                    <th scope="row"><label for="ajl_job_link">Job Link</label></th>
                    <td><input type="url" id="ajl_job_link" name="ajl_job_link" required /></td>
                </tr>
                <!-- Job Salary field -->
                <tr valign="top">
                    <th scope="row"><label for="ajl_job_salary">Salary</label></th>
                    <td><input type="text" id="ajl_job_salary" name="ajl_job_salary" required /></td>
                </tr>
                <!-- Job Date field -->
                <tr valign="top">
                    <th scope="row"><label for="ajl_job_date">Date</label></th>
                    <td><input type="date" id="ajl_job_date" name="ajl_job_date" required /></td>
                </tr>
                 <!-- Job Description field -->
                <tr>
                    <th scope="row"><label for="ajl_job_description"><?php esc_html_e('Job Description', 'ajl-text-domain'); ?></label></th>
                    <td><?php
                        wp_editor('', 'ajl_job_description', array(
                            'textarea_name' => 'ajl_job_description',
                            'textarea_rows' => 10,
                            'media_buttons' => false,
                        ));
                    ?></td>
                </tr>
                <!-- Company Logo upload field -->
                <tr valign="top">
                    <th scope="row"><label for="ajl_company_logo">Company Logo</label></th>
                    <td><input type="file" id="ajl_company_logo" name="ajl_company_logo" /></td>
                </tr>
            </table>
            <?php 
            // Output the "Add Job" submit button
            submit_button('Add Job'); 
            ?>
        </form>
    </div>
    <?php
}
?>