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




