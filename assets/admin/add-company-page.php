<?php
function ajl_add_company_page() {
    ?>
    <div class="wrap">
        <h1>Add New Company</h1>
        <form method="post" action="admin-post.php?action=add_company" enctype="multipart/form-data">
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Company Name</th>
                    <td><input type="text" name="company_name" required /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Company Description</th>
                    <td><textarea name="company_description" required></textarea></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Company Logo</th>
                    <td><input type="file" name="company_logo" /></td>
                </tr>
            </table>
            <?php submit_button('Add Company'); ?>
        </form>
    </div>
    <?php
}
?>
