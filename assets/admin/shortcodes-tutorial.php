<?php
function ajl_shortcode_tutorial_page() {
    ?>
    <div class="wrap">
        <h1>Shortcode Tutorial</h1>
        <h2>Job Listings Shortcode</h2>
        <p>Use the <code>[jobs]</code> shortcode to display job listings on any page or post. You can specify the number of jobs to display using the <code>count</code> attribute. For example:</p>
        <pre><code>[jobs count="10"]</code></pre>
        <p>This will display the latest 10 job listings.</p>

        <h2>Job Application Form Shortcode</h2>
        <p>Use the <code>[application_form]</code> shortcode to display a job application form on any page or post. For example:</p>
        <pre><code>[application_form]</code></pre>
        <p>This will display a form where users can submit their job applications, including uploading a resume.</p>

        <h2>Job Subscription Form Shortcode</h2>
        <p>Use the <code>[job_subscription_form]</code> shortcode to display a subscription form for job notifications on any page or post. For example:</p>
        <pre><code>[job_subscription_form]</code></pre>
        <p>This will display a form where users can enter their email address to subscribe to job notifications.</p>
    </div>
    <?php
}
?>
