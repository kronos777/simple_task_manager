<?php

/**
 * CRUD Operation Table Initialization.
 * 
 * Initialize tasks CRUD table.
 *
 * @return void
 */
function ZISWP_crudOperationsTable()
{
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();
    $table_name = $wpdb->prefix . ZISWP_TASK_TABLE_NAME;
    $sql = "CREATE TABLE IF NOT EXISTS `$table_name` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `title` varchar(100) DEFAULT NULL,
        `userId` int(11) NOT NULL,
        `completed` BOOLEAN,
        PRIMARY KEY(id)
        ) $charset_collate;
    ";
    $logger = new FileLogger();
    $logger->info('plugin install');
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
}


