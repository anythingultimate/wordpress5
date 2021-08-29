<?php
namespace AUPP;
/**
 * Plugin Name: Plugin Practice
 * Plugin URI: https://example.com/plugins/aupp
 * Description: A short description of the plugin.
 * Version: 1.0.0
 * Requires at least: 5.3
 * Requires PHP: 5.6
 * Author: John Doe
 * Author URI: https://example.com
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: aupp
 * Domain Path: /public/lang
 */


// register-activation-hook
register_activation_hook( __FILE__, function() {
    require_once plugin_dir_path( __FILE__ ) . 'src/Activation.php';
    Activation::activate();
} );


// register-deactivation-hook
register_deactivation_hook( __FILE__, function() {
    require_once plugin_dir_path( __FILE__ ) . 'src/Deactivation.php';
    Deactivation::deactivate();
} );

//register-uninstall-hook
register_uninstall_hook( __FILE__, __NAMESPACE__ .'\\aupp_uninstall' );

function aupp_uninstall() {
    $role = get_role( 'administrator' );

    if ( ! empty( $role ) ) {
        $role->remove_cap( 'aupp_manage' );
    }
}

add_action('admin_menu',  __NAMESPACE__ .'\\aupp_create_menu');

function aupp_create_menu()
{

    //create custom top-level menu
    add_menu_page(
        'AUPP Settings Page',
        'AUPP Settings',
        'manage_options',
        'aupp-options',
        __NAMESPACE__ .'\\aupp_settings_page',
        'dashicons-smiley',
        20);

    //create submenu items
    add_submenu_page( 'aupp-options', 'About The AUPP Plugin', 'About',
        'manage_options', 'aupp-about', __NAMESPACE__ .'\\aupp_about_page' );
    add_submenu_page( 'aupp-options', 'Help With The AUPP Plugin',
        'Help', 'manage_options', 'aupp-help', __NAMESPACE__ .'\\aupp_help_page' );
    add_submenu_page( 'aupp-options', 'Uninstall The AUPP Plugin',
        'Uninstall', 'manage_options', 'aupp-uninstall', __NAMESPACE__ .'\\aupp_uninstall_page' );
}

//placerholder function for the settings page
function aupp_settings_page()
{

}
//placerholder function for the about page
function aupp_about_page()
{

}
//placerholder function for the help page
function aupp_help_page()
{

}
//placerholder function for the uninstall page
function aupp_uninstall_page()
{

}

add_action( 'admin_menu', __NAMESPACE__ .'\\aupp_create_submenu' );

function aupp_create_submenu() {
    //create a submenu under Settings
    add_options_page( 'AUPP Plugin Settings', 'AUPP Settings', 'manage_options',
        'aupp_plugin', __NAMESPACE__ .'\\aupp_plugin_option_page' );

}

add_action( 'admin_menu', __NAMESPACE__ .'\\aupp_create_users_submenu' );

function aupp_create_users_submenu() {
    //create a submenu under Users
    add_users_page( 'AUPP Plugin Users Settings', 'AUPP Users Settings', 'manage_options',
        'aupp_users_plugin', __NAMESPACE__ .'\\aupp_plugin_users' );

}

