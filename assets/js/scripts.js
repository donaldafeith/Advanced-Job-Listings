// JavaScript for the job listing plugin
jQuery(document).ready(function ($) {
    console.log('Advanced Job Listing Plugin scripts loaded.');

    // Example: Toggle job details on title click
    $('.ajl-job h2').on('click', function () {
        $(this).siblings('p').slideToggle();
    });
});