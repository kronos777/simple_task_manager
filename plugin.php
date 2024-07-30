<?php

/*
Plugin Name:        Simple task manager
Description:        Простой менеджер задач (Тестовое задание)
Plugin URI:         #
Version:            1
Requires at least:  1
Requires PHP:       7.4
Tested up to:       1
License:            #
License URI:        #
Author:             Ivan Ziborov<creatorweb77@gmail.com>
Author URI:         #
Text Domain:        #
*/

/**
 * Defined Data.
 */
define('ZISWP_AK_TASK__PLUGIN_DIR', plugin_dir_path(__FILE__));
define('ZISWP_TASK_TABLE_NAME', "ZISWP_tbl_ipb_solutions");
// Initializes logger.
require_once(ZISWP_AK_TASK__PLUGIN_DIR . 'filelogger/filelogger.php');
/**
 * Calls when plugin is activated.
 */
register_activation_hook(__FILE__, 'ZISWP_crudOperationsTable');

/**
 * Calls when plugin is deactivated.
 */
register_deactivation_hook(__FILE__, 'ZISWP_uninstallAndDeleteTables');




// Initializes Function.
require_once(ZISWP_AK_TASK__PLUGIN_DIR . 'functions/init.php');
require_once(ZISWP_AK_TASK__PLUGIN_DIR . 'functions/uninstall.php');
require_once(ZISWP_AK_TASK__PLUGIN_DIR . 'functions/main.php');

// Create CRUD Pages for Admin.
add_action('admin_menu', 'ZISWP_addAdminPageContent');

function ZISWP_addAdminPageContent() {
    add_menu_page('Task Management', 'Все задачи', 'manage_options', 'tasks-all', 'ZISWP_allTaskOperation', 'dashicons-admin-page');
}

// Add Styles & JS Action.
add_action('admin_init', 'ZISWP_admin_js_css_init');

/**
 * Init CSS and JS.
 *
 * @return void
 */
function ZISWP_admin_js_css_init() {
    wp_register_style('ZISWP_bootstrap_styles', plugins_url('/assets/css/bootstrap.min.css', __FILE__));
    wp_register_style('ZISWP_font_awesome_styles', plugins_url('/assets/css/fonts/font-awesome/css/font-awesome.min.css', __FILE__));
    wp_register_style('ZISWP_main_styles', plugins_url('/assets/css/style.css', __FILE__));
    add_action('admin_print_styles', 'ZISWP_admin_styles');


    wp_register_script('ZISWP_bootstrap_script', plugins_url('/assets/js/bootstrap.min.js', __FILE__));
    wp_register_script('ZISWP_functions_script', plugins_url('/assets/js/functions.js', __FILE__));
    add_action('admin_print_scripts', 'ZISWP_admin_scripts');

    /**
     * Init CSS.
     *
     * @return void
     */
    function ZISWP_admin_styles() {
        wp_enqueue_style('ZISWP_bootstrap_styles');
        wp_enqueue_style('ZISWP_font_awesome_styles');
        wp_enqueue_style('ZISWP_main_styles');
    }

    /**
     * Init JS.
     *
     * @return void
     */
    function ZISWP_admin_scripts() {
        wp_enqueue_script('ZISWP_bootstrap_script');
        wp_enqueue_script('ZISWP_functions_script');
    }
}
