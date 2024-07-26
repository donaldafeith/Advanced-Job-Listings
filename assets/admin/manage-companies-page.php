<?php
function ajl_manage_companies_page() {
    ?>
    <div class="wrap">
        <h1>Manage Companies</h1>

        <?php ajl_view_companies(); ?>
    </div>
    <?php
}

function ajl_view_companies() {
    $args = array(
        'post_type' => 'company',
        'post_status' => 'publish',
        'posts_per_page' => -1,
    );

    $companies = new WP_Query($args);

    if ($companies->have_posts()) {
        echo '<h2>All Companies</h2>';
        echo '<table class="wp-list-table widefat fixed striped">';
        echo '<thead><tr><th>Title</th><th>Description</th><th>Logo</th><th>Actions</th></tr></thead>';
        echo '<tbody>';
        while ($companies->have_posts()) {
            $companies->the_post();
            $company_id = get_the_ID();
            echo '<tr>';
            echo '<td>' . get_the_title() . '</td>';
            echo '<td>' . get_the_content() . '</td>';
            echo '<td><img src="' . get_the_post_thumbnail_url($company_id) . '" alt="" width="50" height="50" /></td>';
            echo '<td><a href="' . get_edit_post_link($company_id) . '">Edit</a> | <a href="' . get_delete_post_link($company_id) . '">Delete</a></td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
    } else {
        echo '<p>No companies found</p>';
    }
    wp_reset_postdata();
}
?>
