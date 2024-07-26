<?php

/**
 * Create custom table for job subscriptions
 * 
 * This function creates a custom table to store job subscriptions
 * with unique email addresses.
 */
function ajl_create_subscription_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'job_subscriptions';

    $charset_collate = $wpdb->get_charset_collate();

    // SQL statement to create the job subscriptions table
    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        email varchar(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        UNIQUE KEY email (email)
    ) $charset_collate;";

    // Include the WordPress upgrade script to handle the table creation
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

/**
 * Create custom table for email logs
 * 
 * This function creates a custom table to store email logs.
 */
function ajl_create_email_log_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'email_log';
    
    $charset_collate = $wpdb->get_charset_collate();
    
    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        sender varchar(100) NOT NULL,
        recipient varchar(100) NOT NULL,
        subject varchar(255) NOT NULL,
        message text NOT NULL,
        sent_at datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";
    
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
