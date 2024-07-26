<?php
/**
 * Renders the Shortcode Tutorial page in the admin area.
 * 
 * This function provides information about available shortcodes
 * for the Job Listings plugin, including usage examples.
 */
function ajl_shortcode_tutorial_page() {
    ?>
    <div class="wrap">
        <h1>Shortcode Tutorial</h1>

        <?php ajl_display_shortcode_section('Job Listings Shortcode', 'jobs', '[jobs count="10"]', 
            'Use the <code>[jobs]</code> shortcode to display job listings on any page or post. You can specify the number of jobs to display using the <code>count</code> attribute.',
            'This will display the latest 10 job listings.'); ?>

        <?php ajl_display_shortcode_section('Job Application Form Shortcode', 'application_form', '[application_form]', 
            'Use the <code>[application_form]</code> shortcode to display a job application form on any page or post.',
            'This will display a form where users can submit their job applications, including uploading a resume.'); ?>

        <?php ajl_display_shortcode_section('Job Subscription Form Shortcode', 'job_subscription_form', '[job_subscription_form]', 
            'Use the <code>[job_subscription_form]</code> shortcode to display a subscription form for job notifications on any page or post.',
            'This will display a form where users can enter their email address to subscribe to job notifications.'); ?>
    </div>
    <?php
}

/**
 * Displays a section for a specific shortcode.
 *
 * @param string $title The title of the shortcode section.
 * @param string $shortcode The shortcode name.
 * @param string $example An example usage of the shortcode.
 * @param string $description A description of the shortcode.
 * @param string $result The expected result of using the shortcode.
 */
function ajl_display_shortcode_section($title, $shortcode, $example, $description, $result) {
    ?>
    <section class="ajl-shortcode-section">
        <h2><?php echo esc_html($title); ?></h2>
        <p><?php echo wp_kses_post($description); ?></p>
        <pre><code><?php echo esc_html($example); ?></code></pre>
        <p><?php echo wp_kses_post($result); ?></p>
    </section>
    <?php
}

/**
 * Enqueues styles for the Shortcode Tutorial page.
 */
function ajl_enqueue_shortcode_tutorial_styles() {
    wp_enqueue_style('ajl-shortcode-tutorial-styles', plugin_dir_url(__FILE__) . 'css/shortcode-tutorial.css');
}
add_action('admin_enqueue_scripts', 'ajl_enqueue_shortcode_tutorial_styles');
?>