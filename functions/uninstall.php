<?php
/**
 * Uninstall and Delete tasks table.
 *
 * Delete tasks CRUD table.
 *
 * @return void
 */
function ZISWP_uninstallAndDeleteTables() {
    global $wpdb;
    $table_name = $wpdb->prefix . ZISWP_TASK_TABLE_NAME;
    $sql = "DROP TABLE IF EXISTS $table_name";
    $sql_prep = $wpdb->prepare($sql);
    $logger = new FileLogger();
    $logger->info('plugin delete');
    return $wpdb->get_results($sql_prep);
}