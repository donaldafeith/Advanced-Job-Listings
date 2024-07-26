<?php
function ajl_add_company_page() {
    ?>
    <div class="wrap">
        <h1>Add New Company</h1>
        <!-- Company addition form -->
        <form method="post" action="admin-post.php?action=add_company" enctype="multipart/form-data">
            <?php wp_nonce_field('add_company'); ?>
            <table class="form-table">
                <!-- Company Name field -->
                <tr valign="top">
                    <th scope="row">
                        <label for="company_name">Company Name</label>
                    </th>
                    <td>
                        <input type="text" id="company_name" name="company_name" required />
                    </td>
                </tr>
                <!-- Company Description field -->
                <tr valign="top">
                    <th scope="row">
                        <label for="company_description">Company Description</label>
                    </th>
                    <td>
                        <textarea id="company_description" name="company_description" required></textarea>
                    </td>
                </tr>
                <!-- Company Logo upload field -->
                <tr valign="top">
                    <th scope="row">
                        <label for="company_logo">Company Logo</label>
                    </th>
                    <td>
                        <input type="file" id="company_logo" name="company_logo" />
                    </td>
                </tr>
            </table>
            <?php 
            // Output the "Add Company" submit button
            submit_button('Add Company'); 
            ?>
        </form>
    </div>
    <?php
}
?>