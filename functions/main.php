<?php

require_once( ZISWP_AK_TASK__PLUGIN_DIR . 'functions/query.php' );


function ZISWP_allTaskOperation() {
    global $wpdb;
    $table_name = $wpdb->prefix . ZISWP_TASK_TABLE_NAME;
    
    require_once( ZISWP_AK_TASK__PLUGIN_DIR . 'views/task-list-all.php' );
}
